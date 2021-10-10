<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="media-selector" class="p-4">
    <div>
        <?= $this->Form->create('file',
            [
                'id' => 'upload-form-with-text',
                'type' => 'file'
            ]); ?>
        <div id="i__file-preview" class="d-none">
            <div id="textbox" class="mb-3" style="display: none;">
                <?= $this->element('Widgets/Forms/plain_post_form'); ?>
            </div>
            <div id="selected-files" class="files-gallery gallery-grid row row-cards row-deck"></div>
            <div class="bg-blue-lightest border-top mb-n3 mx-n3 my-2 pb-3 pt-2 pt-3 px-3 rounded-bottom">
                <div class="align-items-baseline gutters-sm row row-cards row-sm tools">
                    <div class="col-auto">
                        <div class="form-group mb-0">
                            <button type="button" class="btn btn-sm btn-outline-primary py-0 px-1 rounded-pill mr-2"
                                    onclick="$('#textbox').toggle()">
                                <i class="mdi mdi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary py-0 px-1 rounded-pill"
                                    onclick="$('input#photo').trigger('click')">
                                <i class="mdi mdi-shape-rectangle-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="form-group mb-0">
                            <label class="custom-control custom-checkbox custom-control-inline mb-0">
                                <input type="hidden" class="custom-control-input" name="publish_on_timeline" value="0">
                                <input type="checkbox" class="custom-control-input" name="publish_on_timeline"
                                       value="1">
                                <span class="custom-control-label">Publish on my timeline</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="form-group mb-0">
                            <select class="custom-select custom-select-sm">
                                <option value="public">Public</option>
                                <option value="connections">Connections</option>
                                <option value="mutual_connections">Mutual Connections</option>
                                <option value="private">Private</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-auto ml-auto">
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-sm btn-primary rounded-pill">Continue</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= $this->Form->end(['Upload']); ?>
    </div>
    <?= $this->Form->create('file',
        [
            'id' => 'upload-form',
            'type' => 'file'
        ]); ?>
    <?= $this->Form->unlockField('file') ?>
    <div id="file-picker" class="col text-center pb-5">
        <section class="A__jfe28knf">
            <div class="p-lg-5">
                <?= $this->Form->input('data-referrer', ['type' => 'hidden', 'value' => $this->getRequest()->getRequestTarget()]) ?>
                <div class="file-picker input">
                    <label for="photo" class="text-muted">
                        <span class="mdi mdi-cloud-upload mdi-48px text-warning"></span>
                        <h4>Click to select files</h4>
                        <p class="land">or drag and drop files here</p>
                    </label>
                    <?= $this->Form->file('file', [
                        'name' => 'files[]',
                        'accept' => implode(', ', $acceptedTypes),
                        'label' => false,
                        'id' => 'photo',
                        'class' => 'd-none',
                        'data-allow-preview' => 'true',
                        'data-preview-output' => '#i__file-preview'
                    ]) ?>
                </div>
                <div class="clearfix"></div>
                <div class="file-info"></div>
            </div>
        </section>
    </div>
    <?= $this->Form->end(['Upload']); ?>
</div>
<div class="modal fade" id="uploaded-file-info-modal" tabindex="-1" role="dialog" aria-labelledby="additional-fileinfo"
     aria-hidden="true">
    <div class="modal-dialog shadow-lg" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h6 class="modal-title" id="additional-fileinfo">Add Info</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row card-row">
                    <div class="col-sm-12 col-lg-5">
                        <div class="selected-file card bdrs-20"></div>
                        <div id="data-sample" class="mt-2">
                            <div class="input-sample small caption-sample d-flex align-items-baseline">
                                <i class="icon mdi mdi-pencil-box-outline text-muted"></i>
                                <span class="mb-1 text-truncate" data-placeholder="Add Caption" data-description="Lets people know what's happening in this video/photo">No Caption</span>
                            </div>
                            <div class="input-sample small tags-sample d-flex align-items-baseline">
                                <i class="icon mdi mdi-account text-muted"></i>
                                <span class="mb-1" data-placeholder="Tag Users" data-description="Lets people know who and who are in this video/photo">Tag Users</span>
                            </div>
                            <div class="input-sample small location-sample d-flex align-items-baseline">
                                <i class="icon mdi mdi-map-marker text-muted"></i>
                                <span class="mb-1" data-placeholder="Add Location" data-description="Lets people know where this video/photo was taken">Add Location</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="file-info-editor input-wrapper" data-sample="#data-sample" data-target="{{target_file_container_id}}">
                            <div class="form-group">
                                <label for="file-caption" class="form-label">Caption</label>
                                <textarea name="caption" id="file-caption" class="form-control caption-input" cols="30"
                                          rows="2" data-target=".caption-sample" field-role="caption"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="tags" class="form-label">Tags</label>
                                <input type="text" name="tags" placeholder="Start typing..." id="tags"
                                       class="form-control input-tags tags-input" value="" data-role="tagsinput" data-target=".tags-sample" field-role="tags">
                            </div>
                            <div class="form-group">
                                <label for="location-created" class="form-label">Location Created</label>
                                <input type="text" name="location" placeholder="Location" id="location-created"
                                       class="form-control location-input" data-target=".location-sample" field-role="location">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bgc-grey-100">
                <div class="form-group float-right">
                    <button
                        type="button" class="bdrs-20 btn btn-outline-primary btn-sm px-3"
                        role="info-submit"
                        data-source=".file-info-editor"
                        data-sample="#data-sample">Done</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->Html->script('upload-processor', ['block' => 'scriptBottom', 'fullBase' => true, 'type' => 'text/javascript', 'charset' => 'utf-8']); ?>
<?= $this->Html->scriptStart(['block' => 'scriptBottom', 'type' => 'text/javascript', 'charset' => 'utf-8']); ?>
    $('input#photo').on('change', function () {
        $(this).parents('form').hide().addClass('d-none :visually-hidden');
    });
<?= $this->Html->scriptEnd(); ?>
