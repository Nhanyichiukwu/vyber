<?php

/**
 * @var AppView $this
 */

use App\View\AppView;
use Cake\Routing\Router;

$thisPage = (string) $this->getRequest()->getParam('controller');
$url = '';
if (strtolower($thisPage) !== 'login') {
    $url = Router::url([
        'controller' => 'login',
        'action' => 'index',
        '?' => [
            'redirect' => urlencode(
                Router::url($this->getRequest()->getRequestTarget(), true)
            )
        ]
    ], true);
}
?>

        <?= $this->Flash->render(); ?>
        <?= $this->Form->create(null, ['url' => $url, 'class' => 'login-form']) ?>
        <?php
        $this->Form->unlockField('email');
        $this->Form->unlockField('contact');
        $this->Form->unlockField('password');
        $this->Form->unlockField('remember_me');
        ?>
        <div class="form-group mb-1">
            <div class="bg-light ebhwdzhs input-group input-group-alternative input-group-merge">
                <div class="input-group-prepend">
                    <span class="bg-transparent border-0 c-grey-700 input-group-text rounded-0"><i
                            class="mdi mdi-account"></i></span>
                </div>
                <input type="text"
                       class="bg-transparent border-0 form-control
                           form-control-plaintext rounded-0 shadow-none jafwiekn<?= (
                       isset($errors['email'])
                           ? ' is-invalid'
                           : ''
                       ) ?>"
                       name="email"
                       value="<?= $login['email'] ?? '' ?>" required autocomplete="email" autofocus
                       placeholder="Email Or Phone">
            </div>
            <?php if (isset($errors['email'])): ?>
                <span class="invalid-feedback" role="alert">
                            <?php foreach ($errors['email'] as $key => $error): ?>
                                <strong><?= __($error) ?></strong>
                            <?php endforeach; ?>
                        </span>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <div class="bg-light input-group input-group-alternative input-group-merge y2j0mtlk">
                <div class="input-group-prepend">
                        <span class="bg-transparent border-0 c-grey-700 input-group-text rounded-0">
                            <i class="mdi mdi-key"></i>
                        </span>
                </div>
                <input type="password"
                       class="bg-transparent border-0 form-control
                           form-control-plaintext rounded-0 shadow-none cjtziucd
                           <?= (isset($errors['password']) ? ' is-invalid' : '') ?>"
                       name="password"
                       value="<?= $login['password'] ?? '' ?>" required autocomplete="password" autofocus
                       placeholder="Password">
            </div>
            <?php if (isset($errors['password'])): ?>
                <span class="invalid-feedback" role="alert">
                        <?php foreach ($errors['password'] as $key => $error): ?>
                            <strong><?= __($error) ?></strong>
                        <?php endforeach; ?>
                    </span>
            <?php endif; ?>
        </div>
        <input class="d-none" type="hidden" name="remember_me" value="no">
        <div class="form-row gutters-sm mt-3">
            <div class="col-auto">
                <div class="custom-control pl-0 custom-control-alternative custom-checkbox mb-3">
                    <input class="custom-control-input" id=" customCheckLogin" type="checkbox" name="remember_me"
                           value="yes">
                    <label class="custom-control-label mhfxfqfp text-muted" for=" customCheckLogin">
                        <span class="text-muted">Remember me</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-block btn-app mmhtpn7c">Sign in</button>
        </div>
        <?= $this->Form->end() ?>

<div class="row mt-3">
    <div class="col-6">
        <a href="<?= Router::url(['controller' => 'PasswordReset', '?' => ['challenge' => 'forgot_password']], true) ?>"
           class="text-gray">
            <small>Forgot password?</small>
        </a>
    </div>
    <div class="col-6 text-right">
        <a href="<?= Router::url(['controller' => 'signup'], true) ?>"
           class="text-gray">
            <small>Not registered?</small>
        </a>
    </div>
</div>
