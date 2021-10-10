<?php

/**
 * 
 */

use App\Utility\DateTimeFormatter;
use Cake\Utility\Text;
?>
<div class="card p-3">
    <div class="">
        <div>
            <a href="javascript:void(0)" class="mb-3">
                <img src="./demo/photos/grant-ritchie-338179-500.jpg" alt="Photo by Nathan Guerrero" class="rounded">
            </a>
            <div class="caption">
                <h4 class="caption"><?= Text::truncate(h($photo->get('caption')), 60, ['ellipsis' => '...']); ?></h4>
            </div>
        </div>
        <div class="d-flex align-items-center px-2">
            <div class="avatar avatar-md mr-3" style="background-image: url(demo/faces/male/41.jpg)"></div>
            <div>
                <div><?= __('{author}', ['author' => $photo->author->getFullName()]) ?></div>
                <small class="d-block text-muted"><?= DateTimeFormatter::humanize($photo->created) ?></small>
            </div>
            <div class="ml-auto text-muted">
                <a href="javascript:void(0)" class="icon"><i class="fe fe-eye mr-1"></i> 112</a>
                <a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><i class="fe fe-heart mr-1"></i> 42</a>
            </div>
        </div>
    </div>
</div>