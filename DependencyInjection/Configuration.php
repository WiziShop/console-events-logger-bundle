<?php

namespace WiziShop\ConsoleEventsLoggerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     *
     * @return treeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('wizi_shop_console_events_logger');

        $rootNode
            ->children()
                ->booleanNode('activated')->defaultTrue()->end()
                ->booleanNode('show_event_start')->defaultTrue()->end()
                ->booleanNode('show_event_terminate')->defaultTrue()->end()
                ->scalarNode('token')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('room_name')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('username')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('icon')->defaultValue('ICON')->end()
            ->end();

        return $treeBuilder;
    }
}
