<?php

/**
 * Dual Sidebar Layout
 */
use App\Utility\RandomString;
use Cake\Utility\Text;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

$sidebarClasses = ($this->get('sidebar_classes') ?? 'col-4');
$sidebarAttributes = (array) $this->get('sidebar_attr') ?? [];
$stringAttributes = '';
foreach ($sidebarAttributes as $key => $value) {
    $stringAttributes .= " {$key}=\"{$value}\"";
}
?>
<?= $this->element('LayoutElements/layout_top'); ?>
<div id="pagelet" class="PUkr col w_fMGsRw">
    <?php if ($this->fetch('page_top')): ?>
    <div class="_3U7cct">
        <?= $this->fetch('page_top'); ?>
    </div>
    <?php endif; ?>
    <?= $this->fetch('content'); ?>
</div>
<?php /** Start Sidebar Content **/ ?>
<aside class="col ml-auto sidebar sidebar-md w_rk2ARF">
    <div class="d7bA">
        <?= $this->fetch('right_sidebar'); ?>
        <?= $this->element('Widgets/important_links'); ?>
        <?php
            echo RandomString::generateString(20);
            echo '<br>';
            echo RandomString::generateString(6, 'mixed');
            echo '<br>';
            echo RandomString::generateString(4, 'mixed');
            echo '<br>';
            echo RandomString::generateString(3, 'mixed');
        ?>
    </div>
</aside>
<?php /** End Sidebar Content **/ ?>
<?= $this->element('LayoutElements/layout_bottom'); ?>
