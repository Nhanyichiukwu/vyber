<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$tab = $this->Url->request->getQuery('action');
if (!$tab) $tab = 'default';
$profileUrl = '/'. $this->Url->request->getParam('controller') .'/' . h($account->username);
?>
<header class="profile-header">
        <div class="cover-image pos-r">
            <div class="profile-cta pos-a">
                <button type="button" class="btn btn-primary btn-sm btn-rounded btn-control-small">
                    Connect <span class="mdi mdi-plus"></span>
                </button>
                <button type="button" class="btn btn-primary btn-sm btn-rounded btn-control-small">
                    Message <span class="mdi mdi-plus"></span>
                </button>
                <button type="button" class="btn btn-primary btn-sm btn-rounded btn-control-small">
                    Meet <span class="mdi mdi-plus"></span>
                </button>
                <button type="button" class="btn btn-primary btn-sm btn-rounded btn-control-small">
                    Introduce <span class="mdi mdi-plus"></span>
                </button>
            </div>
        </div>
        <div class="profile-top container clearfix has-avatar has-account-name has-navigation">
            <div class="avatar avatar-placeholder float-left mx-5 pos-r profile-photo"></div>
            <div class="offset-3 pl-2">
                <div class="account-name my-2">
                    <h1 class="font-weight-light mb-0 text-dark"><?= h($account->fullname); ?></h1>
                </div>
                <nav class="collapse d-lg-flex navbar toolbar page-nav border-bottom p-0">
                    <div class="align-items-center px-2">
                        <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                            <li class="nav-item"><?= $this->Html->link(__('Posts'), $profileUrl . '/posts', ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($tab === 'default'? ' active':'')]) ?></li>
                            <li class="nav-item"><?= $this->Html->link(__('About'), $profileUrl . '/about', ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($tab === 'sent_requests'? ' active':'')]) ?></li>
                            <li class="nav-item"><?= $this->Html->link(__('Connections'), $profileUrl . '/connections', ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($tab === 'pending'? ' active':'')]) ?></li>
                            <li class="nav-item"><?= $this->Html->link(__('Events'), $profileUrl . '/events', ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($tab === 'pending'? ' active':'')]) ?></li>
                            <li class="nav-item"><?= $this->Html->link(__('Photos'), $profileUrl . '/photos', ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($tab === 'pending'? ' active':'')]) ?></li>
                            <li class="nav-item"><?= $this->Html->link(__('Videos'), $profileUrl . '/videos', ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($tab === 'pending'? ' active':'')]) ?></li>
                            <li class="nav-item"><?= $this->Html->link(__('Songs'), $profileUrl . '/songs', ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($tab === 'pending'? ' active':'')]) ?></li>
                            <li class="nav-item"><?= $this->Html->link(__('Albums'), $profileUrl . '/albums', ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($tab === 'pending'? ' active':'')]) ?></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>
