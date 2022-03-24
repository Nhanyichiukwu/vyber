<?php

use Cake\Routing\Router;
use Cake\Utility\Text;
use App\Utility\RandomString;
if (!isset($publisherType)) {
    $publisherType = 'publisher-md';
}
$postEndPoint = Router::url(['controller' => 'posts', 'action' => 'create-new'], true);
?>

<div id="postComposer" class="composer post-composer d-flex card bdrs-10 mb-2" role="publisher"
     data-uri="posts/new_post">
    <div class="card-header p-3 justify-content-end d-none">
        <div class="postSubmit submitBtn btn align-items-center bdrs-20 d-inline-flex btn-azure px-4 disabled" role="button" aria-disabled="true" aria-haspopup="false" data-target="#e__post-text-default-composer">
            <span class="btn-text">Shout Out</span>
        </div>
    </div>
    <div class="card-body p-3">
        <?php $this->Form->create(
            null,
            [
                'id' => 'e__pf',
                'type' => 'file',
                'url' => [
                    'controller' => 'posts',
                    'action' => 'new-post',
                    '?' => [
                        'utm_req_w' => 'if',
                        'utm_submit_type' => 'async',
                        'utm_plfm' => 'desktop'
                    ]
                ],
                'class' => 'form-inline-block _viG',
                'target' => 'post_ajaxSimulator'
            ]); ?>
        <div class="d-none">
            <?php
//            $manifest = json_encode([
//                'uid' => h($user->get('refid')),
//                'postLocation' => [],
//                'dataType' => 'post',
//                'postTmpStore' => Router::url(['controller' => 'post', 'action' => 'save-draft']),
//                'text' => [
//                    'editor' => '#e__status-text-input',
//                    'textarea' => '#e__status-text'
//                ],
//                'feedbackOutput' => [
//                    'draftFeedbackOutput' => '#draft-feedback',
//                    'postFeedbackOutput' => ''
//                ]
//            ]);
            ?>
            <div id="postEditorConfig">
                <input type="hidden" id="uid" name="uid" value="<?= h($user->get('refid')) ?>">
                <input type="hidden" id="post-location" name="post_location" value="[]">
                <input type="hidden" id="has-attachment" name="has_attachment" value="false">
                <input type="hidden" id="content-type" name="content_type" value="post">
                <input type="hidden" id="draftFeedback" name="draftFeedbackOutput" value="#draft-feedback">
                <input type="hidden" id="draft" name="save_draft" value="<?= Router::url(['controller' => 'post', 'action' => 'save-draft']) ?>">
                <input type="hidden" id="handler" value="<?= $postEndPoint ?>">
            </div>
        </div>
        <div class="db-basic-publisher _viG">
            <div class="xrPDnZ _viG">
                <div class="_zmKE _viG">
                    <div class="_Xfc _viG">
                        <span class="float-left mr-3">
                            <span class="avatar avatar-placeholder avatar-md float-left"></span>
                        </span>
                        <div class="U1mk ml-7 _viG">
                            <div class="eY mb-2 _viG" data-type="status">
                                <div class="composer-content-wrapper py-2 _viG">
                                    <div class="editor _VrtdFS pos-r _viG ">
                                        <?php $randID = RandomString::generateString(8, 'mixed'); ?>
                                        <span id="c<?= $randID ?>" class="n-Hk_Gw placeholder textbox-placeholder pos-a-t text-left _mWZ" aria-hidden="true">
                                            <span class="placeholder-text fsz-18 text-muted">What's up?</span>
                                        </span>
                                        <div class="textbox-wrapper _viG">
                                            <div
                                                id="e__post-basic-text-editor"
                                                class="text-editor post-editor hwlT fsz-18 h-auto _oB _jr scrollbar-dynamic status-text h0LT_Ehfh ofy-auto"
                                                contenteditable="true"
                                                role="textbox"
                                                aria-multiline="true"
                                                accesskey="O 0"
                                                data-max="2000"
                                                data-draftable="true"
                                                data-post-type="shoutout"
                                                data-placeholder="#c<?= $randID ?>"
                                                spellcheck="true"
                                                translate="yes"
                                                tabindex="2"
                                                dir="auto"></div>
                                        </div>
                                    </div>
                                    <div id="postComposerMediaContainer" class="media-container bdrs-15 o-hidden my-3 border _Ad53" aria-hidden="true"></div>
                                </div>
                            </div>
                        </div>
                        <div class="U1mk _viG">
                            <div class="bdrs-10 border mb-2 px-3 publishing-options py-2" style="display: none">
                                <div class="d-flex row row-cols-2 selectgroup selectgroup-pills">
                                    <label class="eY tool px-2 selectgroup-item mr-0">
                                        <input type="radio" name="post_type" value="shoutout" class="post-type selectgroup-input" checked>
                                        <span class="_p-o selectgroup-button selectgroup-button-icon py-1" role="button" aria-haspopup="false" aria-description="Send a shoutout..." data-submit="Shout Out">
                                                <span class="align-items-center d-flex">
                                                    <i class="mdi mdi-18px mdi-account-voice mr-1" aria-hidden="true"></i>
                                                    <span class="fsz-14 _iYs" aria-hidden="true">Shoutout</span>
                                                </span>
                                            </span>
                                    </label>
                                    <label class="eY tool px-2 selectgroup-item mr-0">
                                        <input type="radio" name="post_type" value="moment" class="post-type selectgroup-input">
                                        <span class="_p-o selectgroup-button selectgroup-button-icon py-1" role="button" aria-haspopup="false" aria-description="Share your moment..." data-submit="Share">
                                                <span class="align-items-center d-flex">
                                                    <i class="mdi mdi-18px mdi-emoticon-wink-outline mr-1" aria-hidden="true"></i>
                                                    <span class="fsz-14 _iYs" aria-hidden="true">Moment</span>
                                                </span>
                                            </span>
                                    </label>
                                    <label class="eY tool px-2 selectgroup-item mr-0">
                                        <input type="radio" name="post_type" value="story" class="post-type selectgroup-input">
                                        <span class="_p-o selectgroup-button selectgroup-button-icon py-1" role="button" aria-haspopup="false" aria-description="Share a story..." data-submit="Share">
                                                <span class="align-items-center d-flex">
                                                    <i class="mdi mdi-18px mdi-square-edit-outline mr-1" aria-hidden="true"></i>
                                                    <span class="fsz-14 _iYs" aria-hidden="true">Story</span>
                                                </span>
                                            </span>
                                    </label>
                                    <label class="eY tool px-2 selectgroup-item mr-0">
                                        <input type="radio" name="post_type" value="location" class="post-type selectgroup-input">
                                        <span class="_p-o selectgroup-button selectgroup-button-icon py-1" role="button" aria-haspopup="false" aria-description="Share your location" data-submit="Share">
                                                <span class="align-items-center d-flex">
                                                    <i class="mdi mdi-18px mdi-map-marker-radius mr-1" aria-hidden="true"></i>
                                                    <span class="fsz-14 _iYs" aria-hidden="true">Location</span>
                                                </span>
                                            </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->Form->end(['Upload']); ?>
    </div>
    <div class="card-footer p-3">
        <div class="publishing-tools _d4ku d-flex justify-content-between align-items-center
                            gutters-0">
            <div class="col-auto d-inline-flex">
                <div class="eY tool" data-content-type="media">
                    <div class="d-none invisible">
                        <input id="postMediaPicker" name="media" type="file" class="media-uploader" accept="image/jpg,image/jpeg,image/png,image/gif,video/ogg,video/mpeg4,video/mp4,video/mov,audio/ogg,audio/mpeg3,audio/mp3,audio/wav" multiple data-preview="#postComposerMediaContainer" data-haspreview="true" aria-hidden="true">
                    </div>
                    <div class="media-btn btn btn-icon align-items-center bdrs-20 bgcH-grey-300 cH d-inline-flex icon justify-content-center wh_42" role="button" data-media-types="image,gif,video,audio" data-action="select-file" data-target="#postMediaPicker" aria-haspopup="false">
                        <span aria-hidden="true"><i class="mdi mdi-24px mdi-shape-square-plus"></i></span>
                    </div>
                </div>
                <div class="eY tool" data-content-type="emoji">
                    <div class="media-btn btn btn-icon align-items-center bdrs-20 bgcH-grey-300 cH d-inline-flex icon justify-content-center wh_42" role="button" aria-haspopup="false">
                        <span aria-hidden="true"><i class="mdi mdi-24px mdi-emoticon-outline"></i></span>
                    </div>
                </div>
                <div class="eY tool dropdown" data-content-type="options">
                    <div class="media-btn btn btn-icon align-items-center bdrs-20 bgcH-grey-300 cH d-inline-flex icon justify-content-center wh_42 dropdown-toggle no-after" role="button" data-toggle="dropdown">
                        <span aria-hidden="true"><i class="mdi mdi-24px mdi-chevron-down"></i></span>
                    </div>
                    <div class="dropdown-menu"></div>
                </div>
            </div>
            <div class="col-auto">
                <div class="eY">
                    <div class="postSubmit submitBtn btn align-items-center bdrs-20 d-inline-flex btn-azure px-4 disabled" role="button" aria-disabled="true" aria-haspopup="false" data-target="#e__post-text-default-composer">
                        <span class="btn-text">Shout Out</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
