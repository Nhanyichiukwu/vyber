<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div class="suggestions potential-connections">
    <div class="card">
        <div class="card-body">
            <h6 class="afh">People To Meet <small class="float-right"><?=
                    $this->Html->link(
                        __('Explore'),
                        [
                            'controller' => 'explore',
                            'action' => 'suggestions',
                            'potential-connections'
                        ],
                        [
                            'class' => 'link text-info',
                            'fullBase' => true
                        ]
                    ) ?></small></h6>
            <div class="people-list user-list-sm">
                <?php if (isset($suggestedConnections) && count($suggestedConnections)): ?>
                <?php foreach ($suggestedConnections as $personToMeet): ?>
                    <div class="user d-flex py-2 justify-content-between">
                        <img class="avatar avatar-md mr-4" src="">
                        <div class="account-info flex-fill" actionable="true">
                            <div class="account-name mb-2">
                                <?= $this->Html->link(
                                    __('<strong>' . $this->Text->truncate(h($personToMeet->getFullname()), '18', ['ellipsis' => '...']) . '</strong>'),
                                    [
                                        'controller' => 'e',
                                        'action' => h($personToMeet->getUsername())
                                    ],
                                    [
                                        'class' => '',
                                        'escapeTitle' => false,
                                        'fullBase' => true
                                    ]); ?>
                                <?= $this->Html->link(
                                    __('<small class="text-muted-dark">@' . h($personToMeet->getUsername()) . '</small>'),
                                    [
                                        'controller' => 'e',
                                        'action' => h($personToMeet->getUsername())
                                    ],
                                    [
                                        'class' => '',
                                        'escapeTitle' => false,
                                        'fullBase' => true
                                    ]); ?>
                            </div>
                            <?= (!empty($personToMeet->personality) ? '<p class="about-content-block">' . h($personToMeet->about) . '</p>' : ''); ?>
                            <?php if (!empty($personToMeet->about) || !empty($personToMeet->location) || !empty($personToMeet->genre)): ?>
                                <div class="meta-data text-small text-muted-dark">
                                    <?= (!empty($personToMeet->personality) ? '<span class="personality">' . h($personToMeet->personality) . '</span>' : ''); ?>
                                    <?= (!empty($personToMeet->location) ? '<span class="location">' . h($personToMeet->location) . '</span>' : ''); ?>
                                    <?= (!empty($personToMeet->genre) ? '<span class="genre">' . h($personToMeet->genre) . '</span>' : ''); ?>
                                </div>
                            <?php endif; ?>
                            <div class="float-right">
                                <?= $this->Form->postButton(__('Connect'),
                                    [
                                        'controller' => 'commit',
                                        'action' => 'index',
                                        '?' => [
                                            'intent' => 'connect',
                                            'user' => h($activeUser->getUsername()),
                                            'account' => h($personToMeet->getUsername()),
                                            'origin' => 'suggested_users'
                                        ]
                                    ],
                                    [
                                        'class' => 'btn btn-control-small btn-sm btn-outline-primary rounded-pill py-1 px-2',
                                        'data-action' => 'commit',
                                        'data-intent' => 'connect',
                                        'data-screename' => h($activeUser->getUsername()),
                                        'data-account' => h($personToMeet->getUsername()),
                                        'data-referer' => $this->Url->request->getRequestTarget(),
                                        'data-url' => $this->getRequest()->getAttribute('here'),
                                        'data-origin' => 'suggested_users'
                                    ]); ?>
                                <a href="javascript:void()" data-url=""
                                   class="btn btn-control-small btn-danger btn-rounded btn-sm pY-2 px-2"
                                   onclick="remove(this)">
                                    <span class="mdi mdi-cancel"></span> Remove</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>
