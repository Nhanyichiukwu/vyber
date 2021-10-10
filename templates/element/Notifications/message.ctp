<?php
use App\Utility\DateTimeFormatter;
?>

        <?php
//        if ($notification->subject == 'message') {
//            $cssClass = 'unread-message';
//        } else {
//            $cssClass = h($notification->subject) . '-request-notice';
//        }
        ?>
<div class="e_notification <?= $cssClass ?>">
    <?php
    $status = ' unread';
    if ((int) $notification->is_read === 1) {
        $status = ' read';
    }
    ?>
    <a href="<?= Router::normalize('/notifications/' . $notification->get('refid')
        . '?tp=post_comment&status=' . ltrim($status) . '&ref='
        . Configure::read('Site.slug')
        . '_base_notifications_list&permalink='
        . urlencode($notification->subject_permalink)) ?>"
       class="peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
        <div class="peer mR-15">
            <img class="w-3r bdrs-50p avatar avatar-lg" src="<?= $this->Url->webroot
            ($notification->initiator->profile->getProfileImageURL()); ?>" alt="">
        </div>
        <div class="peer peer-greed">
            <div>
                <div class="jc-sb fxw-nw mB-5">
                    <strong class="mB-0"><?= h($notification->initiator->getFullName()); ?></strong>
                    <span class="c-grey-600 fsz-sm">wants to connect with you</span>
                </div>
                <div class="peer"><i class="icon mdi mdi-clock"></i> <small class="fsz-xs"><?=
                        (new DateTimeFormatter)->humanizeDatetime($notification->created, 2) ?></small></div>
            </div>
        </div>
    </a>
</div>
