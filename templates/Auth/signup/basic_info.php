<?php

use Cake\Core\Configure;
use Cake\Routing\Router;

?>
<div class="py-5">
    <div class="card">
        <div class="card-body p-5">
            <h3 class="login-box-msg">Register</h3>

            <?= $this->Form->create(null, ['url' => 'register']) ?>
            <div class="form-group form-group-lg">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <input type="text" class="form-control<?= (isset($errors['firstname']) ? ' is-invalid' : '')
                    ?>" name="firstname" value="<?= isset($credentials['firstname']) ?
                        $credentials['firstname'] : '' ?>" placeholder="First Name">
                </div>
                <?php if (isset($errors['firstname'])): ?>
                    <span class="invalid-feedback" role="alert">
                <?php foreach ($errors['firstname'] as $key => $error): ?>
                    <strong><?= __(str_replace('value', 'firstname', $error)) ?></strong>
                <?php endforeach; ?>
            </span>
                <?php endif; ?>
            </div>
            <div class="form-group form-group-lg">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <input type="text" class="form-control<?= (isset($errors['surname']) ? ' is-invalid' : '')
                    ?>" name="surname" value="<?= isset($credentials['surname']) ?
                        $credentials['surname'] : '' ?>" placeholder="Surname">
                </div>
                <?php if (isset($errors['surname'])): ?>
                    <span class="invalid-feedback" role="alert">
                <?php foreach ($errors['surname'] as $key => $error): ?>
                    <strong><?= __(str_replace('value', 'surname', $error)) ?></strong>
                <?php endforeach; ?>
            </span>
                <?php endif; ?>
            </div>
            <div class="form-group form-group-lg">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <input type="text" class="form-control<?= (isset($errors['other_names']) ? ' is-invalid' : '')
                    ?>" name="other_names"
                           value="<?= isset($credentials['other_names']) ?
                               $credentials['other_names'] : '' ?>" placeholder="Other Names">
                </div>
                <?php if (isset($errors['other_names'])): ?>
                    <span class="invalid-feedback" role="alert">
                    <?php foreach ($errors['other_names'] as $key => $error): ?>
                        <strong><?= __(str_replace('value', 'other_names', $error)) ?></strong>
                    <?php endforeach; ?>
                </span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <div class="d-none"><input type="hidden" name="auto_account" value="no"></div>
                <label class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" name="auto_account" value="yes"
                           checked="checked">
                    <span class="custom-control-label">Also create an account with this name</span>
                </label>
                <?php if (isset($errors['accept_terms'])): ?>
                    <span class="invalid-feedback" role="alert">
                    <?php foreach ($errors['accept_terms'] as $key => $error): ?>
                        <strong><?= __($error) ?></strong>
                    <?php endforeach; ?>
                </span>
                <?php endif; ?>
            </div>
            <!-- /.col -->
            <div class="form-button-group">
                <button type="submit" class="btn btn-primary btn-block">Get Started</button>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
