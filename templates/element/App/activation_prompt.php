<?php
/**
 * @var App\View\AppView;
 */

use Cake\Core\Configure; ?>
<div class="alert alert-warning">
    Your account has not been activated. You may not be allowed access to certain
    features of <?= Configure::read('Site
    .brand', 'Thrilla') ?>
    <a href="../settings/account/activation" class="btn btn-primary btn-sm">Activate</a>
</div>
