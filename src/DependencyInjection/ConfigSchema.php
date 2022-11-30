<?php

/**
 * Created by PhpStorm.
 * @author Erofeev Artem <erofeevas@pik.ru>
 * @date 30.11.2022
 * @time 19:35
 */

declare(strict_types=1);

namespace Pik\Reindexer\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ConfigSchema implements ConfigurationInterface
{

    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        return new TreeBuilder('pik_rx');
    }
}
