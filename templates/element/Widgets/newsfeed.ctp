<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//$this->layout = false;
?>
<?php $thisYear = date('Y'); ?>
<?php if (count($streamItems)): ?>
    <?php foreach ($streamItems as $year => $items): ?>
    <?php for ($i = 0; $i < sizeof($items); $i++): ?>
    <?php endfor; ?>
    <div id="<?= h($year); ?>_timeline" class="e_user-timeline">
        <div class="timeline-title year">
            <?= $this->Html->link(
                    __('{0}', h($year)),
                    [
                        'controller' => 'newsfeed',
                        'action' => 'timeline',
                        '?' => [
                            'filterBy' => 'year',
                            'year' => $year
                        ]
                    ],
                    [
                        'class' => 'year',
                        'escapeTitle' => false
                    ]
                    ); ?>
        </div>
            <?php if ($year == $thisYear): ?>
                <?php foreach ($items as $item): ?>
                    <?= $this->element('Singletons/post_singleton', ['post' => $item]); ?>
                <?php endforeach; ?>
            <?php endif; ?>
    </div><!-- End <?= h($year); ?> -->
    <?php endforeach; ?>
<?php else: ?>
    <h5 class="text-muted text-center text-light">Your newsstream is empty...</h5>
<?php endif; ?>

