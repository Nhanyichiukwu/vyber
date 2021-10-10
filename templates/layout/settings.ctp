<?= $this->element('LayoutElements/layout_top'); ?>
<main class="center col w_1K9SqA">
    <div id="m5r1Oq" class="wv">
        <?= $this->fetch('content'); ?>
    </div>
</main>
<aside class="col sidebar sidebar-lg w_lyHK38">
    <div class="d7bA">
        <?= $this->fetch('right_sidebar'); ?>
        <?= $this->element('Widgets/important_links'); ?>
    </div>
</aside>
<?= $this->element('LayoutElements/layout_bottom'); ?>