<?php
/**
 * @var \App\Model\Entity\User $user
 * @var \App\Model\Entity\User $account
 */
//$btnLabel = $altLabel = 'connect';
//$intent = 'request';
//$btnState = 'unconnected';
//$stateIcon = 'mdi-plus';
//if (isset($user, $account) && $user->isConnectedTo($account)) {
//    $btnLabel = 'Connected';
//    $altLabel = 'Disconnect';
//    $btnState = 'connected';
//    $stateIcon = 'mdi-check';
//}
?>

<div class="btn-group align-items-end">
    <?= $this->Form->postButton(__('<i class="mdi mdi-plus"></i>
    <span>Connect</span>'), [
        'controller' => 'commits',
        'action' => 'connection',
        '?' => [
            'intent' => "invite_connection",
        ]
    ], [
        'data' => [
            'actor' => h($user->getUsername()),
            'account' => h($account->getUsername()),
        ],
        'type' => 'button',
        'role' => 'button',
        'data-commit' => "connection",
        'escapeTitle' => false,
        'data-referer' => $this->getRequest()->getRequestTarget(),
        'class' => 'btn btn-icon uu3ruwfp btn-control-small btn-sm btn-warning ozqeiogn text-capitalize',
        'data-state' => 'unconnected'
    ]); ?>
    <button type="button"
            class="btn btn-icon uu3ruwfp btn-control-small btn-sm btn-warning
            hw3efktc dropdown-toggle dropdown-icon mr-0"
            role="button"
            data-toggle="dropdown">
        <span class="sr-only">Other Options</span>
        <div class="dropdown-menu" role="menu">
            <a class="dropdown-item" href="#">Follow</a>
            <a class="dropdown-item" href="#">Send Message</a>
            <a class="dropdown-item" href="#">Introduce</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Separated link</a>
        </div>
    </button>
</div>
