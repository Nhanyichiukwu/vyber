<?php

/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
*/
use Cake\Routing\Router;
use App\Utility\Calculator;
//$formAction = $this->getRequest()->getPath();
//if ($content_type ===this->getRequest())
?>
<!-- Details -->
<div id="file-preview" class="has-progress-bar row" style="display: none"></div>

<div class="image-preview row row-sm gutters-sm"></div>

<!--<div class="mb-3" data-role="image-picker">
    <label class="align-items-center d-flex 
           justify-content-center min-ht-150t">
        <input id="product-image-picker" type="file" class="custom-file-input 
               d-none" name="product_images[]" accept="image/jpg,image/jpeg,image/png" />
        <span class="border d-block p-1 w-100 shadow-sm">
            <span class="d-block text-center overflow-hidden">
                <img src="assets/imgs/image_placeholder3.jpg" class="img-fluid" />
            </span>
        </span>
    </label>
</div>

<div class="col-sm-12" data-role="image-picker">
    <label class="bd-style-dashed bd-width-4 border ht-300 rounded-lg d-block btn btn-light">
        <input id="product-image-picker" type="file" class="custom-file-input d-none" name="product_images[]" accept="image/jpg,image/jpeg,image/png">
        <span class="d-block h-100"  style="background: url(assets/imgs/image_placeholder1.png) no-repeat center; background-size: contain; opacity: .3"></span>
    </label>
</div>-->

<div id="media-selector">
    <?= $this->Form->create('file', 
            [
                'url' => ['action' => 'upload-processor'],
                'id' => 'upload-form', 
                'type' => 'file'
            ]); ?>
    <?= $this->Form->unlockField('file') ?>
        <div class="col-md-6 mx-auto text-center upload-video pt-5 pb-5">
            <section class="card">
                <div class="card-body p-lg-5">
                    <?= $this->Form->input('data-referrer', ['type' => 'hidden', 'value' => $this->getRequest()->getRequestTarget()]) ?>
                    <div class="file-picker input">
                        <label for="file" class="text-muted">
                            <span class="mdi mdi-cloud-upload mdi-48px text-warning"></span>
                        <h4>Click to select files</h4>
                        <p class="land">or drag and drop files here</p>
                        </label>
                        <?= $this->Form->file('file', [
                            'name' => 'file[]',
                            'accept' => implode(', ', $acceptedTypes),
                            'label' => false,
                            'id' => 'file',
                            'class' => 'd-none',
                            'onchange' => '$(\'button[disabled="disabled"]\').removeAttr(\'disabled\')',
                            'multiple' => 'multiple'
                        ]) ?>
                        <div class="mt-4">
                        <?= $this->Form->button(
                                __('Upload'),
                                [
                                    'disabled' => 'disabled',
                                    'class' => 'btn btn-warning px-5',
                                    'id' => 'uploadBtn'
                                ]
                                ); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="file-info"></div>
                </div>
            </section>
        </div>
    <?= $this->Form->end(['Upload']); ?>
</div>
<?php $this->Html->script('ajax-form', ['block' => 'scriptBottom']); ?>
<?php $this->Html->scriptStart(['block' => 'scriptBottom']); ?>
$(function () {
    $('#file').on('change', function() {
        // readUploadedFile(this);
        var previewer = new FilePreviewer(this);
        previewer.acceptOnly(['jpg','jpeg','png','mp3','mpeg3','mp4','mpeg4','ogg']);
        if (! previewer.processFiles()) {
            console.log('Sorry, FilePreviewer failed to process file');
            return false;
        }
        
        // previewFiles(this, 'file-preview', ['jpg','jpeg','png','mp3','mpeg3','mp4','mpeg4','ogg'], true, true);
    });
});
<?php $this->Html->scriptEnd(); ?>
