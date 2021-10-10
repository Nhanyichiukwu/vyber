<?php
/**
 * @package Timeline Layout
 * @group Grid Layout
 * @name Large
 */

if ($this->get('posts'))
    $timeline = $posts;
?>

<?php $thisYear = date('Y'); ?>
<?php if (count($timeline)): ?>
    <?php foreach ($timeline as $year => $posts): ?>
        <?php for ($i = 0; $i < sizeof($posts); $i++): ?>
        <?php endfor; ?>
        <div id="<?= h($year); ?>_timeline" class="e_user-timeline timeline-grid">
            <?php if ($year <= $thisYear): ?>
                <div class="row">
                    <?php foreach ($posts as $item): ?>
                        <div class="col-md-6 col-lg-6">
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