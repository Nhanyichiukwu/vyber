<?php 

/**
 * User Activities
 */
?>
<?php if (count($activities)): ?>
<div class="card i--c activities"
     datasrc="/activities"
     data-target=".activity-log"
     aria-rowcount="5"
     aria-live="polite"
     live-task="refresh">
        <div class="card-body p-4">
            <h6 class="align-items-baseline card-title d-flex justify-content-between mb-5">Activities
                <small class="mb-0"><?=
                    $this->Html->link(
                        __('More'),
                        [
                            'controller' => 'activities',
                            'action' => 'index'
                        ],
                        [
                            'class' => 'link text-info',
                            'fullBase' => true
                        ]
                    ) ?>
                </small>
            </h6>
            <div class="list-group list-group-flush activity-log user-list-sm mx-n3">
                <?php foreach ($activities as $activity): ?>
            <div
                class="list-group-item list-group-item-action"
                aria-dismissable="true">
                <div class="d-flex gutters-xs mx-n2">
                    <div class="col-auto">
                        <div class="pos-r">
                            <a href="e/<?= h($activity->get('actor')->getUsername()) ?>">
                                <span class="avatar avatar-xl"><?= $activity->get('actor')->getNameAccronym(); ?></span>
                            </a>
                            <!-- Trying to create a hover-popcard to display users' account preview when hovered upon. -->
                        </div>
                    </div>
                    <div class="col">
                        <div>
                            <?= $activity->get('description'); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
            </div>
        </div>
</div>
<?php endif; ?>
