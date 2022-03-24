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
    'About' => [
        'icon' => 'icofont-user-alt-3',
        'url' => [
            'controller' => $account->getUsername(),
            'action' => null
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
    $accountNav['activities'] = [
        'icon' => 'mdi mdi-newspaper',
        'url' => [
            'controller' => $account->getUsername(),
            'action' => 'activities'
        ]
    ];
}
$accountNav['likes'] = [
    'icon' => 'icofont-heart-alt',
    'url' => [

        'controller' => $account->getUsername(),
        'action' => 'likes'
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
<div id="profile" class="user-profile-page">
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
    ?>
    <header class="bg-white-glass card border-top-0 d-block mdder6bk profile-header vllbqapx w-auto xzg02mh0
    shadow-none">
        <div
            class="ajaxify bg-white-glass cover-image h_bP23 pos-r profile-cover card-header"
            style="background-image: url(<?= $account->profile->getHeaderImageUrl() ?>)">
            <div class="_qRwCre pos-a profile-cta">
                <button type="button" class="btn btn-primary btn-sm btn-rounded btn-control-small">
                    Connect <span class="mdi mdi mdi-plus"></span>
                </button>
                <button type="button" class="btn btn-primary btn-sm btn-rounded btn-control-small">
                    Message <span class="mdi mdi mdi-plus"></span>
                </button>
                <button type="button" class="btn btn-primary btn-sm btn-rounded btn-control-small">
                    Meet <span class="mdi mdi mdi-plus"></span>
                </button>
                <button type="button" class="btn btn-primary btn-sm btn-rounded btn-control-small">
                    Introduce <span class="mdi mdi mdi-plus"></span>
                </button>
            </div>
        </div>
        <div class="profile-basic-info card-body clearfix has-avatar has-account-name has-navigation">
            <div class="avatar avatar-placeholder ba8N8mcr float-left ms-5 pos-r profile-photo"></div>
            <div class="vZpCChso clearfix">
                <div class="account-info pe-5 _oFb7Hd">
                    <h1 class="font-weight-light text-dark">
                        <?= h($account->getFullName()); ?>
                    </h1>
                    <?php //if ($account->hasValue('description')): ?>
                        <p class="profile-desc"><?= h($account->profile->getDescription()); ?></p>
                    <?php //endif; ?>
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
                <?php /** Start Navigation bar **/ ?>
                <nav class="d-lg-flex navbar ofx-auto p-0 page-nav toolbar foa3ulpk mt-4 border-top">
                    <div class="align-items-center px-3">
                        <ul class="border-bottom-0 flex-nowrap flex-row nav nav-tabs">
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
                                    <?= $this->Html->link(
                                        __('<span class="fs-5 lh-1 me-0 mb-1 {0}"></span> <span class="TWx fsz-14">{1}</span>',
                                            $array['icon'], Inflector::humanize
                                            ($key)),
                                        $url,
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
            </div>
        </div>
    </header>
    <div class="profile-body px-lg-3">
        <div class="row mx-n3">
            <div class="col-lg-4 col-md-3 px-3 fx1fu3an profile-pagelet-left-sidebar border-right">
                <div class="I3r py-3">
                    <div class="card">
                        <div class="card-header post-search-form p-3">
                            <div class="input-icon w-100">
                                <input type="text" name="keyword" class="custom-control form-control rounded-pill w-100" placeholder="Search..." id="keyword">                        <div class="input-icon-addon text-muted p-e_All">
                                    <button type="submit" class="btn btn-sm btn-transparent">
                                        <i class="mdi mdi mdi-18px mdi mdi-magnify"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="U1Ls">
                            <div class="list-group list-group-flush">
                                <a href="#" class="list-group-item list-group-item-action"><i class="link-icon mdi mdi mdi-calendar-today"></i> <span class="link-text">Date</span></a>
                                <a href="#" class="list-group-item list-group-item-action"><i class="link-icon mdi mdi mdi-reply"></i> <span class="link-text">Replies</span></a>
                                <a href="#" class="list-group-item list-group-item-action"><i class="link-icon mdi mdi mdi-floppy"></i> <span class="link-text">Copied</span></a>
                                <a href="#" class="list-group-item list-group-item-action"><i class="link-icon mdi mdi mdi-chart-line"></i> <span class="link-text">Trending</span></a>
                                <a href="#" class="list-group-item list-group-item-action"><i class="link-icon mdi mdi mdi-star"></i> <span class="link-text">Most Popular</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-9 ms-auto px-3">
                <div class="col-inner">
                    <?= $this->fetch('content'); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->start('sidebar'); ?>
<div class="card">
    <div class="card-body">
        <h6 class="card-title"><?= __('Similar Accounts'); ?></h6>
        <div id="similarAccount"
             class="ajaxify"
             data-name="similar_accounts"
             data-src="<?= '/suggestions/similar_accounts?_dt=i_lookup&user=' . $account->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed'); ?>"
             data-conditions='{"remove_if_no_content":"no","check_for_update":"yes","auto_update":"no","use_data_prospect":"yes"}'></div>
    </div>
</div>
<div class="card">
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
    <div class="card">
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

