<?php
use App\Utility\DateTimeFormatter;
use Cake\Routing\Router;
use Cake\Core\Configure;

?>

        <?php
//        if ($notification->subject == 'message') {
//            $cssClass = 'unread-message';
//        } else {
//            $cssClass = h($notification->subject) . '-request-notice';
//        }
        ?>
<div class="cw_notification <?= h($notification->type); ?>">
    <?php
    $status = 'unread';
    if ((int) $notification->is_read === 1) {
        $status = 'read';
    }
    ?>
    <a
        href="<?= Router::url('/notifications/v/' . $notification->get('refid')
            . '?type=post_comment&status=' . ltrim($status) . '&ref='
            . Configure::read('Site.shortcode')
            . '_base_notifications_list&permalink='
            . urlencode($notification->subject_permalink)) ?>"
        class="ntf <?= $status; ?> c-grey-800 cH-blue d-flex p-2 peers
        td-n">
        <div class="me-2">
            <?php if ($notification->initiator->profile->hasProfileImage()): ?>
            <span class="cw_notif_list-avatar avatar avatar-lg"
                  style="background: url(<?= $this->Url->assetUrl(h
            ($notification->initiator->profile->getImageUrl())); ?>)"></span>
            <?php else: ?>
                <span class="cw_notif_list-avatar avatar avatar-lg avatar-azure">
                    <?= $notification->initiator->getNameAccronym(); ?>
                </span>
            <?php endif; ?>
        </div>
        <div class="peer">
            <div class="fsz-14">
                <span class="text-black"><strong><?= h($notification->initiator->getFullName()); ?></strong></span>
                <span class="c-grey-600 fsz-sm"><?= h($notification->get('message')) ?></span>
            </div>
            <div class="peer">
                <i class="icon mdi mdi-clock"></i>
                <small class="fsz-xs"><?= (new DateTimeFormatter())
                        ->humanizeDatetime(h($notification->created), $appUser->timezone); ?></small>
            </div>
        </div>
    </a>
</div>
