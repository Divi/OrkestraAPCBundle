<?php

namespace Orkestra\APCBundle\DependencyInjection;

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
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('orkestra_apc');

		$rootNode
			->isRequired()
            ->children()
                ->scalarNode('website_url')->isRequired()->end()
                ->scalarNode('web_dir')->defaultValue('%kernel.root_dir%/../web')->end()
                ->scalarNode('access_password')->defaultValue('null')->end()
                ->scalarNode('access_mode')->defaultValue('fopen')->end()
            ->end()
		;

        return $treeBuilder;
    }
}