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
<div class="suggestions potential-connections">
    <div class="card">
        <div class="card-header">
            <h6 class="card-title">Suggested Connections</h6>
        </div>
        <div class="list-group list-group-flush people-list user-list-sm ajaxify"
             data-name="suggested_connectins"
             data-src="<?= '/suggestions/connections?_dt=i_base&actor=' . $activeUser->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed');  ?>"
             data-conditions='{"remove_if_no_content":"no","check_for_update":"yes","auto_update":"yes","use_data_prospect":"yes"}'
            >
         </div>
        <footer class="card-footer bg-light border-top-0">
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
        </footer>
    </div>
</div>
