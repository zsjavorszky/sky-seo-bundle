<?php
namespace Sky\Bundle\SeoBundle;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

class InMemoryProvider
{

    protected $defaults;

    protected $routes;

    protected $routeCollection;
    
    function __construct ($defaults, $routes)
    {
        $this->defaults = $defaults;
        $this->routes = $routes;
        $this->routeCollection = null;
        
    }

    public function getTitle ($routeName)
    {
        if (isset($this->routes[$routeName]['title'])) {
            $title = $this->routes[$routeName]['title'];
        } else {
            $title = $this->defaults['title'];
        }
        
        return $title;
    }

    public function getMetaContent($routeName, $attributeName, $attributeValue)
    {
        if (isset($this->routes[$routeName]['metas'][$attributeName][$attributeValue]))
        {
            $content = $this->routes[$routeName]['metas'][$attributeName][$attributeValue];

        }
        elseif (isset($this->defaults['metas'][$attributeName][$attributeValue]))
        {
            $content = $this->defaults['metas'][$attributeName][$attributeValue];
        }
        else
        {
            $content = null;
        }
        
        return $content;
        
    }

    public function getMetas ($routeName)
    {
        $metas = $this->defaults['metas'];
        $overwriteMetas = array();
        if (isset($this->routes[$routeName]['metas']))
        {
            $overwriteMetas = $this->routes[$routeName]['metas'];
        }

        foreach($overwriteMetas as $metasKey => $metasValues)
        {
            foreach ($metasValues as $metaKey => $metaValue)
            {
                $metas[$metasKey][$metaKey] = $metaValue;
            }
            
        }
        
        return $metas;
    }
    
    /**
     *
     * @return the $routeCollection
     */
    public function getRouteCollection ()
    {
        if ($this->routeCollection === null)
        {
            $routes = $this->routes;
            $routeCollection = new RouteCollection();
            foreach ($routes as $name => $value) {
                $routeCollection->add($name, new Route($value['pattern']));
                unset($this->routes[$name]['pattern']);
            }
            $this->routeCollection = $routeCollection;
        }
        
        return $this->routeCollection;
    }
}