<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Connection $invitation
 */

use App\Utility\RandomString;
use Cake\Routing\Router;
use Cake\Utility\Text;
?>
<div class="invitation content p-0">
    <div class="_oFb7Hd flex-column h-100 mb-0 n1ft4jmn xoj5za5y">
        <div class="card-header h_LjH0 yhbirx bg-yellow" style="background-image: url
            (demo/photos/eberhard-grossgasteiger-311213-500.jpg);"></div>
        <div class="card-body p-2 text-center">
            <img class="nYJsFM-img avatar avatar-xxl header-avatar" src="<?= $this->Url->assetUrl('img/profile-photos/img_avatar.png')
            ?>">
            <div class="d-flex flex-column mb-3">
                <h2 class="widget-user-username">
                    <a href="<?= Router::url('/' . h($invitation->sender->getUsername())) ?>" class="d-block _zeN4uW">
                        <span class="gax4op5o font-weight-light">
                            <?= h($invitation->sender->getFullName()) ?>
                        </span>
                    </a>
                </h2>
                <h5 class="widget-user-desc">Web Designer</h5>
                <?php if (!$invitation->sender->profile->isEmpty('about')): ?>
                    <div class="fsz-12 lh_f5 mb-3">
                        <?= Text::truncate(
                            h($invitation->sender->profile->about),
                            75
                        ); ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($invitation->hasValue('short_message')): ?>
                <?php $panelID = RandomString::generateString(16, 'mixed', 'alpha'); ?>
                <div class="appendage bg-light border collapsible xoj5za5y">
                    <a href="#"
                       data-toggle="collapse"
                       data-target="#<?= $panelID ?>"
                       class="btn btn-block btn-icon no-focus">
                        <i class="fe fe-mail text-yellow"></i> <span class="fs-6 text-muted-dark">View Message</span>
                    </a>
                    <div id="<?= $panelID ?>" class="collapse border-top text-left">
                        <div class="inviation-intro p-3"><?= $invitation->get('short_message') ?></div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="appendage meta-info">
                <?php $panel2ID = RandomString::generateString(16, 'mixed', 'alpha'); ?>
                <a href="#"
                   data-toggle="collapse"
                   data-target="#<?= $panel2ID ?>"
                   class="btn btn-block btn-icon no-focus">
                    <i class="fe fe-chevron-down text-yellow"></i> <span class="fs-6 text-muted-dark">More Details</span>
                </a>
                <div id="<?= $panel2ID ?>" class="collapse border-top text-left">
                    <div class="inviation-intro p-3"><?= $invitation->get('short_message') ?></div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light actionable n1ft4jmn qrfe0hvl px-3">
            <?php if (isset($user) && $user->isConnectedTo($invitation->sender)): ?>
                <?= $this->element('App/buttons/connection_disconnect_btn', ['account' => $invitation->sender]); ?>
            <?php elseif (isset($user) && $invitation->sender->hasPendingInvitation($user)): ?>
                <?= $this->element('App/buttons/connection_cancel_btn', ['account' => $invitation->sender]); ?>
            <?php elseif (isset($user) && $user->hasPendingInvitation($invitation->sender)): ?>
                <div class="col">
                    <?= $this->Form->postButton(__('<i class="mdi mdi-check fs-4 n1ft4jmn"></i>' .
                        '<span>Accept</span>'), [
                        'controller' => 'commits',
                        'action' => 'connection',
                        '?' => [
                            'intent' => "accept",
                        ]
                    ], [
                        'data' => [
                            'actor' => h($user->getUsername()),
                            'account' => h($invitation->sender->getUsername()),
                        ],
                        'form' => [
                            'class' => 'form-inline'
                        ],
                        'data-commit' => "connection",
                        'escapeTitle' => false,
                        'data-referer' => $this->getRequest()->getRequestTarget(),
                        'class' => 'btn btn-sm btn-block btn-icon btn-pill btn-warning text-capitalize',
                        'data-state' => 'pending'
                    ]); ?>
                </div>
                <div class="col">
                    <?= $this->Form->postButton(__('<i class="mdi mdi-close fs-4 n1ft4jmn"></i>
<span>Decline</span>'), [
                        'controller' => 'commits',
                        'action' => 'connection',
                        '?' => [
                            'intent' => "decline",
                        ]
                    ], [
                        'data' => [
                            'actor' => h($user->getUsername()),
                            'account' => h($invitation->sender->getUsername()),
                        ],
                        'form' => [
                            'class' => 'form-inline'
                        ],
                        'data-commit' => "connection",
                        'escapeTitle' => false,
                        'data-referer' => $this->getRequest()->getRequestTarget(),
                        'class' => 'btn btn-sm btn-block btn-icon btn-pill btn-red text-capitalize',
                        'data-state' => 'pending'
                    ]); ?>
                </div>
            <?php else: ?>
                <?= $this->element('App/buttons/connection_invite_btn', ['account' => $invitation->sender]); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
