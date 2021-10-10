<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
use Cake\Utility\Security as SecurityAlias;
?>
<?php
if ($this->get('suggestedConnections') && $this->get('suggestedConnections')->count() > 0): ?>
<div class="card i--c suggestions potential-connections"
     datasrc="/suggestions/connections?src=<?= sprintf("%s/%s", SecurityAlias::randomString(30), $activeUser->get('refid')) ?>"
     data-target=".people-list"
     aria-rowcount="5"
     aria-live="polite"
     live-task="refresh">
        <div class="card-body p-4">
            <h6 class="align-items-baseline card-title d-flex justify-content-between mb-5">Suggested Connections
                <small class="mb-0"><?=
                    $this->Html->link(
                        __('Explore'),
                        [
                            'controller' => 'explore',
                            'action' => 'suggestions',
                            'potential-connections'
                        ],
                        [
                            'class' => 'link text-info',
                            'fullBase' => true
                        ]
                    ) ?>
                </small>
            </h6>
            <div class="list-group list-group-flush people-list user-list-sm mx-n3 mb-n3">
                <?php foreach ($this->get('suggestedConnections') as $peopleToMeet): ?>
                    <i-fc class="user d-flex py-4 justify-content-between"></i-fc>
                <?php endforeach; ?>
            </div>
        </div>
</div>
<?php endif; ?>
