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
if ($this->get('pendingRequests') && $this->get('pendingRequests') > 0): ?>
    <div class="i--c requests card"
         datasrc="/requests?src=<?= sprintf("%s/%s", SecurityAlias::randomString(30), $activeUser->get('refid')) ?>"
         data-target=".requests-list"
         aria-rowcount="5"
         aria-live="polite"
         live-task="refresh">
        <div class="card-body i_fjew p-4">
            <h6 class="align-items-baseline card-title d-flex justify-content-between mb-5">Requests
                <small class="mb-0"><?=
                    $this->Html->link(
                        __('See More'),
                        [
                            'controller' => 'requests',
                            'action' => 'index'
                        ],
                        [
                            'class' => 'link text-info',
                            'fullBase' => true
                        ]
                    ) ?>
                </small>
            </h6>
            <div class="list-group list-group-flush mx-n3 mb-n3 requests-list">
                <?php foreach ($this->get('pendingRequests') as $request): ?>
                    <i-fc class="user d-flex py-4 justify-content-between"></i-fc>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
