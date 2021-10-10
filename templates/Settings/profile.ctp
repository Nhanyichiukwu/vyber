<?php

/**
 * Settings/account/edit Profile Edit template
 */

use Cake\Routing\Router;
?>
<?php $this->assign('title', 'Edit Profile'); ?>

<div class="mt-n4 mx-n4 border-bottom bg-light profile-header profile-header-sm" style="background: url(<?= $activeUser->profile->hasHeaderImage()? $activeUser->profile->getProfileHeaderImageUrl() : $this->UiDefaults->getDefaultProfileHeaderImageUrl(); ?>)">

</div>
<div class="d-flex position-relative mt-n5 mb-4">
    <div class="col-auto offset-3 profile-editor text-right">
        <div class="avatar avatar-lg pos-r bg-light" style="background: url(<?= $activeUser->profile->hasProfileImage() ? $activeUser->profile->getProfileImageUrl() : $this->UiDefaults->getDefaultProfileImageUrl(); ?>)" hover-controls=".show-on-hover">
            <button type="button" data-toggle="dropdown" class="border btn btn-light p-0 pos-a-b rounded-pill show-on-hover text-center dropdown-toggle no-after">
                <i class="mdi mdi-18px mdi-account-edit"></i>
            </button>
            <div class="dropdown-menu shadow">
                <?php if ($activeUser->hasPhotos()): ?>
                <a class="dropdown-item" role="profile-image-administrator" href="javascript:void(0)" data-toggle="modal" data-target="#profile-image-modal" aria-controls="#profile-profile-image-url" data-action="change-image">
                    <i class="mdi mdi-account-switch"></i> Change Image
                </a>
                <?php endif; ?>
                <a id="i__profile-photo-uploader" class="dropdown-item" role="profile-image-administrator" href="javascript:void(0)" data-toggle="modal" data-target="#profile-image-modal" data-title="Update Profile Photo" data-intent="profile_photo_upload" data-request-handler="/upload/photo" redirect-url="/account-services/fetch-photos?intent=select_photo&purpost=make_profile_photo" data-referer="<?= $this->getRequest()->getAttribute('here') ?>">
                    <i class="mdi mdi-account-plus"></i> Upload Image
                </a>
                <?php if ($activeUser->profile->hasProfileImage()): ?>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" role="profile-image-administrator" href="javascript:void(0)" aria-controls="#profile-profile-image-url" data-action="remove-image">
                    <i class="mdi mdi-account-off"></i> Remove Image
                </a>
                <?php endif; ?>
            </div>
            <div class="modal fade auto-scale" id="profile-image-modal" tabindex="-1" role="dialog" aria-labelledby="profile-photo-selector" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h6 class="modal-title" id="profile-photo-selector">Select Image</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-left"></div>
<!--                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>-->
                    </div>
                </div>
            </div>
            <span class="d-none">
                        <?= $this->Form->input(
                        'profile.profile_image_url',
                        [
                            'name' => 'profile_image_url',
                            'type' => 'hidden',
                            'class' => ':visually-hidden'
                        ]); ?>
                        <?= $this->Form->input(
                        'profile.header_image_url',
                        [
                            'name' => 'header_image_url',
                            'type' => 'hidden',
                            'class' => ':visually-hidden'
                        ]); ?>
                <input id="fJA_3nf8" type="file" name="profile_photo" accept="image/jpg, image/jpeg, image/png">
            </span>
        </div>
    </div>
    <div class="col">
        <div class="account-name mt-5 pt-2">
            <span class="fullname text-dark d-block"><?= h($activeUser->getFullname()); ?></span>
            <span class="username text-muted d-block">@<?= h($activeUser->getUsername()); ?>
                        <?= $this->Html->link(
                            __('<i class="link-icon mdi mdi-pencil"></i>'),
                            ['action' => 'account', 'username'],
                            [
                                'class' => 'btn btn-outline-secondary btn-sm ml-2 px-1 py-0 rounded-circle',
                                'escapeTitle' => false,
                                'title' => 'Change Username',
                                'fullBase' => true
                            ]); ?>
            </span>
        </div>
    </div>
</div>
<?= $this->Form->create(
        $activeUser,
        [
            'class' => 'profile',
            'type' => 'file',
            'method' => 'post'
        ]); ?>
<div class="px-lg-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group row align-items-center">
                <label class="form-label col-lg-4 text-lg-right">First Name</label>
                <div class="col">
                <?= $this->Form->control('firstname', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Firstname']); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group row align-items-center">
                <label class="form-label col-lg-4 text-lg-right">Last Name</label>
                <div class="col">
                <?= $this->Form->input('lastname', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Lastname']); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group row align-items-center">
                <label class="form-label col-lg-4 text-lg-right">Other Names</label>
                <div class="col">
                <?= $this->Form->control('othernames', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Othernames']); ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group row align-items-center">
                <label class="form-label col-lg-4 text-lg-right">About Me</label>
                <div class="col">
                <?= $this->Form->input(
                'profile.about',
                [
                    'name' => 'about',
                    'type' => 'textarea',
                    'class' => 'form-control',
                    'placeholder' => 'About',
                    'label' => false
                ]); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group row align-items-center">
                <div class="form-label col-lg-4 text-lg-right">Gender</div>
                <div class="col">
                    <div class="custom-controls-stacked">
                    <?= $this->Form->input('gender', ['type' => 'hidden']); ?>
                        <label for="gender-male" class="custom-control custom-radio custom-control-inline">
                <?= $this->Form->radio('gender',
                [
                    [
                        'value' => 'male',
                        'text' => 'Male',
                        'class' => 'custom-control-input',
                        'hiddenField' => false
                    ]
                ],
                [
                    'hiddenField' => false,
                    'label' => false
                ]); ?>
                            <div class="custom-control-label">Male</div>
                        </label>
                        <label for="gender-female" class="custom-control custom-radio custom-control-inline">
                <?= $this->Form->radio('gender',
                [
                    [
                        'value' => 'female',
                        'text' => 'Female',
                        'class' => 'custom-control-input'
                    ]
                ],
                [
                    'hiddenField' => false,
                    'label' => false
                ]); ?>
                            <div class="custom-control-label">Female</div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group row align-items-center">
                <label class="form-label col-lg-4 text-lg-right">Date Of Birth</label>
                <div class="col">
                <?= $this->Form->input(
                'profile.date_of_birth',
                [
                    'type' => 'date',
                    'name' => 'data_of_birth',
                    'year' => [
                        'start' => 1959,
                        'class' => 'col-4 custom-select form-control mr-2'
                    ],
                    'month' => ['class' => 'col-4 custom-select form-control mr-2'],
                    'day' => ['class' => 'col-2 custom-select form-control'],
                    'label' => false,
                    'wrapper' => false,
                    'class' => 'form-group'
                ]); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group row align-items-center">
                <label class="form-label col-lg-4 text-lg-right">Email</label>
                <div class="col">
                <?php if ($activeUser->has('email')): ?>
                    <div class="input-group">
                        <?= $this->Form->control('email', [
                            'templates' => [
                                'inputContainer' => '{{content}}'
                            ],
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => 'Email',
                            'readonly' => 'true'
                        ]); ?>
                        <span class="input-group-append">
                            <?= $this->Html->link(
                                    __('<i class="link-icon mdi mdi-pencil"></i>'),
                                    [
                                        'action' => 'account',
                                        'email',
                                        'change-email'
                                    ],
                                    [
                                        'class' => 'input-group-text',
                                        'escapeTitle' => false,
                                        'title' => 'Change email'
                                    ]); ?>
                        </span>
                        <span class="input-group-append">
                            <?= $this->Html->link(
                                    __('<i class="link-icon mdi mdi-plus"></i>'),
                                    [
                                        'action' => 'account',
                                        'email',
                                        'add-email'
                                    ],
                                    [
                                        'class' => 'input-group-text',
                                        'escapeTitle' => false,
                                        'title' => 'Add new email'
                                    ]); ?>
                        </span>
                    </div>
                <?php else: ?>
                    <span class="input-group-append">
                        <?= $this->Html->link(
                            __('<i class="link-icon mdi mdi-shape-rectangle-plus"></i> Add Email'),
                            [
                                'action' => 'account',
                                'email',
                                'add-email'
                            ],
                            [
                                'class' => 'btn btn-sm btn-outline-secondary',
                                'escapeTitle' => false,
                                'title' => 'Add new email'
                            ]); ?>
                    </span>
                <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group row align-items-center">
                <label class="form-label col-lg-4 text-lg-right">Phone</label>
                <div class="col">
                <?php if ($activeUser->has('phone')): ?>
                    <div class="input-group">
                        <?= $this->Form->control('phone', [
                            'templates' => [
                                'inputContainer' => '{{content}}'
                            ],
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => 'Phone',
                            'readonly' => 'true'
                        ]); ?>
                        <span class="input-group-append">
                            <?= $this->Html->link(
                                __('<i class="link-icon mdi mdi-pencil"></i>'),
                                [
                                    'action' => 'account',
                                    'phone',
                                    'change-phone'
                                ],
                                [
                                    'class' => 'input-group-text',
                                    'escapeTitle' => false,
                                    'title' => 'Change Phone'
                                ]); ?>
                        </span>
                        <span class="input-group-append">
                            <?= $this->Html->link(
                                __('<i class="link-icon mdi mdi-plus"></i>'),
                                [
                                    'action' => 'account',
                                    'phone',
                                    'add-phone'
                                ],
                                [
                                    'class' => 'input-group-text',
                                    'escapeTitle' => false,
                                    'title' => 'Add new phone'
                                ]); ?>
                        </span>
                    </div>
                <?php else: ?>
                    <span class="">
                        <?= $this->Html->link(
                            __('<i class="link-icon mdi mdi-phone-plus"></i> Add Phone'),
                            [
                                'action' => 'account',
                                'phone',
                                'add-phone'
                            ],
                            [
                                'class' => 'btn btn-sm btn-outline-secondary',
                                'escapeTitle' => false,
                                'title' => 'Add new phone'
                            ]); ?>
                    </span>
                <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-12 text-right">
            <div class="">
                <span class="p-2 bg-primary rounded-pill">Save changes</span>
                <button type="submit" name="save_profile" class="btn shadow-sm btn-primary rounded-pill">
                    <i class="mdi mdi-24px mdi-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->Form->end(['Upload']); ?>

<?= $this->Html->scriptStart(['block' => 'scriptBottom']); ?>
(function ($, accountService, metaData) {
    accountService.init(metaData);
    var pia = $('[role="profile-image-administrator"]');
    var ic = $('[data-action="change-image"]');
    var ir = $('[data-action="remove-image"]');
    var iu = $('#i__profile-photo-uploader');
    $(ic).click(function(e) {
        var url = accountService.getRequestHandler() + '/fetch-photos';
        var t = $(this).attr('aria-controls');
        var o = $(this).data('output');
        var jqXHR = $.ajax({
            url: url,
            type: 'GET',
            contentType: 'html',
            success: function (data) {
                $(o).html(data);
            }
        });
    });

    $(iu).click(function (e) {
        var $this = $(this);
        var metaData = $.parseJSON(I_ACCOUNT_META_DATA);
        var url = metaData.baseUri + '/' + $this.data('request-handler');
        var t = $this.attr('aria-controls');
        var o = $($this.data('target')).find('.modal-body');
        $($this.data('target')).find('.modal-dialog').removeAttr('style');
        $(o).html($('.content-loading').clone());
        var jqXHR = $.ajax({
            url: url,
            type: 'GET',
            contentType: 'html',
            success: function (data) {
                window.createEvent('modalContentReady', document);
                $(o).html(data);
            }
        });
    });

    $(document).on('modalContentReady', function(e) {
        $('.modal.auto-scale.show').children('.modal-dialog').animate({
            //opacity: 0.25,
            //left: "+=50",
            maxWidth: "600"
        }, 300, function() {
            // Animation complete.
        });
        //$('.modal.show').children('.modal-dialog').addClass('modal-lg modal-grow modal-scrollable');
    });
    // $('.modal').on('hidden.bs.modal', function () {
       // $(this).children('.modal-dialog').removeAttr('style');
    // });

    $('.modal .close').click(function (e) {
        // e.stopPropagation();
        // window.createEvent('hidden.bs.modal', document);
    });
})(jQuery, AsyncAccountService, META_DATA);
<?= $this->Html->scriptEnd(); ?>
