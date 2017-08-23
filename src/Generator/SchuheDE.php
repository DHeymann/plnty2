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
			'Bestand',
			'Farbe',
            'EAN',
			'Währung',
			'Versandkosten',
			'Info Versandkosten',
			'Preis (UVP)',
			'reduzierter Preis',
			'Grundpreis',
			'Grundpreis Einheit',
            'Preis01',
            'Preis01ID',
            'Preis02',
            'Preis02ID',
            'Preis03',
            'Preis03ID',
            'Kategorien',
			'Link',
			'Anzahl Verkäufe',
			'Steuersatz',
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

		//$priceList = $this->elasticExportPriceHelper->getPriceList($variation, $settings, 2, '.');
        $priceList = $this->getPriceListHeym01($variation, $settings, 2, '.');

        $basePriceData = $this->elasticExportPriceHelper->getBasePriceDetails($variation, (float) $priceList['price'], $settings->get('lang'));
        $testPreis1 = $this->elasticExportPriceHelper->getBasePriceDetails($variation, (float) $priceList['price'], $settings->get('lang'));
        $temp = $variation['data']['variation'];
        $temp  = $priceList;
        if (is_array($temp))
        {
            $ausgabe_temp = "offen";
            foreach ($temp as $name=>$wert)
            {
                if (is_array($wert))
                {
                    $wert_schreiben = "Array";
                }else{
                    $wert_schreiben = "$wert";
                }
                $ausgabe_temp.= " $name = $wert_schreiben | ";
            }
        }else{
            $ausgabe_temp = "kein Array";
        }

		$data = [
			'Identnummer'                   => $variation['id'],
			'Artikelnummer'                 => $variation['data']['variation']['number'],
			'Herstellerartikelnummer'       => $variation['data']['variation']['model'],
			'Artikelname'                   => $this->elasticExportCoreHelper->getName($variation, $settings),
			'Artikelbeschreibung'           => $this->elasticExportCoreHelper->getMutatedDescription($variation, $settings),
			'Bild(er)'                      => $this->getImages($variation, $settings, ';'),
			'Bestand'                       => $this->elasticExportStockHelper->getStock($variation),
			'Farbe'                         => $this->getProperty($variationAttributes, $itemPropertyList, 'color'),
			'EAN'                           => $this->elasticExportCoreHelper->getBarcodeByType($variation, $settings->get('barcode')),
			'Währung'                       => $priceList['currency'],
			'Versandkosten'                 => $this->elasticExportCoreHelper->getShippingCost($variation['data']['item']['id'], $settings),
			'Info Versandkosten'            => $this->getProperty($variationAttributes, $itemPropertyList, 'shipping_costs_info'),
			'Preis (UVP)'                   => $priceList['recommendedRetailPrice'] > $priceList['price'] ? $priceList['recommendedRetailPrice'] : $priceList['price'],
			'reduzierter Preis'             => $priceList['recommendedRetailPrice'] > $priceList['price'] ? $priceList['price'] : '',
            'Grundpreis'                    => count($basePriceData) ? number_format((float)$basePriceData['price'], 2, '.','') : '',
            'Grundpreis Einheit'            => count($basePriceData) ? 'pro '.$basePriceData['lot'].' '.$basePriceData['unitLongName'] : '',
            'Preis01'                       => 'T1: ' .  $ausgabe_temp,
            'Preis01ID'                     => $variation['data']['variation']['variationSalesPrices'][0]['salesPriceId'],
            'Preis02'                       => $variation['data']['variation']['variationSalesPrices'][1]['price'],
            'Preis02ID'                     => $variation['data']['variation']['variationSalesPrices'][1]['salesPriceId'],
            'Preis03'                       => $variation['data']['variation']['variationSalesPrices'][2]['price'],
            'Preis03ID'                     => $variation['data']['variation']['variationSalesPrices'][2]['salesPriceId'],
			'Kategorien'                    => $this->getCategories($variation, $settings),
			'Link'                          => $this->elasticExportCoreHelper->getMutatedUrl($variation, $settings),
			'Anzahl Verkäufe'               => $this->getProperty($variationAttributes, $itemPropertyList, 'sold_items'),
			'Steuersatz'                    => $this->getProperty($variationAttributes, $itemPropertyList, 'tax'),
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


    public function getPriceListHeym01($variation, KeyValue $settings, $decimals = 2, $decSeparator = '.'):array
    {
        //$countryId = $settings->get('destination');
        //$currency = $this->currencyRepository->getCountryCurrency($countryId)->currency;

        // getting the retail price
        $this->salesPriceSearchRequest->variationId = $variation['id'];
        $this->salesPriceSearchRequest->referrerId = $settings->get('referrerId');
        $this->salesPriceSearchRequest->plentyId = $settings->get('plentyId');
        $this->salesPriceSearchRequest->type = 'default';
        $this->salesPriceSearchRequest->countryId = $countryId;
        $this->salesPriceSearchRequest->currency = $currency;

        $salesPriceSearch  = $this->salesPriceSearchRepository->search($this->salesPriceSearchRequest);
        $price = '';
        $vatValue = '';
        $variationRrp = '';
        $variationSpecialPrice = '';

        if(isset($salesPriceSearch->price))
        {
            $price = number_format((float)$salesPriceSearch->price, $decimals, $decSeparator, '');
        }

        if(isset($salesPriceSearch->vatValue))
        {
            $vatValue = $salesPriceSearch->vatValue;
        }

        // getting the recommended retail price
        if($settings->get('transferRrp') == self::TRANSFER_RRP_YES)
        {
            $this->salesPriceSearchRequest->type = 'rrp';
            $salesPriceSearch = $this->salesPriceSearchRepository->search($this->salesPriceSearchRequest);

            if(isset($salesPriceSearch->price))
            {
                $variationRrp = number_format((float)$salesPriceSearch->price, $decimals, $decSeparator, '');
            }
        }

        // getting the special price
        if($settings->get('transferOfferPrice') == self::TRANSFER_OFFER_PRICE_YES)
        {
            $this->salesPriceSearchRequest->type = 'specialOffer';
            $salesPriceSearch = $this->salesPriceSearchRepository->search($this->salesPriceSearchRequest);

            if(isset($salesPriceSearch->price))
            {
                $variationSpecialPrice = number_format((float)$salesPriceSearch->price, $decimals, $decSeparator, '');
            }
        }

        return array(
            'price'                     =>	$price,
            'recommendedRetailPrice'	=>	$variationRrp,
            'specialPrice'              =>	$variationSpecialPrice,
            'vatValue'                  =>	$vatValue,
            'currency'					=>	$currency
        );
    }

}
