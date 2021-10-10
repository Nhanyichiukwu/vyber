<?php

/*
 * Widget for Requests
 */
use App\Utility\RandomString;
use Cake\Routing\Router;
?>
<div class="card">
    <div class="card-body p-3">
        <h6 class="card-title small mb-5"><?= __('Requests'); ?></h6>
        <div class="segment sTn"
             data-name="requests"
             data-src="<?= Router::url('/xhrs/fetch_segment/requests?actor=' . $activeUser->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed'));  ?>"
             data-conditions='{"remove_if_no_content":"no","check_for_update":"yes","auto_update":"yes","use_data_prospect":"yes"}'
            >
        </div>
    </div>
    <footer class="card-footer p-3 bg-light">
        <small class="mb-0"><?=
                $this->Html->link(
                    __('See More'),
                    [
                        'controller' => 'requests',
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