<?php
use App\Utility\TimeCalculator;
?>

        <?php   
//        if ($notification->subject == 'message') {
//            $cssClass = 'unread-message';
//        } else {
//            $cssClass = h($notification->subject) . '-request-notice';
//        }
        ?>
<div class="e_notification <?= h($notification->reason); ?>-request-notice">
    <?php
    $status = ' unread';
    if ((int) $notification->is_read === 1) {
        $status = ' read';
    }
    ?>
    <a 
        href="<?= $this->Url->request->getAttribute('base') ?>/requests/v/<?= h($notification->subject->refid) ?>?e_ntf_ref=<?= h($notification->refid) ?>&e_notif_obj=<?= h($notification->reason) ?>" 
        class="ntf<?= $status; ?> peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
        <div class="peer mR-15">
            <img class="w-3r bdrs-50p avatar avatar-lg" src="<?= $this->Url->webroot(h($notification->initiator->profile_image_url)); ?>" alt="">
        </div>
        <div class="peer peer-greed">
            <div>
                <div class="jc-sb fxw-nw mB-5">
                    <strong class="mB-0"><?= h($notification->initiator->fullname); ?></strong> 
                    <span class="c-grey-600 fsz-sm">wants to connect with you</span>
                </div>
                <div class="peer"><i class="icon mdi mdi-clock"></i> <small class="fsz-xs"><?= (new TimeCalculator)->calculateTimePassedSince(h($notification->created), 2); ?></small></div>
            </div>
        </div>
    </a>
</div>
