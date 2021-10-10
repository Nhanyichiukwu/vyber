<?php
/**
 * @var \App\Model\Entity\User $user
 * @var \App\Model\Entity\User $account
 */

use App\Utility\RandomString;
use Cake\Routing\Router; ?>
<div class="btn-group align-items-end">
    <?= $this->Form->postButton(__('<i class="mdi mdi-check"></i>
    <span>Connected</span>'), [
        'controller' => 'commits',
        'action' => 'connection',
    ], [
        'data' => [
            'actor' => h($user->getUsername()),
            'account' => h($account->getUsername()),
            'intent' => 'undo_connection'
        ],
        'type' => 'button',
        'role' => 'button',
        'data-commit' => "connection",
        'escapeTitle' => false,
        'data-referer' => $this->getRequest()->getRequestTarget(),
        'class' => 'btn btn-icon uu3ruwfp btn-control-small btn-sm btn-warning ozqeiogn text-capitalize',
        'data-state' => 'connected'
    ]); ?>
    <div class="dropdown">
        <button type="button"
                class="btn btn-icon uu3ruwfp btn-control-small btn-sm btn-warning
            hw3efktc dropdown-toggle dropdown-icon mr-0"
                role="button"
                data-toggle="dropdown">
            <span class="sr-only">Other Options</span>
        </button>
        <div class="dropdown-menu" role="menu">
            <a href="<?= Router::url('/messages/' . RandomString::generateString(32, 'mixed'), true) ?>"
               class="dropdown-item"
               type="button"
               role="link"
               data-referer="<?= $this->getRequest()->getRequestTarget() ?>">
                <i class="mdi mdi-message"></i> Send Message
            </a>
            <a class="dropdown-item" href="#">Meet</a>
            <a href="<?= Router::url('/introductions/introduce/' . $account->refid, true) ?>"
               class="dropdown-item"
               type="button"
               role="link"
               data-referer="<?= $this->getRequest()->getRequestTarget() ?>">
                <i class="mdi mdi-message"></i> Introduce
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Unfollow</a>
            <a href="<?= Router::url('/reports/report/' . $account->refid, true) ?>"
               class="dropdown-item"
               type="button"
               role="link"
               data-referer="<?= $this->getRequest()->getRequestTarget() ?>">
                <i class="mdi mdi-message"></i> Report User
            </a>
        </div>
    </div>
</div>
