<?php

/**
 * Settings/account/edit Profile Edit template
 * @var \App\Model\Entity\User $user
 */

use App\Utility\RandomString;
use Cake\Routing\Router;

$this->assign('title', 'Edit Profile');
if (!$this->getRequest()->is('ajax')) {
    $this->extend('common');
}

$years = range(date('Y'), 1959);
$dateYears = array_combine(array_values($years), array_values($years));

$months = range(1,12);
$dateMonths = array_combine(array_values($months), array_values($months));

$days = range(1, 31);
$dateDays = array_combine(array_values($days), array_values($days));


$industries = json_decode($this->cell(
    'ContentLoader::list', [
        'industries'
    ]
)->render(), false);

$genres = json_decode($this->cell('ContentLoader::list', [
    'genres', [
        'byIndustry',
        ['industry' => 'music']
    ]
])->render(), false);
$categories = json_decode($this->cell('ContentLoader::list', [
    'categories', [
        'byType',
        ['type' => 'music']
    ]
])->render(), false);
$roles = json_decode($this->cell('ContentLoader::list', [
    'roles', [
        'byIndustry',
        ['industry' =>'music']
    ]
])->render(), false);

$primaryLanguage = null;
if (count($user->profile->languages)) {
    $primaryLanguage = $user->profile->languages[0]->toArray();
}


/**
 * Use Industries
 */
/*$userProperties = $user->profile->extract([
    'industries','genres','roles'
]);

//$userIndustriesIDs = collection($userProperties['user_industries'])->map(
//    function (\App\Model\Entity\UserIndustry $row) {
//        return $row->industry_id;
//    }
//)->toArray(false);
$userIndustriesIDs = (array) json_decode($userProperties['industries']);

$userIndustries = collection($userIndustriesIDs)->map(
    function ($id) {
        $actualIndustries = $this->cell(
            'ContentLoader::fetch', [
                'industries',
                null,
                [
                    'options' => [],
                    'where' => ['id' => $id],
                    'callback' => function(\Cake\ORM\Query $query) {

                        $result = $query->first()->toArray();
                        $this->set('result', $result);
                    }
                ]
            ]
        )->render();
        $result = json_decode($actualIndustries, false);
        pr($actualIndustries);
//        return $result->name;
    }
)->toArray(false);

pr($userIndustries);
exit;

$userGenresIDs = collection($userProperties['user_genres'])->map(
    function (\App\Model\Entity\UserGenre $row) {
        return $row->genre_id;
    }
)->toArray(false);

$userGenres = collection($userProperties['user_genres'])->map(
    function (\App\Model\Entity\UserGenre $row) {
        return $row->genre->name;
    }
)->toArray(false);

$userRolesIDs = collection($userProperties['user_roles'])->map(
    function (\App\Model\Entity\UserRole $row) {
        return $row->role_id;
    }
)->toArray(false);

$userRoles = collection($userProperties['user_roles'])->map(
    function (\App\Model\Entity\UserRole $row) {
        return $row->role->name;
    }
)->toArray(false);*/
?>
<div class="mt-n3">
    <!--<div class="border-bottom bg-light profile-header profile-header-sm"
         style="background: url(<?/*= $user->profile->hasHeaderImage()
             ? $user->profile->getProfileHeaderImageUrl()
             : $this->UiDefaults->getDefaultProfileHeaderImageUrl();
         */?>)">
    </div>-->
    <div id="basic-info" class="_UxaA _4gUj0 card _JLBq4 shadow-none">
        <div class="card-body px-4">
            <div class="align-items-center d-flex justify-content-between">
                <h6 class="card-title mb-0">Basic Info</h6>
                <div>
                    <button class="btn btn-icon btn-sm"
                            data-bs-toggle="collapse"
                            data-bs-target="#basicInfoCollapsible"
                            aria-controls="#basicInfoCollapsible">
                        <span class="icofont-3x icofont-thin-down"></span>
                    </button>
                </div>
            </div>
            <div id="basicInfoCollapsible" class="collapse show">
                <div class="align-items-center flex-column flex-md-row mb-5 _oFb7Hd row">
                    <div class="col-auto offset-lg-3 offset-md-1 profile-editor text-right">
                        <div class="avatar avatar-xxl avatar-yellow mb-3 mb-md-0"
                             style="background-image: url(<?=
                             $user->profile->hasProfileImage()
                                 ? $user->profile->getProfileImageUrl()
                                 : $this->UiDefaults->getDefaultProfileImageUrl();
                             ?>)" hover-controls="show-on-hover">
                            <button type="button"
                                    data-toggle="dropdown"
                                    class="border btn btn-light p-0 pos-a-b rounded-pill
                    show-on-hover text-center dropdown-toggle no-after">
                                <i class="mdi mdi-18px mdi-account-edit"></i>
                            </button>
                            <div class="dropdown-menu shadow">
                                <?php if ($user->hasPhotos()): ?>
                                    <a class="dropdown-item"
                                       role="profile-image-administrator"
                                       href="javascript:void(0)"
                                       data-bs-toggle="modal"
                                       data-bs-target="#profile-image-modal"
                                       aria-controls="#profile-profile-image-url"
                                       data-action="change-image">
                                        <i class="mdi mdi-account-switch"></i> Change Image
                                    </a>
                                <?php endif; ?>
                                <a id="i__profile-photo-uploader" class="dropdown-item"
                                   role="profile-image-administrator"
                                   href="javascript:void(0)"
                                   data-bs-toggle="modal"
                                   data-bs-target="#profile-image-modal"
                                   data-title="Update Profile Photo"
                                   data-intent="profile_photo_upload"
                                   data-request-handler="/upload/photo"
                                   redirect-url="/account-services/fetch-photos?intent=select_photo&purpost=make_profile_photo"
                                   data-referer="<?= $this->getRequest()->getAttribute('here') ?>">
                                    <i class="mdi mdi-account-plus"></i> Upload Image
                                </a>
                                <?php if ($user->profile->hasProfileImage()): ?>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" role="profile-image-administrator"
                                       href="javascript:void(0)" aria-controls="#profile-profile-image-url"
                                       data-action="remove-image">
                                        <i class="mdi mdi-account-off"></i> Remove Image
                                    </a>
                                <?php endif; ?>
                            </div>
                            <!--<div class="modal fade auto-scale" id="profile-image-modal"
                                 tabindex="-1" role="dialog"
                                 aria-labelledby="profile-photo-selector" aria-hidden="true">
                                <div class="modal-dialog modal-sm" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <h6 class="modal-title" id="profile-photo-selector">Select Image</h6>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-left"></div>
                                    </div>
                                </div>
                            </div>-->
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
                    <div class="col-md-auto">
                        <div class="account-name text-center text-md-left text-md-start">
                            <span class="fullname text-dark d-block"><?= h($user->getFullname()); ?></span>
                            <span class="username text-muted d-block">@<?= h($user->getUsername()); ?>
                                <?= $this->Html->link(
                                    __('<i class="link-icon mdi mdi-pencil"></i>'),
                                    ['action' => 'account', 'username'],
                                    [
                                        'data-ov-toggle' => "modal",
                                        'data-ov-target' => "#" . RandomString::generateString(
                                                32,
                                                'mixed',
                                                'alpha'
                                            ),
                                        'data-title' => 'Change Username',
                                        'data-uri' => Router::url([
                                            'action' => 'account',
                                            'username'
                                        ], true),
                                        'data-modal-control' => '{"class":"d-flex flex-column flex-column-reverse"}',
                                        'data-dialog-control' => '{"class":"align-self-end m-md-auto mx-0 my-0 my-md-5 w-100"}',
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
                    $user,
                    [
                        'class' => 'profile',
                        'type' => 'file',
                        'method' => 'post'
                    ]); ?>
                <?php $this->Form->unlockField('section'); ?>
                <div class="form-group">
                    <div class="row align-items-center">
                        <label class="form-label col-lg-4 text-lg-right">First Name</label>
                        <div class="col">
                            <?= $this->Form->control('firstname', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Firstname']); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row align-items-center">
                        <label class="form-label col-lg-4 text-lg-right">Last Name</label>
                        <div class="col">
                            <?= $this->Form->input('lastname', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Lastname']); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row align-items-center">
                        <label class="form-label col-lg-4 text-lg-right">Other Names</label>
                        <div class="col">
                            <?= $this->Form->control('othernames', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Othernames']); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row align-items-center">
                        <label class="form-label col-lg-4 text-lg-right">Description</label>
                        <div class="col">
                            <?= $this->Form->input(
                                'profile.description',
                                [
                                    'type' => 'text',
                                    'class' => 'form-control',
                                    'placeholder' => '',
                                    'label' => false
                                ]); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row align-items-center">
                        <label class="form-label col-lg-4 text-lg-right">About Me</label>
                        <div class="col">
                            <?= $this->Form->input(
                                'profile.bio',
                                [
                                    'type' => 'textarea',
                                    'class' => 'form-control',
                                    'placeholder' => '',
                                    'label' => false
                                ]); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row align-items-center">
                        <div class="form-label col-lg-4 text-lg-right">Gender</div>
                        <div class="col">
                            <div class="custom-controls-stacked">
                                <?= $this->Form->input('profile.gender', ['type' => 'hidden']); ?>
                                <label for="gender-male" class="custom-control custom-radio custom-control-inline">
                                    <?= $this->Form->radio('profile.gender',
                                        [
                                            [
                                                'id' => 'gender-male',
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
                                    <?= $this->Form->radio('profile.gender',
                                        [
                                            [
                                                'id' => 'gender-female',
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
                                <label for="gender-cross-gender"
                                       class="custom-control custom-radio custom-control-inline">
                                    <?= $this->Form->radio('profile.gender',
                                        [
                                            [
                                                'id' => 'gender-cross-gender',
                                                'value' => 'cross_gender',
                                                'text' => 'Cross Gender',
                                                'class' => 'custom-control-input'
                                            ]
                                        ],
                                        [
                                            'hiddenField' => false,
                                            'label' => false
                                        ]); ?>
                                    <div class="custom-control-label">Cross Gender</div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-right">
                <span class="d-none">
                    <input type="hidden" name="section" value="basic_info">
                </span>
                    <button type="submit"
                            class="btn btn-app bzakvszf lh-sm ms-auto n1ft4jmn
                            py-1 rounded-pill shadow-sm">
                        Save changes <i class="ms-2 mdi mdi-24px mdi-check"></i>
                    </button>
                </div>
                <?= $this->Form->end(['Upload']); ?>
            </div>
        </div>
    </div>
    <div id="date-of-birth" class="_UxaA _4gUj0 card shadow-none">
        <div class="card-body px-4">
            <div class="align-items-center d-flex justify-content-between">
                <h6 class="card-title mb-0">Date of Birth</h6>
                <div>
                    <button class="btn btn-icon btn-sm"
                            data-bs-toggle="collapse"
                            data-bs-target="#dateOfBirth"
                            aria-controls="#dateOfBirth">
                        <span class="icofont-3x icofont-thin-down"></span>
                    </button>
                </div>
            </div>
            <div id="dateOfBirth" class="collapse mt-4">
                <?= $this->Form->create(
                    $user,
                    [
                        'class' => 'profile',
                        'type' => 'file',
                        'method' => 'post'
                    ]); ?>
                <?php $this->Form->unlockField('section'); ?>
                <div class="form-group">
                    <div class="row align-items-center">
                        <label class="form-label col-lg-4 text-lg-right">Date Of Birth</label>
                        <div class="col">
                            <div class="form-row">
                                <div class="col-auto">
                                    <?= $this->Form->control(
                                        'profile.date_of_birth',
                                        [
                                            'label' => false,
                                            'wrapper' => false,
                                            'class' => 'form-control'
                                        ]); ?>
                                </div>
                                <!--<div class="col-auto">
                                <label for="date-year">Year</label>
                                <? /*= $this->Form->select(
                                    'profile.date_of_birth',
                                    $dateYears,
                                    [
                                        'name' => 'profile[date_of_birth][year]',
                                        'id' => 'date-year',
                                        'label' => false,
                                        'wrapper' => false,
                                        'class' => 'form-select'
                                    ]); */ ?>
                            </div>-->
                                <!--<div class="col-auto">
                                <label for="date-month">Month</label>
                                <? /*= $this->Form->select(
                                    'profile.date_of_birth',
                                    $dateMonths,
                                    [
                                        'name' => 'profile[date_of_birth][month]',
                                        'id' => 'date-month',
                                        'label' => false,
                                        'wrapper' => false,
                                        'class' => 'form-select'
                                    ]); */ ?>
                            </div>
                            <div class="col-auto">
                                <label for="date-day">Day</label>
                                <? /*= $this->Form->select(
                                    'profile.date_of_birth',
                                    $dateDays,
                                    [
                                        'name' => 'profile[date_of_birth][day]',
                                        'id' => 'date-day',
                                        'label' => false,
                                        'wrapper' => false,
                                        'class' => 'form-select'
                                    ]); */ ?>
                            </div>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-right">
                <span class="d-none">
                    <input type="hidden" name="section" value="birth_date">
                </span>
                    <button type="submit"
                            class="btn btn-app bzakvszf lh-sm ms-auto n1ft4jmn
                            py-1 rounded-pill shadow-sm">
                        Save changes <i class="ms-2 mdi mdi-24px mdi-check"></i>
                    </button>
                </div>
                <?= $this->Form->end(['Upload']); ?>
            </div>
        </div>
    </div>
    <div id="industry" class="_UxaA _4gUj0 card shadow-none">
        <div class="card-body px-4">
            <div class="align-items-center d-flex justify-content-between">
                <h6 class="card-title mb-0">Industry</h6>
                <div>
                    <button class="btn btn-icon btn-sm"
                            data-bs-toggle="collapse"
                            data-bs-target="#industryInfo"
                            aria-controls="#industryInfo">
                        <span class="icofont-3x icofont-thin-down"></span>
                    </button>
                </div>
            </div>
            <div id="industryInfo" class="collapse mt-4">
                <?= $this->Form->create(
                    null,
                    [
                        'class' => 'profile',
                        'type' => 'file',
                        'method' => 'post'
                    ]); ?>
                <?php $this->Form->unlockField('section'); ?>
                <?php $this->Form->unlockField('profile.industries'); ?>
                <?php $this->Form->unlockField('profile.roles'); ?>
                <?php $this->Form->unlockField('profile.genres'); ?>
                <label class="form-label">Add Industries</label>
                <div class="form-group">
                    <!--<div class="n4rSGWg selectgroup selectgroup-pills">
                    <?php /*foreach ($industries as $industry): */ ?>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="industries[]" value="<? /*= $industry->id */ ?>"
                                   class="selectgroup-input"
                                   <? /*= in_array($industry->id, $userIndustriesIDs) ? 'checked' : ''; */ ?>>
                            <span class="selectgroup-button"><? /*= h($industry->name) */ ?></span>
                        </label>
                    <?php /*endforeach; */ ?>
                </div>-->
                    <p class="small text-muted-dark">Which industry are you into? Music, Movie, Comedy, Sport or TV?</p>
                    <div id="input-industries" class="tags-input">
                        <input name="profile[industries]" type="hidden" class="tags-input_field"
                               data-role="tags-input-field" value="<?= implode(',', $userIndustries); ?>">
                    </div>
                </div>
                <label class="form-label">Add Roles</label>
                <div class="form-group">
                    <p class="small text-muted-dark">Who are you in the industry? A Song Writer, Rapper, Actor, Radio
                        Presenter, or Soccer Coach?</p>
                    <div id="input-roles" class="tags-input">
                        <input name="profile[roles]" type="hidden" class="tags-input_field"
                               data-role="tags-input-field" value="<?= implode(',', $userRoles); ?>">
                    </div>
                </div>
                <label class="form-label">Add Genres</label>
                <div class="form-group">
                    <p class="small text-muted-dark">What's your genre? Hip-Hop, R&B, Soccer, Volley Ball, Reality Show,
                        or Stand-Up Comedy?
                    </p>
                    <div id="input-genres" class="tags-input">
                        <input name="profile[genres]" type="hidden" class="tags-input_field"
                               data-role="tags-input-field" value="<?= implode(',', $userGenres); ?>">
                    </div>
                </div>
                <div class="form-group text-right">
                    <span class="d-none">
                        <input type="hidden" name="section" value="industry">
                    </span>
                    <button type="submit"
                            class="btn btn-app bzakvszf lh-sm ms-auto n1ft4jmn
                            py-1 rounded-pill shadow-sm">
                        Save changes <i class="ms-2 mdi mdi-24px mdi-check"></i>
                    </button>
                </div>
                <?= $this->Form->end(['Upload']); ?>
            </div>
        </div>
    </div>
    <div id="background" class="_UxaA _4gUj0 card _JLBq4 shadow-none">
        <div class="card-body px-4">
            <div class="align-items-center d-flex justify-content-between">
                <h6 class="card-title mb-0">Background</h6>
                <div>
                    <button class="btn btn-icon btn-sm"
                            data-bs-toggle="collapse"
                            data-bs-target="#backgroundInfo"
                            aria-controls="#backgroundInfo">
                        <span class="icofont-3x icofont-thin-down"></span>
                    </button>
                </div>
            </div>
            <div id="backgroundInfo" class="collapse mt-4">
                <?= $this->Form->create(
                    $user,
                    [
                        'class' => 'profile',
                        'method' => 'post'
                    ]); ?>
                <?php $this->Form->unlockField('profile.languages'); ?>
                <?php $this->Form->unlockField('section'); ?>
                <div class="form-group">
                    <div class="row align-items-center">
                        <label class="form-label col-lg-4 text-lg-right">Country/Region</label>
                        <div class="col">
                            <?= $this->Form->select('profile.country_of_origin',
                                [
                                    'Biafra' => 'Biafra',
                                ],
                                [
                                    'label' => false,
                                    'class' => 'form-select'
                                ]); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row align-items-center">
                        <label class="form-label col-lg-4 text-lg-right">State/Province</label>
                        <div class="col">
                            <?= $this->Form->select('profile.state_of_origin',
                                [],
                                [
                                    'label' => false,
                                    'class' => 'form-select'
                                ]); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row align-items-center">
                        <label class="form-label col-lg-4 text-lg-right">Local Government</label>
                        <div class="col">
                            <?= $this->Form->control('profile.lga_of_origin', ['label' => false, 'class' => 'form-control',
                                'placeholder' =>
                                    'Local Government']); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <div class="row align-items-center">
                        <label class="form-label col-lg-4 text-lg-right">City/Hometown</label>
                        <div class="col">
                            <?= $this->Form->input(
                                'profile.hometown',
                                [
                                    'type' => 'text',
                                    'class' => 'form-control',
                                    'placeholder' => 'City/Hometown',
                                    'label' => false
                                ]); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row align-items-center">
                        <label class="form-label col-lg-4 text-lg-right">Parentage</label>
                        <div class="col">
                            <div class="border fieldset p-3 xoj5za5y">
                                <div class="mb-3">
                                    <?= $this->Form->input(
                                        'profile.name_of_father',
                                        [
                                            'type' => 'text',
                                            'class' => 'form-control',
                                            'placeholder' => 'Father\'s Name',
                                            'label' => false
                                        ]); ?>
                                </div>
                                <div>
                                    <?= $this->Form->input(
                                        'profile.name_of_mother',
                                        [
                                            'type' => 'text',
                                            'class' => 'form-control',
                                            'placeholder' => 'Mother\'s Name',
                                            'label' => false
                                        ]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mb-4">
                    <label class="col-lg-3 form-label text-lg-right">
                        Languages
                        <small class="d-lg-none">(What languages do you speak?)</small>
                    </label>
                    <div class="col">
                        <div class="align-items-center d-none d-lg-flex justify-content-between mb-3">
                            <p class="small text-muted-dark mb-0">What languages do you speak?</p>
                        </div>
                        <?php
                        echo $this->element('App/widgets/language_selector', [
                            'fieldName' => 'profile_languages_0',
                            'css' => 'mx-n4 YbrzKYBn fX8bj0SG py-2 px-4 bg-light',
                            'defaultLang' => $primaryLanguage,
                            'removable' => false
                        ]);
                        if (count($user->profile->languages) > 1) {
                            foreach ($user->profile->languages as $index => $language) {
                                if ($index === 0) {
                                    continue;
                                }
                                echo $this->element('App/widgets/language_selector', [
                                    'fieldName' => 'profile_languages_' . $index,
                                    'css' => 'mx-n4 YbrzKYBn fX8bj0SG py-2 px-4 bg-light',
                                    'defaultLang' => $language->toArray(),
                                    'removable' => true
                                ]);
                            }
                        }
                        ?>
                        <div class="add-language-row">
                            <button class="btn btn-icon btn-sm btn-outline-secondary"
                                    data-action="add-language"
                                    data-url="../d-cs/html/language-selector"
                                    type="button">
                                <span class="icofont-2x mdi mdi-plus"></span> Add Language
                            </button>
                        </div>
                    </div>
                </div>
                <div class="form-group text-right">
                <span class="d-none">
                    <input type="hidden" name="section" value="background">
                </span>
                    <button type="submit"
                            class="btn btn-app bzakvszf lh-sm ms-auto n1ft4jmn
                            py-1 rounded-pill shadow-sm">
                        Save changes <i class="ms-2 mdi mdi-24px mdi-check"></i>
                    </button>
                </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
    <div id="location" class="_UxaA _4gUj0 card _JLBq4 shadow-none">
        <div class="card-body px-4">
            <div class="align-items-center d-flex justify-content-between">
                <h6 class="card-title mb-0">Residential Info</h6>
                <div>
                    <button class="btn btn-icon btn-sm"
                            data-bs-toggle="collapse"
                            data-bs-target="#residentialInfo"
                            aria-controls="#residentialInfo">
                        <span class="icofont-3x icofont-thin-down"></span>
                    </button>
                </div>
            </div>
            <div id="residentialInfo" class="collapse mt-4">
                <?= $this->Form->create(
                    $user,
                    [
                        'class' => 'profile',
                        'method' => 'post'
                    ]); ?>
                <?php $this->Form->unlockField('section'); ?>
                <div class="form-group">
                    <div class="row align-items-center">
                        <label class="form-label col-lg-4 text-lg-right">Country/Region</label>
                        <div class="col">
                            <?= $this->Form->select('profile.country_of_residence',
                                [
                                    'Biafra' => 'Biafra',
                                ],
                                [
                                    'label' => false,
                                    'class' => 'form-select'
                                ]); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row align-items-center">
                        <label class="form-label col-lg-4 text-lg-right">State/Province</label>
                        <div class="col">
                            <?= $this->Form->select('profile.state_of_residence',
                                [],
                                [
                                    'label' => false,
                                    'class' => 'form-select'
                                ]); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row align-items-center">
                        <label class="form-label col-lg-4 text-lg-right">Local Government</label>
                        <div class="col">
                            <?= $this->Form->control('profile.lga_of_residence', ['label' => false, 'class' => 'form-control',
                                'placeholder' =>
                                    'Local Government']); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row align-items-center">
                        <label class="form-label col-lg-4 text-lg-right">City</label>
                        <div class="col">
                            <?= $this->Form->input(
                                'profile.current_city',
                                [
                                    'type' => 'text',
                                    'class' => 'form-control',
                                    'placeholder' => 'City/Hometown',
                                    'label' => false
                                ]); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row align-items-center">
                        <label class="form-label col-lg-4 text-lg-right">Street Address</label>
                        <div class="col">
                            <?= $this->Form->input(
                                'profile.address',
                                [
                                    'class' => 'form-control',
                                    'placeholder' => 'Street Address',
                                    'label' => false
                                ]); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row align-items-center">
                        <div class="form-label col-lg-4 text-lg-right">Postal/Zip Code</div>
                        <div class="col">
                            <?= $this->Form->input(
                                'profile.postcode',
                                [
                                    'class' => 'form-control',
                                    'placeholder' => 'Post/Zip code',
                                    'label' => false
                                ]); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row align-items-center">
                        <div class="form-label col-lg-4 text-lg-right">Current Location</div>
                        <div class="col">
                            <?= $this->Form->input(
                                'profile.location',
                                [
                                    'class' => 'form-control',
                                    'placeholder' => 'Post/Zip code',
                                    'label' => false
                                ]); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group text-right">
                <span class="d-none">
                    <input type="hidden" name="section" value="residential_info">
                </span>
                    <button type="submit"
                            class="btn btn-app bzakvszf lh-sm ms-auto n1ft4jmn
                            py-1 rounded-pill shadow-sm">
                        Save changes <i class="ms-2 mdi mdi-24px mdi-check"></i>
                    </button>
                </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
    <div id="contacts" class="_UxaA _4gUj0 card shadow-none">
        <div class="card-body px-4">
            <div class="align-items-center d-flex justify-content-between">
                <h6 class="card-title mb-0">Contacts</h6>
                <div>
                    <button class="btn btn-icon btn-sm"
                            data-bs-toggle="collapse"
                            data-bs-target="#contactsInfo"
                            aria-controls="#contactsInfo">
                        <span class="icofont-3x icofont-thin-down"></span>
                    </button>
                </div>
            </div>
            <div id="contactsInfo" class="collapse mt-4">
                <?= $this->Form->create(
                    $user,
                    [
                        'class' => 'profile',
                        'type' => 'file',
                        'method' => 'post'
                    ]); ?>
                <div class="form-group">
                    <div class="row align-items-center">
                        <label class="form-label col-lg-4 text-lg-right">Email</label>
                        <div class="col">
                            <?php if ($user->has('emails') && count($user->emails)): ?>
                                <div class="input-group">
                                    <?= $this->Form->control("emails.0.address", [
                                        'templates' => [
                                            'inputContainer' => '{{content}}'
                                        ],
                                        'label' => false,
                                        'class' => 'form-control',
                                        'placeholder' => 'Email',
                                        'readonly' => 'true'
                                    ]); ?>
                                    <?php if ($user->emails[0]->is_primary): ?>
                                        <span class="input-group-append">
                                            <span class="input-group-text">
                                                <span class="badge bg-secondary">Primary</span>
                                            </span>
                                        </span>
                                    <?php else: ?>
                                        <span class="input-group-append">
                                            <?= $this->Html->link(
                                                __('<i class="link-icon mdi mdi-pencil"></i>'),
                                                [
                                                    'action' => 'account',
                                                    'email',
                                                    'edit',
                                                    '?' => ['id' => 0]
                                                ],
                                                [
                                                    'class' => 'input-group-text',
                                                    'escapeTitle' => false,
                                                    'title' => 'Change email'
                                                ]); ?>
                                        </span>
                                        <span class="input-group-append">
                                            <?= $this->Html->link(
                                                __('<i class="link-icon icofont-close-line icofont-2x"></i>'),
                                                [
                                                    'action' => 'account',
                                                    'email',
                                                    '?' => ['option' => 'remove', 'id' => 0]
                                                ],
                                                [
                                                    'class' => 'input-group-text',
                                                    'escapeTitle' => false,
                                                    'title' => 'Remove email'
                                                ]); ?>
                                        </span>
                                    <?php endif; ?>
                                    <span class="input-group-append">
                                        <?= $this->Html->link(
                                            __('<i class="link-icon mdi mdi-plus"></i>'),
                                            [
                                                'action' => 'account',
                                                'add-email'
                                            ],
                                            [
                                                'class' => 'input-group-text',
                                                'escapeTitle' => false,
                                                'title' => 'Add new email'
                                            ]); ?>
                                    </span>
                                </div>
                                <?php
                                foreach ($user->emails as $index => $email):
                                    if ($index === 0) { continue; }
                                    ?>
                                    <div class="input-group">
                                        <?= $this->Form->control("emails.$index.address", [
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
                                                'edit-email',
                                                '?' => ['id' => $index]
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
                                                'add-email'
                                            ],
                                            [
                                                'class' => 'input-group-text',
                                                'escapeTitle' => false,
                                                'title' => 'Add new email'
                                            ]); ?>
                                        </span>
                                    </div>
                                <?php
                                endforeach;
                            else:
                                ?>
                                <span class="input-group-append">
                                    <?= $this->Html->link(
                                        __('<i class="link-icon mdi mdi-shape-rectangle-plus"></i> Add Email'),
                                        [
                                            'action' => 'account',
                                            'add-email'
                                        ],
                                        [
                                            'data-ov-toggle' => "modal",
                                            'data-ov-target' => "#" . RandomString::generateString(
                                                    32,
                                                    'mixed',
                                                    'alpha'
                                                ),
                                            'data-title' => 'Add new email',
                                            'data-uri' => Router::url([
                                                'action' => 'account',
                                                'add-email'
                                            ], true),
                                            'data-modal-control' => '{"class":"d-flex flex-column flex-column-reverse"}',
                                            'data-dialog-control' => '{"css":{"maxHeight":"90%"},
                                            "class":"align-self-end m-md-auto mx-0 my-0 my-md-5 w-100"}',
                                            'class' => 'btn btn-sm btn-outline-secondary',
                                            'escapeTitle' => false,
                                            'title' => 'Add new email'
                                        ]); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row align-items-center">
                        <label class="form-label col-lg-4 text-lg-right">Phone</label>
                        <div class="col">
                            <?php if ($user->has('phones') && count($user->phones)): ?>
                                <div class="input-group">
                                    <?= $this->Form->control('phones.0.number', [
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
                                <?= $this->Html->link(
                                    __('<i class="link-icon mdi mdi-phone-plus"></i> Add Phone'),
                                    [
                                        'action' => 'account',
                                        'phone',
                                        'add-phone'
                                    ],
                                    [
                                        'data-ov-toggle' => "modal",
                                        'data-ov-target' => "#" . RandomString::generateString(
                                                32,
                                                'mixed',
                                                'alpha'
                                            ),
                                        'data-title' => 'Add new phone',
                                        'data-uri' => Router::url([
                                            'action' => 'account',
                                            'add-phone'
                                        ], true),
                                        'data-modal-control' => '{"class":"d-flex flex-column flex-column-reverse"}',
                                        'data-dialog-control' => '{"class":"align-self-end m-md-auto mx-0 my-0 my-md-5 w-100"}',
                                        'class' => 'btn btn-sm btn-outline-secondary',
                                        'escapeTitle' => false,
                                        'title' => 'Add new phone'
                                    ]); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="form-group text-right">
                    <button type="submit"
                            class="btn btn-app bzakvszf lh-sm ms-auto n1ft4jmn
                            py-1 rounded-pill shadow-sm">
                        Save changes <i class="ms-2 mdi mdi-24px mdi-check"></i>
                    </button>
                </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        const inputIndustries = new TagsInput('#input-industries', true, {
            tagsBordered: true,
            inputFromSuggestion: true,
            suggestionSourceUrl: '<?= Router::url("/search/type-hint/suggestion?what=industries", true) ?>',
            suggestionCallback: function (result, output, obj) {
                let suggestions = '<div></div>';
                result.forEach(function (item, index) {
                    let suggestion = $('<span id="suggestion-' + item + '" '
                        + 'class="tags-input_suggestion" '
                        + 'data-tag-name="' + item + '">' + item
                        + '<span class="insert-tag">+</span></span>');
                    if (obj.tagAlreadySelected(item)) {
                        suggestion = $(suggestion).addClass('selected');
                    }
                    suggestions = $(suggestions).append(suggestion);
                });
                output.html($(suggestions).children());
                $(suggestions).html('');
            }
        });
        inputIndustries.tagify();

        /**
         * Input roles by type-hint
         * @type {TagsInput}
         */
        const inputRoles = new TagsInput('#input-roles', true, {
            tagsBordered: true,
            inputFromSuggestion: true,
            suggestionSourceUrl: '<?= Router::url("/search/type-hint/suggestion?what=roles", true) ?>',
            suggestionCallback: function (result, output, obj) {
                let suggestions = '<div></div>';
                result.forEach(function (item, index) {
                    let suggestion = $('<span id="suggestion-' + item + '" '
                        + 'class="tags-input_suggestion" '
                        + 'data-tag-name="' + item + '">' + item
                        + '<span class="insert-tag">+</span></span>');
                    if (obj.tagAlreadySelected(item)) {
                        suggestion = $(suggestion).addClass('selected');
                    }
                    suggestions = $(suggestions).append(suggestion);
                });
                output.html($(suggestions).children());
                $(suggestions).html('');
            }
        });
        inputRoles.tagify();

        /**
         * Input genres by type-hint
         *
         * @type {TagsInput}
         */
        const inputGenres = new TagsInput('#input-genres', true, {
            tagsBordered: true,
            inputFromSuggestion: true,
            suggestionSourceUrl: '<?= Router::url("/search/type-hint/suggestion?what=genres", true) ?>',
            suggestionCallback: function (result, output, obj) {
                let suggestions = '<div></div>';
                result.forEach(function (item, index) {
                    let suggestion = $('<span id="suggestion-' + item + '" '
                        + 'class="tags-input_suggestion" '
                        + 'data-tag-name="' + item + '">' + item
                        + '<span class="insert-tag">+</span></span>');
                    if (obj.tagAlreadySelected(item)) {
                        suggestion = $(suggestion).addClass('selected');
                    }
                    suggestions = $(suggestions).append(suggestion);
                });
                output.html($(suggestions).children());
                $(suggestions).html('');
            }
        });
        inputGenres.tagify();

        $('[data-action="add-language"]').click(function (e) {
            e.preventDefault();
            let $this = $(this),
                url = $(this).data('url'),
                spinnerId = 'languageLoading',
                loading = spinner(spinnerId);
            $(loading).insertBefore($this.parent());
            let existing = $('.language-selector');
            url += '?fn=profile_languages_' + existing.length;

            $.get(url).done(function (response) {
                // $(response).insertBefore($this.parent());
                response = $(response).addClass($(existing).attr('class'));
                $('#'+spinnerId).replaceWith(response);
            });
        });

        const settings = {
            "async": true,
            "crossDomain": true,
            "url": "https://city-api-io.p.rapidapi.com/country/list",
            "method": "POST",
            "headers": {
                "content-type": "application/json",
                "x-rapidapi-host": "city-api-io.p.rapidapi.com",
                "x-rapidapi-key": "1e5149384bmshafc6a71a4e006f8p1b59e3jsna7f88be2de8f"
            },
            "processData": false,
            "data": {
                "Filtering": {
                    "Query": "Korean' in demography.usedLanguages"
                }
            }
        };

        $.ajax(settings).done(function (response) {
            console.log(response);
        });

    });
</script>
<?= $this->Html->scriptStart(['block' => 'scriptBottom']); ?>
/*(function ($, accountService, metaData) {
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
})(jQuery, AsyncAccountService, META_DATA);*/


// inputIndustries.setOptions({foo: "bar"});
<?= $this->Html->scriptEnd(); ?>
