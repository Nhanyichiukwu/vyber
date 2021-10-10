<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Activity[]|\Cake\Collection\CollectionInterface $activities
 */

$this->set('title', 'My Activities');
$this->set('activities', $myActivities);
?>
<?php $this->extend('index'); ?>
<div class="activities index content">
    <h3><?= __('My Activities') ?></h3>
</div>
