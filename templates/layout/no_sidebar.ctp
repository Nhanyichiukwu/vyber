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

<?= $this->fetch('content'); ?>

<?= $this->element('LayoutElements/layout_bottom'); ?>
