<?php

/**
 * This file is part of Herbie.
 *
 * (c) Thomas Breuss <www.tebe.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace herbie\plugin\googlemaps;

use Herbie;
use Twig_SimpleFunction;

class GooglemapsPlugin extends Herbie\Plugin
{
    /**
     * @var int
     */
    private static $instances = 0;

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        $events = [];
        if ((bool)$this->config('plugins.config.googlemaps.twig', false)) {
            $events[] = 'onTwigInitialized';
        }
        if ((bool)$this->config('plugins.config.googlemaps.shortcode', true)) {
            $events[] = 'onShortcodeInitialized';
        }
        return $events;
    }

    public function onTwigInitialized($twig)
    {
        $twig->addFunction(
            new Twig_SimpleFunction('googlemaps', [$this, 'googlemapsTwig'], ['is_safe' => ['html']])
        );
    }

    public function onShortcodeInitialized($shortcode)
    {
        $shortcode->add('googlemaps', [$this, 'googlemapsShortcode']);
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
    public function googlemapsTwig($id = 'gmap', $width = 600, $height = 450, $type = 'roadmap', $class = 'gmap', $zoom = 15, $address = '')
    {
        self::$instances++;
        $template = $this->config->get(
            'plugins.config.googlemaps.template',
            '@plugin/googlemaps/templates/googlemaps.twig'
        );
        return $this->render($template, [
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
    public function googlemapsShortcode($options)
    {
        $options = $this->initOptions([
            'id' => 'gmap',
            'width' => 600,
            'height' => 450,
            'type' => 'roadmap',
            'class' => 'gmap',
            'zoom' => 15,
            'address' => '',
        ], $options);
        return call_user_func_array([$this, 'googlemapsTwig'], $options);
    }

}
