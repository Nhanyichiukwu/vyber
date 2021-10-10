<?php
use Cake\Core\Configure;
?>
<div class="page">
    <div class="page-single">
        <div class="container">
            <div class="row">
                <div class="col mx-auto">
                    <div class="text-center mb-6">
                        <img src="./demo/brand/tabler.svg" class="h-6" alt="">
                    </div>
                    <?= $this->Form->create($user, ['class' => 'card']) ?>
                    <?= $this->Form->unlockField('username') ?>
                    <?= $this->Form->unlockField('password') ?>
                    <?= $this->Form->unlockField('re_password') ?>
                    <div class="card-body p-6">
                        <?= $this->Flash->render(); ?>
                        <div class="row">
                            <div class="col-lg-12 text-muted">
                                <h3>Please tell us your name and who you are in the entataynment industry.</h3>
                                <h4>This is how people see you on entatayner</h4>
                            </div>
                            <div class="col-lg-6">
                            <?= $this->Form->control('firstname', ['class' => 'form-control']); ?>
                            </div>
                            <div class="col-lg-6">
                            <?=  $this->Form->control('lastname'); ?>
                            </div>
                            <div class="col-lg-12">
                                <p class="text-muted"><span class="fa fa-info-circle"></span> Note: Make it easy for people to find you, by using the same name that you are best known by.</p>
                            </div>
                            <div class="col-lg-12">
                            <?=  $this->Form->control('personality'); ?>
                            </div>
                            <hr class="my-5">
                            <div class="col-lg-12">
                                <h3>How do you wish to access Entatayna?</h3>
                                <?=  $this->Form->control('username', ['onkeyup' => 'AccountService.checkUsernameAvailability(this)']); ?>
                                <?=  $this->Form->control('password'); ?>
                            </div>
                            <div class="col-lg-6">
                            <?=  $this->Form->radio('gender'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <span class="text-muted">By clicking on "Create My Account" below, I agree to the <?= Configure::read('Site.name') ?>'s <a href="terms.html">terms of Service</a> and <a href="privacy-policy.html">Privacy Policy</a></span>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary btn-block">Create My Account</button>
                        </div>
                    </div>
                    <?= $this->Form->end() ?>
                    <div class="text-center text-muted">
                        Already have account? <a href="./login">Sign in</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>