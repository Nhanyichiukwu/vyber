<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Connection[]|\Cake\Collection\CollectionInterface $connections
 */
use Cake\Utility\Inflector;
use Cake\Utility\Text;
?>
<?php

// Page Title Definition
//if (!isset($pageTitle)) $pageTitle = 'Connections';
//$title = $pageTitle === 'Connections' ? $pageTitle : 'Connections - ' . $pageTitle;
//$this->assign('title', $title);

// Used to control active menu highlighting
$action = Inflector::delimit($this->getRequest()->getParam('action'), '_');
?>
<div class="bg-white d-flex gutters-lg mx-0 page-header py-0">
    <div class="col-auto">
        <h3 class="page-title"><?= __('{page_title}', ['page_title' => $pageTitle]) ?></h3>
    </div>
    <nav class="navbar toolbar page-nav ml-auto py-0">
        <ul class="navbar-nav nav nav-tabs border-0 flex-row">
            <li class="nav-item <?= ($action === 'index'? ' active':'') ?>">
    <?= $this->Html->link(
            __('<span class="counter">{0}</span> Connections', $this->cell('Counter', ['object' => 'connection_request', 'section' => 'approved'])),
            ['action' => 'index'],
            [
                'class' => 'nav-link border-top-0 border-right-0 border-left-0',
                'escapeTitle' => false
            ]
        ) ?></li>
            <li class="nav-item <?= ($action === 'sent_requests'? ' active':'') ?>">
    <?= $this->Html->link(
            __('<span class="counter">{0}</span> Sent Requests', $this->cell('Counter', ['object' => 'connection_request', 'section' => 'sent'])),
            ['action' => 'sent_requests'],
            [
                'class' => 'nav-link border-top-0 border-right-0 border-left-0',
                'escapeTitle' => false
            ]
        ) ?></li>
            <li class="nav-item <?= ($action === 'pending_requests'? ' active':'') ?>">
    <?= $this->Html->link(
            __('<span class="counter">{0}</span> Pending Approval', $this->cell('Counter', ['object' => 'connection_request', 'section' => 'pending_approval'])),
            ['action' => 'pending_requests'],
            [
                'class' => 'nav-link border-top-0 border-right-0 border-left-0',
                'escapeTitle' => false
            ]
        ) ?></li>
        </ul>
    </nav>
</div>
