<?php
/**
 * @var \App\Model\Entity\User $user
 * @var \App\Model\Entity\User $account
 */

use App\Utility\RandomString;
use Cake\Routing\Router; ?>
<div class="dropdown me-2">
    <button type="button"
            class="btn btn-app btn-icon dropdown-toggle me-0 mmhtpn7c no-after rmgay8tp"
            role="button"
            data-bs-toggle="dropdown">
        <i class="mdi mdi-24px mdi-dots-horizontal lh-1"></i>
        <span class="sr-only">Other Options</span>
    </button>
    <div class="dropdown-menu" role="menu">
        <a href="<?= Router::url('/messages/t/' . RandomString::generateString(32, 'mixed'), true) ?>"
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
<?php if (isset($appUser)): ?>
<?= $this->Form->postButton(__('<span class="mdi mdi-24px mdi-close"></span>'), [
    'controller' => 'commits',
    'action' => 'connection',
], [
    'data' => [
        'actor' => h($appUser->getUsername()),
        'account' => h($account->getUsername()),
        'intent' => 'undo_connection'
    ],
    'type' => 'button',
    'role' => 'button',
    'data-commit' => "connection",
    'escapeTitle' => false,
    'data-referer' => $this->getRequest()->getRequestTarget(),
    'class' => 'btn btn-red btn-icon fsz-12 mmhtpn7c text-capitalize rmgay8tp',
    'data-state' => 'connected'
]); ?>
<?php endif; ?>