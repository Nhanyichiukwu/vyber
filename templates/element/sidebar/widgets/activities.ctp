<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Cake\Routing\Router;
use App\Utility\RandomString;
?>
<div class="card">
    <div class="card-body p-3">
        <h6 class="card-title mb-5"><?= __('My Activities') ?></h6>
        <div class="segment sTn"
             data-name="activities"
             data-src="<?= Router::url('/xhrs/fetch_segment/user_activities?actor=' . $activeUser->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed'));  ?>"
             data-conditions='{"remove_if_no_content":"no","check_for_update":"no","auto_update":"no","use_data_prospect":"yes"}'
             >
        </div>
    </div>
    <footer class="card-footer p-3 bg-light">
        <small class="mb-0"><?=
                $this->Html->link(
                    __('See More'),
                    [
                        'controller' => 'activities',
                        'action' => 'index'
                    ],
                    [
                        'class' => 'link text-info',
                        'fullBase' => true
                    ]
                ) ?>
        </small>
    </footer>
</div>