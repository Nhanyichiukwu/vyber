<?php

/**
 * @var \App\View\AppView $this
 */
use Cake\Routing\Router;

$this->set('bgColor', 'bg-translucent-white');
$startingPhrase = [
    'phone' => 'An sms',
    'email' => 'A mail'
];
?>
<div class="login-box">
    <?= $this->Form->create(null) ?>
    <?php
    $this->Form->unlockField('verification_code');
    ?>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="text-center"><?= $startingPhrase[$contactType] ?>
                containing a six digit verification code has been sent
                to your <?= $contactType ?>. Enter the code in the box below to
                verify your <?= $contactType ?>.
                </p>
            <pre>
                [<?= $storedCode ?>]
            </pre>
            <div class="mb-3">
                <input type="text" id="verification-code" name="verification_code" data-type="numbers"
                       class="border-bottom border-top-0 form-control form-control-plaintext shadow-none"
                       placeholder="Enter Code" maxlength="6" required>
            </div>
        </div>
        <footer class="card-footer bg-azure-lightest p-3">
            <div class="form-submit">
                <button type="submit" class="btn btn-azure btn-block rounded-pill btn-lg">Verify</button>
            </div>
        </footer>
    </div>
    <a class="text-center" href="<?= Router::url([
        'action' => 'request-code',
        '?' => [
            'after_send_redirect' => $this->getRequest()->getRequestTarget()
        ]
    ]);
    ?>">
        <i class="mdi mdi-refresh"></i>
        <?= __('Resend Code?') ?>
    </a>
    <?= $this->Form->end() ?>
</div>

    <?= $this->Html->scriptStart(['block' => 'scriptBottom']);?>

    <?= $this->Html->scriptEnd(); ?>
