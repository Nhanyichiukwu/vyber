<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View;

use Cake\View\View;

/**
 * Application View
 *
 * Your application's default view class
 *
 * @link https://book.cakephp.org/4/en/views.html#the-app-view
 */
class AppView extends View
{
    private $commonWidgets = [];
    private $pageWidgets = [];
    private $omittedWidgets = [];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize(): void
    {
    }

    public function has(string $var): bool
    {
        return (bool) null !== $this->get($var);
    }

    public function isSidebarEnabled(): bool
    {
        return (bool) true === $this->get('sidebar');
    }

    public function enableSidebar(): void
    {
        $this->set('sidebar', true);
    }

    public function disableSidebar(): void
    {
        $this->set('sidebar', false);
    }

    public function enablePageHeader()
    {
        $this->set('showPageHeader', true);
    }

    public function disablePageHeader()
    {
        $this->set('showPageHeader', false);
    }

    public function pageTitle($title)
    {
        $title = ucwords($title);
        $this->assign('title', $title);
        $this->set('page_title', $title);
    }

    public function isPageHeaderEnabled()
    {
        return (bool) true === $this->get('showPageHeader');
    }

    public function getAppAccent()
    {
        return $this->get('theme_accent', 'app');
    }

    /**
     * Appends a widget or widgets to the end of the widgets list
     *
     * @param $widget string|array The item or items to be added to the list of
     * widgets
     * @return $this
     */
    public function addWidget($widget)
    {
        if (is_string($widget)) {
            $this->commonWidgets[] = $widget;
        } elseif (is_array($widget)) {
            $this->commonWidgets = array_merge($this->commonWidgets, $widget);
        }

        return $this;
    }

    /**
     * Inserts a new widget in a given position in the widgets list
     *
     * @param string $widget The name of the widget to insert into the widgets
     * list
     * @param int $position The point where it should be inserted. Note: If there
     * is a widget existing in the given position, all element beginning from that
     * point forward will be moved forward to make room for the new widget. If
     * you wish to replace the item in that position entirely, use the
     * replaceWidget() method instead.
     * @return $this
     */
    public function insertWidget(string $widget, int $position) {
        if (!count($this->commonWidgets)) {
            $this->commonWidgets[$position] = $widget;
        } else {
            $fromInsertionPoint = array_slice($this->commonWidgets, $position);
            $newArr = array_slice($this->commonWidgets, 0, $position, true);
            $newArr[$position] = $widget;
            $this->commonWidgets = array_merge($newArr, $fromInsertionPoint);
        }
        return $this;
    }

    /**
     * Replace the widget in the position specified in $target
     *
     * @param string $target The widget to replace
     * @param string $replacement The new widget. Note: this method will do
     * nothing if the target does not exist.
     * @return $this
     */
    public function replaceWidget(string $target, string $replacement)
    {
        if (in_array($target, $this->commonWidgets)) {
            $position = array_keys($this->commonWidgets, $target)[0];
            $this->commonWidgets[$position] = $replacement;
        }
        return $this;
    }

    /**
     * Remove a specified widget from the list
     *
     * @param string $widget
     * @return $this
     */
    public function removeWidget(string $widget)
    {
        if (in_array($widget, $this->commonWidgets)) {
            unset($this->commonWidgets[$widget]);
        }
        return $this;
    }

    /**
     * Remove a specified widget from the list
     *
     * @param string $widget
     * @return $this
     */
    public function omitWidget($widgets)
    {
        if (is_string($widgets) && !in_array($widgets, $this->omittedWidgets)) {
            $this->omittedWidgets[] = $widgets;
        } elseif (is_array($widgets)) {
            foreach ($widgets as $widget) {
                $this->omittedWidgets[] = $widget;
            }
        }

        return $this;
    }

    public function addPageWidgets($widgets)
    {
        if (is_string($widgets) && !in_array($widgets, $this->pageWidgets)) {
            $this->pageWidgets[] = $widgets;
        } elseif (is_array($widgets)) {
            foreach ($widgets as $widget) {
                $this->pageWidgets[] = $widget;
            }
        }

        return $this;
    }

    /**
     * Renders all widgets
     *
     * @return $this
     */
    public function loadWidgets()
    {
        foreach ($this->commonWidgets as $widget) {
            $path = 'sidebar/widgets/'.$widget;
            if ($this->elementExists($path)) {
                echo $this->element($path);
            }
        }
        return $this;
    }

    public function getPageWidgets()
    {
        return $this->pageWidgets;
    }

    public function getOmittedWidgets()
    {
        return $this->omittedWidgets;
    }

    public function contentUnavailable(string $content)
    {
        return $this->element('App/content_unavailable', ['content' => $content]);
    }
}
