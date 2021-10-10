<?php

?>
<h3 class="font-weight-lighter">The username/email you entered matched the following account.</h3>
<div class="identified-user mt-5">
    <div class="">
        <div class="row gutters-sm">
            <div class="col-auto profile">
                <span class="avatar avatar-xxl" style="<?= $userfound->profile->getProfileImageUrl() ?>"></span>
            </div>
            <div class="col account-details">
                <h4 class="account-name fsz-18"><?= $userfound->getFullname(); ?></h4>
                <h3 class="font-weight-lighter text-right">Is this you?</h3>
            </div>
        </div>
        <div class="password-form">
            <?= $this->Form->create(null, ['type' => 'post', 'class' => '']); ?>
            <div class="form-group hidden">
                <input name="username" id="username" class="form-control bdrs-r-4 pr-5" type="hidden" value="<?= isset($postData, $postData['username']) ? $postData['username'] : '' ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Retype Password</label>
                <div class="input-group input-group pos-r">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fe fe-unlock icon-lock"></i>
                        </span>
                    </div>
                    <input name="password" id="password" class="form-control bdrs-r-4 pr-5" type="password" placeholder="Password" aria-revealable="true" value="<?= isset($postData, $postData['password']) ? $postData['password'] : '' ?>">
                    <span class="input-icon-addon p-e_All pos-a-r z_rS0"  data-toggle="password-visibility" data-target="#password">
                        <i class="mdi mdi-eye-outline mdi-18px"></i>
                    </span>
                </div>
            </div>
            <div class="text-right mb-4">
                <?= $this->Html->link(__('Forgotten password'),
                        [
                            'controller' => 'account-services',
                            'action' => 'password-reset',
                            '?' => [
                                'challenge' => 'forgot_pw'
                            ]
                        ],
                        [
                            'class' => 'small',
                            'escapeTitle' => false
                        ]
                    ); ?>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-md btn-block btn-primary">Login</button>
            </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>
