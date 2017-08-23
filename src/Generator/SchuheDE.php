<?php

namespace ElasticExportSchuheDE\Generator;

use ElasticExport\Helper\ElasticExportCoreHelper;
use ElasticExport\Helper\ElasticExportPriceHelper;
use ElasticExport\Helper\ElasticExportPropertyHelper;
use ElasticExport\Helper\ElasticExportStockHelper;
use Plenty\Modules\DataExchange\Contracts\CSVPluginGenerator;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Helper\Models\KeyValue;
use Plenty\Modules\Item\Attribute\Contracts\AttributeValueNameRepositoryContract;
use Plenty\Modules\Item\Attribute\Models\AttributeValueName;
use Plenty\Modules\Item\Property\Contracts\PropertySelectionRepositoryContract;
use Plenty\Modules\Item\Property\Models\PropertySelection;
use Plenty\Modules\Item\Search\Contracts\VariationElasticSearchScrollRepositoryContract;
use Plenty\Plugin\Log\Loggable;

/**
 * Class SchuheDE
 * @package ElasticExportSchuheDE\Generator
 */
class SchuheDE extends CSVPluginGenerator
{
	use Loggable;

    const SCHUHE_DE = 141.00;

    /**
     * @var ElasticExportCoreHelper $elasticExportCoreHelper
     */
    private $elasticExportCoreHelper;

	/**
	 * @var ElasticExportPriceHelper $elasticExportPriceHelper
	 */
    private $elasticExportPriceHelper;

	/**
	 * @var ElasticExportStockHelper $elasticExportStockHelper
	 */
    private $elasticExportStockHelper;

	/**
	 * @var ElasticExportPropertyHelper $elasticExportPropertyHelper
	 */
    private $elasticExportPropertyHelper;

    /**
     * @var ArrayHelper $arrayHelper
     */
    private $arrayHelper;

    /**
     * @var AttributeValueNameRepositoryContract $attributeValueNameRepository
     */
    private $attributeValueNameRepository;

    /**
     * @var PropertySelectionRepositoryContract $propertySelectionRepository
     */
    private $propertySelectionRepository;

    /**
     * @var array $variations
     */
    private $variations = [];

    /**
     * SchuheDE constructor.
     *
     * @param ArrayHelper $arrayHelper
     * @param AttributeValueNameRepositoryContract $attributeValueNameRepository
     * @param PropertySelectionRepositoryContract $propertySelectionRepository
     */
    public function __construct(
        ArrayHelper $arrayHelper,
        AttributeValueNameRepositoryContract $attributeValueNameRepository,
        PropertySelectionRepositoryContract $propertySelectionRepository
    )
    {
        $this->arrayHelper = $arrayHelper;
        $this->attributeValueNameRepository = $attributeValueNameRepository;
        $this->propertySelectionRepository = $propertySelectionRepository;
    }

    /**
     * Generates and populates the data into the CSV file.
     *
     * @param VariationElasticSearchScrollRepositoryContract $elasticSearch
     * @param array $formatSettings
     * @param array $filter
     */
    protected function generatePluginContent($elasticSearch, array $formatSettings = [], array $filter = [])
    {
        $this->elasticExportCoreHelper 		= pluginApp(ElasticExportCoreHelper::class);
        $this->elasticExportPriceHelper 	= pluginApp(ElasticExportPriceHelper::class);
		$this->elasticExportStockHelper 	= pluginApp(ElasticExportStockHelper::class);
		$this->elasticExportPropertyHelper 	= pluginApp(ElasticExportPropertyHelper::class);

		$settings = $this->arrayHelper->buildMapFromObjectList($formatSettings, 'key', 'value');

		$this->setDelimiter(";");

		$this->addCSVContent([
			'Identnummer',
			'Artikelnummer',
			'Herstellerartikelnummer',
			'Artikelname',
			'Artikelbeschreibung',
			'Bild(er)',
			'360 Grad',
			'Bestand',
			'Farbe',
			'Farbe Suche I',
			'Farbe Suche II',
			'Hersteller Farbbezeichnung',
			'GG Größengang',
			'Größe',
			'Marke',
			'Saison',
			'EAN',
			'Währung',
			'Versandkosten',
			'Info Versandkosten',
			'Preis (UVP)',
			'reduzierter Preis',
			'Grundpreis',
			'Grundpreis Einheit',
			'Kategorien',
			'Link',
			'Anzahl Verkäufe',
			'Schuhbreite',
			'Absatzhöhe',
			'Absatzform',
			'Schuhspitze',
			'Obermaterial',
			'Schaftweite',
			'Schafthöhe',
			'Materialzusammensetzung',
			'Besonderheiten',
			'Verschluss',
			'Innenmaterial',
			'Sohle',
			'Größenhinweis',
			'Wechselfussbett',
			'Wasserdicht',
			'Promotion',
			'URL Video',
			'Steuersatz',
			'ANWR schuh Trend',
		]);

		if($elasticSearch instanceof VariationElasticSearchScrollRepositoryContract)
		{
			$limitReached = false;
			$lines = 0;
			do
			{
				if($limitReached === true)
				{
					break;
				}

				$resultList = $elasticSearch->execute();

				foreach($resultList['documents'] as $variation)
				{
					if($lines == $filter['limit'])
					{
						$limitReached = true;
						break;
					}

					if(is_array($resultList['documents']) && count($resultList['documents']) > 0)
					{
						if($this->elasticExportStockHelper->isFilteredByStock($variation, $filter) === true)
						{
							continue;
						}

						try
						{
							$this->buildRow($variation, $settings);
						}
						catch(\Throwable $throwable)
						{
							$this->getLogger(__METHOD__)->error('ElasticExportGoogleShopping::logs.fillRowError', [
								'Error message ' => $throwable->getMessage(),
								'Error line'    => $throwable->getLine(),
								'VariationId'   => $variation['id']
							]);
						}
						$lines = $lines +1;
					}
				}
			}while ($elasticSearch->hasNext());
		}
    }

	/**
	 * @param array $variation
	 * @param KeyValue $settings
	 */
    private function buildRow($variation, $settings)
	{
		$variationAttributes = $this->getVariationAttributes($variation, $settings);
        if($this->handled($variation['data']['item']['id'], $variationAttributes))
        {
            return;
        }

        $itemPropertyList = $this->elasticExportPropertyHelper->getItemPropertyList($variation, self::SCHUHE_DE);

		$priceList = $this->elasticExportPriceHelper->getPriceList($variation, $settings, 2, '.');

        $basePriceData = $this->elasticExportPriceHelper->getBasePriceDetails($variation, (float) $priceList['price'], $settings->get('lang'));

		$data = [
			'Identnummer'                   => $variation['id'],
			'Artikelnummer'                 => $variation['data']['variation']['number'],
			'Herstellerartikelnummer'       => $variation['data']['variation']['model'],
			'Artikelname'                   => $this->elasticExportCoreHelper->getName($variation, $settings),
			'Artikelbeschreibung'           => $this->elasticExportCoreHelper->getMutatedDescription($variation, $settings),
			'Bild(er)'                      => $this->getImages($variation, $settings, ';'),
			'360 Grad'                      => $this->getProperty($variationAttributes, $itemPropertyList, '360_view_url'),
			'Bestand'                       => $this->elasticExportStockHelper->getStock($variation),
			'Farbe'                         => $this->getProperty($variationAttributes, $itemPropertyList, 'color'),
			'Farbe Suche I'                 => $this->getProperty($variationAttributes, $itemPropertyList, 'color_1'),
			'Farbe Suche II'                => $this->getProperty($variationAttributes, $itemPropertyList, 'color_2'),
			'Hersteller Farbbezeichnung'    => $this->getProperty($variationAttributes, $itemPropertyList, 'producer_color'),
			'GG Größengang'                 => $this->getProperty($variationAttributes, $itemPropertyList, 'size_range'),
			'Größe'                         => $this->getProperty($variationAttributes, $itemPropertyList, 'size'),
			'Marke'                         => $this->elasticExportCoreHelper->getExternalManufacturerName((int)$variation['data']['item']['manufacturer']['id']),
			'Saison'                        => $this->getProperty($variationAttributes, $itemPropertyList, 'season'),
			'EAN'                           => $this->elasticExportCoreHelper->getBarcodeByType($variation, $settings->get('barcode')),
			'Währung'                       => $priceList['currency'],
			'Versandkosten'                 => $this->elasticExportCoreHelper->getShippingCost($variation['data']['item']['id'], $settings),
			'Info Versandkosten'            => $this->getProperty($variationAttributes, $itemPropertyList, 'shipping_costs_info'),
			'Preis (UVP)'                   => $priceList['recommendedRetailPrice'] > $priceList['price'] ? $priceList['recommendedRetailPrice'] : $priceList['price'],
			'reduzierter Preis'             => $priceList['recommendedRetailPrice'] > $priceList['price'] ? $priceList['price'] : '',
            'Grundpreis'                    => count($basePriceData) ? number_format((float)$basePriceData['price'], 2, '.','') : '',
            'Grundpreis Einheit'            => count($basePriceData) ? 'pro '.$basePriceData['lot'].' '.$basePriceData['unitLongName'] : '',
			'Kategorien'                    => $this->getCategories($variation, $settings),
			'Link'                          => $this->elasticExportCoreHelper->getMutatedUrl($variation, $settings),
			'Anzahl Verkäufe'               => $this->getProperty($variationAttributes, $itemPropertyList, 'sold_items'),
			'Schuhbreite'                   => $this->getProperty($variationAttributes, $itemPropertyList, 'shoe_width'),
			'Absatzhöhe'                    => $this->getProperty($variationAttributes, $itemPropertyList, 'heel_height'),
			'Absatzform'                    => $this->getProperty($variationAttributes, $itemPropertyList, 'heel_form'),
			'Schuhspitze'                   => $this->getProperty($variationAttributes, $itemPropertyList, 'shoe_tip'),
			'Obermaterial'                  => $this->getProperty($variationAttributes, $itemPropertyList, 'upper_material'),
			'Schaftweite'                   => $this->getProperty($variationAttributes, $itemPropertyList, 'calf_size'),
			'Schafthöhe'                    => $this->getProperty($variationAttributes, $itemPropertyList, 'calf_height'),
			'Materialzusammensetzung'       => $this->getProperty($variationAttributes, $itemPropertyList, 'material_composition'),
			'Besonderheiten'                => $this->getProperty($variationAttributes, $itemPropertyList, 'features'),
			'Verschluss'                    => $this->getProperty($variationAttributes, $itemPropertyList, 'fastener'),
			'Innenmaterial'                 => $this->getProperty($variationAttributes, $itemPropertyList, 'interior_material'),
			'Sohle'                         => $this->getProperty($variationAttributes, $itemPropertyList, 'sole'),
			'Größenhinweis'                 => $this->getProperty($variationAttributes, $itemPropertyList, 'size_advice'),
			'Wechselfussbett'               => $this->getProperty($variationAttributes, $itemPropertyList, 'removable_insole'),
			'Wasserdicht'                   => $this->getProperty($variationAttributes, $itemPropertyList, 'waterproof'),
			'Promotion'                     => $this->getProperty($variationAttributes, $itemPropertyList, 'promotion'),
			'URL Video'                     => $this->getProperty($variationAttributes, $itemPropertyList, 'video_url'),
			'Steuersatz'                    => $this->getProperty($variationAttributes, $itemPropertyList, 'tax'),
			'ANWR schuh Trend'              => $this->getProperty($variationAttributes, $itemPropertyList, 'shoe_trend'),
		];

		$this->addCSVContent(array_values($data));
	}

    /**
     * Get property.
     *
     * @param  array    $variationAttributes
     * @param  array    $itemPropertyList
     * @param  string   $property
     * @return string
     */
    private function getProperty(array $variationAttributes, array $itemPropertyList, string $property):string
    {
        if(array_key_exists($property, $variationAttributes))
        {
            return $variationAttributes[$property];
        }

        if(array_key_exists($property, $itemPropertyList))
        {
            return $itemPropertyList[$property];
        }

        return '';
    }

    /**
     * Get variation attributes.
     *
     * @param  array    $variation
     * @param  KeyValue $settings
     * @return array<string,string>
     */
    private function getVariationAttributes($variation, KeyValue $settings)
    {
        $variationAttributes = [];

        foreach($variation['data']['attributes'] as $variationAttribute)
        {
            $attributeValueName = $this->attributeValueNameRepository->findOne($variationAttribute['valueId'], $settings->get('lang'));

            if($attributeValueName instanceof AttributeValueName)
            {
                if($attributeValueName->attributeValue->attribute->amazonAttribute == 'Color')
                {
                    $variationAttributes['color'][] = $attributeValueName->name;
                }

                if($attributeValueName->attributeValue->attribute->amazonAttribute == 'Size')
                {
                    $variationAttributes['size'][] = $attributeValueName->name;
                }
            }
        }

        $list = [];

        foreach($variationAttributes as $key => $value)
        {
            if(is_array($value) && count($value))
            {
                $list[$key] = implode(', ', $value);
            }
        }

        return $list;
    }

    /**
     * Check if attributes were already handled.
     *
     * @param  int  $itemId
     * @param  array<string,string> $variationAttributes
     * @return bool
     */
    private function handled(int $itemId, array $variationAttributes):bool
    {
        $attributes = $this->hashAttributes($itemId, $variationAttributes);

        if(in_array($attributes, $this->variations))
        {
            return true;
        }

        $this->variations[] = $attributes;

        return false;
    }

    /**
     * Generate attributes hash.
     *
     * @param  int  $itemId
     * @param  array<string,string> $variationAttributes
     * @return string
     */
    private function hashAttributes(int $itemId, array $variationAttributes):string
    {
        $attributes = (string) $itemId;

        if(count($variationAttributes))
        {
            $attributes .= implode(';', $variationAttributes);
        }

        return $attributes;
    }

    /**
     * Get list of categories.
     *
     * @param  array    $variation
     * @param  KeyValue $settings
     * @return string
     */
    private function getCategories($variation, KeyValue $settings):string
    {
        $categoryList = [];

        if(is_array($variation['data']['ids']['categories']['branches']) && count($variation['data']['ids']['categories']['branches']) > 0)
        {
			// go though the list of the category details
			foreach($variation['data']['ids']['categories']['branches'] as $categoryId)
			{
				// pass the category id to construct the category path
				$category = $this->elasticExportCoreHelper->getSingleCategory((int)$categoryId, $settings->get('lang'), $settings->get('plentyId'));

				if(strlen($category))
				{
					$categoryList[] = $category;
				}
			}

			return implode(';', $categoryList);
		}

		return '';
    }

    /**
     * Get images.
     *
     * @param  array    $variation
     * @param  KeyValue $settings
     * @param  string   $separator  = ','
     * @param  string   $imageType  = 'normal'
     * @return string
     */
    public function getImages($variation, KeyValue $settings, string $separator = ',', string $imageType = 'normal'):string
    {
        $list = $this->elasticExportCoreHelper->getImageList($variation, $settings, $imageType);

        if(count($list))
        {
            return implode($separator, $list);
        }

        return '';
    }
}
