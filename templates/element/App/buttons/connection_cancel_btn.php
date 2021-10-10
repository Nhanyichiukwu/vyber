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
<?= $this->Form->postButton(__('<i class="mdi mdi-account-question" data-alt="mdi mdi-cancel"></i>
    <span data-alt="Cancel">Pending</span>'), [
    'controller' => 'commits',
    'action' => 'connection',
    '?' => [
        'intent' => "cancel",
    ]
], [
    'data' => [
        'actor' => h($user->getUsername()),
        'account' => h($account->getUsername()),
    ],
    'data-commit' => "connection",
    'escapeTitle' => false,
    'data-referer' => $this->getRequest()->getRequestTarget(),
    'class' => 'btn btn-icon etke5kld uu3ruwfp btn-control-small btn-sm btn-red btn-rounded px-2 btn-block btn-pill text-capitalize',
    'data-state' => 'pending'
]); ?>
