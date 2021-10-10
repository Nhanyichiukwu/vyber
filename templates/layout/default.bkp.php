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
<div class="mx-n4 d-flex">
    <div class="_aC5riV _aYUGBN w_IsfXJh mt-n4 border-right">
        <?php if ($this->fetch('pagelet_top')): ?>
            <div class="_RXm66N">
                <?= $this->fetch('pagelet_top'); ?>
            </div>
        <?php endif; ?>
        <?= $this->fetch('content'); ?>
    </div>
    <aside class="ml-auto sidebar w_JhJQoD">
        <div class="d7bA text-break">
            <?php if ($this->fetch('right_sidebar')): ?>
                <?= $this->fetch('right_sidebar'); ?>
                <?= $this->element('Widgets/important_links'); ?>
            <?php endif; ?>
            <?= RandomString::generateString(64, 'mixed'); ?>
        </div>
    </aside>
</div>
<?php /*
<div class="_aYUGBN col main">
    <?php if ($this->fetch('page_top')): ?>
    <div class="_RXm66N">
            <?= $this->fetch('page_top'); ?>
    </div>
    <?php endif; ?>
    <div class="row gutters-sm">

    </div>
</div>
*/ ?>
<?= $this->element('LayoutElements/layout_bottom'); ?>
