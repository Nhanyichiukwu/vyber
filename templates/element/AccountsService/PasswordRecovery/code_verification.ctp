<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="form-group">
    <p class="small-4 text-center">Enter Verification Code</p>
    <p class="small-4 text-center"><?= $code ?></p>
    <?= $this->Form->input('code', ['label' => false, 'class' => 'form-control rounded-pill']); ?>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-block rounded-pill btn-primary">Verify</button>
</div>
<!--<div class="form-group">
    <?= $this->Form->control('current_password', ['label' => false, 'type' => 'password', 'class' => 'form-control rounded-pill', 'placeholder' => 'Current Password']); ?>
    <div class="text-right">
        <?= $this->Html->link(
            __('Forgot Password?'),
            [
                'controller' => 'accounts-service',
                'action' => 'password-recovery',
                '?' => [
                    'challenge' => 'forgot_pw'
                ]
            ],
            [
                'class' => 'text-small text-muted text-primary',
                'escapeTitle' => false
            ]
        ); ?>
    </div>
</div>
<div class="form-group">
    <?= $this->Form->control('new_password', ['label' => false, 'type' => 'password', 'class' => 'form-control rounded-pill', 'placeholder' => 'New Password']); ?>
</div>
<div class="form-group">
    <?= $this->Form->control('repeat_password', ['label' => false, 'type' => 'password', 'class' => 'form-control rounded-pill', 'placeholder' => 'Repeat Password']); ?>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-block rounded-pill btn-primary">Save Changes</button>
</div>-->

