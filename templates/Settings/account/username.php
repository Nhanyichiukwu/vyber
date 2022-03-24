<?php
use Cake\Routing\Router;
/*
 * Privacy Settings
 */

if (!$this->getRequest()->is('ajax')) {
    $this->extend('common');
}
?>
<?php ?>
<div class="p-4">
    <div class="alert alert-primary d-flex align-items-center" role="alert">
        <span class="mdi mdi-alert-circle me-2 mdi-24px" aria-hidden="true"></span>
        <small>You may only use leters A-Z, a-z, numbers 0-9 and underscore (_).</small>
    </div>
    <?= $this->Form->create(
        $user,
        [
            'url' => [
                'type' => 'post',
                'action' => 'account',
                'username',
                '?' => [
                    'um' => 'sectional',
                    'section' => 'username',
                ],

//                    'redirect' => urlencode($this->getRequest()->getAttribute('here'))
            ],
            'id' => 'username-updater'
        ]); ?>
    <div style="display:none;">
        <input type="hidden" name="_method" value="POST">
    </div>
    <div class="form-group">
        <label class="form-label">Username</label>
        <?= $this->Form->control(
            'username',
            [
                'label' => false,
                'templates' => [
                    'inputContainer' => '{{content}}'
                ],
                'class' => 'form-control rounded-pill',
                'placeholder' => 'Username',
                'data-hasvalidation' => 'true',
                'data-target' => '#username-validator',
                'data-validation-method' => 'proxy',
                'autocomplete' => 'off',
                'required' => 'required',
                'currentValue' => $user->getUsername(),
            ]); ?>
        <div class="mt-2 input-feedback"></div>
    </div>
    <div class="form-group">
        <label class="form-label">Password</label>
        <div class="password-input has-preview input-icon">
            <?= $this->Form->control('password',
                [
                    'templates' => [
                        'inputContainer' => '{{content}}'
                    ],
                    'label' => false,
                    'class' => 'form-control rounded-pill',
                    'placeholder' => 'Password',
                    'data-togglable' => 'true',
                    'required' => 'required',
                    'value' => ''
                ]); ?>
            <button data-toggle="password-preview"
                    class="btn btn-icon input-icon-addon _FJ8m lh-lg"
                    type="button">
                <i class="fs-5 icofont-eye icon lh-base"></i>
            </button>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-app btn-block btn-pill disabled">Update</button>
    </div>
    <?= $this->Form->end(); ?>
</div>
<div class="d-none :visually-hidden">
    <?=
    $this->Form->create(null,
        [
            'id' => 'username-validator',
            'class' => 'ajax-tokenizer'
        ]);
    $this->Form->end();
    ?>
</div>
<?= $this->Html->script('AssyncAccountService', ['block' => 'scriptBottom', 'fullBase' => true, 'type' => 'text/javascript', 'charset' => 'utf-8']); ?>
<?= $this->Html->scriptStart(['block' => 'scriptBottom', 'type' => 'text/javascript', 'charset' => 'utf-8']); ?>
const I_ACCOUNT_META_DATA = '<?= json_encode(array(
    'baseUri' => Router::url(['controller' => '/'], true),
    'asxhrh' => Router::url(['controller' => 'AccountServices'], true),
    'currentPage' => $this->getRequest()->getAttribute('here'),
    'account' => [
        'firstname' => $user->getFirstName(),
        'lastname' => $user->getLastName(),
        'othernames' => $user->getOthernames(),
        'username' => $user->getUsername(),
        'email' => $user->getPrimaryEmail(),
        'phone' => $user->getPrimaryPhone(),
        'gender' => $user->profile->getGender(),
        'dob' => $user->profile->getDOB(),
        'maritalStatus' => $user->profile->getRelationship(),
        'timezone' => ''
    ]
)); ?>';
<?= $this->Html->scriptEnd(); ?>
<?= $this->Html->script('password-revealer', ['block' => 'scriptBottom']); ?>
<?= $this->Html->scriptStart(['block' => 'scriptBottom']); ?>
(function ($, accountService, metaData) {
accountService.init(metaData);
// var url = '<?= Router::url(['controller' => 'AccountServices'], true); ?>';
// accountService.setRequestHandler(url);
$('#username').on({
'input': function() {
accountService.validateUsername($(this));
}
});
})(jQuery, AssyncAccountService, I_ACCOUNT_META_DATA);
<?= $this->Html->scriptEnd(); ?>
