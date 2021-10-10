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
            <?= $this->element('Cell/Notifications/' . $data_type, ['item' => $item, 'cssClass' => $cssClass]); ?>
    <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>