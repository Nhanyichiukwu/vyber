<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user // Only when there's is a logged in user
 * @var \App\Model\Entity\User $account
 */
use Cake\Routing\Router;
use App\Utility\RandomString;
use Cake\Utility\Text;
use Cake\Utility\Inflector;
?>
<?php
//$theme = 'e__theme';
//if (isset($user) && $user->hasCustomTheme) {
//    $theme = 'default.theme.css?type=custom&color=' . $user->themeColor . '&token=' . date('ymdhim');
//}
//if (isset($pageTitle)) {
//    $this->assign('title', $pageTitle);
//}

$requestPath = $this->getRequest()->getPath();

/**
 * Building the navigation menu
 */
$accountNav = [
    'Overview' => [
        'icon' => 'icofont-user-alt-3',
        'url' => [
            'controller' => $account->getUsername(),
            'action' => null
        ]
    ],
    'About' => [
        'icon' => 'icofont-user-alt-3',
        'url' => [
            'controller' => $account->getUsername(),
            'action' => 'about'
        ]
    ],
    'posts' => [
        'icon' => 'icofont-newspaper',
        'url' => [
            'controller' => $account->getUsername(),
            'action' => 'posts'
        ]
    ],
    'connections' => [
        'icon' => 'icofont-users-alt-5',
        'url' => [
            'controller' => $account->getUsername(),
            'action' => 'connections'
        ]
    ],
    'events' => [
        'icon' => 'icofont-tasks-alt',
        'url' => [
            'controller' => $account->getUsername(),
            'action' => 'events'
        ]
    ]
];
if (isset($user) && $account->isSameAs($user)) {
    $accountNav['activity'] = [
        'icon' => 'mdi mdi-newspaper',
        'url' => [
            'controller' => $account->getUsername(),
            'action' => 'activity'
        ]
    ];
}
$accountNav['interests'] = [
    'icon' => 'icofont-heart-alt',
    'url' => [

        'controller' => $account->getUsername(),
        'action' => 'interests'
    ]
];
$accountNav['photos'] = [
    'icon' => 'icofont-image',
    'url' => [
        'controller' => $account->getUsername(),
        'action' => 'photos'
    ]
];
/*if ('music' == $account->getNiche()) {
    $accountNav['songs'] = [
        'icon' => 'mdi mdi-newspaper',
        'url' => [

            'controller' => $account->getUsername(),
            'action' => 'songs'
        ]
    ];
}
elseif ('movie' == $account->getNiche()) {
    $accountNav['movies'] = [
        'icon' => 'mdi mdi-newspaper',
        'url' => [

            'controller' => $account->getUsername(),
            'action' => 'movies'
        ]
    ];
    $accountNav['series'] = [
        'icon' => 'mdi mdi-newspaper',
        'url' => [

            'controller' => $account->getUsername(),
            'action' => 'series'
        ]
    ];
}
if (in_array($account->getNiche(), ['music', 'comedy'])) {
    $accountNav['videos'] = [
        'icon' => 'mdi mdi-newspaper',
        'url' => [

            'controller' => $account->getUsername(),
            'action' => 'videos'
        ]
    ];
}*/
$accountNav['albums'] = [
    'icon' => 'icofont-retro-music-disk',
    'url' => [
        'controller' => $account->getUsername(),
        'action' => 'albums'
    ]
];
if (isset($user) && $account->isSameAs($user)) {
    $accountNav['collections'] = [
        'icon' => 'mdi mdi-newspaper',
        'url' => [
            'controller' => $account->getUsername(),
            'action' => 'collections'
        ]
    ];
    $accountNav['inventories'] = [
        'icon' => 'mdi mdi-note-edit',
        'url' => [
            'controller' => $account->getUsername(),
            'action' => 'inventories'
        ]
    ];
}
?>
<div id="profile" class="user-profile-page krfczvqa">
    <!--<header id="i3o" class="card-profile pos-r profile-header bg-white ajaxify h_bP23 border-bottom"
             data-name="profile_cover"
             data-src="<?/*= '/profile/cover?user=' . $account->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed'); */?>"
             data-conditions='{"remove_if_no_content":"no","check_for_update":"yes","auto_update":"no","use_data_prospect":"yes"}'>-->
        <?php /** End Profile Cover Container **/ ?>
    <!--</header>-->
    <?php
    $tab = $this->getRequest()->getQuery('action');
    if (!$tab) {
        $tab = 'default';
    }
    $profileUrl = '/'. $this->getRequest()->getParam('controller') .'/' . h($account->username);
    $coverUrl = Router::url('/public-files/vzN83U2EVFhcX8O/photos/profile-headers/1640154779_gbg5abO3BffODmWD.png');
    ?>
    <x-cw-profile-header class="_oFb7Hd ajaxify cover-image d-block _UxaA r8upjl1q o-hidden">
        <div class="profile-cover ikp8xqyl"
             style="background-image: url(<?= $coverUrl ?>)">
        </div>
        <div class="p-3 bg-white ikp8xqyl">
            <div class="_oFb7Hd has-account-name has-avatar has-navigation profile-basic-info row">
                <div class="col-12 col-lg-5 col-md-4">
                    <div class="align-items-center flex-md-column flex-row gutters-sm mb-3 row">
                        <div class="col-auto col-md-12 col-sm-3">
                            <span class="avatar ba8N8mcr border-0 d-block mx-auto profile-photo
                            mb-md-4"></span>
                        </div>
                        <div class="col">
                            <div
                                class="d-flex flex-lg-row mx-0 profile-cta row row-cols-2 row-cols-lg-4 row-cols-md-2 row-cols-sm-auto">
                                <span class="p-1">
                                    <button type="button"
                                            class="btn btn-block btn-control-small btn-icon btn-primary btn-rounded btn-sm lh-sm n1ft4jmn q3ywbqi8">
                                        Connect <span class="fsz-14 mdi mdi-account-plus"></span>
                                    </button>
                                </span>
                                <span class="p-1">
                                    <button type="button"
                                            class="btn btn-block btn-control-small btn-icon btn-primary btn-rounded btn-sm lh-sm n1ft4jmn q3ywbqi8">
                                        Message <span class="fsz-14 mdi mdi-message"></span>
                                    </button>
                                </span>
                                <span class="p-1">
                                    <button type="button"
                                            class="btn btn-block btn-control-small btn-icon btn-primary btn-rounded btn-sm lh-sm n1ft4jmn q3ywbqi8">
                                        Meet <span class="fsz-14 mdi mdi-handshake"></span>
                                    </button>
                                </span>
                                <span class="p-1">
                                    <button type="button"
                                            class="btn btn-block btn-control-small btn-icon btn-primary btn-rounded btn-sm lh-sm n1ft4jmn q3ywbqi8">
                                        Introduce <span class="fsz-14 mdi mdi-redo"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="_oFb7Hd account-info">
                        <div class="mb-3">
                            <div class="lh_wxx">
                                <x-cw-inline-span
                                    class="profile-screen-name fw-normal fs-2 <?= $account->isVerifiedAccount() ? 'account-verified' : '' ?>
                                    ">@<?= h($account->getUsername()); ?></x-cw-inline-span>
                            </div>
                            <div class="lh-1">
                                    <span
                                        class="d-inline-block fs-4 fw-light text-gray"><?= h($account->getFullName())
                                        ; ?></span>
                            </div>
                        </div>
                        <?php if (count($account->profile->getRoles())): ?>
                            <div class="mb-3">
                                <x-cw-flex-box class="bzakvszf flex-mat w-100 wsnuxou6 text-gray">
                                    <cw-icon class="cw-app_user-nav_icon icon-prepend
                                     icofont-briefcase-1 fs-5 me-2"></cw-icon>
                                    <cw-inline-span class="cw-app_user-nav_title cw-app_link_title
                            nav-link-label"><?= $account->profile->getRolesAsString() ?></cw-inline-span>
                                </x-cw-flex-box>
                            </div>
                        <?php endif; ?>
                        <?php if ($account->profile->hasValue('description')): ?>
                            <div class="profile-desc mb-3"><?= h($account->profile->getDescription()); ?></div>
                        <?php endif; ?>
                        <ul class="gutters-sm mb-4 nav row row-cols-sm-auto">
                            <li class="col ywbtrza8">
                                <div>
                                    <a href="#"
                                       class="a3jocrmt flex-sm-row n1ft4jmn ofjtagoh text-center text-dark">
                                        <x-cw-inline-span
                                            class="counter fw-bold me-sm-1"><?= $account->connectionsCount() ?></x-cw-inline-span>
                                        connections
                                    </a>
                                </div>
                            </li>
                            <li class="col ywbtrza8">
                                <div>
                                    <a href="#"
                                       class="a3jocrmt flex-sm-row n1ft4jmn ofjtagoh text-center text-dark">
                                        <x-cw-inline-span
                                            class="counter fw-bold me-sm-1"><?= $account->followersCount() ?></x-cw-inline-span>
                                        followers
                                    </a>
                                </div>
                            </li>
                            <li class="col ywbtrza8">
                                <div>
                                    <a href="#"
                                       class="a3jocrmt flex-sm-row n1ft4jmn ofjtagoh text-center text-dark">
                                        <x-cw-inline-span
                                            class="counter fw-bold me-sm-1"><?= $account->followingsCount() ?></x-cw-inline-span>
                                        following
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <?php if (isset($user) && $account->isSameAs($user)): ?>
                            <div class="_qRwCre _bHrk _p5kp">
                                <?= $this->Html->link('<span class="fsz-16 lh-1 mdi mdi-24px mdi-account-edit-outline"></span>', [
                                    'controller' => 'settings',
                                    'action' => 'profile'
                                ], [
                                    'class' => 'btn btn-app-outline btn-icon btn-pill d-flex h_yHVB patuzxjv text-center x_yHVB',
                                    'escapeTitle' => false
                                ]) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
        <?php /** Start Navigation bar **/ ?>
        <nav class="bg-white d-lg-flex navbar ofx-auto p-0 page-nav toolbar foa3ulpk">
            <div class="align-items-center px-3 w-100">
                <ul class="flex-nowrap flex-row nav nav-tabs row-cols-auto mx-n3 _muZaE">
                    <?php foreach ($accountNav as $key => $array): ?>
                        <li class="nav-item px-3">
                            <?php
                            $classes = ['align-items-center c-grey-600 e__nav-link flex-column justify-content-center nav-link'];
                            //                            $classes = ['list-group-item','list-group-item-action'];
                            $requestPath = strtolower(trim($requestPath, '/'));
                            $url = implode('/', array_values($array['url']));
                            if (rtrim($requestPath, '/') === rtrim(strtolower($url), '/')) {
                                $classes[] = 'active';
                            }
                            $url = Router::url('/'.$url, true);
                            ?>
                            <?php
//                            $this->Html->link(
//                                __('<span class="fs-5 lh-1 me-0 mb-1 {0}"></span> <span class="TWx fsz-14">{1}</span>',
//                                    $array['icon'], Inflector::humanize
//                                    ($key)),
//                                $url,
//                                [
//                                    'class' => implode(' ', $classes),
//                                    'data-uri' => '/profile/' . $key . '?user=' . $account->getUsername() . '&_referer='
//                                        . urlencode($this->getRequest()->getAttribute('here'))
//                                        . '&_accessKey=' . RandomString::generateString(16, 'mixed'),
//                                    'escapeTitle' => false
//                                ]
//                            );
                            ?>
                            <?= $this->Html->link(
                                __('<span class="TWx fsz-14">{0}</span>',
                                    Inflector::humanize($key)), $url,
                                [
                                    'class' => implode(' ', $classes),
                                    'data-uri' => '/profile/' . $key . '?user=' . $account->getUsername() . '&_referer='
                                        . urlencode($this->getRequest()->getAttribute('here'))
                                        . '&_accessKey=' . RandomString::generateString(16, 'mixed'),
                                    'escapeTitle' => false
                                ]
                            ); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </nav>
        <?php /** End Navigation bar **/ ?>
    </x-cw-profile-header>
    <div class="profile-body">
        <div id="page-content-wrapper" class="col-inner">
            <?= $this->fetch('content'); ?>
        </div>
    </div>
</div>


<?php $this->start('sidebar'); ?>
<div class="card mwp7f1ov">
    <div class="card-body">
        <h6 class="card-title"><?= __('Similar Accounts'); ?></h6>
        <div id="similarAccount"
             class="ajaxify"
             data-name="similar_accounts"
             data-src=""
             data-conditions='{"remove_if_no_content":"no","check_for_update":"yes","auto_update":"no","use_data_prospect":"yes"}'></div>
    </div>
</div>
<div class="card mwp7f1ov">
    <div class="card-body">
        <h6 class="card-title"><?= __('People You May Know'); ?></h6>
        <div id="profileFamiliarUsers"
             class="ajaxify"
             data-name="familiar_users"
             data-src="<?= '/suggestions/familiar_users?_dt=i_lookup&user=' . $account->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed'); ?>"
             data-conditions='{"remove_if_no_content":"no","check_for_update":"yes","auto_update":"no","use_data_prospect":"yes"}'></div>
    </div>
</div>
<?php if (!isset($user)): ?>
    <div class="card mwp7f1ov">
        <div class="card-header">
            <h2 class="card-title">Login</h2>
        </div>
        <div class="card-body">
            <p class="text-muted"><?= $account->getFirstname() ?> may be online now.
                But you are not logged in, so you will not be able to interact with
                <?= $account->profile->getGender() === 'male'? 'him' : 'her'; ?>. Login or
                click on 'Signup' below to create a new account. It's absolute
                free.</p>
            <?= $this->element('Auth/login_customizable'); ?>
        </div>
    </div>
<?php endif; ?>
<?php $this->end(); ?>

