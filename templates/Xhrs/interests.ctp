<?php

/* 
 * Likes Widget
 */

use Cake\Utility\Inflector;
use Cake\Utility\Text;

?>
<?php if (count($data)): ?>
<div class="card">
    <div class="card-body">
        <h6 class="afh">Likes <small class="fl-r"> . <?= 
        $this->Html->link(
                __('View All'),
                [
                    'controller' => 'e',
                    'action' => h($actor->username),
                    'likes'
                ],
                [
                    'class' => 'link',
                ]
                ) ?></small></h6>
        <ul class="bow box">
    <?php foreach ($data as $like): ?>
        <?php if ($this->elementExist($like->object_name)): ?>
        <?= $this->element(h($like->object_name, ["$like->object_name" => $like->object])); ?>
            <li class="rv afa">
                <img class="bos vb yb aff" src="assets/img/avatar-fat.jpg">
                <div class="rw">
                    <strong></strong> @fat
                    <div class="bpa">
                        <button class="btn btn-outline-primary btn-sm">
                            <span class="mdi mdi-account-plus"></span> Follow</button>
                    </div>
                </div>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php endif; ?>