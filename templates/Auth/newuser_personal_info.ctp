<?php

use Cake\Core\Configure;
?>
<div class="col-md-6 mx-auto my-5">
    <div class="text-center mb-6">
        <img src="./demo/brand/tabler.svg" class="h-6" alt="">
    </div>
            <h4>Just a few more info and you're done..</h4>
            <p class="small">This is how people see you on entatayner</p>
    <div class="personal-info card shadow-sm">
            <?= $this->Form->create($user, ['class' => 'card-body p-7']) ?>
            <?= $this->Form->unlockField('username') ?>
            <?= $this->Form->unlockField('password') ?>
            <?= $this->Form->unlockField('re_password') ?>
                <?= $this->Flash->render(); ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <?= $this->Form->control('firstname', ['class' => 'form-control']); ?>
                </div>
                <div class="col-md-6">
                    <?=  $this->Form->control('lastname', ['class' => 'form-control']); ?>
                </div>
                <div class="col-md-12 mb-3">
                    <small class="text-muted"><span class="mdi mdi-info-circle"></span> Note: Make it easy for people to find you, by using the same name that you are best known by.</small>
                </div>
                <div class="col-lg-12">
                        <?=  $this->Form->control('username', ['onkeyup' => 'AccountService.checkUsernameAvailability(this.value)', 'class' => 'form-control']); ?>
                </div>
                <div class="col-lg-12">
                        <?=  $this->Form->control('password', ['class' => 'form-control']); ?>
                </div>
            </div>
            <div class="form-group">
                <span class="text-muted">By clicking on "Create My Account" below, I agree to the <?= Configure::read('Site.name') ?>'s <a href="terms.html">terms of Service</a> and <a href="privacy-policy.html">Privacy Policy</a></span>
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary btn-block">Create My Account</button>
            </div>
            <?= $this->Form->end() ?>
    </div>
        <div class="text-center text-muted">
            Already have account? <a href="./login">Sign in</a>
        </div>
</div>