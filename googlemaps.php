<?php

use Herbie\DI;
use Herbie\Hook;

class GooglemapsPlugin
{
    /** @var  \Herbie\Config */
    private static $config;

    /**
     * @var int
     */
    private static $instances = 0;

    /**
     * @return array
     */
    public static function install()
    {
        self::$config = DI::get('Config');
        if ((bool)self::$config->get('plugins.config.googlemaps.twig', false)) {
            Hook::attach('twigInitialized', ['GooglemapsPlugin', 'addTwigFunction']);
        }
        if ((bool)self::$config->get('plugins.config.googlemaps.shortcode', true)) {
            Hook::attach('shortcodeInitialized', ['GooglemapsPlugin', 'addShortcode']);
        }
    }

    public static function addTwigFunction($twig)
    {
        $twig->addFunction(
            new Twig_SimpleFunction('googlemaps', ['GooglemapsPlugin', 'googlemapsTwig'], ['is_safe' => ['html']])
        );
    }

    public static function addShortcode($shortcode)
    {
        $shortcode->add('googlemaps', ['GooglemapsPlugin', 'googlemapsShortcode']);
    }

    /**
     * @param string $id
     * @param int $width
     * @param int $height
     * @param string $type
     * @param string $class
     * @param int $zoom
     * @param string $address
     * @return string
     */
    public static function googlemapsTwig($id = 'gmap', $width = 600, $height = 450, $type = 'roadmap', $class = 'gmap', $zoom = 15, $address = '')
    {
        self::$instances++;
        $template = self::$config->get(
            'plugins.config.googlemaps.template',
            '@plugin/googlemaps/templates/googlemaps.twig'
        );
        return DI::get('Twig')->render($template, [
                'id' => $id . '-' . self::$instances,
                'width' => $width,
                'height' => $height,
                'type' => $type,
                'class' => $class,
                'zoom' => $zoom,
                'address' => $address,
                'instances' => self::$instances
        ]);
    }

    /**
     * @param array $options
     * @return string
     */
    public static function googlemapsShortcode($options)
    {
        $options = array_merge([
            'id' => 'gmap',
            'width' => 600,
            'height' => 450,
            'type' => 'roadmap',
            'class' => 'gmap',
            'zoom' => 15,
            'address' => '',
        ], $options);
        return call_user_func_array(['GooglemapsPlugin', 'googlemapsTwig'], $options);
    }

}

GooglemapsPlugin::install();
