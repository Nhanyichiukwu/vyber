<?php

use Cake\Routing\Router;
?>
<div id="e__cb-<?= h($post->refid); ?>" class="pb-2 bdB mb-3">
    <div class="commenter-avatar avatar avatar fl-l mr-3"></div>
    <div class="e__comment-form-container offset-1">
    <?= $this->Form->create(
            'comment-form', 
            [
                'type' => 'file', 
                'id' => 'comment-form-'.h($post->refid)
            ]
        ); ?>
        
        <div class="d-n">
    <?php
    $manifest = json_encode([
        'uid' => h($activeUser->refid),
        'postLocation' => [],
        'dataType' => 'post',
        'postTmpStore' => Router::url(['controller' => 'post', 'action' => 'save-draft', 'comment']),
        'text' => [
            'editor' => 'e__' . h($activeUser->refid) . '-comment-text-input',
            'textarea' => '#e__' . h($activeUser->refid) . '-text'
        ],
        'feedbackOutput' => [
            'draftFeedbackOutput' => '#draft-feedback',
            'postFeedbackOutput' => ''
        ]
    ]);
    ?>
    <div data-role="manifest" data-manifest='<?= $manifest ?>'></div>
    <input type="hidden" name="uid" value="<?= h($activeUser->refid) ?>">
    <input type="hidden" name="post_location" value="[]">
    <input type="hidden" name="has_attachment" value="0">
    <input type="hidden" name="content_type" value="comment">
</div>
        <div class="row gutters-sm">
            <div class="col-md-9 col-lg-9">
                <div class="e__text-editor-container form-group mb-0 pos-r">
                    <div class="e__input-group pos-r">
                        <div 
                            id="e__<?= h($activeUser->refid) ?>-comment-text-input" 
                            class="status-text hTaI form-control bdrs-20 pr-7" 
                            contenteditable="true" 
                            role="text-editor" 
                            placeholder="Add Comment..."  
                            aria-label="Add Comment"></div>
                            <button 
                            type="button" 
                            class="b-0 bdrs-r-20 bg-transparent border-0 input-group-apppend input-group-text pos-a r-0" 
                            role="attachment-button"
                            data-toggle="display"
                            data-target="#post<?= h($post->id); ?>-cts"
                            data-default-state="hidden"
                            data-animation="true"
                            >
                            <i class="mdi mdi-shape-circle-plus"></i></button>
                        <div class="e__textarea-container :visually-hidden d-n">
                            <?= $this->Form->input(
                                    __('e__comment_{0}', h($post->refid)),
                                    [
                                        'id' => 'comment-box-'.h($post->refid),
                                        'class' => 'd-n',
                                        'role' => 'comment-text'
                                    ]
                            ); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-lg-3 pos-r">
                <div class="input-group pos-a b-0">
                    <button type="submit" name="comment_btn" class="btn e_bJ-ruM px-3 py-1 rounded-pill">Comment</button>
                </div>
            </div>
            <div class="col-12">
                <div id="post<?= h($post->id); ?>-cts" class="clearfix cts je03 mt-3">
                    <div class="ct border p-10 rounded-circle">
                        <label for="photo-upload-<?= h($post->id); ?>" class="input-group-apppend" id="basic-addon-<?= h($post->id); ?>">
                            <i class="mdi mdi-camera"></i>
                            <input type="file" name="photo" id="photo-upload-<?= h($post->id); ?>" class="d-n">
                        </label>
                    </div>
                    <div class="ct border p-10 rounded-circle">
                        <label for="video-upload-<?= h($post->id); ?>" class="input-group-apppend" id="basic-addon-<?= h($post->id); ?>">
                            <i class="mdi mdi-movie"></i>
                            <input type="file" name="video" id="video-upload-<?= h($post->id); ?>" class="d-n">
                        </label>
                    </div>
                    <div class="ct border p-10 rounded-circle">
                        <label for="music-upload-<?= h($post->id); ?>" class="input-group-apppend" id="basic-addon-<?= h($post->id); ?>">
                            <i class="mdi mdi-music"></i>
                            <input type="file" name="music" id="music-upload-<?= h($post->id); ?>" class="d-n">
                        </label>
                    </div>
                    <div class="ct border p-10 rounded-circle">
                        <button type="button" class="bg-transparent border-0 emoji p-0">
                            <i class="mdi mdi mdi-emoticon"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
            <?= $this->Form->end(['Upload']); ?>
    </div>
</div>