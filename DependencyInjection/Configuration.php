<?php

namespace Aldaflux\YoutubeUtilsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use Symfony\Component\HttpKernel\Kernel;


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

        $treeBuilder = new TreeBuilder('youtube_utils');
        if (Kernel::VERSION_ID >= 40200) 
        {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            $rootNode = $treeBuilder->root('youtube_utils');
        }        

        $rootNode->children()->scalarNode( 'youtube_api_key' )->end();

        return $treeBuilder;
    }
}
