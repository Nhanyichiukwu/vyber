<?php

/**
 * 
 */
use Cake\Utility\Inflector;
use Cake\Routing\Router;
?>
<div class="event">
    <div class="card">
        <div class="card-img card-img-top">
            <?php
                $imageSplit = explode(DS, $event->image);
                $imageName = array_pop($imageSplit);
                $fileType = Inflector::singularize($imageSplit[0]);
                $imageName = substr($imageName, 0, strrpos($imageName, '.'));
                $imageName = str_replace(DS, '/', $imageName);
                $ext = substr($event->image, strrpos($event->image, '.') + 1);
            ?>
            <?= $this->Html->image(Router::url('/media/' . $imageName . '?type=' . $fileType . '&format=' . $ext . '&size=small', true), []); ?>
        </div>
        <div class="card-body">
            <div class="event-description"><?= h($event->description) ?></div>
        </div>
    </div>
</div>

