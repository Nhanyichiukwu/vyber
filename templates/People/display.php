<?php

/**
 * @var \App\View\AppView $this
 */

$action = $this->getRequest()->getParam('action');
$subpage = $this->getRequest()->getQuery('cat', $action);
$subpage = str_replace('_', ' ', $subpage);
$this->pageTitle($subpage);
$this->enablePageHeader();
?>
<?= $this->contentUnavailable($subpage); ?>
