<?php

namespace ElasticExportShopping24DE;

use Plenty\Modules\DataExchange\Services\ExportPresetContainer;
use Plenty\Plugin\DataExchangeServiceProvider;

class ElasticExportShopping24DEServiceProvider extends DataExchangeServiceProvider
{
    public function register()
    {

    }

    public function exports(ExportPresetContainer $container)
    {
        $container->add(
            'Shopping24DE-Plugin',
            'ElasticExportShopping24DE\ResultField\Shopping24DE',
            'ElasticExportShopping24DE\Generator\Shopping24DE',
            '',
            true
        );
    }
}