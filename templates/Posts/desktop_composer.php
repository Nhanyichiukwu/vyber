<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Post $post
 */
use Cake\Routing\Router;
?>
<?= $this->Form->create(
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
        'target' => 'post_ajaxSimulator'
    ]); ?>
<div class="d-n">
    <?php
    $manifest = json_encode([
        'uid' => h($user->refid),
        'postLocation' => [],
        'dataType' => 'post',
        'postTmpStore' => Router::url(['controller' => 'post', 'action' => 'save-draft']),
        'text' => [
            'editor' => '#e__status-text-input',
            'textarea' => '#e__status-text'
        ],
        'feedbackOutput' => [
            'draftFeedbackOutput' => '#draft-feedback',
            'postFeedbackOutput' => ''
        ]
    ]);
    ?>
    <div data-role="manifest" data-manifest='<?= $manifest ?>'></div>
    <input type="hidden" name="uid" value="<?= h($user->refid) ?>">
    <input type="hidden" name="post_location" value="[]">
    <input type="hidden" name="has_attachment" value="0">
    <input type="hidden" name="content_type" value="post">
</div>
<div class="card">
    <div class="card-header  e_kjg position-relative">
        <ul class="editor-toolbar toolbar-top fl-r m-0 p-0 pos-a r-0 t-0 unstyled">
            <li>
                <button type="button" class="box-square-2 close  text-white" data-toggle="dropdown">
                    <span class="mdi mdi-dots-horizontal" aria-hidden="true"></span>
                </button>
            </li>
            <li>
                <button type="button" class="box-square-2 close  minimize text-white" data-minimize="modal" aria-label="Minimize">
                    <span class="mdi mdi-window-minimize" aria-hidden="true"></span>
                </button>
            </li>
            <li>
                <button type="button" class="box-square-2 close text-white" data-dismiss="modal" aria-label="Close">
                    <span class="mdi mdi-window-close" aria-hidden="true"></span>
                </button>
            </li>
            <li>
            <?= $this->Html->link(
                __('<span class="mdi mdi-window-restore" aria-hidden="true"></span>'),
                [
                    'controller' => '/',
                    'action' => 'index',
                    'v' => 'modal',
                    'm_obj' => 'post_composer'
                ],
                [
                    'class' => 'box-square-2 close text-white',
                    'aria-label' => 'Go Fullscreen',
                    'escapeTitle' => false
                ]);
            ?>
            </li>
            <li>
            <?php $this->Html->link(
                __('<span class="mdi mdi-window-close" aria-hidden="true"></span>'),
                [
                    'controller' => 'e',
                    'action' => h($user->username),
                    'posts'
                ],
                [
                    'class' => 'box-square-2 close text-white',
                    'aria-label' => 'Go Fullscreen',
                    'escapeTitle' => false
                ]);
            ?>
            </li>
        </ul>
        <div class="has-account-name has-avatar form-row">
            <div class="col-auto">
                <div class="e_profile-photo profile-photo-md avatar" style="background-image: url(<?= h($user->profile_image_url) ?>)"></div>
            </div>
            <div class="account-name text-white col">
                <span class="fullname font-weight-bold d-b"><?= h($user->fullname); ?></span>
                <span class="username small">@<?= h($user->username); ?></span>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="e__text-editor-container pb-2 pt-5 px-5">
            <div id="e__status-text-input" class="publishing-tool status-text bdB hjK_rhTep" contenteditable="true" role="text-editor" placeholder="What's happening?" data-submit="#status-post-btn"></div>
            <div class="e__textarea-container :visually-hidden d-n">
                <textarea name="status_text"  class="d-none" id="e__status-text" role="actual-status-text" use="js-data-transfer"></textarea>
            </div>
        </div>
        <div class="toolbar-bottom clearfix px-5 py-3">
            <div class="options form-row">
                <div class="col-auto text-left">
                    <label for="privacy" class="mb-0">
                        <select name="privacy" id="privacy" class="custom-select custom-select-sm">
                            <option value="private">Only me</option>
                            <option value="public" selected>Public</option>
                            <option value="connections">Connections</option>
                            <option value="mutual_connections">Mutual Connection</option>
                        </select>
                    </label>
                </div>
                <div class="col">
                    <div class="form-group mb-0">
                        <input name="schedule_post" type="hidden" class="hidden" value="0">
                        <label class="custom-control custom-checkbox">
                            <input name="schedule_post" type="checkbox" class="custom-control-input" value="1">
                            <span class="custom-control-label">Schedule Post</span>
                        </label>
                    </div>
                </div>
                <div class="col">
                    <span id="draft-feedback" class="alert alert-info py-2 rounded-pill" style="display: none"></span>
                </div>
            </div>
        </div>
        <div class="d-n w-0">
            <iframe name="post_ajaxSimulator" id="post-ajaxSimulator" class="ajaxSimulator" hidden="hidden" width="0" height="0"></iframe>
        </div>
    </div>
    <div class="publisher d-flex card-footer justify-content-between">
        <div class="toolset toolset-plain">
            <button type="button" class="tool btn btn-icon" data-type="status">
                <i class="mdi mdi-pencil"></i>
            </button>
        </div>
        <button id="status-post-btn" type="submit" class="btn btn-warning disabled px-4 rounded-pill" disabled="disable">Post</button>
    </div>
    <?= $this->fetch('publisherFileControls'); ?>
</div>
<?= $this->Form->end(['Upload']); ?>
