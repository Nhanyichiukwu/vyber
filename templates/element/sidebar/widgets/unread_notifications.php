<?php use App\Utility\RandomString;

if ((int) $this->cell('Counter::count', ['notifications', [$appUser, 'unread']])->render() > 0): ?>
    <div class="_4gUj0 _UxaA _gGsso _jr card section vllbqapx" data-role="widget"
         data-config='<?= json_encode([
             'content' => 'unread_notifications',
             'limit' => 4
         ]) ?>'
         data-auto-update="true">
        <div class="card-body p-3">
            <h6 class="card-title mb-2">Notifications</h6>
            <?php
            $params = json_encode([
                'resource_handle' => 'notifications',
                'resource_path' => 'notifications/uncategorized',
            ]);
            $token = base64_encode(serialize($params));

            $sidebarWidgetAccessKey = $this->getRequest()
                ->getSession()
                ->read('cw_sidebar_widget_accesskey');
            $pymk = json_encode([
                'content' => 'notifications',
                'src' => '/widget/notifications?cat=unread&limit=5&'
                    . 'target=cw_home-sidebar-notif-list&token='
                    . $token .'&_referer='
                    . urlencode($this->getRequest()->getAttribute('here'))
                    . '&_accessKey=' . $sidebarWidgetAccessKey,
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
                'controller' => 'notifications',
                'action' => 'index',
                '?' => [
                    '_ref_point' => 'cw_home_sidebar_notif_list'
                ]
            ],[
                'class' => 'small'
            ]) ?>
        </div>
    </div>
<?php endif; ?>
