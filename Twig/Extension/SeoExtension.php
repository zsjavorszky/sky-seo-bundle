<?php

namespace Sky\Bundle\SeoBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;

class SeoExtension extends \Twig_Extension
{

    protected $seo;

    public function __construct ($seo)
    {
        $this->seo = $seo;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions ()
    {
        $options = array('is_safe' => array('html'));
        return array(
                'sky_seo_get_title' => new \Twig_Function_Method($this, 
                        'getTitle', $options), 
                'sky_seo_get_meta_content' => new \Twig_Function_Method($this, 
                        'getMetaContent', $options), 
                'sky_seo_get_metas' => new \Twig_Function_Method($this, 
                        'getMetas', $options), 
                'sky_seo_title' => new \Twig_Function_Method($this, 
                        'renderTitle', $options), 
                'sky_seo_meta_element' => new \Twig_Function_Method($this, 
                        'renderMetaElement', $options), 
                'sky_seo_meta_elements' => new \Twig_Function_Method($this, 
                        'renderMetaElements', $options));
    }

    /**
     * Returns meta content.
     *
     * @param $attributeName string           
     * @param $attributeValue string          
     *
     * @return string meta content
     */
    public function getMetaContent ($attributeName, $attributeValue)
    {
        return $this->seo->getMetaContent($attributeName, $attributeValue);
    }

    /**
     * Return an array of meta element attributes.
     *
     * @return array An array of meta element attributes
     */
    public function getMetas ()
    {
        return $this->seo->getMetas();
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName ()
    {
        return 'Seo';
    }

    /**
     * Returns the title.
     *
     * @return string The extension name
     */
    public function getTitle ()
    {
        return $this->seo->getTitle();
    }

    /**
     * Retuns html meta element.
     *
     * @param $attributeName string           
     * @param $attributeValue string           
     *
     * @return string html meta element
     */
    public function renderMetaElement ($attributeName, $attributeValue)
    {
        $content = $this->getMetaContent($attributeName, $attributeValue);
        return sprintf('<meta name="%s" content="%s" />', $attributeValue, 
                $content);
    }

    /**
     * Returns html meta elements
     *
     * @return string html meta elements
     */
    public function renderMetaElements ()
    {
        $renderedMetas = "";
        $metas = $this->getMetas();
        
        foreach ($metas as $attributeName => $attributeValues) {
            foreach ($attributeValues as $attributeValue => $content) {
                $renderedMetas .= $this->renderMetaElement($attributeName, 
                        $attributeValue);
            }
        }
        
        return $renderedMetas;
    }

    /**
     * Returns html title element.
     *
     *
     * @return string html title element
     */
    public function renderTitle ()
    {
        return sprintf('<title>%s</title>', $this->getTitle());
    }

}