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

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $builder = (new TreeBuilder('pik_reindexer'));

        $builder
            ->getRootNode()
                ->children()
                    ->append($this->createClientsNode())
                    ->end()
        ;

        return $builder;
    }

    private function createClientsNode(): ArrayNodeDefinition
    {
        $node = (new TreeBuilder('clients'))->getRootNode();

        /** @var \Symfony\Component\Config\Definition\Builder\NodeBuilder $nodeChildren */
        $nodeChildren = $node
            ->useAttributeAsKey('name')
            ->prototype('array')
            ->children();

        $nodeChildren
            ->scalarNode('url')->end()
            ->scalarNode('dbname')->end()
            ->scalarNode('api_class')->defaultNull()->end()
        ;

        return $node;
    }
}
