<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Connection[]|\Cake\Collection\CollectionInterface $connections
 */

$this->extend('/Common/connections');
?>

<div class="">
    <?php if ($requests->count() > 0): ?>
    
    <?php else: ?>
    <div class="">
        <p>You have no pending requests</p>
    </div>
    <?php endif; ?>
</div>
