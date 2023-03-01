<?php

/**
 * @author    Erofeev Artem <artem.erof1@gmail.com>
 * @author    Molchanov Danila <danila.molchanovv@gmail.com>
 * @copyright Copyright (c) 2022, PIK Digital
 * @see       https://pik.digital
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pik\Bundle\ReindexerBundle\DependencyInjection;

use Pik\Bundle\ReindexerBundle\Client\Client;
use Pik\Bundle\ReindexerBundle\Client\ClientInterface;
use Reindexer\Client\Api;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class PikReindexerExtension extends Extension
{
    /**
     * @param array<array-key, mixed> $configs
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach ($config['clients'] as $name => $options) {
            $client = new Definition(Client::class);
            $client->addArgument($this->createApi($container, $name, $options));
            $client->addArgument($options['dbname']);

            $serviceName = sprintf('%s.client.%s', $this->getAlias(), $name);
            $container->setDefinition($serviceName, $client);

            $container->registerAliasForArgument($serviceName, ClientInterface::class, $name . 'Client');
        }
    }

    private function createApi(ContainerBuilder $container, string $clientName, array $options): Definition
    {
        $api = new Definition(Api::class);
        $api->addArgument($options['url']);

        $apiServiceName = sprintf('%s.%s.api', $this->getAlias(), $clientName);
        $container->setDefinition($apiServiceName, $api);

        return $api;
    }

    public function getAlias(): string
    {
        return 'pik_reindexer';
    }
}
