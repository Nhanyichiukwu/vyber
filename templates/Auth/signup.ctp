<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
use Cake\Core\Configure;
use Cake\Utility\Hash;
?>
<?php $this->assign('title', 'Sign Up'); ?>

<div class="col-md-5 mx-auto pt-5">
    <div class="signup-form-container card shadow-sm">
        <div class="card-body p-7">
            <h1 class="font-weight-light mb-4">Sign Up</h1>
            <div id="register">
         <?= $this->Form->create($newUser, ['id' => 'registration_form', 'class' => 'form']); ?>
            <?= $this->Flash->render(); ?>
            <?= $this->Form->unlockField('username') ?>
            <?= $this->Form->unlockField('password') ?>
            <?= $this->Form->unlockField('re_password') ?>
                <div class="row gutters-sm">
                    <div class="col-md-6 mb-3">
                    <?= $this->Form->control('firstname', ['class' => 'form-control bdrs-0 input-lg']); ?>
                        <?php if (isset($errors['firstname'])): ?>
                        <div class="input-error alert alert-danger mt-2 mb-0 bdrs-0"><?= $errors['firstname'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                    <?=  $this->Form->control('lastname', ['class' => 'form-control bdrs-0 input-lg']); ?>
                        <?php if (isset($errors['lastname'])): ?>
                        <div class="input-error alert alert-danger mt-2 mb-0 bdrs-0"><?= $errors['lastname'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-12 mb-3">
                        <small class="text-muted"><span class="mdi mdi-info-circle"></span> Note: We strongly recommend using the same name that you are best known by, to make it easy for people to find you.</small>
                    </div>
                    <div class="form-group col-xs-12 col-lg-12">
                        <label for="contact">Email Or Phone</label>
                        <input id="contact" class="form-control bdrs-0 input-lg" type="text" name="contact" title="Enter Email Or Phone" placeholder="Your Email Or Phone...">
                        <?php if (isset($errors['contact'])): ?>
                        <div class="input-error alert alert-danger mt-2 mb-0 bdrs-0"><?= $errors['contact'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <?=  $this->Form->control('username', ['onkeyup' => 'Validator.checkUsernameAvailability(this.value)', 'class' => 'form-control bdrs-0 input-lg']); ?>
                        <?php if (isset($errors['username'])): ?>
                        <div class="input-error alert alert-danger mt-2 mb-0 bdrs-0"><?= $errors['username'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="form-group">
                        <input name="password" id="password" class="form-control form-control-lg bdrs-r-4 pr-5" type="password" placeholder="Password" aria-revealable="true">
                        <span class="input-icon-addon p-e_All pos-a-r z_rS0"  data-toggle="password-visibility" data-target="#password">
                            <i class="mdi mdi-eye-outline mdi-18px"></i>
                        </span>
                        </div>
                        <?php if (isset($errors['password'])): ?>
                        <div class="input-error alert alert-danger mt-2 mb-0 bdrs-0"><?= $errors['password'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <span class="text-muted">By clicking on "Create My Account" below, I agree to the <?= Configure::read('Site.name') ?>'s <a href="/legal/terms/service-terms.html">terms of Service</a> and <a href="/legal/policies/privacy-policy.html">Privacy Policy</a></span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block bdrs-0 input-lg">Create My Account</button>
                    </div>
                </div>
        <?= $this->Form->end(); ?><!-- Signup Form Ends -->
            </div><!--Registration Form Contents Ends-->
        </div>
    </div>
    <div class=" text-center">
        <p><a href="login">Already have an account?</a></p>
    </div>
</div>
<?php $this->Html->script("password-revealer", ['block' => 'scriptBottom']); ?>