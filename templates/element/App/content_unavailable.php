<?php

use Cake\Utility\Inflector;

?>
<div class="bg-white my-3 p-5">
    <div class="text-center text-muted">
        <div class="avatar avatar-xxl avatar-azure mb-3 mx-auto n1ft4jmn ofjtagoh qrfe0hvl">
            <i class="icofont-rolling-eyes text-gray"></i>
        </div>
        <div class="mx-4 mx-md-5 px-3 px-md-5">Sorry, there doesn't seem to be
            <strong><?= Inflector::pluralize($content); ?></strong>
            here right now... Please check back after a while.
        </div>
    </div>
</div>
