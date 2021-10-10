<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<?php
use Cake\Utility\Security as SecurityAlias;
?>
<?php
if (count($suggestions)): ?>
    <?php foreach ($suggestions as $personToMeet): ?>
        <div
            class="list-group-item list-group-item-action suggested-connection"
            aria-dismissable="true">
            <div class="mx-n2">
                <div class="float-left">
                    <div class="pos-r">
                        <a href="e/<?= h($personToMeet->getUsername()) ?>">
                            <span class="avatar avatar-xl"><?= $personToMeet->getNameAccronym(); ?></span>
                        </a>
                        <!-- Trying to create a hover-popcard to display users' account preview when hovered upon. -->
                    </div>
                </div>
                <div class="offset-3">
                    <div>
                        <div class="d-flex gutters-xs">
                            <div class="account-info col" actionable="true">
                                <p class="account-name lh_f5">
                                    <?= $this->Html->link(
                                        __('<strong>' . $this->Text->truncate(h($personToMeet->getFullname()), '21', ['ellipsis' => '...']) . '</strong>'),
                                        '/e/' . h($personToMeet->getUsername()),
                                        [
                                            'class' => '',
                                            'escapeTitle' => false
                                        ]); ?>
                                    <?= $this->Html->link(
                                        __('<small class="text-muted-dark">@' . h($personToMeet->getUsername()) . '</small>'),
                                        '/e/' . h($personToMeet->getUsername()),
                                        [
                                            'class' => '',
                                            'escapeTitle' => false
                                        ]); ?>
                                </p>
                                <?= (! empty($personToMeet->personality) ? '<p class="about-content-block">' . h($personToMeet->about) . '</p>' : ''); ?>
                                <?php if (
                                    !empty($personToMeet->about) ||
                                    !empty($personToMeet->location) ||
                                    !empty($personToMeet->genre)): ?>
                                    <div class="meta-data text-small text-muted-dark">
                                        <?= (! empty($personToMeet->personality)
                                            ? '<span class="personality">' . h($personToMeet->personality) . '</span>'
                                            : ''); ?>
                                        <?= (! empty($personToMeet->location) ? '<span class="location">'
                                            . h($personToMeet->location) . '</span>' : ''); ?>
                                        <?= (! empty($personToMeet->genre) ? '<span class="genre">'
                                            . h($personToMeet->genre) . '</span>' : ''); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-auto">
                                <div class="dropdown">
                                    <button class="bgcH-grey-300 btn btn-sm bx bx-rnd i_H4n mx-0 p-1 wh_30 p-1 wh_30"
                                            data-toggle="dropdown" aria-expanded="false">
                                        <i class="icon mdi mdi-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="ml-auto">
                                <div
                                    role="button"
                                    class="btn btn-outline-primary btn-sm commit-btn i_H4n"
                                    data-commit="connection"
                                    data-intent="request"
                                    aria-committed="false"
                                    data="<?= h($activeUser->getUsername()); ?>/<?= h($personToMeet->getUsername()) ?>"
                                >
                                    <i class="mdi mdi-account-plus pr-1"></i> <span class="btn-text" aria-alt-text="Disconnect">Connect</span>
                                </div>
                                <?= $this->Form->postLink(__('<i class="mdi mdi-cancel"></i> Remove'),
                                    [
                                        'controller' => 'action',
                                        'action' => 'remove',
                                        '?' => [
                                            'what' => 'suggestion',
                                            'as' => 'potential-connection',
                                            'account' => h($personToMeet->getUsername())
                                        ]
                                    ],
                                    [
                                        'class' => 'btn btn-outline-danger btn-sm commit-btn i_H4n',
                                        'onclick' => 'return false',
                                        'fullBase' => true,
                                        'escapeTitle' => false,
                                        'data-action' => 'remove',
                                        'data-intent' => 'connect',
                                        'data-screen-name' => h($activeUser->getUsername()),
                                        'data-account' => h($personToMeet->getUsername())
                                    ]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
