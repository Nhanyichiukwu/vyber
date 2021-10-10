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
<aside class="_27b9uW _Axdy _uXY7 _ycGkU4 col left-sidebar w_gtwbex header-vacuum afixed">
    <div class="_vYaq h-100 mr-n1 o-hidden scroll-f">
        <div class="pt-4">
            <?php if (isset($activeUser)): ?>
            <?= $this->element('Profile/sidebar/my_micro_profile'); ?>
            <?= $this->element('sidebar/widgets/due_events'); ?>
            <?= $this->element('sidebar/widgets/activities'); ?>
            <?= $this->element('sidebar/widgets/interactions'); ?>
            <?php endif; ?>
            <?= $this->fetch('left_sidebar') ?>
        </div>
        <div class="text-break">
            <?php
            echo RandomString::generateString(64, 'mixed');
            echo '<br>';
            echo RandomString::generateString(6, 'mixed');
            echo '<br>';
            echo RandomString::generateString(6, 'mixed');
            echo '<br>';
            echo RandomString::generateString(4, 'mixed');
            echo '<br>';
            echo RandomString::generateString(3, 'mixed');
            ?>
        </div>
    </div>
</aside>
<div class="w_5toKaY main col ml-auto">
    <?= $this->Flash->render(); ?>
    <?php if ($this->fetch('page_top')): ?>
    <div class="_RXm66N">
            <?= $this->fetch('page_top'); ?>
    </div>
    <?php endif; ?>
    <?php if ($this->fetch('pagelet_top')): ?>
    <div class="_RXm66N">
                    <?= $this->fetch('pagelet_top'); ?>
    </div>
    <?php endif; ?>
    <?= $this->fetch('content'); ?>
</div>
<?= $this->element('LayoutElements/layout_bottom'); ?>