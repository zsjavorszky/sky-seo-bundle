<?php

namespace Sky\Bundle\SeoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link
 * http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SkySeoExtension extends Extension
{

    /**
     * {@inheritDoc}
     */
    public function load (array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        
        $loader = new Loader\XmlFileLoader($container, 
                new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        if (isset($config['providers'])
   		{
        	$class = $config['providers']['in_memory']['class'];
        	$defaults = $config['providers']['in_memory']['defaults'];
			$routes = $config['providers']['in_memory']['routes'];        	

	        $definition = $container->getDefinition('sky_seo.seo');
	
	        $fullName = 'sky_seo.providers.in_memory';
	        $container->setDefinition($fullName,
	       		new Definition($class, array($defaults, $routes)));
	        
	        $this->twigLoad($config, $container);
   		}

    }
    
   public function twigLoad(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('twig.xml');
    }
    
}
