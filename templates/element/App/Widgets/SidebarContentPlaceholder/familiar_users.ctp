<?php

/*
 * Widget for People You May know
 */

?>
<?php if (count($familiarUsers)): ?>
<div class="card">
    <div class="card-body">
        <h6 class="afh">People You May Know <small class="fl-r"> . <?=
        $this->Html->link(
                __('See More'),
                [
                    'controller' => 'sugggestions',
                    'action' => 'people',
                    'people-you-may-know'
                ],
                [
                    'class' => 'link',
                ]
                ) ?></small></h6>
        <div class="people-list user-list-sm">
            <?php foreach ($familiarUsers as $someoneYouMayKnow): ?>
            <i-fc class="user d-flex py-4 justify-content-between"></i-fc>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>
