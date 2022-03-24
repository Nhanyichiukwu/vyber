<?php
/**
 * @var App\View\AppView;
 */

use Cake\Core\Configure; ?>
<div class="alert alert-warning text-center text-md-left mb-0">
    Your account has not been activated. You may not be allowed access to certain
        features of <?= Configure::read('Site.brand', 'CrowdWow') ?>.
    <span class="d-block d-md-inline-block"><?= $this->Html->link(__('Activate'), [
            'controller' => 'Settings',
            'action' => 'account',
            'activation'
        ], [
            'class' => 'btn btn-app btn-sm'
        ]); ?></span>
</div>
