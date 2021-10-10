<?php
use Cake\Routing\Router;
/* 
 * Privacy Settings
 */
?>
<?php ?>
<div class="row">
    <div class="col-6">
    <?= $this->Form->create(
        $user,
        [
            'url' => [
                'action' => 'account',
                'username',
                'um' => 'sectional',
                'section' => 'username',
                'redirect' => urlencode($this->getRequest()->getAttribute('here'))
            ],
            'id' => 'e_username-updater'
        ]); ?>
    <?= $this->Form->input('_method', ['id' => '30nfJGssf', 'type' => 'hidden', 'value' => 'POST', 'label' => false]); ?>

        <div class="form-group">
            <label class="form-label">Username</label>
            <?= $this->Form->control(
                    'username', 
                    [
                        'label' => false,
                        'templates' => [
                            'inputContainer' => '{{content}}'
                        ],
                        'class' => 'form-control', 
                        'placeholder' => 'Username',
                        'data-hasvalidation' => 'true',
                        'data-target' => '#username-validator',
                        'data-validation-method' => 'proxy',
                        'autocomplete' => 'off'
                    ]); ?>
            <div class="mt-2 input-feedback"></div>
        </div>
        <div class="form-group">
            <label class="form-label">Password</label>
            
            <?= $this->Form->control('password', 
                    [
                        'templates' => [
                            'inputContainer' => '<div class="password-input has-preview input-icon">{{content}}<button data-toggle="password-preview" class="btn btn-icon input-icon-addon" type="button" disable="disabled">
                    <i class="icon mdi mdi-eye-outline"></i>
                </button></div>'
                        ],
                        'label' => false, 
                        'class' => 'form-control', 
                        'placeholder' => 'Password',
                        'data-togglable' => 'true',
                        'value' => ''
                    ]); ?>
        </div>
        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
<?= $this->Form->end(); ?>
    </div>
    <div class="col">
        <div class="alert alert-icon alert-primary small" role="alert">
            <i class="mdi mdi-alert-circle mr-2" aria-hidden="true"></i> You may only use leters A-Z, a-z, numbers 0-9 and underscore (_).
        </div>
    </div>
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
    I_ACCOUNT_META_DATA = '<?= json_encode(array(
        'baseUri' => Router::url(['controller' => '/'], ['fullBase' => true]),
        'asxhrh' => Router::url(['controller' => 'AccountServices'], ['fullBase' => true]),
        'currentPage' => $this->getRequest()->getAttribute('here'),
        'account' => [
            'firstname' => $activeUser->getFirstName(),
            'lastname' => $activeUser->getLastName(),
            'othernames' => $activeUser->getOthernames(),
            'username' => $activeUser->getUsername(),
            'email' => $activeUser->getPrimaryEmail(),
            'phone' => $activeUser->getPrimaryPhone(),
            'gender' => $activeUser->getGender(),
            'dob' => $activeUser->profile->getDOB(),
            'maritalStatus' => $activeUser->profile->getMaritalStatus(),
            'timezone' => ''
        ]
    )); ?>';
<?= $this->Html->scriptEnd(); ?>
<?= $this->Html->script('password-revealer', ['block' => 'scriptBottom']); ?>
<?= $this->Html->scriptStart(['block' => 'scriptBottom']); ?>
(function ($, accountService, metaData) {
    accountService.init(metaData);
    // var url = '<?= Router::url(['controller' => 'AccountServices'], ['fullBase' => true]); ?>';
    // accountService.setRequestHandler(url);
    $('#username').on({
        'input': function() {
            accountService.validateUsername($(this));
        }
    });
})(jQuery, AssyncAccountService, I_ACCOUNT_META_DATA);
<?= $this->Html->scriptEnd(); ?>

