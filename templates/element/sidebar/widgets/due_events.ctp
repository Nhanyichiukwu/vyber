<?php

/*
 * Widget for Due Events
 */
use App\Utility\RandomString;
use Cake\Routing\Router;
?>
<div class="card">
    <div class="card-body p-3">
        <h6 class="card-title"><?= __('Due Events') ?></h6>
        <div class="segment sTn"
             data-name="due_events"
             data-src="<?= Router::url('/xhrs/fetch_segment/due_events?actor=' . $activeUser->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed'));  ?>"
             data-conditions='{"remove_if_no_content":"no","check_for_update":"yes","auto_update":"yes","use_data_prospect":"yes"}'
            >
        </div>
    </div>
    <footer class="card-footer p-3 bg-light">
        <small class="mb-0"><?=
                $this->Html->link(
                    __('See More'),
                    [
                        'controller' => 'events',
                        'action' => 'due'
                    ],
                    [
                        'class' => 'link text-info',
                        'fullBase' => true
                    ]
                ) ?>
        </small>
    </footer>
</div>