<?php

namespace Aldaflux\YoutubeUtilsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use Symfony\Component\HttpKernel\Kernel;
 
class Configuration implements ConfigurationInterface
{
    
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder() : TreeBuilder
    {

        $treeBuilder = new TreeBuilder('aldaflux_youtube_utils');
        if (Kernel::VERSION_ID >= 40200) 
        {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            $rootNode = $treeBuilder->root('aldaflux_youtube_utils');
        }        

        $rootNode->children()->scalarNode( 'youtube_api_key' )->end();

        return $treeBuilder;
    }
}
