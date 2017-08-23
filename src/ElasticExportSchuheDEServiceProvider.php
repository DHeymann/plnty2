<?php

namespace ElasticExportSchuheDE;

use Plenty\Modules\DataExchange\Services\ExportPresetContainer;
use Plenty\Plugin\DataExchangeServiceProvider;


/**
 * Class ElasticExportSchuheDEServiceProvider
 * @package ElasticExportSchuheDE
 */
class ElasticExportSchuheDEServiceProvider extends DataExchangeServiceProvider
{
    /**
     * Abstract function for registering the service provider.
     */
    public function register()
    {

    }

    /**
     * Adds the export format to the export container.
     *
     * @param ExportPresetContainer $container
     */
    public function exports(ExportPresetContainer $container)
    {
        $container->add(
            'SchuheDE-Plugin',
            'ElasticExportSchuheDE\ResultField\SchuheDE',
            'ElasticExportSchuheDE\Generator\SchuheDE',
            '',
            true,
			true
        );
    }
}