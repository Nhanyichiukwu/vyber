<?php

/**
 * @var \App\View\AppView $this
 */

$cat = $this->getRequest()->getQuery('cat', 'athletes');
$cat = str_replace('_', ' ', $cat);

$this->pageTitle($cat);
$this->enablePageHeader();
?>
<?= $this->contentUnavailable($cat); ?>
