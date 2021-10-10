<?php

use Cake\Utility\Text;
use Cake\Utility\Inflector;
use App\Utility\RandomString;
use Cake\Routing\Router;

//if ($this->get('layout') && $this->getLayout($this->get('layout'))) {
//    $this->extend($this->get('layout'));
//}

//pr($this->getOptions());
//exit;
// Turn off the sidebar by default
if (! $this->hasOption('right_sidebar'))
    $this->enableOption('right_sidebar');
?>
<?php
//$theme = 'e__theme';
//if (isset($activeUser) && $activeUser->hasCustomTheme) {
//    $theme = 'default.theme.css?type=custom&color=' . $activeUser->themeColor . '&token=' . date('ymdhim');
//}
//if (isset($pageTitle)) {
//    $this->assign('title', $pageTitle);
//}

$requestPath = $this->getRequest()->getPath();

/**
 * Building the navigation menu
 */
$accountNav = [
    'about' => [
        'icon' => 'mdi-account',
        'url' => [
            'action' => $account->getUsername(),
            'about'
        ]
    ],
    'posts' => [
        'icon' => 'mdi-newspaper',
        'url' => [
            'action' => $account->getUsername(),
            'posts'
        ]
    ],
    'connections' => [
        'icon' => 'mdi-newspaper',
        'url' => [
            'action' => $account->getUsername(),
            'connections'
        ]
    ],
    'events' => [
        'icon' => 'mdi-newspaper',
        'url' => [
            'action' => $account->getUsername(),
            'events'
        ]
    ],
    'activities' => [
        'icon' => 'mdi-newspaper',
        'url' => [
            'action' => $account->getUsername(),
            'activities'
        ]
    ],
//    'likes' => [
//        'icon' => 'mdi-newspaper',
//        'url' => [
//
//            'action' => $account->getUsername(),
//            'likes'
//        ]
//    ],
    'photos' => [
        'icon' => 'mdi-newspaper',
        'url' => [
            'action' => $account->getUsername(),
            'photos'
        ]
    ]
];
//if ('music' == $account->getNiche()) {
//    $accountNav['songs'] = [
//        'icon' => 'mdi-newspaper',
//        'url' => [
//
//            'action' => $account->getUsername(),
//            'songs'
//        ]
//    ];
//}
//elseif ('movie' == $account->getNiche()) {
//    $accountNav['movies'] = [
//        'icon' => 'mdi-newspaper',
//        'url' => [
//
//            'action' => $account->getUsername(),
//            'movies'
//        ]
//    ];
//    $accountNav['series'] = [
//        'icon' => 'mdi-newspaper',
//        'url' => [
//
//            'action' => $account->getUsername(),
//            'series'
//        ]
//    ];
//}
//if (in_array($account->getNiche(), ['music', 'comedy'])) {
//    $accountNav['videos'] = [
//        'icon' => 'mdi-newspaper',
//        'url' => [
//
//            'action' => $account->getUsername(),
//            'videos'
//        ]
//    ];
//}
$accountNav['albums'] = [
    'icon' => 'mdi-disc',
    'url' => [
        'action' => $account->getUsername(),
        'albums'
    ]
];
if (isset($activeUser) && $account->isSameAs($activeUser)) {
    $accountNav['collections'] = [
            'icon' => 'mdi-newspaper',
            'url' => [
                'action' => $account->getUsername(),
                'collections'
            ]
        ];
    $accountNav['inventories'] = [
            'icon' => 'mdi-note-edit',
            'url' => [
                'action' => $account->getUsername(),
                'inventories'
            ]
        ];
}
?>
<?= $this->element('LayoutElements/layout_top'); ?>
    <header class="card card-profile mb-4 pos-r profile-header bg-transparent">
        <?php /** Profile Cover Container **/ ?>
        <div id="i3o"
             class="ajaxify"
             data-name="profile_cover"
             data-src="<?= '/profile/cover?user=' . $account->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed');  ?>"
             data-conditions='{"remove_if_no_content":"no","check_for_update":"yes","auto_update":"no","use_data_prospect":"yes"}'>
        </div>
        <?php /** End Profile Cover Container **/ ?>
        <?php /** Start Navigation bar **/ ?>
        <nav class="VH0HTU bg-white border-top pos-r profile-basic-navigator profile-navbar">
            <div class="align-items-center w-100p">
                <div class="profile-nav w-100p">
                    <ul class="w-100p nav nav-tabs border-0 flex-nowrap tlb mx-0">
                        <!--            <div class="card">
                                        <div class="list-group list-group-flush">-->
                        <?php foreach ($accountNav as $key => $array): ?>
                            <li class="e__nav-item _gH7Jzt">
                                <?php
                                $classes = ['nav-link', 'e__nav-link'];
                                //                            $classes = ['list-group-item','list-group-item-action'];
                                $requestPath = strtolower(trim($requestPath, '/'));
                                $url = implode('/', array_values($array['url']));

                                if ($requestPath === strtolower($url)) {
                                    $classes[] = 'active';
                                }
                                ?>
                                <?= $this->Html->link(
                                    __('<span class="TWx">{0}</span>', Inflector::humanize($key)),
                                    Router::normalize($url, ['fullBase' => true]),
                                    [
                                        'class' => implode(' ', $classes),
                                        'data-uri' => '/profile/' . $key . '?user=' . $account->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed'),
                                        'escapeTitle' => false
                                    ]
                                ); ?>
                            </li>
                        <?php endforeach; ?>
                        <!--                </div>
                                    </div>-->
                    </ul>
                </div>
            </div>
        </nav>
        <?php /** End Navigation bar **/ ?>
    </header>
    <div class="row gutters-lg">
        <div id="pagelet" class="PUkr col w_fMGsRw">
            <div class="Vo6f">
                <?php if ($this->fetch('pagelet_top')): ?>
                    <div class="over-head mb-4">
                        <?= $this->fetch('pagelet_top'); ?>
                    </div>
                <?php endif; ?>
                <?php /** Main Content Area **/ ?>
                <div id="pageContent" class="_dzYJed">
                    <?= $this->fetch('content'); ?>
                </div>
                <?php /** End Main Content Area **/ ?>
            </div>
        </div>
        <?php /** Start Sidebar Content **/ ?>
        <aside class="col ml-auto sidebar sidebar-md w_rk2ARF">
            <div class="d7bA">
                <?= $this->fetch('profile_sidedock'); ?>
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
                             data-src="<?= '/suggestions/familiar_users?_dt=i_lookup&user=' . $account->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed');  ?>"
                             data-conditions='{"remove_if_no_content":"no","check_for_update":"yes","auto_update":"no","use_data_prospect":"yes"}'></div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title"><?= __('Interests'); ?></h6>
                        <div id="userInterests"
                             class="ajaxify"
                             data-name="interests"
                             data-src="<?= '/profile/interests?user=' . $account->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed'); ?>"
                             data-conditions='{"remove_if_no_content":"no","check_for_update":"yes","auto_update":"no","use_data_prospect":"yes"}'></div>
                    </div>
                </div>
                <div id="profileRelatedArticles"
                     class="ajaxify"
                     data-name="related_articles"
                     data-src="<?= '/profile/related_articles?user=' . $account->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed');  ?>"
                     data-conditions='{"remove_if_no_content":"no","check_for_update":"yes","auto_update":"no","use_data_prospect":"yes"}'>
                </div>

                <?= $this->element('Widgets/important_links'); ?>
                <?php
                echo RandomString::generateString(20);
                echo '<br>';
                echo RandomString::generateString(6, 'mixed');
                echo '<br>';
                echo RandomString::generateString(4, 'mixed');
                echo '<br>';
                echo RandomString::generateString(3, 'mixed');
                ?>
            </div>
        </aside>
        <?php /** End Sidebar Content **/ ?>
    </div>
<?= $this->element('LayoutElements/layout_bottom'); ?>
