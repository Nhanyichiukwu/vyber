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
<html lang="en-US">
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
    </head>
    <body class="has-sidebar bg-transparent"
          data-app-user="<?= $username; ?>"
          data-sidebar-size="<?= $sidebarSize; ?>"
          data-base-uri="<?= $baseUri ?>"
          >
        <div id="wrapper">
            <main role="main" class="content :includes-footer">
                <div class="_ngci4i">
                    <main id="main-content" class="_xgmy44">

