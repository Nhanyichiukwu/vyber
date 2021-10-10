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
<div class="e_notification <?= h($notification->type); ?>">
    <?php
    $status = ' unread';
    if ((int) $notification->is_read === 1) {
        $status = ' read';
    }
    ?>
    <a
        href="<?= Router::normalize('/notifications/' . $notification->get('refid')
            . '?tp=post_comment&status=' . ltrim($status) . '&ref='
            . Configure::read('Site.slug')
            . '_base_notifications_list&permalink='
            . urlencode($notification->subject_permalink)) ?>"
        class="ntf<?= $status; ?> bgcH-grey-100 c-grey-800 cH-blue d-flex justify-content-between ntf p-4 peers td-n">
        <div class="peer peer-greed">
            <div class="d-inline-flex peers mr-4">
                <div class="peer">
                    <span class="mr-3 notificon text-green"><i class="mdi mdi-24px mdi-comment-text-outline"></i></span>
                </div>
                <div class="peer">
                    <div class="jc-sb fxw-nw mB-5">
                        <strong class="mB-0"><?= h($notification->initiator->getFullName()); ?></strong>
                        <span class="c-grey-600 fsz-sm"><?= h($notification->get('message')) ?></span>
                    </div>
                    <div class="peer"><i class="icon mdi mdi-clock"></i> <small class="fsz-xs"><?= (new DateTimeFormatter())
                                ->humanizeDatetime(h($notification->created), $activeUser->timezone); ?></small></div>
                </div>
            </div>
        </div>
        <div class="peer mR-15">
            <img class="w-3r bdrs-50p avatar avatar-lg" src="<?= $this->Url->assetUrl(h
            ($notification->initiator->profile->getProfileImageUrl())); ?>" alt="">
        </div>
    </a>
</div>
