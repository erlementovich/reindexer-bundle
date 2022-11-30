<?php

/**
 * Created by PhpStorm.
 * @author Erofeev Artem <erofeevas@pik.ru>
 * @date 30.11.2022
 * @time 19:45
 */

declare(strict_types=1);

namespace Pik\Reindexer\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class PikRxExtension extends Extension
{
    /**
     * @inheritDoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configDir = new FileLocator(__DIR__ . '/../../config');

        // Load the bundle's service declarations
        $loader = new YamlFileLoader($container, $configDir);
        $loader->load('services.yaml');
        // Apply our config schema to the given app's configs
        $schema = new ConfigSchema();
        $this->processConfiguration($schema, $configs);
    }
}
