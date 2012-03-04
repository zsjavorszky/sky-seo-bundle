<?php

namespace Sky\Bundle\SeoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This is the class that validates and merges configuration from your
 * app/config files
 *
 * To learn more see {@link
 * http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sky_seo');
        
        $rootNode
            ->children()
                ->arrayNode('providers')
                ->end()
            ->end()
        ;
        
        $this->addInMemoryProviderSection($rootNode);
        
        return $treeBuilder;
    }
    
    private function addInMemoryProviderSection(ArrayNodeDefinition $rootNode)
    {
    	$rootNode
            ->fixXmlConfig('provider')
    	    ->children()
                ->arrayNode('providers')
    	            ->children()
            	        ->arrayNode('in_memory')
            	            ->children()
            	                ->scalarNode('class')->defaultValue('Sky\Bundle\SeoBundle\InMemoryProvider')->end()
            	                ->arrayNode('defaults')
                                    ->children()
                                        ->scalarNode('title')->end()
                                        ->arrayNode('metas')
                                            ->useAttributeAsKey('id')
                                            ->prototype('array')
                                                ->useAttributeAsKey('id')
                                                ->prototype('variable')->end()
                                            ->end()
                                        ->end()
                                    ->end()
        	                    ->end()
                                ->arrayNode('routes')
                                ->useAttributeAsKey('id')
                                ->prototype('array')
                            	    ->children()
                                	    ->scalarNode('pattern')->end()
                                        ->scalarNode('title')->end()
                                        ->arrayNode('metas')
                                            ->useAttributeAsKey('id')
                                            ->prototype('array')
                                                ->useAttributeAsKey('id')
                                                ->prototype('variable')->end()
                                            ->end()
                                        ->end()
        	                        ->end()
                	            ->end()
                	        ->end()
                	    ->end()
            	    ->end()
            	->end()
    	    ->end()
    	;
    	
    }
    
}
