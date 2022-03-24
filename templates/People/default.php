<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Utility\Inflector;

$page = Inflector::humanize($page, '-');
$this->pageTitle($page);
$this->enablePageHeader();
?>
<?= $this->contentUnavailable($page); ?>
