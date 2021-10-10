<?php

/**
 * @var \App\View\AppView $this
 */
use Cake\Routing\Router;

?>
<div class="login-box">
    <div class="card">
        <div class="card-body login-card-body">
            <?= $this->Flash->render(); ?>
            <div class="alert alert-info alert-default-info">
                <div class="row">
                    <div class="col-auto"><i class="fa-4x fa-smile-wink fas"></i></div>
                    <div class="col"><strong>Awesome!</strong> You are just one last step away from the most
                        exciting digital
                        banking
                        world! You
                        need to
                        create a password to personalize your accounts
                    </div>
                </div>
            </div>
            <?= $this->Form->create() ?>
            <div class="form-group">
                <div class="mb-3">
                    <input type="password" class="form-control<?= isset($errors['password']) ? ' is-invalid'
                        : '' ?>" name="password" required autocomplete="current-password" placeholder="Password">
                </div>
                <?php if (isset($errors['password'])): ?>
                    <span class="invalid-feedback" role="alert">
                            <strong><?= __($errors['password']) ?></strong>
                        </span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <div class="mb-3">
                    <input type="password" class="form-control<?= isset($errors['confirm_password']) ? ' is-invalid'
                        : '' ?>" name="confirm_password" required autocomplete="current-password"
                           placeholder="Confirm Password">
                </div>
                <?php if (isset($errors['confirm_password'])): ?>
                    <span class="invalid-feedback" role="alert">
                            <strong><?= __($errors['confirm_password']) ?></strong>
                        </span>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary btn-block">Go Digital</button>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<?= $this->Html->scriptStart(['block' => 'scriptBottom']);?>

<?= $this->Html->scriptEnd(); ?>
