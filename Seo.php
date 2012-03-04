<?php
namespace Sky\Bundle\SeoBundle;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\DependencyInjection\ContainerAware;

class Seo extends ContainerAware
{

    protected $match = null;

    /**
     * Returns meta content.
     *
     * @param $attributeName string           
     * @param $attributeValue string           
     * @return string meta content
     */
    public function getMetaContent ($attributeName, $attributeValue)
    {
        $routeName = $this->getRouteName();
        $metaContent = $this->getProvider()->getMetaContent($routeName, 
                $attributeName, $attributeValue);
        
        return $metaContent;
    }

    public function getMetas ()
    {
        $routeName = $this->getRouteName();
        $metas = $this->getProvider()->getMetas($routeName);
        
        return $metas;
    }

    private function getRouteName ()
    {
        $match = $this->getMatch();
        
        if (isset($match['_route'])) {
            $routeName = $match['_route'];
        } else {
            $routeName = '';
        }
        
        return $routeName;
    }

    public function getTitle ()
    {
        $routeName = $this->getRouteName();
        $title = $this->getProvider()->getTitle($routeName);
        
        return $title;
    }

    protected function getMatch ()
    {
        if ($this->match == null) {
            $matcher = $this->getMatcher();
            $path = $req = $this->container->get('request')->getPathInfo();
            try {
                $match = $matcher->match($path);
            }
            catch(ResourceNotFoundException $e)
            {
                $match = array();
            }
            
            $this->match = $match;            
        } else {
            $match = $this->match;
        }

        return $match;
    }

    protected function getMatcher ()
    {
        $context = $this->container->get('router')->getContext();
        $provider = $this->getProvider();
        $routeCollection = $provider->getRouteCollection();
        $matcher = new UrlMatcher($routeCollection, $context);
        
        return $matcher;
    }

    protected function getProvider ()
    {
        $inMemoryProvider = $this->container->get('sky_seo.providers.in_memory');
        return $inMemoryProvider;
    }
}