<?php

namespace Aldaflux\YoutubeUtilsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
		
        $rootNode = $treeBuilder->root('youtube_utils');
        $rootNode->children()->scalarNode( 'template' )->defaultValue('bootstrap4')->end();
        $rootNode->children()->scalarNode( 'delete' )->defaultValue('false')->end();
                


        return $treeBuilder;
    }
}
