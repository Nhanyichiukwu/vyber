<?php

use Cake\Utility\Text;
use Cake\Utility\Inflector;
use Cake\Core\Configure;
?>
<?php
//if (isset($pageTitle)) {
    $this->assign('title', 'Welcome to ' . Configure::read('Site.name') . ', ' . Configure::read('Site.tagline'));
//}

// Prevent this template from rendering the layout
$this->setLayout(false);
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
        <title><?= $this->fetch('title'); ?></title>

        <!-- Main Styles CSS -->


        <!-- Bootstrap CSS -->
        <?= $this->Html->css('vendor/bootstrap/bootstrap-grid'); ?>
        <?= $this->Html->css('vendor/bootstrap/bootstrap-reboot'); ?>
        <?= $this->Html->css('vendor/bootstrap/bootstrap.min'); ?>
        <?= $this->Html->css('materialdesignicons.min'); ?>

        <style>
            #loader {
                transition: all .3s ease-in-out;
                opacity: 1;
                visibility: visible;
                position: fixed;
                height: 100vh;
                width: 100%;
                background: #fff;
                z-index: 90000
            }

            #loader.fadeOut {
                opacity: 0;
                visibility: hidden
            }

            .spinner {
                width: 40px;
                height: 40px;
                position: absolute;
                top: calc(50% - 20px);
                left: calc(50% - 20px);
                background-color: #333;
                border-radius: 100%;
                -webkit-animation: sk-scaleout 1s infinite ease-in-out;
                animation: sk-scaleout 1s infinite ease-in-out
            }

            @-webkit-keyframes sk-scaleout {
                0% {
                    -webkit-transform: scale(0)
                }
                100% {
                    -webkit-transform: scale(1);
                    opacity: 0
                }
            }

            @keyframes sk-scaleout {
                0% {
                    -webkit-transform: scale(0);
                    transform: scale(0)
                }
                100% {
                    -webkit-transform: scale(1);
                    transform: scale(1);
                    opacity: 0
                }
            }
        </style>
        <?= $this->Html->css('vendor/sprint/style'); ?>
        <?= $this->Html->css('vendor/sprint/sprint.components_controls.min'); ?>
        <?= $this->Html->css('vendor/sprint/sprint.bootstrap.min'); ?>
        <?= $this->Html->css('bootstrap.dashboard'); ?>
        <?= $this->Html->css('bootstrap-override'); ?>
        <?= $this->Html->css('custom'); ?>

        <?= $this->fetch('css'); ?>
        <?= $this->fetch('meta'); ?>
        <?= $this->fetch('script'); ?>
    </head>
    <body class="homepage bgc-grey-200">
        <div>
            <!-- Sidebar was here -->
            <div>
                <?= $this->element('general_header') ?>
                <div class="page-container clearfix pos-r">
                    <main id="mainContent" class="main-content container">
                        <?= $this->Flash->render(); ?>
                        <div class="row">
                            <main class="col-7">

                            </main>
                            <aside class="col-5">
                                <?= $this->element('Auth/login'); ?>
                            </aside>
                        </div>
                    </main>
                </div>
                <footer class="bdT ta-c p-30 lh-0 fsz-sm c-grey-600">
                    <span>Copyright © 2017 Designed by <a href="https://colorlib.com" target="_blank" title="Colorlib">Colorlib</a>. All rights reserved.</span>
                </footer>
            </div>
        </div>
        <?= $this->Html->script('vendor/jQuery/jquery-3.1.1.min'); ?>
        <?= $this->Html->script('vendor/bootstrap/bootstrap.bundle.min.js'); ?>
        <?= $this->Html->script('vendor/tSplash/core'); ?>
        <?= $this->Html->script('vendor/tSplash/vendors/jquery.tablesorter.min.js'); ?>
        <?= $this->Html->script('vendor/tSplash/vendors/jquery.sparkline.min.js'); ?>
        <?= $this->Html->script('core-functions'); ?>
    </body>
</html>
