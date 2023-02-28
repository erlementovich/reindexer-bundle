<?php

/**
 * @author    Erofeev Artem <erofeevas@pik.ru>
 * @copyright Copyright (c) 2022, PIK Digital
 * @see       https://pik.digital
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pik\Bundle\ReindexerBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class PikRxExtension extends Extension
{
    /**
     * {@inheritDoc}
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
