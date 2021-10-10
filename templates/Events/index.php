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
$this->assign(
    'title',
    $this->fetch(
        'title',
        $this->getRequest()->getParam('controller')
    )
);
?>
<?= $this->element('App/page_header'); ?>
<?php /*
<div class="page-header mt-0 py-4 n1ft4jmn q3ywbqi8">
    <h2 class="page-title mb-0 upxakz6m"><?= __('Events') ?></h2>

</div>
 */ ?>

<div class="row">
    <div class="events col-md-9 content table-responsive">
        <nav class="toolbar page-nav border-bottom p-0 mb-5">
            <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                <li class="nav-item"><?= $this->Html->link(__('My Events'), ['action' => 'index'], ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($section === 'default'? ' active':'')]) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Invites'), ['action' => 'invites'], ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($section === 'sent_requests'? ' active':'')]) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Upcoming'), ['action' => 'upcoming'], ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($section === 'pending'? ' active':'')]) ?></li>
                <li class="nav-item"><?= $this->Html->link(__('Recent'), ['action' => 'recent'], ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($section === 'pending'? ' active':'')]) ?></li>
            </ul>
        </nav>
        <?php if (isset($events)): ?>
            <div class="">
            <div class="row">
                <?php foreach ($events as $event): ?>
                <div class="col-md-4">
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
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="paginator">
            <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first'), ['class' => 'bar']) ?>
            <?= $this->Paginator->prev('< ' . __('previous'), ['class' => 'barz']) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >', ['class' => 'foo']) ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
        </div>
        <?php endif; ?>
    </div>
    <div class="col-md-3">
        <?php if ($this->fetch('sidebar')): ?>
        <?= $this->fetch('sidebar'); ?>
        <?php endif; ?>
    </div>
</div>
<div class="_srxwY9">
    <?= $this->Html->link(
        __('<span class="_PoCPxV"><i class="mdi mdi-plus-circle"></i></span> New Event'),
        [
            'action' => 'create'
        ],
        [
            'class' => 'btn btn-azure btn-sm mmhtpn7c tsafbbqc',
            'data-toggle' => 'drawer',
            'aria-controls' => '#' . RandomString::generateString(32,'mixed', 'alpha'),
            'escapeTitle' => false
        ]); ?>
</div>
