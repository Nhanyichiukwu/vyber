<?php

/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
  */
  
  $requestAction = $this->Url->request->action;
?>
<div class="col-md-3 mx-auto mt-5">
    <div class="row">
        <div class="col col-login mx-auto">
            <div class="text-center mb-6">
                <img src="./demo/brand/tabler.svg" class="h-6" alt="">
            </div>
            <?= $this->Form->create('User') ?>
            <?= $this->Form->unlockField('username') ?>
            <?= $this->Form->unlockField('password') ?>
            <?= $this->Form->unlockField('save_login') ?>
            <div class="p-6">
                <h4 class="">Login to your account</h4>
                <div class="form-group">
                    <label class="form-label" for="username">Email Or @Username</label>
                    <input name="username" type="username" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Email Or @Username">
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">
                        Password
                        <a href="./forgot-password.html" class="float-right small">I forgot password</a>
                    </label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <label class="custom-control custom-checkbox">
                        <input name="save_login" type="hidden" class="hidden" value="0">
                        <input name="save_login" type="checkbox" class="custom-control-input" value="1" checked="true">
                        <span class="custom-control-label">Remember me</span>
                    </label>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                </div>
            </div>
        <?= $this->Form->end(); ?>
            <div class="text-center text-muted">
                Don't have account yet? <?= $this->Html->link(__('Signup'), ['controller' => '/', 'action' => 'signup']); ?> It's free.
            </div>
        </div>
    </div>
</div>
