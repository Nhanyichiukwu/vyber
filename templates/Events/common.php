<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Event[]|\Cake\Collection\CollectionInterface $events
 */

use Cake\Routing\Router;
use Cake\Utility\Inflector;
use App\Utility\RandomString;
?>

<?php
$section = $this->getRequest()->getQuery('section');
if (!$section) {
    $section = 'default';
}
$this->enablePageHeader();
?>
<?php /*
<div class="page-header mt-0 py-4 n1ft4jmn q3ywbqi8">
    <h2 class="page-title mb-0 upxakz6m"><?= __('Events') ?></h2>

</div>
 */ ?>
<?php $this->start('header_widget'); ?>
<?= $this->Html->link(
    __('<span class="_PoCPxV"><i class="mdi mdi-plus mdi-18px"></i></span> New Events'),
    [
        'controller' => 'Events',
        'action' => 'create'
    ],
    [
        'class' => 'btn btn-app shadow-sm tsafbbqc',
        'data-toggle' => 'page',
        'data-page-id' => RandomString::generateString(32, 'mixed', 'alpha'),
        'escapeTitle' => false,
        'fullBase' => true,
    ]); ?>
<?php $this->end(); ?>

<div class="events content">
    <nav class="toolbar page-nav bg-white p-0 mb-2">
        <ul class="nav nav-tabs border-0 flex-column flex-lg-row mx-0">
            <li class="nav-item"><?= $this->Html->link(__('My Events'), ['action' => 'index'], ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($section === 'default' ? ' active' : '')]) ?></li>
            <li class="nav-item"><?= $this->Html->link(__('Invites'), ['action' => 'invites'], ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($section === 'sent_requests' ? ' active' : '')]) ?></li>
            <li class="nav-item"><?= $this->Html->link(__('Upcoming'), ['action' => 'upcoming'], ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($section === 'pending' ? ' active' : '')]) ?></li>
            <li class="nav-item"><?= $this->Html->link(__('Recent'), ['action' => 'recent'], ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($section === 'pending' ? ' active' : '')]) ?></li>
        </ul>
    </nav>
    <?= $this->fetch('content'); ?>
</div>
