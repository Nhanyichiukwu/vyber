<?php

/**
 * @var \App\View\AppView $this ;
 */

use Cake\Routing\Router;
use Cake\Utility\Text;
use App\Utility\RandomString;

if (!isset($publisherType)) {
    $publisherType = 'publisher-md';
}
$this->set('hasHeader', false);
$this->set('hasFooter', false);

//if ($this->getRequest()->is('ajax')) {
////    $headerDisplacement = 'q4vjl30x';//'xujm46fe';
//} else
//if ($this->getRequest()->is(['mobile', 'tablet']) &&
//    !$this->getRequest()->is('ajax')) {
//    $this->setLayout('blank');
////    $headerDisplacement = 'uhzlfru1';
//    //mgzsegwo
//}
?>
<!--<style>
    .q4vjl30x + * {
        margin-top: 58px;
    }
    .uhzlfru1 + * {
        margin-top: 5px;
    }
</style>-->

<?php /*$this->element('App/widgets/content_creator');*/ ?>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

//use Cake\Routing\Router;
//use App\Utility\RandomString;

if (!isset($publisherType)) {
    $publisherType = 'publisher-md';
}
$postEndPoint = Router::url(['controller' => 'posts', 'action' => 'create-new'], true);
$contentType = $this->getRequest()->getQuery('what', 'thought');
$verb = 'Post';
if (in_array($contentType, ['thought', 'moment', 'location', 'story'])) {
    $verb = 'Share';
} elseif ($contentType === 'shout_out') {
    $verb = 'Send';
}
?>

<div id="postComposer"
     class="post-composer content-creator bg-white composer mx-lg-auto n1ft4jmn ofjtagoh otgeu7ew p3n2yi2f"
     data-role="content-creator"
     data-uri="posts/create">
    <div class="composer-header bzakvszf h-auto p-3 lh-base
    n1ft4jmn q3ywbqi8 _oFb7Hd z-9">
<!--        <div class="mr-2 xh1oomr6">-->
            <?php /*if ($this->getRequest()->is('ajax')): */?>
<!--                <button class="bgcH-grey-200 btn btn-sm c-grey-600-->
<!--                close-drawer n1ft4jmn lzkw2xxp patuzxjv qrfe0hvl rmgay8tp"-->
<!--                        type="button"-->
<!--                        role="button"-->
<!--                        data-role="drawer-close-button"-->
<!--                        data-toggle="drawer">-->
<!--                    <i class="mdi mdi-close mdi-24px"></i>-->
<!--                </button>-->
            <?php /*elseif ($this->getRequest()->is('mobile')):*/ ?>
<!--                <a href="javascript:previousPage()"-->
<!--                   class="btn-sm c-grey-600 no-focus patuzxjv"-->
<!--                   role="button">-->
<!--                    <i class="mdi mdi-arrow-left mdi-24px"></i>-->
<!--                </a>-->
            <?php /*endif;*/ ?>
<!--        </div>-->
        <div class="h4 upxakz6m page-title mb-0 mr-auto">What's Up?</div>
        <button class="mmhtpn7c btn btn-azure disabled postSubmit submitBtn tsafbbqc"
                role="button"
                aria-disabled="true"
                aria-haspopup="false"
                data-target="#e__post-text-default-composer">
            <span class="btn-text"><?= $verb ?></span>
        </button>
    </div>
    <div class="composer-body card-body ofy-auto p-3 xzg02mh0 foa3ulpk bg-white"
         onscroll="return scrollSpy(this, scrollOptions)">
        <?= $this->Form->create(
            $post,
            [
                'id' => 'e__pf',
                'type' => 'file',
                'url' => [
                    'controller' => 'posts',
                    'action' => 'create',
//                    '?' => [
//                        'utm_req_ua' => 'mobile',
//                        'utm_submit_type' => 'async',
//                        'utm_plfm' => 'desktop'
//                    ]
                ],
                'class' => '_viG d-flex flex-column h-100 justify-content-between'
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

            $this->Form->unlockField('uid');
            $this->Form->unlockField('post_location');
            $this->Form->unlockField('has_attachment');
            $this->Form->unlockField('content_type');
            $this->Form->unlockField('draftFeedbackOutput');
            $this->Form->unlockField('save_draft');
//            $this->Form->unlockField('post_text');
            $this->Form->unlockField('post_type');
            $this->Form->unlockField('attachments');
            $this->Form->unlockField('attachment_type');
            $this->Form->unlockField('privacy');
            $this->Form->unlockField('schedule_post');
            ?>
            <div id="postEditorConfig">
                <input type="hidden" name="account" value="<?= h($user->get('refid')) ?>">
                <input type="hidden" id="location" name="location">
                <input type="hidden" id="default-content-type" name="content_type" value="post">
                <input type="hidden" id="draftFeedback" name="draftFeedbackOutput" value="#draft-feedback">
                <input type="hidden" id="draft" name="save_draft"
                       value="<?= Router::url(['controller' => 'post', 'action' => 'save-draft']) ?>">
                <input type="hidden" id="handler" value="<?= Router::url([
                    'controller' => 'posts',
                    'action' => 'create'
                ]) ?>">
                <?= $this->Form->textarea('post_text', ['class' => 'd-none']); ?>
            </div>
        </div>
        <div class="db-basic-publisher _viG">
            <div class="xrPDnZ _viG">
                <div class="_zmKE _viG">
                    <div class="_Xfc _viG">
                        <div class="creator d-flex mb-2">
                            <div class="me-3 col-auto">
                                <span class="avatar avatar-placeholder avatar-lg"></span>
                            </div>
                            <div class="creator-details">
                                <?php
                                /* Chech if the account is verified and apply a badge */
                                $verifiedStatus = '';
                                if ($user->isVerifiedAccount()) {
                                    $verifiedStatus = ' account-verified';
                                }
                                ?>
                                <span class="creator-name d-block c-grey-900 fw-bold wsnuxou6<?= $verifiedStatus ?>">
                                    <?= h($user->getFullName()); ?>
                                </span>
                                <span class="creator-username c-grey-700 wsnuxou6 fsz-14">
                                    @<?= h($user->getUsername()); ?>
                                </span>
                            </div>
                        </div>
                        <div class="U1mk _viG">
                            <div class="eY _viG" data-type="status">
                                <div class="composer-content-wrapper _viG">
                                    <div class="_VrtdFS _viG editor mb-2 pos-r">
                                        <?php $randID = RandomString::generateString(8, 'mixed'); ?>
                                        <span id="c<?= $randID ?>"
                                              class="_mWZ _viG n-Hk_Gw placeholder pos-a-t text-left textbox-placeholder"
                                              aria-hidden="true">
                                            <span class="fsz-16 lh-1 placeholder-text text-muted">Got something to
                                                share? Let's hearit...</span>
                                        </span>
                                        <div class="textbox-wrapper _viG">
                                            <div
                                                id="e__post-basic-text-editor"
                                                class="text-editor post-editor hwlT fsz-16 h-auto _oB _jr
                                                scrollbar-dynamic status-text gstcdcjz ofy-auto"
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
                                    <div id="postComposerMediaContainer"
                                         class="media-container bdrs-15 o-hidden border _Ad53 mb-3"
                                         aria-hidden="true"></div>
                                    <div class="U1mk _viG">
                                        <div class="xoj5za5y border mb-2 px-3 publishing-options py-2"
                                             style="display: none">
                                            <div class="d-flex row row-cols-2 row-cols-md-5 row-cols-sm-4 selectgroup
                                            selectgroup-pills">
                                                <div class="col">
                                                    <label class="eY tool selectgroup-item d-block mx-0">
                                                        <input type="radio" name="post_type" value="shoutout" class="post-type
                                        post-type-option
                                        selectgroup-input" checked>
                                                        <span
                                                            class="fxjd2lmp selectgroup-button selectgroup-button-icon py-1"
                                                            role="button" aria-haspopup="false"
                                                            aria-description="Send a shoutout..."
                                                            data-submit="Shout Out">
                                                            <span class="align-items-center d-flex">
                                                                <i class="mdi mdi-18px mdi-account-voice me-1"
                                                                   aria-hidden="true"></i>
                                                                <span class="fsz-14 _iYs"
                                                                      aria-hidden="true">Shoutout</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="col">
                                                    <label class="eY tool selectgroup-item d-block mx-0">
                                                        <input type="radio" name="post_type"
                                                               value="moment"
                                                               class="post-type post-type-option selectgroup-input">
                                                        <span
                                                            class="fxjd2lmp selectgroup-button selectgroup-button-icon py-1"
                                                            role="button" aria-haspopup="false"
                                                            aria-description="Share your moment..." data-submit="Share">
                                                            <span class="align-items-center d-flex">
                                                                <i class="mdi mdi-18px mdi-emoticon-wink-outline me-1"
                                                                   aria-hidden="true"></i>
                                                                <span class="fsz-14 _iYs"
                                                                      aria-hidden="true">Moment</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="col">
                                                    <label class="eY tool selectgroup-item d-block mx-0">
                                                        <input type="radio" name="post_type"
                                                               value="story"
                                                               class="post-type post-type-option selectgroup-input">
                                                        <span
                                                            class="fxjd2lmp selectgroup-button selectgroup-button-icon py-1"
                                                            role="button" aria-haspopup="false"
                                                            aria-description="Share a story..." data-submit="Share">
                                                <span class="align-items-center d-flex">
                                                    <i class="mdi mdi-18px mdi-square-edit-outline me-1"
                                                       aria-hidden="true"></i>
                                                    <span class="fsz-14 _iYs" aria-hidden="true">Story</span>
                                                </span>
                                            </span>
                                                    </label>
                                                </div>
                                                <div class="col">
                                                    <label class="eY tool selectgroup-item d-block mx-0">
                                                        <input type="radio" name="post_type" value="location" class="post-type
                                        post--type-option
                                        selectgroup-input">
                                                        <span
                                                            class="fxjd2lmp selectgroup-button selectgroup-button-icon py-1"
                                                            role="button" aria-haspopup="false"
                                                            aria-description="Share your location" data-submit="Share">
                                                <span class="align-items-center d-flex">
                                                    <i class="mdi mdi-18px mdi-map-marker-radius mr-1"
                                                       aria-hidden="true"></i>
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
                    </div>
                </div>
            </div>
        </div>

        <div class="toolbar-bottom clearfix">
            <div class="options form-row">
                <div class="col-auto text-left">
                    <label for="privacy" class="mb-0">
                        <select name="privacy" id="privacy" class="custom-select custom-select-sm form-select">
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
                        <button type="button" class="badge badge-default btn btn-icon"
                                data-bs-toggle="modal"
                                data-bs-target="#post-scheduler">
                            <i class="icofont-clock-time me-1"></i> Schedule post</button>
                        <div class="modal" id="post-scheduler">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6>Schedule Post</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">...</div>
                                </div>
                            </div>
                        </div>
                        <!--<label class="custom-control custom-checkbox">
                            <input name="schedule_post" type="checkbox" class="custom-control-input" value="1">
                            <span class="custom-control-label">Schedule Post</span>
                        </label>-->
                    </div>
                </div>
                <div class="col">
                    <span id="draft-feedback" class="alert alert-info py-2 rounded-pill" style="display: none"></span>
                </div>
            </div>
        </div>
        <?= $this->Form->end(['Upload']); ?>
    </div>
    <div class="composer-footer card-footer p-3">
        <div class="publishing-tools _d4ku d-flex justify-content-between align-items-center
                            gutters-0">
            <div class="d-inline-flex">
                <div class="eY tool" data-content-type="media">
                    <div class="d-none invisible">
                    </div>
                    <label class="bgcH-grey-300 btn btn-icon btn-sm bzakvszf cH
                    icon lzkw2xxp media-btn n1ft4jmn qrfe0hvl zbzlslol"
                           role="button"
                           data-media-types="image,gif,video,audio"
                           data-action="select-file"
                           data-target="#postMediaPicker"
                           aria-haspopup="false">
                        <input id="postMediaPicker" name="media" type="file" class="media-uploader d-none"
                               accept="image/jpg,image/jpeg,image/png,image/gif,video/ogg,video/mpeg4,video/mp4,video/mov,audio/ogg,audio/mpeg3,audio/mp3,audio/wav"
                               multiple data-preview="#postComposerMediaContainer"
                               data-haspreview="true"
                               aria-hidden="true">
                        <span aria-hidden="true"><i class="mdi mdi-24px mdi-shape-square-plus"></i></span>
                    </label>
                </div>
                <div class="eY tool" data-content-type="emoji">
                    <div class="bgcH-grey-300 btn btn-icon btn-sm bzakvszf cH
                    icon lzkw2xxp media-btn n1ft4jmn qrfe0hvl zbzlslol"
                         role="button" aria-haspopup="false">
                        <span aria-hidden="true"><i class="mdi mdi-24px mdi-emoticon-outline"></i></span>
                    </div>
                </div>
                <div class="eY tool dropdown" data-content-type="options">
                    <div class="bgcH-grey-300 btn btn-icon btn-sm bzakvszf cH
                    icon lzkw2xxp media-btn n1ft4jmn qrfe0hvl zbzlslol"
                         role="button" data-toggle="dropdown">
                        <span aria-hidden="true"><i class="mdi mdi-24px mdi-chevron-down"></i></span>
                    </div>
                    <div class="dropdown-menu">
                        <?= $this->element('tools/publishing_tools'); ?>
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <div class="eY">
                    <div class="postSubmit submitBtn btn align-items-center
                    mmhtpn7c d-inline-flex btn-azure px-4 disabled"
                         role="button"
                         aria-disabled="true"
                         aria-haspopup="false"
                         data-target="#e__post-text-default-composer">
                        <span class="btn-text">Shout Out</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let scrollTarget = document.querySelector('#postComposer .composer-header');
    let scrollOptions = {
        onScrollUp: function () {
            scrollTarget.classList.add('ikp8xqyl', 'ulnt0fka');
        },
        onScrollDown: function () {
            scrollTarget.classList.remove('ikp8xqyl', 'ulnt0fka');
        }
    };
</script>

