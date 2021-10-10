<?php
use Cake\Routing\Router;
?>
<div class="ovY-a p-4">
    <?php if (count($photos)): ?>

    <?php else: ?>
    <div class="no-results">You have no photos yet</div>
    <div class="tip row">
        
        <div class="col-auto mx-auto">
            <h3 class="text-muted">Upload Photos</h3>
        <?= $this->Form->create(null, [
            'type' => 'file', 
            'url' => Router::url([
                'controller' => 'upload', 
                'action' => 'photo',
                'continue' => urlencode($this->getRequest()->getAttribute('here')),
            ],
            [
                'fullBase' => true
            ]), 
            'name' => 'photo-uploader',
            'assync' => 'true'
        ]); ?>
            <div class="form-group">
                <div class="custom-file">
                <?= $this->Form->input('photo[]', [
                    'type' => 'file',
                    'label' => false,
                    'templates' => [
                        'inputContainer' => '{{content}}'
                    ],
                    'class' => 'custom-file-input',
                    'accept' => 'image/jpg,image/jpeg,image/png'
                ]); ?>
                    <label class="custom-file-label"></label>
                </div>
            </div>
            <div class="form-group">
                <div class="custom-file">
                <?= $this->Form->input('photo[]', [
                    'type' => 'file',
                    'label' => false,
                    'templates' => [
                        'inputContainer' => '{{content}}'
                    ],
                    'class' => 'custom-file-input',
                    'accept' => 'image/jpg,image/jpeg,image/png'
                ]); ?>
                    <label class="custom-file-label"></label>
                </div>
            </div>
            <div class="form-group">
                <div class="custom-file">
                <?= $this->Form->input('photo[]', [
                    'type' => 'file',
                    'label' => false,
                    'templates' => [
                        'inputContainer' => '{{content}}'
                    ],
                    'class' => 'custom-file-input',
                    'accept' => 'image/jpg,image/jpeg,image/png'
                ]); ?>
                    <label class="custom-file-label"></label>
                </div>
            </div>
            <div class="form-group">
                <?= $this->Form->button(__('Upload <i class="btn-icon mdi mdi-upload"></i>'), [
                    'type' => 'submit',
                    'class' => 'btn btn-sm btn-primary',
                    'escapeTitle' => false
                ]); ?>
            </div>
        <?= $this->Form->end(['upload']); ?>
        </div>
        
    </div>
    <?php endif; ?>
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

<?= $this->Html->scriptStart(['block' => 'scriptBottom']); ?>
(function ($, accountService, metaData) {
    accountService.init(metaData);
    var frm = $('form');
    if (frm.attr('assync') === 'true') {
        frm.ajaxForm({
            url: frm.attr('href'),
            beforeSubmit: function () 
            {
                if($('input[type="file"]').val() === "") {
                    frm.prepend('<div class="invalid-feedback">You haven\'t selected any file yet. Please select a file and the try again...</div>');
                    return false; 
                }
            },
            complete: function (xhr, status, data) 
            {
                
            }
        });
    }
})(jQuery, AssyncAccountService, I_ACCOUNT_META_DATA);
<?= $this->Html->scriptEnd(); ?>
<script>
    
    </script>
    