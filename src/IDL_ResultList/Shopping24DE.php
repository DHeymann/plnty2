<?php

namespace ElasticExportShopping24DE\IDL_ResultList;

use Plenty\Modules\Item\DataLayer\Contracts\ItemDataLayerRepositoryContract;
use Plenty\Modules\Helper\Models\KeyValue;
use Plenty\Modules\Item\DataLayer\Models\RecordList;

class Shopping24DE
{
    /**
     * @param array $variationIds
     * @param KeyValue $settings
     * @return RecordList|string
     */
    public function getResultList($variationIds, $settings)
    {
        $referrer = $settings->get('referrerId') ? $settings->get('referrerId') : -1;

        if(is_array($variationIds) && count($variationIds) > 0)
        {
            $searchFilter = array(
                'variationBase.hasId' => array(
                    'id' => $variationIds
                )
            );

            $resultFields = array(
                'itemBase' => array(
                    'id',
                ),

                'variationBase' => array(
                    'id',
                    'customNumber'
                ),

                'itemPropertyList' => array(
                    'params' => array(),
                    'fields' => array(
                        'itemPropertyId',
                        'propertyId',
                        'propertyValue',
                        'propertyValueType',
                    )
                ),

                'variationRetailPrice' => array(
                    'params' => array(
                        'referrerId' => $referrer,
                    ),
                    'fields' => array(
                        'price',
                        'currency'
                    ),
                ),

                'variationRecommendedRetailPrice' => array(
                    'params' => array(
                        'referrerId' => $referrer,
                    ),
                    'fields' => array(
                        'price',    // uvp
                    ),
                ),
            );

            $itemDataLayer = pluginApp(ItemDataLayerRepositoryContract::class);
            /**
             * @var ItemDataLayerRepositoryContract $itemDataLayer
             */
            $itemDataLayer = $itemDataLayer->search($resultFields, $searchFilter);
            return $itemDataLayer;
        }
        return '';
    }
}