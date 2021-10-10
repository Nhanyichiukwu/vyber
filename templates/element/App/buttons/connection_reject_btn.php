<?php
/**
 * @var \App\Model\Entity\User $user
 * @var \App\Model\Entity\User $account
 */
?>

<?= $this->Form->postButton(__('<i class="mdi mdi-close fs-4 n1ft4jmn"></i>
<span class="sr-only">Decline</span>'), [
    'controller' => 'commits',
    'action' => 'connection',
    '?' => [
        'intent' => "decline_invitation",
    ]
], [
    'data' => [
        'actor' => h($user->getUsername()),
        'account' => h($account->getUsername()),
    ],
    'form' => [
        'class' => 'form-inline'
    ],
    'data-commit' => "connection",
    'escapeTitle' => false,
    'data-referer' => $this->getRequest()->getRequestTarget(),
    'class' => 'btn btn-icon btn-sm btn-red text-white btn-pill uq5kc354 text-capitalize',
    'data-state' => 'pending'
]); ?>
