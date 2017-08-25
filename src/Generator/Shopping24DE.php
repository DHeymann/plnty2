<?php

namespace ElasticExportShopping24DE\Generator;

use ElasticExport\Helper\ElasticExportCoreHelper;
use Plenty\Modules\DataExchange\Contracts\CSVPluginGenerator;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Item\DataLayer\Models\Record;
use Plenty\Modules\Item\DataLayer\Models\RecordList;
use Plenty\Modules\DataExchange\Models\FormatSetting;
use Plenty\Modules\Helper\Models\KeyValue;
use Plenty\Modules\Item\Attribute\Contracts\AttributeValueNameRepositoryContract;
use Plenty\Modules\Item\Attribute\Models\AttributeValueName;
use Plenty\Modules\Item\Property\Contracts\PropertySelectionRepositoryContract;
use Plenty\Modules\Item\Property\Models\PropertySelection;
use Plenty\Plugin\Log\Loggable;

class Shopping24DE extends CSVPluginGenerator
{
	use Loggable;

    /**
     * @var ElasticExportCoreHelper $elasticExportHelper
     */
    private $elasticExportHelper;

    /**
     * @var ArrayHelper $arrayHelper
     */
    private $arrayHelper;

    /**
     * AttributeValueNameRepositoryContract $attributeValueNameRepository
     */
    private $attributeValueNameRepository;

    /**
     * PropertySelectionRepositoryContract $propertySelectionRepository
     */
    private $propertySelectionRepository;

    /**
     * @var array
     */
    private $itemPropertyCache = [];

    /**
     * @var array
     */
    private $idlVariations = array();

    /**
     * Shopping24DE constructor.
     * @param ArrayHelper $arrayHelper
     * @param AttributeValueNameRepositoryContract $attributeValueNameRepository
     * @param PropertySelectionRepositoryContract $propertySelectionRepository
     */
    public function __construct(ArrayHelper $arrayHelper,
                                AttributeValueNameRepositoryContract $attributeValueNameRepository,
                                PropertySelectionRepositoryContract $propertySelectionRepository)
    {
        $this->arrayHelper                  = $arrayHelper;
        $this->attributeValueNameRepository = $attributeValueNameRepository;
        $this->propertySelectionRepository = $propertySelectionRepository;
    }

    /**
     * @param array $resultData
     * @param array $formatSettings
     * @param array $filter
     */
    protected function generatePluginContent($resultData, array $formatSettings = [], array $filter = [])
    {
        if(is_array($resultData['documents']) && count($resultData['documents']) > 0)
        {
            $this->elasticExportHelper = pluginApp(ElasticExportCoreHelper::class);

            $settings = $this->arrayHelper->buildMapFromObjectList($formatSettings, 'key', 'value');

            $this->setDelimiter("	"); //tab sign

            $this->addCSVContent([
                'art_name',
                'long_description',
                'image_url',
                'deep_link',
                'price',
                'old_price',
                'currency',
                'delivery_costs',
                'category',
                'brand',
                'gender_age',
                'ean',
                'keywords',
                'art_number',
                'color',
                'clothing_size',
                'cut',
                'link',
                'unit_price'
            ]);

			try
			{
				//Create a List of all VariationIds
				$variationIdList = array();
				foreach($resultData['documents'] as $variation)
				{
					$variationIdList[] = $variation['id'];
				}

				//Get the missing fields in ES from IDL
				if(is_array($variationIdList) && count($variationIdList) > 0)
				{
					/**
					 * @var \ElasticExportShopping24DE\IDL_ResultList\Shopping24DE $idlResultList
					 */
					$idlResultList = pluginApp(\ElasticExportShopping24DE\IDL_ResultList\Shopping24DE::class);
					$idlResultList = $idlResultList->getResultList($variationIdList, $settings);
				}

				//Creates an array with the variationId as key to surpass the sorting problem
				if(isset($idlResultList) && $idlResultList instanceof RecordList)
				{
					$this->createIdlArray($idlResultList);
				}

				$rows = [];

				foreach($resultData['documents'] as $item)
				{
					if(!array_key_exists($item['data']['item']['id'], $rows))
					{
						$this->getItemPropertyList($item, $settings);
						$rows[$item['data']['item']['id']] = $this->getMain($item, $settings);
					}

					if(array_key_exists($item['data']['item']['id'], $rows) && $item['data']['attributes']['attributeValueSetId'] > 0)
					{
						$variationAttributes = $this->getVariationAttributes($item, $settings);

						if(array_key_exists('Color', $variationAttributes))
						{
							$rows[$item['data']['item']['id']]['color'] = array_unique(array_merge($rows[$item['data']['item']['id']]['color'], $variationAttributes['Color']));
						}

						if(array_key_exists('Size', $variationAttributes))
						{
							$rows[$item['data']['item']['id']]['clothing_size'] = array_unique(array_merge($rows[$item['data']['item']['id']]['clothing_size'], $variationAttributes['Size']));
						}
					}
				}

				foreach($rows as $data)
				{
					if(array_key_exists('color', $data) && is_array($data['color']))
					{
						$data['color'] = implode(', ', $data['color']);
					}

					if(array_key_exists('clothing_size', $data) && is_array($data['clothing_size']))
					{
						$data['clothing_size'] = implode(', ', $data['clothing_size']);
					}

					$this->addCSVContent(array_values($data));
				}
			}
			catch(\Throwable $exception)
			{
				$this->getLogger(__METHOD__)->error('ElasticExportShopping24DE::log.buildRowError', [
					'Error message ' 	=> $exception->getMessage(),
					'Error line'    	=> $exception->getLine(),
				]);
			}
        }
    }

    /**
     * Get main information.
     * @param  array   $item
     * @param  KeyValue $settings
     * @return array
     */
    private function getMain($item, KeyValue $settings):array
    {
        $rrp = $this->elasticExportHelper->getRecommendedRetailPrice($this->idlVariations[$item['id']]['variationRecommendedRetailPrice.price'], $settings);
        $retailPrice = $this->idlVariations[$item['id']]['variationRetailPrice.price'];

        if($retailPrice <= 0)
        {
        	$retailPrice = '';
        	$currency = '';
		}
		else
		{
			$retailPrice = number_format((float)$retailPrice, 2, ',', '');
			$currency = $this->idlVariations[$item['id']]['variationRetailPrice.currency'];
		}

        $rrp = $rrp > $retailPrice ? number_format((float)$rrp, 2, ',','') : '';
        $deliveryCost = $this->elasticExportHelper->getShippingCost($item['data']['item']['id'], $settings);

        if(!is_null($deliveryCost))
        {
            $deliveryCost = number_format((float)$deliveryCost, 2, ',', '');
        }
        else
        {
            $deliveryCost = '';
        }

		$image = $this->elasticExportHelper->getImageListInOrder($item, $settings, 1, $this->elasticExportHelper::ITEM_IMAGES);

		if(count($image) > 0)
		{
			$image = $image[0];
		}
		else
		{
			$image = '';
		}

        $data = [
            'art_name'          => strip_tags(html_entity_decode($this->elasticExportHelper->getName($item, $settings, 80))),
            'long_description'  => preg_replace(array("/\t/","/;/","/\|/"),"",strip_tags(html_entity_decode($this->elasticExportHelper->getDescription($item, $settings)))),
            'image_url'         => $image,
            'deep_link'         => $this->elasticExportHelper->getUrl($item, $settings, true, false),
            'price'             => $retailPrice,
            'old_price'         => $rrp,
            'currency'          => $currency,
            'delivery_costs'    => $deliveryCost,
            'category'          => $this->elasticExportHelper->getCategory((int)$item['data']['defaultCategories'][0]['id'], $settings->get('lang'), $settings->get('plentyId')),
            'brand'             => html_entity_decode($this->elasticExportHelper->getExternalManufacturerName((int)$item['data']['item']['manufacturer']['id'])),
            'gender_age'        => $this->itemPropertyCache[$item['data']['item']['id']]['gender_age'],
            'ean'               => $this->elasticExportHelper->getBarcodeByType($item, $settings->get('barcode')),
            'keywords'          => html_entity_decode($item['data']['texts'][0]['keywords']),
            'art_number'        => html_entity_decode($this->idlVariations[$item['id']]['variationBase.customNumber']),
            'color'             => [],
            'clothing_size'     => [],
            'cut'               => '',
            'link'              => '',
            'unit_price'        => $this->elasticExportHelper->getBasePrice($item, $this->idlVariations),
        ];

        return $data;
    }

    /**
     * Get variation attributes.
     * @param  Record   $item
     * @param  KeyValue $settings
     * @return array<string,string>
     */
    private function getVariationAttributes(Record $item, KeyValue $settings):array
    {
        $variationAttributes = [];

        foreach($item->variationAttributeValueList as $variationAttribute)
        {
            $attributeValueName = $this->attributeValueNameRepository->findOne($variationAttribute->attributeValueId, $settings->get('lang'));

            if($attributeValueName instanceof AttributeValueName)
            {
                if($attributeValueName->attributeValue->attribute->amazonAttribute)
                {
                    $variationAttributes[$attributeValueName->attributeValue->attribute->amazonAttribute][] = $attributeValueName->name;
                }
            }
        }

        return $variationAttributes;
    }

    /**
     * Get item properties.
     * @param 	array $item
     * @param   KeyValue $settings
     * @return array<string,string>
     */
    protected function getItemPropertyList($item, $settings):array
    {
        if(!array_key_exists($item['data']['item']['id'], $this->itemPropertyCache))
        {
            $characterMarketComponentList = $this->elasticExportHelper->getItemCharactersByComponent($item, $settings->get('referrerId'));

            $list = [];

            if(count($characterMarketComponentList))
            {
                foreach($characterMarketComponentList as $data)
                {
                    if((string) $data['characterValueType'] != 'file' && (string) $data['characterValueType'] != 'empty' && (string) $data['externalComponent'] != "0")
                    {
                        if((string) $data['characterValueType'] == 'selection')
                        {
                            $propertySelection = $this->propertySelectionRepository->findOne((int) $data['characterValue'], 'de');
                            if($propertySelection instanceof PropertySelection)
                            {
                                $list[(string) $data['externalComponent']] = (string) $propertySelection->name;
                            }
                        }
                        else
                        {
                            $list[(string) $data['externalComponent']] = (string) $data['characterValue'];
                        }

                    }
                }
            }

            $this->itemPropertyCache[$item['data']['item']['id']] = $list;
        }

        return $this->itemPropertyCache[$item['data']['item']['id']];
    }

    /**
     * @param RecordList $idlResultList
     */
    private function createIdlArray($idlResultList)
    {
        if($idlResultList instanceof RecordList)
        {
            foreach($idlResultList as $idlVariation)
            {
                if($idlVariation instanceof Record)
                {
                    $this->idlVariations[$idlVariation->variationBase->id] = [
                        'itemBase.id' => $idlVariation->itemBase->id,
                        'variationBase.id' => $idlVariation->variationBase->id,
                        'variationBase.customNumber' => $idlVariation->variationBase->customNumber,
                        'itemPropertyList' => $idlVariation->itemPropertyList,
                        'variationRetailPrice.price' => $idlVariation->variationRetailPrice->price,
                        'variationRetailPrice.currency'  => $idlVariation->variationRetailPrice->currency,
                        'variationRecommendedRetailPrice.price' => $idlVariation->variationRecommendedRetailPrice->price,
                    ];
                }
            }
        }
    }
}
