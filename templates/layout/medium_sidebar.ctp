<?php
/**
 * Medium Sidebar Layout
 */
?>
<?= $this->element('LayoutElements/layout_top'); ?>
    <?php if ($this->fetch('pagelet_overhead')): ?>
    <div class="over-head col-12">
        <?= $this->fetch('pagelet_overhead'); ?>
    </div>
    <?php endif; ?>
    <main class="col w_jT7Y1V">
        <?php if ($this->fetch('content_prefix')): ?>
        <?= $this->fetch('content_prefix'); ?>
        <?php endif; ?>
        <div id="m5r1Oq" data-content="<?= $mainContent ?>">
            <?= $this->fetch('content'); ?>
        </div>
    </main>
    <aside class="col ml-auto sidebar sidebar-md w_tbHgYx">
        <div class="d7bA">
            <?= $this->fetch('right_sidebar'); ?>
            <?= $this->element('Widgets/important_links'); ?>
        </div>
    </aside>
<?= $this->element('LayoutElements/layout_bottom'); ?>
