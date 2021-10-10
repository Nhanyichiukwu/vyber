<?php
use App\Utility\TimeCalculator;
?>
<?php

$message = '';
switch ($item->reason)
{
    case 'connection_request':
        $message = '<strong class="mB-0">'. h($item->sender->fullname) . '</strong> <span class="c-grey-600 fsz-sm">wants to connect with you</span>';
        break;
    case 'message':
        $message = '<strong class="mB-0">'. h($item->sender->fullname) . '</strong> <span class="c-grey-600 fsz-sm">wants to connect with you</span>';
        break;
    case 'meeting_request':
        $message = '<strong class="mB-0">'. h($item->sender->fullname) . '</strong> <span class="c-grey-600 fsz-sm">would like to meet with you</span>';
        break;
    case 'content_like':
        
        break;
    default:
}
?>
<div class="e_notification <?= h($item->reason); ?>-request-notice">
    <a href="<?= $this->Url->request->getAttribute('base') ?>/requests/<?= h($item->refid) ?>?type=request&e_db_tab=<?= h($item->reason) ?>" class="peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
        <div class="peer mR-15">
            <img class="w-3r bdrs-50p avatar avatar-lg" src="<?= $this->Url->webroot($item->sender->profile_image_url); ?>" alt="">
        </div>
        <div class="peer peer-greed">
            <div>
                <div class="jc-sb fxw-nw mB-5">
                    <?= $message; ?>
                </div>
                <div class="peer"><i class="icon mdi mdi-clock"></i> <small class="fsz-xs"><?= (new TimeCalculator)->calculateTimePassedSince(h($item->created), 2); ?></small></div>
            </div>
        </div>
    </a>
</div>
