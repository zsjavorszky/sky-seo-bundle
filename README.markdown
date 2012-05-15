# SkySeoBundle

## Installation

### Get the bundle
Add the following lines to your deps file and then run php bin/vendors install:

    [SkySeoBundle]
        git=http://github.com/sky-one/SkySeoBundle
        target=bundles/Sky/Bundle/SeoBundle

### Register the namespaces
Add the following namespace entriy to the registerNamespaces call in your autoloader:

    <?php
    
    // app/autoload.php
    $loader->registerNamespaces(array(
    // ...
    'Sky' => __DIR__.'/../vendor/bundles',
    // ...
    ));

### Register the bundle
To start using the bundle, register it in your Kernel:

    <?php
    
    // app/AppKernel.php
    
    public function registerBundles()
    {
        $bundles = array(
        // ...
        new Sky\Bundle\SeoBundle\SkySeoBundle(),
    );
    // ...
    }


## Config

### Import seo.yml
To put the configuration in a external file named "seo.yml" stored in the app/config folder just write in the app/config/config.yml file:

    imports:
        seo: { resource: seo.yml }


### Configure seo.yml file
    sky_seo:
        providers:
            in_memory:
                defaults:
                    title: "Example Site Title"
                    metas:
                        name:
                            http-equiv:           utf-8
                            keywords:             example,seo
                            description:          "Example site default description."
                routes:
                    about:
                        pattern: "/about"
                    contact:
                        pattern: "/contact"
                        metas:
                            name:
                            title:              "Contact page title"
                            description:        "Contact page description."


## Usage 

###Twig Functions:

####sky_seo_get_title()
Returns the title value.

Layout file:

    <head>
    <title>{{sky_seo_get_title()}}</title>
    </head>

HTML output:

    <head>
    <title>Example Site Title</title>
    </head>

####sky_seo_get_meta_content($attributeName, $attributeValue)
Returns a meta value.

Layout file:

    <head>
    <meta name="keywords" content="{{sky_seo_get_meta_content('name', 'keywords')}}" />
    </head>

HTML output:

    <head>
    <meta name="keywords" content="example,seo" />
    </head>

####sky_seo_get_metas()
Returns all meta values.

Layout file:

    <head>
    {% for attributes  in sky_seo_get_metas() %}
        {% for attributeName, attributeValue in attributes %}
            <meta name="{{attributeName}}" content="{{attributeValue}}" />
        {% endfor %}                
    {% endfor %}
    </head>

HTML output:

    <head>
    <meta name="keywords" content="example,seo" />
    <meta name="description" content="Example site default description." />
    <meta name="http-equiv" content="utf-8" />
    </head>

####sky_seo_title()
Renders the title value.

Layout file:

    <head>
    {{sky_seo_get_title()}}
    </head>

HTML output:

    <head>
    <title>Example Site Title</title>
    </head>

####sky_seo_meta_element($attributeName, $attributeValue)
Renders a meta value.

Layout file:

    <head>
    {{sky_seo_meta_element('name', 'keywords')}}"
    </head>

HTML output:

    <head>
    <meta name="keywords" content="example,seo" />
    </head>

####sky_seo_meta_elements()
Renders all meta values.

Layout file:

    <head>
    {{sky_seo_meta_elements()}}
    </head>

HTML output:

    <head>
    <meta name="keywords" content="example,seo" />
    <meta name="description" content="Example site default description." />
    <meta name="http-equiv" content="utf-8" />
    </head>


###Layout example
Put in the main layout

    <?php
    // app/Resources/views/base.html.twig

    <head>
    {{sky_seo_title()}}
    {{sky_seo_meta_elements()}}
    </head>
