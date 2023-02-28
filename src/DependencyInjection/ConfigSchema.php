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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ConfigSchema implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        return new TreeBuilder('pik_rx');
    }
}
