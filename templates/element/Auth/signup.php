<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

use Cake\Routing\Router;
$url = null;
$controller = $this->getRequest()->getParam('controller');
if ($controller !== 'signup') {
    $url = [
        'controller' => 'signup',
        'action' => 'index'
    ];
}
?>
<div class="sign-up-form">
    <?= $this->Form->create(null, [
            'class' => 'ajax-form',
            'async' => 'async',
            'url' => $url
        ]) ?>
    <?php
    $this->Form->unlockField('contact');
    $this->Form->unlockField('accept_terms');
    $this->Form->unlockField('contact');
    ?>
    <div class="card mb-3 mmhtpn7c">
        <div class="card-body p-4">
            <div class="form-group form-group-lg">
                <label for="contact">Your Phone Or Email</label>
                <div class="bg-light mb-3">
                    <input type="contact" name="contact" id="contact"
                        <?= isset($credentials['contact']) ? 'value="' .
                            $credentials['contact'] . '"' : '' ?>
                        class="border-0 form-control form-control-plaintext rounded-0 shadow-none
                        <?= ((isset
                            ($errors['contact']) ||
                            isset($errors['email']) || isset(
                                $errors['phone'])) ? ' is-invalid border-danger' : '')
                        ?>"
                        placeholder="Phone or Email">
                </div>
                <?php if (isset($errors['contact'])): ?>
                    <span class="invalid-feedback" role="alert">
                <?php foreach ($errors['contact'] as $key => $error): ?>
                    <strong><?= __(str_replace('value', 'contact', $error)) ?></strong>
                <?php endforeach; ?>
            </span>
                <?php endif; ?>
                <?php if (isset($errors['email'])): ?>
                    <span class="invalid-feedback" role="alert">
                <?php foreach ($errors['email'] as $key => $error): ?>
                    <strong><?= __(str_replace('value', 'email address', $error)) ?></strong>
                <?php endforeach; ?>
            </span>
                <?php endif; ?>
                <?php if (isset($errors['phone'])): ?>
                    <span class="invalid-feedback" role="alert">
                <?php foreach ($errors['phone'] as $key => $error): ?>
                    <strong><?= __(str_replace('value', 'phone number', $error)) ?></strong>
                <?php endforeach; ?>
            </span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <div class="d-none"><input type="hidden" name="accept_terms" value="reject"></div>
                <label class="custom-control custom-checkbox custom-control-inline pl-0">
                    <input type="checkbox" class="custom-control-input" id="agreeTerms" name="accept_terms" value="accept">
                    <?php
                    $hasError = 'text-muted';
                    if (isset($errors['accept_terms'])) {
                        $hasError = 'text-danger';
                    }
                    ?>
                    <span class="custom-control-label mhfxfqfp <?= $hasError ?>">I agree to the <a href="<?= Router::normalize('legal/terms') ?>">terms</a></span>
                </label>
            </div>
            <?php if (isset($errors['accept_terms'])): ?>
                <span class="invalid-feedback" role="alert">
                    <?php foreach ($errors['accept_terms'] as $key => $error): ?>
                        <strong><?= __($error) ?></strong>
                    <?php endforeach; ?>
                </span>
            <?php endif; ?>
        </div>
        <footer class="bg-yellow-lightest card-footer p-3 r0tvn9df">
            <div class="form-submt">
                <button type="submit"
                        class="btn btn-block btn-lg btn-yellow rounded-pill
                        text-dark">Get Started
                    <i class="mdi mdi-arrow-right"></i>
                </button>
            </div>
        </footer>
    </div>
    <!-- /.col -->
    <div class="_j4">
        <div class="form-group form-group-button">
            <div>
                <a href="<?= Router::url(['controller' => 'login']); ?>"
                   class="text-center btn rounded-pill btn-outline-primary
                   btn-block btn-lg">
                    <i class="mdi mdi-arrow-left"></i> Already registered
                </a>
            </div>
        </div>
    </div>
    <!-- /.col -->
    <?= $this->Form->end() ?>
</div>
<?= $this->Html->scriptStart(['block' => 'scriptBottom']); ?>

    (function ($) {
        $('.ajax-form').on('submit', function (e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var data = $(this).serialize();

            $.ajax({
                url: url,
                type: "POST",
                data: data,
                dataType: "json",
                success: function (data, status) {
                    if (data.hasOwnProperty('url')) {
                        var nextPage = data.url;
// window.location.assign(nextPage);
                        window.history.pushState(null, data.pageTitle, nextPage);
                        var loader = $('<div class="loading fullscreen-overlay bg-gradient-theme"><span class="box-100 fa
                        spinner - border
                        text - warning
                        "></span>' +
                        '</div>'
                    )
                        ;
                        $('body').append(loader);
// $.ajax({
//     url: nextPage,
//     type: "GET",
//     dataType: "HTML",
//     success: function (data, status) {
//         if (data.indexOf('<html') > -1) {
//             // $(window).replaceWith(data);
//             var newPage = document.open('text/html','replace');
//             newPage.write(data);
//             newPage.close();
//         }
//         return true;
//     }
// });
                    }
                },
                error: function (data, status, xhrs) {

                }
            });
        });
    })(jQuery);
<?= $this->Html->scriptEnd(); ?>
