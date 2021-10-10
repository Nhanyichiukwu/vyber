<?php
use App\Utility\TimeCalculator;
?>

        <?php   
//        if ($item->subject == 'message') {
//            $cssClass = 'unread-message';
//        } else {
//            $cssClass = h($item->subject) . '-request-notice';
//        }
        ?>
<div class="e_notification <?= $cssClass ?>">
    <a href="<?= $this->Url->request->getAttribute('base') ?>/notifications/<?= h($item->refid) ?>?type=request&e_db_tab=<?= h($item->reason) ?>" class="peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
        <div class="peer mR-15">
            <img class="w-3r bdrs-50p avatar avatar-lg" src="<?= $this->Url->webroot($item->sender->profile_image_url); ?>" alt="">
        </div>
        <div class="peer peer-greed">
            <div>
                <div class="jc-sb fxw-nw mB-5">
                    <strong class="mB-0"><?= h($item->sender->fullname); ?></strong> 
                    <span class="c-grey-600 fsz-sm">wants to connect with you</span>
                </div>
                <div class="peer"><i class="icon mdi mdi-clock"></i> <small class="fsz-xs"><?= (new TimeCalculator)->calculateTimePassedSince(h($item->created), 2); ?></small></div>
            </div>
        </div>
    </a>
</div>
