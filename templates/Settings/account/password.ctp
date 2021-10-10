<?php

/* 
 * Password Manager
 */
?>
<?php $this->assign('title', 'Change Password'); ?>
<div class="row">
    <div class="col-7">
    <?= $this->Form->create(
        null,
        [
            'method' => 'post'
        ]); ?>
                    <div class="form-group row align-items-center mb-0">
                        <label class="form-label col-4 text-right">Current Password</label>
                        <div class="col">
                        <?= $this->Form->control('current_password', ['label' => false, 'type' => 'password', 'class' => 'form-control', 'placeholder' => 'Current Password']); ?>
                        </div>
                    </div>
                    <div class="text-right mb-3">
                        <?= $this->Html->link(
                            __('Forgot Password?'),
                            [
                                'controller' => 'accounts-service',
                                'action' => 'password-help',
                                'accountChallenge' => 'forgot_password'
                            ],
                            [
                                'class' => 'text-small text-muted text-primary',
                                'escapeTitle' => false
                            ]
                        ); ?>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="form-label col-4 text-right">New Password</label>
                        <div class="col">
                        <?= $this->Form->control('new_password', 
                                [
                                    'templates' => [
                                        'inputContainer' => '<div class="password-input has-preview input-icon">{{content}}<button data-toggle="password-preview" class="btn btn-icon input-icon-addon" type="button" disable="disabled">
                                <i class="icon mdi mdi-eye-outline"></i>
                            </button></div>'
                                    ],
                                    'type' => 'password',
                                    'label' => false, 
                                    'class' => 'form-control', 
                                    'placeholder' => 'New Password',
                                    'data-togglable' => 'true'
                                ]); ?>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label class="form-label col-4 text-right">Repeat Password</label>
                        <div class="col">
                        <?= $this->Form->control('repeat_password', 
                                [
                                    'templates' => [
                                        'inputContainer' => '<div class="password-input has-preview input-icon">{{content}}<button data-toggle="password-preview" class="btn btn-icon input-icon-addon" type="button" disable="disabled">
                                <i class="icon mdi mdi-eye-outline"></i>
                            </button></div>'
                                    ],
                                    'type' => 'password',
                                    'label' => false, 
                                    'class' => 'form-control', 
                                    'placeholder' => 'Repeat Password',
                                    'data-togglable' => 'true'
                                ]); ?>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
    <?= $this->Form->end(); ?>
    </div>
    <div class="col">
        <div class="alert alert-icon alert-primary small" role="alert">
            <span class="mdi mdi-alert-circle mr-2" aria-hidden="true"></span> Please be aware that using simlpe passwords such as 123456 and abcdef, is dangerous and vunrable to attack, as such passwords are easily guessed.
            Therefore, in order to make your password strong and secure, we advice you use combinations of UPPER and lower case letters, numbers and special characters.
        </div>
    </div>
</div>

<?= $this->Html->script('password-revealer', ['block' => 'scriptBottom']); ?>