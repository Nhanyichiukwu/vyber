<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Group $group
 */

use App\Utility\RandomString;
$paddingTop = ' py-3';
if ($this->getRequest()->is('ajax')) {
    $paddingTop = '';
}
?>
<div class="bg-white content form groups mgriukcz">
    <div class="border-bottom border-top page-header py-2 px-4">
        <?php if (!$this->getRequest()->is('ajax')): ?>
            <a href="<?= $this->getRequest()->referer(); ?>" class="_ah49Gn btn bzakvszf close-page lzkw2xxp n1ft4jmn
            patuzxjv qrfe0hvl rmgay8tp lh-1 float-left mr-4"
                    type="button"
                    role="button"
                    data-role="page-close-button">
                <i class="mdi mdi-arrow-left mdi-24px"></i>
            </a>
        <?php endif; ?>
        <h3 class="page-title"><?= __('Add Group') ?></h3>
    </div>
    <?= $this->Form->create($group, ['type' => 'file', 'class' => 'p-4']) ?>
    <div class="fieldset">
        <?php
        echo $this->Form->control('refid', [
            'type'=>'hidden',
            'value' => RandomString::generateString(20),
        ]);
        echo $this->Form->control('name', [
            'class' => 'form-control',
            'templateVars' => ['help' => 'What\'s the name of the group?'],
            'templates' => [
                'inputContainer' => '<div class="input {{type}}{{required}} mb-3">
        {{content}} <span class="help small text-muted">{{help}}</span></div>'
            ]
        ]);

        $this->Form->setTemplates([
            'inputContainer' => '<div class="input {{type}}{{required}} mb-3 pos-r">
        {{content}}</div>'
        ]);
        echo $this->Form->control('description', [
            'class' => 'form-control',
        ]);
        echo $this->Form->control('group_image', [
            'type' => 'file',
            'class' => 'form-control custom-file-input',
            'label' => ['class' => 'custom-file-label'],
            'accept' => "image/jpg,image/jpeg,image/png",
            'data-haspreview' => 'true',
            'aria-hidden' => 'true',
            'multiple' => 'false',
        ]);
        echo $this->Form->control('author', ['type'=>'hidden', 'value' => $user->refid]);
        ?>
    </div>
    <?= $this->Form->button(__('Submit'), [
        'class' => 'btn btn-primary btn-block yy63sy1k'
    ]) ?>
    <?= $this->Form->end(['Upload']) ?>
</div>
