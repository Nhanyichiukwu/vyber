<?php
namespace App\View\Helper;

use Cake\Utility\Inflector;
use Cake\View\Helper;
use Cake\View\View;

/**
 * Navigation helper
 */
class NavigationHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * @var array
     */
    private $menus = array(
        'main_menu' => [
            [
                'title' => 'Home',
                'controller' => 'home',
                'action' => 'index',
                'icon' => 'mdi-home'
            ],
            [
                'controller' => 'songs',
                'action' => 'index',
                'icon' => 'mdi-music'
            ],
            [
                'controller' => 'videos',
                'action' => 'index',
                'icon' => 'mdi-video'
            ],
            [
                'controller' => 'my-network',
                'action' => 'index',
                'icon' => 'mdi-account-group'
            ],
            [
                'controller' => 'calendar',
                'action' => 'index',
                'icon' => 'mdi-calendar',
                'submenus' => [
                    [
                        'page' => 'due-events',
                        'icon' => 'mdi-event'
                    ]
                ]
            ],
            [
                'controller' => 'events',
                'action' => 'index',
                'icon' => 'mdi-calendar',
                'section' => ['music','movie']
            ],
            [
                'controller' => 'messages',
                'action' => 'index',
                'icon' => 'mdi-message',
                'section' => ['music','movie']
            ],
            [
                'controller' => 'files',
                'action' => 'index',
                'icon' => 'mdi-file',
                'section' => ['music','movie']
            ],
            [
                'controller' => 'notifications',
                'action' => 'index',
                'icon' => 'mdi-bell',
                'section' => ['music','movie']
            ],
            [
                'controller' => 'appointments',
                'action' => 'index',
                'icon' => 'mdi-handshake',
                'section' => ['music','movie']
            ]
        ]
    );

    /**
     * @param $menu
     * @param null $key
     * @return array
     */
    public function getMenu($menu, $key = null)
    {
        if (!array_key_exists($menu, $this->menus)) {
            $msg = 'Menu not found';
            throw new \InvalidArgumentException();
        }
        if ($key && array_key_exists($key, $this->menus[$menu])) {
            return $this->menus[$key];
        }
        return $this->menus[$menu];
    }

    /**
     * Add a single item to a menu. If the menu does not exist, it will create
     * it and add the given item at the specified position
     *
     * @param string $menu The menu to add items to
     * @param array $item The item to add
     * @param null|string|int $position Could be string key or integer index
     * @return NavigationHelper
     */
    public function withMenuItem(string $menu, array $item, $position = null): NavigationHelper
    {
        if (!array_key_exists($menu, $this->menus)) {
            $this->menus[$menu] = [];
        }
        if ($position) {
            $this->menus[$menu][$position] = $item;
        } else {
            $this->menus[$menu][] = $item;
        }

        $new = clone $this;
        return $new;
    }

    /**
     * Add multiple items to a menu. If the menu does not exist, it will create
     * it and add the given items in the order in which they are arranged
     * @param string $menu
     * @param array $items
     * @return NavigationHelper
     */
    public function withMenuItems(string $menu, array $items): NavigationHelper
    {
        if (count($items)) {
            array_map(function ($item) use ($menu) {
                $this->withMenuItem($menu, $item);
            }, $items);
        }

        $new = clone $this;
        return $new;
    }

}
