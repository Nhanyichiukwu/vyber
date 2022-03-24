<?php

/**
 *
 */

use Cake\Routing\Router;
use Cake\Utility\Text;
use Cake\Utility\Inflector;
use Cake\Utility\Security;

$this->extend('common');
?>
<?php $this->start('pagelet_top'); ?>
    <h3 class="page-title">
        <?php if ($this->get('activeUser') && $account->isSameAs($activeUser)): ?>
        <?= __('My Connections'); ?>
        <?php else: ?>
        <?= __('{firstname}\'s Connections', ['firstname' => $account->getFirstName()]); ?>
        <?php endif; ?>
    </h3>
<?php $this->end(); ?>


<div class="connections profile-cards profile-grid">
<?php if (isset($connections) && is_array($connections)): ?>
    <div class="row">
    <?php foreach ($connections as $connection): ?>
        <div class="col-md-6 col-lg-4">
            <?php
                $dataSrc = 'connection/'.$connection->get('refid') . '?token=' . base64_encode(Security::randomString() . '_'. time());
                $randID = Security::randomString(6);
            ?>
            <div class="_kG2vdB _Hc0qB9" data-load-type="r" data-src="<?= $dataSrc ?>" data-rfc="connection<?= $randID ?>" data-su="false" data-limit="1" data-r-ind="false" id="connection<?= $randID ?>"></div>
        </div>
    <?php endforeach; ?>
    </div>
<?php endif; ?>
</div>
