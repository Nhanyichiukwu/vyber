<?php

/**
 * 
 */
?>

<div class="clearfix ml-md-8">
    <div id="e__composerModal" class="modal scale" tabindex="-1" role="dialog" aria-labelledby="Publisher" aria-hidden="true">
        <div id="status-composer" class="e__col-medium modal-dialog mt-5 mx-auto pt-5" role="document">
            <div class="modal-content">
                <div class="card-header position-relative">
                    <ul class="editor-toolbar mr-1 mt-1 nav pos-a-r pos-a-t r-0 toolbar-top">
                        <li>
                            <button type="button" class="box-square-2 close " data-toggle="dropdown">
                                <span class="mdi mdi-dots-horizontal" aria-hidden="true"></span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="box-square-2 close  minimize" data-minimize="modal" aria-label="Minimize">
                                <span class="mdi mdi-window-minimize" aria-hidden="true"></span>
                            </button>
                        </li>
                        <li>
                        <?= $this->Html->link(
                            __('<span class="mdi mdi-tab" aria-hidden="true"></span>'),
                            [
                                'controller' => 'posts',
                                'action' => 'new-post',
                                'editor' => 'main'
                            ],
                            [
                                'class' => 'box-square-2 close',
                                'aria-label' => 'Go Fullscreen',
                                'escapeTitle' => false
                            ]);
                        ?>
                        </li>
                        <li>
                            <button type="button" class="box-square-2 close" data-dismiss="modal" aria-label="Close">
                                <span class="mdi mdi-window-close" aria-hidden="true"></span>
                            </button>
                        </li>
                    </ul>
                    <div class="card-deck d-flex gutters-sm has-account-name has-avatar row-sm">
                        <div class="col-auto">
                            <div class="e_profile-photo profile-photo-md avatar avatar-lg" style="background-image: url(<?= h($activeUser->profile_image_url) ?>)"></div>
                        </div>
                        <div class="account-name col">
                            <span class="fullname font-weight-bold d-block"><?= Text::truncate(h($activeUser->getFullname()), 28, ['ellipses' => '...']); ?></span>
                            <span class="username small">@<?= h($activeUser->getUsername()); ?></span>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="e__text-editor-container mb-3">
                        <div id="e__status-text-input" class="tool status-text h0LT_Ehfh scroll-f scrollbar-dynamic" contenteditable="true" role="text-editor" placeholder="What's happening?" data-submit="#status-post-btn"></div>
                        <div class="e__textarea-container :visually-hidden d-n">
                            <textarea name="status_text"  class="d-none" id="e__status-text" role="actual-status-text" use="js-data-transfer"></textarea>
                        </div>
                    </div>
                    <?= $this->fetch('publisherFileControls'); ?>
                    <div class="options form-row">
                        <div class="col-auto text-left">
                            <label for="privacy" class="mb-0">
                                <select name="privacy" id="privacy" class="custom-select custom-select-sm py-0">
                                    <option value="private">Only me</option>
                                    <option value="public" selected="true">Public</option>
                                    <option value="connections">Connections</option>
                                    <option value="mutual_connections">Mutual Connection</option>
                                </select>
                            </label>
                        </div>
                        <div class="col-auto">
                            <button data-toggle="collapse" data-target="#post-options" type="button" class="bdrs-20 btn btn-sm bgcH-grey-300 text-cyan dropdown-toggle no-after YOPV YZq">
                                <i class="mdi mdi-dots-horizontal-circle"></i>
                            </button>
                        </div>
                        <div class="col">
                            <span id="draft-feedback" class="badge badge-default p-3 rounded-pill" style="display: none"></span>
                        </div>
                        <div id="post-options" class="col-12 collapse collapsable">
                            <div class="form-row mt-3 uv0FH4">
                                <div class="col-4">
                                    <div class="form-group mb-0">
                                        <input name="schedule_post" type="hidden" class="hidden" value="0">
                                        <label class="custom-control custom-checkbox">
                                            <input name="schedule_post" type="checkbox" class="custom-control-input" value="1">
                                            <span class="custom-control-label">Schedule Post</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group mb-0">
                                        <input name="save_as_draft" type="hidden" class="hidden" value="0">
                                        <label class="custom-control custom-checkbox">
                                            <input name="save_as_draft" type="checkbox" class="custom-control-input" value="1">
                                            <span class="custom-control-label">Save As Draft</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group mb-0">
                                        <input name="save_as_note" type="hidden" class="hidden" value="0">
                                        <label class="custom-control custom-checkbox">
                                            <input name="save_as_note" type="checkbox" class="custom-control-input" value="1">
                                            <span class="custom-control-label">Save As Note</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-n w-0">
                        <iframe name="post_ajaxSimulator" id="post-ajaxSimulator" class="ajaxSimulator" hidden="hidden" width="0" height="0"></iframe>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <div class="publishing-tools tools-plain tools-hover tools-rounded">
                        <button type="button" class="tool btn btn-icon txt" data-type="status">
                            <i class="mdi mdi-pencil"></i>
                        </button>
                        <?= $this->element('tools/publishing_tools'); ?>
                    </div>
                    <button id="status-post-btn" type="submit" class="btn btn-warning disabled px-4 rounded-pill" disabled="disable">Post</button>
                </div>
            </div>
        </div>
    </div>
</div>