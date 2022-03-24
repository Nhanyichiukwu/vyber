<?php

/**
 *
 */

use Cake\Routing\Router;
use Cake\Utility\Text;
use Cake\Utility\Inflector;
use Cake\Utility\Security;
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
    <div class="card section _gGsso _4gUj0 _UxaA _jr vllbqapx r8upjl1q">
        <div class="card-body p-3">
            <?php
            $token = base64_encode(
                serialize(
                    json_encode([
                        'resource_handle' => 'users',
                        'resource_path' => '/element/Users/users_grid',
                        'content' => 'connections',
                    ])
                )
            );

            $connectionsSrc = 'connections/'. $account->getUsername() . '?token=' . $token;
            ?>
            <div data-load-type="async"
                 class="_M22YBE ajaxify flex-wrap gutters-xs row row-cols-2 row-cols-xxl-6 row-cols-md-5 row-cols-sm-4"
                 data-category="page_data"
                 data-src="<?= $connectionsSrc ?>"
                 data-config='<?= json_encode([
                     'content' => 'profile_connections',
                     'remove_if_no_content' => 'no',
                     'check_for_update' => 'yes',
                     'auto_update' => 'yes',
                     'use_data_prospect' => 'yes',
                     'load_type' => 'overwrite',
                 ]); ?>'>
                <?= $this->element('App/loading', ['modifier' => 'py-3']); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->extend('common'); ?>
