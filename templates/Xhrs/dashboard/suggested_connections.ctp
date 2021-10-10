<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cake\Utility\Security as SecurityAlias;
use Cake\Routing\Router;
use App\Utility\RandomString;
?>
<div class="card i--c suggestions potential-connections">
    <div class="card-body">
        <h6 class="align-items-baseline card-title d-flex justify-content-between mb-5">Suggested Connections
            <small class="mb-0"><?=
                $this->Html->link(
                    __('Explore'),
                    [
                        'controller' => 'explore',
                        'action' => 'suggestions',
                        'potential-connections'
                    ],
                    [
                        'class' => 'link text-info',
                        'fullBase' => true
                    ]
                ) ?>
            </small>
        </h6>
        <div class="list-group list-group-flush people-list user-list-sm segment sTn"
         data-name="suggested_connections"
         data-src="<?= Router::url('/xhrs/fetch_segment/suggested_connections?_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed'));  ?>"
         data-conditions='{"remove_if_no_content":"no","check_for_update":"yes","auto_update":"yes","use_data_prospect":"yes"}'>
        </div>
    </div>
</div>
