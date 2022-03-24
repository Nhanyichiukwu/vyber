<?php

/*
 * Widget for Due Events
 */
use App\Utility\RandomString;
use Cake\Routing\Router;
?>
<!--<div class="card">
    <div class="card-body p-3">
        <h6 class="card-title"><?/*= __('Due Events') */?></h6>
        <div class="segment sTn"
             data-name="due_events"
             data-src="<?/*= Router::url('/xhrs/fetch_segment/due_events?actor=' . $activeUser->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed'));  */?>"
             data-conditions='{"remove_if_no_content":"no","check_for_update":"yes","auto_update":"yes","use_data_prospect":"yes"}'
            >
        </div>
    </div>
    <footer class="card-footer p-3 bg-light">
        <small class="mb-0"><?/*=
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
                ) */?>
        </small>
    </footer>
</div>-->
<?php if ((int) $this->cell('Counter::count', ['events', [$user, 'due_events']])->render() > 0): ?>
    <div class="card mwp7f1ov" data-role="widget"
         data-config='<?= json_encode([
             'content' => 'upcoming_events',
             'limit' => 5
         ]) ?>'
         data-auto-update="true">
        <div class="card-body p-3">
            <h6 class="card-title mb-2">Events</h6>
            <?php
            $params = json_encode([
                'resource_handle' => 'events',
                'resource_path' => 'events/uncategorized',
            ]);
            $token = base64_encode(serialize($params));
            $sidebarEventsAccessKey = RandomString::generateString(16, 'mixed');
            $this->getRequest()->getSession()
                ->write('cw_sidebar_events_accesskey', $sidebarEventsAccessKey);
            $pymk = json_encode([
                'content' => 'events',
                'src' => '/widget/events?cat=due_events&limit=5&'
                    . 'target=cw_home-sidebar-events-list&token='
                    . $token .'&_referer='
                    . urlencode($this->getRequest()->getAttribute('here'))
                    . '&_accessKey=' . $sidebarNotifAccessKey,
                'remove_if_no_content' => 'no',
                'check_for_update' => 'yes',
                'auto_update' => 'yes',
                'use_data_prospect' => 'yes',
                'load_type' => 'overwrite',
            ]);
            ?>
            <div data-load-type="async"
                 class="ajaxify mx-n3 mb-n3"
                 data-category="widget" data-config='<?= $pymk ?>'>
                <?= $this->element('App/loading', ['modifier' => 'py-3']); ?>
            </div>

        </div>
        <div class="card-footer py-2 px-3 text-center">
            <?= $this->Html->link(__('See All'), [
                'controller' => 'Events',
                'action' => 'upcoming',
                '?' => [
                    '_ref_point' => 'cw_home_sidebar_events_list'
                ]
            ],[
                'class' => 'small'
            ]) ?>
        </div>
    </div>
<?php endif; ?>
