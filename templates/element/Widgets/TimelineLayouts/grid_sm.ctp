<?php
/**
 * @package Timeline Layout
 * @group Grid Layout
 * @name Small
 */
?>

<?php $thisYear = date('Y'); ?>
<?php if (count($timeline)): ?>
    <?php foreach ($timeline as $year => $items): ?>
    <?php for ($i = 0; $i < sizeof($items); $i++): ?>
    <?php endfor; ?>
<div id="<?= h($year); ?>_timeline" class="e_user-timeline">
        <?php if ($year == $thisYear): ?>
    <div class="timeline-grid_sm row">
            <?php foreach ($items as $item): ?>
        <div class="col-md-4 col-lg-4">
                <?= $this->element('Singletons/post_singleton', ['post' => $item]); ?>
        </div>
            <?php endforeach; ?>
    </div>
        <?php endif; ?>
</div><!-- End <?= h($year); ?> -->
    <?php endforeach; ?>
<?php else: ?>
<h5 class="text-muted text-center text-light">Your newsstream is empty...</h5>
<?php endif; ?>

