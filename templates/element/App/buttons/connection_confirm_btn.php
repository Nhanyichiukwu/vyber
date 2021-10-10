<?php
/**
 * @var \App\Model\Entity\User $user
 * @var \App\Model\Entity\User $account
 */
?>
<?= $this->Form->postButton(__('<i class="mdi mdi-check fs-4 n1ft4jmn"></i>' .
    '<span class="sr-only">Accept</span>'), [
    'controller' => 'commits',
    'action' => 'connection',
], [
    'data' => [
        'actor' => h($user->getUsername()),
        'account' => h($account->getUsername()),
        'intent' => 'accept_invitation'
    ],
    'form' => [
        'class' => 'form-inline'
    ],
    'data-commit' => "connection",
    'escapeTitle' => false,
    'data-referer' => $this->getRequest()->getRequestTarget(),
    'class' => 'btn btn-icon btn-sm btn-warning rmgay8tp btn-pill text-capitalize',
    'data-state' => 'pending'
]); ?>
