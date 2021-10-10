<?php

use Cake\Routing\Router;

$this->Navigation->addMenuItem('dashboard', [
    'calendar' => [
        'controller' => 'calendar',
        'action' => 'index',
        'icon' => 'mdi-bell'
    ],
    'messages' => [
        'controller' => 'messages',
        'action' => 'index',
        'icon' => 'mdi-bell'
    ],
    'notifications' => [
        'controller' => 'notifications',
        'action' => 'index',
        'icon' => 'mdi-bell'
    ]
]);
?>
<ul id="dashboard" class="nav">
    <li class="edb_tab calendar_tab dropdown">
        <?php
        $events = $this->cell('Counter::count', array('due_events', [$activeUser]))->render();
        if ((int) $events > 0) {
            $state = 'active';
            echo '<span class="notification-icon">' . $events . '</span>';
        }
        ?>
        <a
            href="<?= $this->getRequest()->getAttribute('base') ?>/calendar/"
            data-source="<?= $this->getRequest()->getAttribute('base') ?>/calendar/"
            data-type="calendar"
            class="dropdown-toggle no-after"
            data-toggle="dropdown">
            <span class="icon-holder"><i class="icon mdi mdi-calendar"></i></span>
            <span class="tool-label">Calendar</span>
        </a>
        <div class="e-dropmenu e-events dropdown-menu dropdown-menu-right py-0">
            <div class="pX-20 pY-15 bdB">
                <i class="icon mdi mdi-message pR-10"></i>
                <span class="fsz-sm fw-600 c-grey-900">Calendar</span>
            </div>
            <div>
                <div class="edb_data-list edb_event-list scrollable ovY-a pos-r lis-n p-0 m-0 fsz-sm">
                    <div class="loading"><span class="mdi mdi-spinner"></span></div>
                </div>
            </div>
            <div class="text-right pY-15 pX-20">
                <?= $this->Html->link(
                    __('See all...'),
                    ['controller' => 'calendar', 'action' => 'events']
                ); ?>
            </div>
        </div>
    </li>
    <li class="edb_tab messages_tab dropdown">
        <?php
        $state = '';
        $unreadMessages = $this->cell('Counter::count', array('unread_messages', [$activeUser]))->render();
        if ((int) $unreadMessages > 0) {
            $state = 'active';
            echo '<span class="notification-icon">' . $unreadMessages . '</span>';
        }
        ?>
        <a
            href="<?= Router::normalize('/messages/') ?>"
            data-source="<?= Router::normalize('/messages/unread?recent') ?>"
            data-type="messages"
            class="dropdown-toggle no-after"
            data-toggle="dropdown">
            <span class="icon-holder"><i class="icon mdi mdi-message"></i> </span>
            <span class="tool-label">Messages</span>
        </a>
        <div class="e-dropmenu e-messages dropdown-menu dropdown-menu-right py-0">
            <div class="pX-20 pY-15 bdB">
                <i class="icon mdi mdi-message pR-10"></i>
                <span class="fsz-sm fw-600 c-grey-900">Messages</span>
            </div>
            <div>
                <div class="edb_data-list edb_message-list scrollable ovY-a pos-r p-0 m-0 fsz-sm">
                    <div class="loading"><span class="mdi mdi-spinner"></span></div>
                </div>
            </div>
            <div class="text-right pY-15 pX-20">
                <?= $this->Html->link(
                    __('See all...'),
                    ['controller' => 'messages', 'action' => 'inbox']
                ); ?>
            </div>
        </div>
    </li>
    <li class="edb_tab notifications_tab dropdown">
        <?php
        $state = '';
        $notifications = $this->cell('Counter::count', array('unread_notifications', [$activeUser]))->render();
        if ((int) $notifications > 0) {
            $state = 'active';
            echo '<span class="notification-icon">' . $notifications . '</span>';
        }
        ?>
        <a
            href="<?= Router::normalize('/notifications/'); ?>"
            data-source="<?= Router::normalize('/notifications/recent?v=edb_notiflist'); ?>"
            data-type="notifications"
            class="dropdown-toggle no-after <?= $state ?>"
            data-toggle="dropdown">
            <span class="icon-holder"><i class="icon mdi mdi-bell"></i> </span>
            <span class="tool-label">Notifications</span>
        </a>
        <div class="e-dropmenu e-notifications dropdown-menu dropdown-menu-right py-0">
            <div class="pX-20 pY-15 bdB">
                <div class="clearfix">
                    <div class="fl-r">
                        <div class="btns">
                            <?= $this->Html->link(
                                __('Notification Settings'),
                                ['controller' => 'settings', 'action' => 'notifications'],
                                ['class' => 'btn btn-sm', 'escapeTitle' => false]
                            ); ?>
                        </div>
                    </div>
                    <i class="icon mdi mdi-bell pR-10"></i>
                    <span class="fsz-sm fw-600 c-grey-900">Notifications</span>
                </div>
                <div class="btns text-right">
                    <?= $this->Html->link(
                        __('<span class="mdi mdi-check"></span> Mark all as Read'),
                        [
                            'controller' => 'flag',
                            'action' => 'index',
                            '?' => [
                                '_tn' => 'notifications',
                                '_scope' => 'all',
                                'f' => 'read'
                            ]
                        ],
                        ['class' => 'btn btn-sm btn-outline-info', 'escapeTitle' => false]
                    ); ?>
                    <?= $this->Html->link(
                        __('<span class="mdi mdi-check"></span> Mark all as Unread'),
                        [
                            'controller' => 'flag',
                            'action' => 'index',
                            '?' => [
                                '_tn' => 'notifications',
                                '_scope' => 'all',
                                'f' => 'unread'
                            ]
                        ],
                        ['class' => 'btn btn-sm btn-outline-info', 'escapeTitle' => false]
                    ); ?>
                </div>
            </div>
            <div>
                <div class="edb_data-list edb_notifications-list scrollable ovY-a pos-r p-0 m-0 fsz-sm"></div>
            </div>
            <div class="text-right pY-15 pX-20">
                <?= $this->Html->link(
                    __('See all...'),
                    ['controller' => 'notifications', 'action' => 'index']
                ); ?>
            </div>
        </div>
    </li>
</ul>
