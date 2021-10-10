<?php
/**
 * Basic Layout Top
 *
 * All Layouts except the auth screen, must include this file at the top and
 * the corresponding layout bottom at the bottom.
 */

use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Utility\Text;
use Cake\Utility\Inflector;
use App\Utility\RandomString;

$baseUri = $this->getRequest()->getAttribute('base');
$sidebarSize = $this->get('sidebarSize', 'Medium') ;
$username = $this->get('activeUser') ? $activeUser->getUsername() : 'Visitor' ;
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
        <title><?= $this->fetch('title'); ?> - <?= Configure::read('Site.name'); ?></title>
        <?= $this->fetch('meta'); ?>

        <!-- Bootstrap CSS -->
        <?= $this->Html->css('vendor/bootstrap/bootstrap-grid.min'); ?>
        <?= $this->Html->css('vendor/bootstrap/bootstrap-reboot.min'); ?>
        <?= $this->Html->css('vendor/bootstrap/bootstrap.min'); ?>
        <?= $this->Html->css('bootstrap-override'); ?>
        <?= $this->Html->css('app'); ?>
        <?= $this->Html->css('themes/e__theme'); ?>
        <?= $this->Html->css('themes/custom_theme'); ?>

        <?= $this->fetch('css'); ?>
        <?= $this->fetch('scriptTop'); ?>
        <script>
            function resizeFrame(obj, forceFullHeight = false) {
                if (forceFullHeight) {
                    obj.setAttribute('scrolling', 'no');
                    obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
                } else {
                    obj.style.height = '80hv';
                }
            }
        </script>
    </head>
    <body class="has-sidebar bg-light"
          data-app-user="<?= $username; ?>"
          data-sidebar-size="<?= $sidebarSize; ?>"
          data-base-uri="<?= $baseUri ?>"
          >
        <?= $this->element('general_header') ?>
        <div class="d-flex flex-column header-vacuum justify-content-between mx-auto w_gtspOU _viG">
            <?php if ($this->get('activeUser')): ?>
            <aside class="_27b9uW _Axdy _uXY7 _ycGkU4 col header-vacuum left-sidebar border-right px-0 w_gtwbex _viG">
                <div class="_vYaq h-100 o-hidden scroll-f _viG">
                    <div class="pt-4 _viG">
                        <?php if ($this->fetch('left_sidebar_override')): ?>
                            <?= $this->fetch('left_sidebar_override'); ?>
                        <?php else: ?>
                            <?php
                            /** Insert content at the top of the sidebar */
                            if ($this->fetch('left_sidebar_prefix')): ?>
                                <?= $this->fetch('left_sidebar_prefix'); ?>
                                <div class="border-bottom my-3 py-2 fsz-22">Main Menu</div>
                            <?php endif; ?>
                            <?= $this->element('main_navigation_pane'); ?>
                            <?php
                            /** Append content at the bottom of the sidebar */
                            if ($this->fetch('left_sidebar_suffix')): ?>
                                <?= $this->fetch('left_sidebar_suffix'); ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if (isset($activeUser)): ?>
                            <?php $this->element('Profile/sidebar/my_micro_profile'); ?>
                            <?php $this->element('sidebar/widgets/due_events'); ?>
                            <?php $this->element('sidebar/widgets/activities'); ?>
                            <?php $this->element('sidebar/widgets/interactions'); ?>
                        <?php endif; ?>
                        <?php $this->fetch('left_sidebar') ?>
                    </div>
                </div>
            </aside>
            <?php endif; ?>
            <main role="main" class=":includes-footer _aYUGBN content pl-5 clearfix">
                <div class="py-5">
                <?php if ($this->fetch('page_header')): ?>
                    <?= $this->fetch('page_header'); ?>
                <?php endif; ?>


