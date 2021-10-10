<?php
use App\Utility\TimeCalculator;
use Cake\Utility\Inflector;
/* 
 * Data List Cell single output template
 */

$cssClass = '';
?>
<?php if (count($items) > 0): ?>
<div class="e-dropmenu dropdown-menu dropdown-menu-right">
    <div class="pX-20 pY-15 bdB">
        <i class="icon mdi mdi-account-multiple pR-10"></i> 
        <span class="fsz-sm fw-600 c-grey-900"><?= Inflector::humanize($data_type, '_') ?></span>
    </div>
    <div>
        <div class="ovY-a pos-r scrollable lis-n p-0 m-0 fsz-sm">
    <?php foreach ($items as $item): ?>
        <?php   
        if ($item->subject == 'message') {
            $cssClass = 'unread-message';
        } else {
            $cssClass = h($item->subject) . '-request-notice';
        }
        ?>
            <div class="e_notification <?= $cssClass ?>">
                <a href="<?= $this->Url->request->getAttribute('base') ?>/notifications/<?= h($item->refid) ?>?type=request&e_db_tab=<?= h($item->type) ?>&" class="peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
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
    <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>