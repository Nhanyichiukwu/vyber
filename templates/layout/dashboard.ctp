<?php

use Cake\Utility\Text;
use Cake\Utility\Inflector;
use Cake\Routing\Router;

$inflector = new \Cake\Utility\Inflector();
?>
<?php
$this->EWidgets
        ->setPageWidgets($widgets)
        ->setPageActor($activeUser);
?>
<?php
$theme = 'e__theme';
if ($activeUser->hasCustomTheme) {
    $theme = 'default.theme.css?type=custom&color=' . $activeUser->themeColor . '&token=' . date('ymdhim');
}
if (isset($pageTitle)) {
    $this->assign('title', $pageTitle);
}
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
        <?= $this->Html->css('bootstrap.dashboard'); ?>
        <?= $this->Html->css('materialdesignicons.min'); ?>
        <?= $this->Html->css('custom'); ?>
        <?= $this->Html->css('accents/default.theme'); ?>
        <?= $this->Html->css('accents/custom.theme'); ?>

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
        <?= $this->Html->css('accents/' . $theme); ?>
        <?= $this->Html->css('custom'); ?>

        <?= $this->fetch('css'); ?>
        <?= $this->fetch('meta'); ?>
        <?= $this->fetch('script'); ?>
        <?php //$this->Html->script('vendor/tSplash/require.min'); ?>
        <script type="text/javascript">
            //            requirejs.config({
            //                baseUrl: '<?= $this->Url->webroot('/js/vendor/tSplash/'); ?>'
            //            });
        </script>
    </head>
    <body class="dual-sidebar bgc-grey-200">
        <div id="loader"><div class="spinner"></div></div>
        <script>
            window.addEventListener('load', () => {
                const loader = document.getElementById('loader');
                setTimeout(() => {
                    loader.classList.add('fadeOut');
                }, 300);

            });
        </script>
        <div>
        <?= $this->element('general_header') ?>
            <!-- Sidebar was here -->
            <main class="main">
                <div class="page-container clearfix pos-r">
                    <?php $this->element('main_navbar'); ?>
                    <main id="mainContent" class="main-content container">
                        <?= $this->Flash->render(); ?>
                        <div class="row">
                            <main class="col-md-8 col-lg-8 ">
                                <?= $this->element('Widgets/publishing_tools', ['publisherType' => 'publisher-large db-basic-publisher']); ?>
                                <?= $this->element('Widgets/filter_toolbar', ['actor' => $activeUser]); ?>

                                <div class="feed-notification-bar">
                                    <span id="newitems" class="fl-r d-n">New Updates <span class="counter"></span></span>
                                    Latest News
                                </div>
                                <div class="scrollbar-dynamic position-relative">
                                    <div id="newsfeed" class="mb-5 newsfeed-home pb-5" role="newsfeed" data-source="ajax">

                                    </div>
                                </div>
                            </main>
                            <aside class="col-md-4 col-lg-4 sidebar--md">
                                <div class="col__inner">
                                    <?php if (count($peopleYouMayKnow)): ?>
                                    <div class="section card">
                                        <div class="card-body">
                                            <h6 class="text-small text-muted">People You May Know</h6>
                                            <?= $this->element('Suggestions/people_you_may_know'); ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (count($peopleToMeet)): ?>
                                    <div class="section card">
                                        <div class="card-body">
                                            <h6 class="text-small text-muted">People You May Love To Meet</h6>
                                            <?= $this->element('Suggestions/people_to_meet'); ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="afh">Likes <small>· <a href="#">View All</a></small></h6>
                                            <ul class="bow box">
                                                <li class="rv afa">
                                                    <img class="bos vb yb aff" src="assets/img/avatar-fat.jpg">
                                                    <div class="rw">
                                                        <strong>Jacob Thornton</strong> @fat
                                                        <div class="bpa">
                                                            <button class="btn btn-outline-primary btn-sm">
                                                                <span class="mdi mdi-account-plus"></span> Follow</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="rv">
                                                    <a class="bpu" href="#">
                                                        <img class="bos vb yb aff" src="assets/img/avatar-mdo.png">
                                                    </a>
                                                    <div class="rw">
                                                        <strong>Mark Otto</strong> @mdo
                                                        <div class="bpa">
                                                            <button class="btn btn-outline-primary btn-sm">
                                                                <span class="mdi mdi-account-plus"></span> Follow</button>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-footer">
                                            Dave really likes these nerds, no one knows why though.
                                        </div>
                                    </div>
                                </div>
                            </aside>
                        </div>
                    </main>
                </div>
                <footer class="bdT ta-c p-30 lh-0 fsz-sm c-grey-600">
                    <span>Copyright © 2017 Designed by <a href="https://colorlib.com" target="_blank" title="Colorlib">Colorlib</a>. All rights reserved.</span>
                </footer>
            </main>
            <div class="ps__rail-y">
                <div class="ps__thumb-y" tabindex="0"></div>
            </div>
        </div>
        <div class="d-n">
            <script type="text/javascript">
                const BASEURI = '<?= $this->Url->getView()->getRequest()->getAttribute('base') ?>';
                const WIDGETS = '<?= json_encode($widgets); ?>';
                const user = '<?= json_encode(['screenname' => h($activeUser->username), 'id' => h($activeUser->refid)]) ?>';
            </script>
        </div>

<!--        --><?//= $this->Html->script('vendor/jQuery/jquery-3.1.1.min'); ?>
<!--        --><?//= $this->Html->script('vendor/jQuery/jquery.cookie'); ?>
<!--        --><?//= $this->Html->script('vendor/bootstrap/bootstrap.bundle.min.js'); ?>
<!--        --><?//= $this->Html->script('vendor/tSplash/core'); ?>
<!--        --><?//= $this->Html->script('vendor/tSplash/vendors/jquery.tablesorter.min.js'); ?>
<!--        --><?//= $this->Html->script('vendor/tSplash/vendors/jquery.sparkline.min.js'); ?>
<!--        --><?//= $this->Html->script('core-functions'); ?>
<!--        --><?//= $this->Html->script('commit'); ?>
<!--        --><?//= $this->Html->script('form'); ?>
<!--        --><?//= $this->Html->script('notifications'); ?>
<!--        --><?//= $this->Html->script('e__core.jquery'); ?>

        <?= $this->element('Widgets/hidden_widgets'); ?>
        <?= $this->element('linked_scripts'); ?>
        <script type="text/javascript">
            $(function(){
                // Enables popover
                $("[data-toggle=popover]").popover();

                enableDisplayToggle();
            });
        </script>
    </body>
</html>
