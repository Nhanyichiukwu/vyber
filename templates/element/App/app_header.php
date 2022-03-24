<?php

use App\Utility\RandomString;
use Cake\Routing\Router;

$controlClasses = $control ?? 'pos-r';
?>
<div id="app-header" class="app-header <?= $controlClasses ?> mgxl72rm mgxpa6lw ms-lg-0 fixed-top">
    <div class="hCp h-100 row gutters-sm">
        <div class="col-6 col-md-auto flex-fill universal-search">
            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'm-0 p-0']); ?>
            <div class="input-icon">
                <input type="search" class="bg-translucent form-control form-control-sm"
                       placeholder="Search for...">
                <span class="input-icon-addon">
              <i class="mdi mdi-magnify"></i>
            </span>
            </div>
            <?= $this->Form->end(); ?>
        </div>
        <div class="app-dashboard col-auto">
            <div class="gutters-sm justify-content-between row align-items-center">
                <nav class="app-header-nav col-auto d-none d-md-flex flex-fill">
                    <?= $this->element('App/main_nav'); ?>
                </nav>
                <div class="col-auto notifications">
                    <div class="dropdown">
                        <a href="javascript:void(0)"
                           vibely-data-url="<?= Router::url('/notifications?data-target=dropdown&max=10&vtype=list', true)
                           ?>"
                           class="d-block headerButton pos-r px-1 py-1"
                           data-toggle="dropdown">
                            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                      d="M21,19V20H3V19L5,17V11C5,7.9 7.03,5.17 10,4.29C10,4.19 10,4.1 10,4A2,2 0 0,1 12,2A2,2 0 0,1 14,4C14,4.1 14,4.19 14,4.29C16.97,5.17 19,7.9 19,11V17L21,19M14,21A2,2 0 0,1 12,23A2,2 0 0,1 10,21"></path>
                            </svg>
                            <span class="notification-icon">4</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-bottom dropdown-menu-arrow">
                            <a href="#" class="dropdown-item d-flex">
                            <span class="avatar mr-3 align-self-center"
                                  style="background-image: url(demo/faces/male/41.jpg)"></span>
                                <div>
                                    <strong>Nathan</strong> pushed new commit: Fix page load performance issue.
                                    <div class="small text-muted">10 minutes ago</div>
                                </div>
                            </a>
                            <a href="#" class="dropdown-item d-flex">
                            <span class="avatar mr-3 align-self-center"
                                  style="background-image: url(demo/faces/female/1.jpg)"></span>
                                <div>
                                    <strong>Alice</strong> started new task: Tabler UI design.
                                    <div class="small text-muted">1 hour ago</div>
                                </div>
                            </a>
                            <a href="#" class="dropdown-item d-flex">
                            <span class="avatar mr-3 align-self-center"
                                  style="background-image: url(demo/faces/female/18.jpg)"></span>
                                <div>
                                    <strong>Rose</strong> deployed new version of NodeJS REST Api V3
                                    <div class="small text-muted">2 hours ago</div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item text-center text-muted-dark">Mark all as read</a>
                        </div>
                    </div>
                </div>
                <div class="col-auto message-notification">
                    <div class="dropdown">
                        <a href="javascript.void(1)"
                           vibely-data-url="<?= Router::url('/messages?data-target=dropdown&max=10&vtype=list', true) ?>"
                           class="d-block headerButton pos-r px-1 py-1" data-toggle="dropdown">
                            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                      d="M17,12V3A1,1 0 0,0 16,2H3A1,1 0 0,0 2,3V17L6,13H16A1,1 0 0,0 17,12M21,6H19V15H6V17A1,1 0 0,0 7,18H18L22,22V7A1,1 0 0,0 21,6Z"></path>
                            </svg>
                            <span class="notification-icon">4</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-bottom dropdown-menu-arrow">
                            <a href="#" class="dropdown-item d-flex">
                            <span class="avatar mr-3 align-self-center"
                                  style="background-image: url(demo/faces/male/41.jpg)"></span>
                                <div>
                                    <strong>Nathan</strong> pushed new commit: Fix page load performance issue.
                                    <div class="small text-muted">10 minutes ago</div>
                                </div>
                            </a>
                            <a href="#" class="dropdown-item d-flex">
                            <span class="avatar mr-3 align-self-center"
                                  style="background-image: url(demo/faces/female/1.jpg)"></span>
                                <div>
                                    <strong>Alice</strong> started new task: Tabler UI design.
                                    <div class="small text-muted">1 hour ago</div>
                                </div>
                            </a>
                            <a href="#" class="dropdown-item d-flex">
                            <span class="avatar mr-3 align-self-center"
                                  style="background-image: url(demo/faces/female/18.jpg)"></span>
                                <div>
                                    <strong>Rose</strong> deployed new version of NodeJS REST Api V3
                                    <div class="small text-muted">2 hours ago</div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item text-center text-muted-dark">Mark all as read</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu-toggler col-auto">
            <?php
            $vibelyData = json_encode(
                array(
                    'clickAction' => 'render',
                    'handler' => 'Drawer.open',
                    'src' => Router::url(
                        '/dynamic-contents/menu/main-menu', true
                    ),
                    'output' => '.side-drawer',
                    'direction' => 'ltr'
                )
            );


            $drawerConfig = json_encode(
                array(
                    'direction' => 'ltr',
                    'drawerMax' => '95%'
                )
            );

            ?>
            <a href="<?= Router::url(
                '/dynamic-contents/menu/profile-menu?for=user&user=me', true
            ) ?>"
               data-toggle="drawer"
               data-config='<?= $drawerConfig ?>'
               aria-controls="#<?= RandomString::generateString(
                   32,
                   'mixed',
                   'alpha'
               ) ?>"
               class="item me">
                    <span class="avatar app-user"
                          style='background-image: url("<?= $this->Url->image('profile-photos/img_avatar.png') ?>")'></span>
            </a>
            <?php /*
            <a href="javascript:void(0);"
               data-processor="vibely"
               vibely-data='<?= $vibelyData ?>'
               aria-controls="drawer"
               data-url="<?= Router::url(
                   '/dynamic-contents/menu/profile-menu?for=user&user=me', true
               ) ?>"
               class="item me">
                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M3,6H21V8H3V6M3,11H21V13H3V11M3,16H21V18H3V16Z"></path>
                </svg>
            </a>
            */ ?>
            <!--<a href="#" class="headerButton" data-bs-toggle="modal" data-bs-target="#sidebarPanel">

            </a>-->
        </div>
    </div>
</div>
