<?php

/**
 *
 */
use Cake\Utility\Security;
?>
<?php
$dataSrc = '/timeline?token=' . base64_encode(Security::randomString() . '_'.
        $actor->get('refid') . time());
?>
<div class="list-group _Hc0qB9" data-load-type="r" data-src="<?= $dataSrc ?>" data-rfc="timeline"
     data-su="false"
     data-limit="24" data-r-ind="false">
<?php foreach ($timeline as $year => $posts): ?>
    <?php for ($i = 0; $i < sizeof($posts); $i++): ?>
    <div class="list-group-item p-0 mb-0 _kG2vdB"></div>
    <?php endfor; ?>
<?php endforeach; ?>
</div>
