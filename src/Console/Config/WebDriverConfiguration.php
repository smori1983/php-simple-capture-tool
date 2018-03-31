<?php

namespace Momo\Selenium\Console\Config;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class WebDriverConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('webdriver');
        $rootNode
            ->children()
                ->scalarNode('url')
                    ->isRequired()
                ->end()
                ->integerNode('connection_timeout_ms')
                    ->defaultNull()
                ->end()
                ->integerNode('request_timeout_ms')
                    ->defaultNull()
                ->end()
                ->arrayNode('browser')
                    ->children()
                        ->scalarNode('type')
                            ->isRequired()
                        ->end()
                        ->integerNode('width')
                            ->isRequired()
                            ->min(1)
                        ->end()
                        ->integerNode('height')
                            ->isRequired()
                            ->min(1)
                        ->end()
                    ->end()
                ->end()
                ->integerNode('page_load_timeout')
                    ->defaultNull()
                ->end()
                ->scalarNode('screenshot_save_directory')
                    ->isRequired()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
