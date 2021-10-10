<div class="col-lg-5 col-md-4 col-sm-12">
    <div class="py-5">
        <div class="card">
            <div class="card-body p-5">
                <h3 class="login-box-msg">Login</h3>
                <?= $this->Flash->render(); ?>
                <?= $this->Form->create('login', ['url' => 'login']) ?>
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control<?= (isset($errors['email']) ? ' is-invalid' : '')
                        ?>"
                               name="email"
                               value="<?= $login['email'] ?? '' ?>" required autocomplete="email" autofocus
                               placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
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
                    <div class="input-group mb-3">
                        <input type="password" class="form-control<?= isset($errors['password']) ? ' is-invalid'
                            : '' ?>" name="password" required autocomplete="current-password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <?php if (isset($errors['password'])): ?>
                        <span class="invalid-feedback" role="alert">
                            <?php foreach ($errors['password'] as $key => $error): ?>
                                <strong><?= __($error) ?></strong>
                            <?php endforeach; ?>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block"><?= __('Login') ?></button>
                    </div>
                    <!-- /.col -->
                </div>
                <?= $this->Form->end() ?>

                <div class="social-auth-links text-center mb-3">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google mr-2"></i> Sign in using Google
                    </a>
                </div>
                <!-- /.social-auth-links -->

                <p>
                    <a class="text-center" href="<?= Router::normalize('password/reset') ?>">
                        <?= __('Forgot Your Password?') ?>
                    </a>
                </p>
                <p class="mb-0">
                    <a href="<?= Router::normalize('register') ?>" class="text-center btn btn-block
                    btn-warning">Register</a>
                </p>
            </div>
        </div>
    </div>
</div>
<!-- /.login-box -->
