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
            <p>Would you like to receive another code to enable you verify your contact? Enter your email address or
                phone below so we can send you a new code.
            </p>
            <?= $this->Form->create() ?>
            <?php $this->Form->unlockField('contact'); ?>
            <div class="mb-3">
                <div class="form-group">
                    <div class="mb-3">
                        <input type="text" class="form-control rounded-pill<?= (isset($errors['contact']) ? ' is-invalid' :
                            '')
                        ?>"
                               name="contact"
                               value="<?= $check['contact'] ?? '' ?>" required autocomplete="contact" autofocus
                               placeholder="Email or Phone">
                    </div>

                    <?php if (isset($errors['contact'])): ?>
                        <span class="invalid-feedback" role="alert">
                            <strong><?= __($errors['contact']) ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary btn-block rounded-pill">Request Code</button>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<?= $this->Html->scriptStart(['block' => 'scriptBottom']);?>

<?= $this->Html->scriptEnd(); ?>
