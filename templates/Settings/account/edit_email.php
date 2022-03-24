<?php

/**
 * Email Edit Form
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$this->enablePageHeader();
$this->assign('title', 'Edit Email');
?>
<div class="container-fluid p-4">
    <?= $this->Form->create($user, [
        'url' => [
            'action' => 'account',
            'email',
            '?' => [
                'um' => 'sectional',
                'section' => 'email',
//                'redirect' => urlencode($this->getRequest()->getAttribute('here'))
            ]
        ],
        'method' => 'post'
    ]); ?>
    <div class="row">
        <div class="col-12">
            <label class="form-label">Email</label>
        </div>
        <div class="col">
            <div class="form-group">
                <?= $this->Form->control("emails.$id.address", [
                    'label' => false,
                    'class' => 'form-control rounded-pill',
                    'placeholder' => 'Email',
                    'required' => 'required']); ?>
            </div>
            <?php if ($user->emails[$id]->is_primary): ?>
                <p class="text-muted-dark fsz-12 text-center text-md-left">
                    This is currently your primary email. If you wish to change this,
                    you should set another email as primary, then this one will
                    automatically be updated accordingly.
                </p>
            <?php else: ?>
            <div class="form-group">
                <label class="custom-switch">
                    <?= $this->Form->checkbox("emails.$id.is_primary", [
//                            'templates' => [
//                                'inputContainer' => '{{content}}'
//                            ],
                        'label' => false,
                        'class' => 'custom-switch-input'
                    ]); ?>
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description">Make this my primary email</span>
                </label>
            </div>
            <?php endif; ?>
        </div>
        <div class="col-md-auto">
            <button type="submit" class="btn btn-app btn-block btn-pill">Update</button>
        </div>
    </div>
<?= $this->Form->end(); ?>
</div>

