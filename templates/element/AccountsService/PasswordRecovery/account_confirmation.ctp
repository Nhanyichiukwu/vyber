<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<p class="small-4 text-center">Your search matched the following account. Is this you?</p>
<div class="align-items-center text-center py-3 mt-auto">
    <div class="avatar avatar-xl mb-3" style="background-image: url(../demo/faces/female/18.jpg)"></div>
    <div>
        <h6><a href="../profile.html" class="text-default"><?= h($matchedAccount->firstname) . ' ' . h($matchedAccount->lastname); ?></a></h6>
        <?php if (!empty($matchedAccount->about)): ?>
        <small class="d-block text-muted"><?= h($matchedAccount->about) ?></small>
        <?php endif; ?>
    </div>
</div>
<div class="form-group text-center">
    <div><?= $this->Html->link(
            __('Yes. That\'s me'),
            ['code-verification'],
            ['class' => 'text-link']
            ) ?></div>
    <div><?= $this->Html->link(
            __('No. Not my account'),
            ['account-mismatch'],
            ['class' => 'text-link']
            ) ?></div>
</div>


