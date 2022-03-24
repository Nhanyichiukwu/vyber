<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $appUser
 */
use Cake\Routing\Router;
use App\Utility\RandomString;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use App\Utility\File;
?>

<div class="user-dashboard">
    <div class="cw-app_user-dashboard p-4"
         style="background-image: url(<?php /*$this->MediaResolver->resolveProfileHeaderImage(
        $appUser->profile->getHeaderImageUrl());*/ ?>);">
        <div class="ajqwjj6r bg-white-glass card e8wksrsz mmhtpn7c profile-card">
            <div class="card-body text-center p-3">
                <div class="mb-4">
                    <div class="">
                        <div class="mb-2">
                    <span class="avatar avatar-xxl"
                          style="background-image: url(<?= $this->Url->assetUrl('img/profile-photos/img_avatar.png')
                          ?>)"></span>
                        </div>
                        <div class="account-name">
                            <a href="<?= Router::url('/' . h($appUser->getUsername()) . '?preview=1&view=hover-card') ?>"
                               class="profile-url load-pop-card c-grey-900 d-block fw-bold lh-sm a3jocrmt">
                                <span class="_LsGU5g"><?= h($appUser->getFullname()) ?></span>
                            </a>
                        </div>
                    </div>
                </div>
                <ul class="activity-counter list-unstyled d-flex fsz-12 justify-content-between">
                    <li class="followers d-grid">
                        <span class="count">
                            <?= $this->Number->format($appUser->connectionsCount()) ?>
                        </span>
                        <?= $this->Html->link(__('<span class="link-text">Connections</span>'),
                            '/my-network/connections',
                            [
                                'class' => '_zeN4uW c-grey-700 cH-grey-900 fw-bold lh_wxx link',
                                'role' => 'link',
                                'escapeTitle' => false
                            ]
                        ); ?>
                    </li>
                    <li class="followers d-grid">
                        <span class="count">
                            <?= $this->Number->format($appUser->followersCount()) ?>
                        </span>
                        <?= $this->Html->link(__('<span class="link-text">Followers</span>'),
                            '/my-network/followers',
                            [
                                'class' => '_zeN4uW c-grey-700 cH-grey-900 fw-bold lh_wxx link',
                                'role' => 'link',
                                'escapeTitle' => false
                            ]
                        ); ?>
                    </li>
                    <li class="followers d-grid">
                        <span class="count">
                            <?= $this->Number->format($appUser->followingsCount()) ?>
                        </span>
                        <?= $this->Html->link(__('<span class="link-text">Followings</span>'),
                            '/my-network/followings',
                            [
                                'class' => '_zeN4uW c-grey-700 cH-grey-900 fw-bold lh_wxx link',
                                'role' => 'link',
                                'escapeTitle' => false
                            ]
                        ); ?>
                    </li>
                </ul>
            </div>
            <footer class="card-footer p-3 text-center">
                <div class="d-flex justify-content-between">
                    <?= $this->Html->link(__('<span class="link-text"><i class="mdi mdi-18px mdi-eye"></i></span>'),
                        '/' . $appUser->getUsername(),
                        [
                            'class' => '_zeN4uW bdrs-20 btn btn-white justify-content-center lzkw2xxp',
                            'role' => 'button',
                            'aria-haspopup' => 'false',
                            'escapeTitle' => false
                        ]
                    ); ?>
                    <?= $this->Html->link(__('<span class="link-text"><i class="mdi mdi-18px mdi-account-edit-outline"></i></span>'),
                        '/settings/profile',
                        [
                            'class' => '_zeN4uW bdrs-20 btn btn-white justify-content-center lzkw2xxp',
                            'role' => 'button',
                            'aria-haspopup' => 'false',
                            'escapeTitle' => false
                        ]
                    ); ?>
                    <?= $this->Html->link(__('<span class="link-text"><i class="mdi mdi-18px mdi-share-variant"></i></span>'),
                        'javascript:void(0)',
                        [
                            'class' => '_zeN4uW bdrs-20 btn btn-white justify-content-center lzkw2xxp',
                            'role' => 'button',
                            'aria-haspopup' => 'false',
                            'data-uri' => Router::url('/' . $appUser->getUsername(), true),
                            'escapeTitle' => false
                        ]
                    ); ?>
                </div>
            </footer>
        </div>
    </div>
    <div class="cw-app_user-navbar px-3">
        <ul id="cw-app_user-nav" class="nav nav-stack flex-column mx-n3">
            <li class="nav-item px-0">
                <a href="<?= Router::url([
                    'controller' => 'activities',
                    'action' => 'my-activities',
                ]) ?>"
                   class="nav-link w-100 px-0" title="Activities">
                    <x-cw-flex-box class="flex-mat bzakvszf
                    cH-grey-900 lh_w4J px-4 py-2 w-100 wsnuxou6">
                        <cw-icon class="cw-app_user-nav_icon icon icon-prepend
                        link-icon fe fe-activity"></cw-icon>
                        <cw-inline-span class="cw-app_user-nav_title cw-app_link_title
                        nav-link-label">Activities</cw-inline-span>
                    </x-cw-flex-box>
                </a>
            </li>
            <li class="nav-item px-0">
                <a href="<?= Router::url([
                    'controller' => 'events',
                    'action' => 'my-events',
                ]) ?>"
                   class="nav-link w-100 px-0" title="My Events">
                    <x-cw-flex-box class="flex-mat bzakvszf
                    cH-grey-900 lh_w4J px-4 py-2 w-100 wsnuxou6">
                        <cw-icon class="cw-app_user-nav_icon icon icon-prepend
                        link-icon mdi mdi-calendar-month-outline"></cw-icon>
                        <cw-inline-span class="cw-app_user-nav_title cw-app_link_title
                        nav-link-label">My Events</cw-inline-span>
                    </x-cw-flex-box>
                </a>
            </li>
            <li class="nav-item px-0">
                <a href="<?= Router::url([
                    'controller' => 'MyNetwork',
                    'action' => 'connections'
                ]) ?>"
                   class="nav-link w-100 px-0" title="Connections">
                    <x-cw-flex-box class="flex-mat bzakvszf
                    cH-grey-900 lh_w4J px-4 py-2 w-100 wsnuxou6">
                        <cw-icon class="cw-app_user-nav_icon icon icon-prepend
                        link-icon icofont-users-alt-3"></cw-icon>
                        <cw-inline-span class="cw-app_user-nav_title cw-app_link_title
                        nav-link-label">Connections</cw-inline-span>
                    </x-cw-flex-box>
                </a>
            </li>
            <li class="nav-item px-0">
                <a href="<?= Router::url([
                    'controller' => 'MyNetwork',
                    'action' => 'followers'
                ]) ?>"
                       class="nav-link w-100 px-0" title="Followers">
                    <x-cw-flex-box class="flex-mat bzakvszf
                    cH-grey-900 lh_w4J px-4 py-2 w-100 wsnuxou6">
                        <cw-icon class="cw-app_user-nav_icon icon icon-prepend
                        link-icon mdi mdi-account-multiple"></cw-icon>
                        <cw-inline-span class="cw-app_user-nav_title cw-app_link_title
                        nav-link-label">Followers</cw-inline-span>
                    </x-cw-flex-box>
                </a>
            </li>
            <li class="nav-item px-0">
                <a href="<?= Router::url([
                    'controller' => 'MyNetwork',
                    'action' => 'followings'
                ]) ?>"
                   class="nav-link w-100 px-0" title="Followings">
                    <x-cw-flex-box class="flex-mat bzakvszf
                    cH-grey-900 lh_w4J px-4 py-2 w-100 wsnuxou6">
                        <cw-icon class="cw-app_user-nav_icon icon icon-prepend
                        link-icon mdi mdi-account-multiple-outline"></cw-icon>
                        <cw-inline-span class="cw-app_user-nav_title cw-app_link_title
                        nav-link-label">Followings</cw-inline-span>
                    </x-cw-flex-box>
                </a>
            </li>
            <li class="separator border-bottom">
                <x-cw-block-span class="mb-0 py-2 px-4 fw-normal fsz-20 text-muted-dark">Libraries</x-cw-block-span>
            </li>
            <li class="nav-item px-0">
                <a href="<?= Router::url('/' . $appUser->getUsername() . '/photos') ?>"
                   class="nav-link w-100 px-0" title="My Photos">
                    <x-cw-flex-box class="flex-mat bzakvszf
                    cH-grey-900 lh_w4J px-4 py-2 w-100 wsnuxou6">
                        <x-cw-icon class="cw-app_user-nav_icon icon icon-prepend
                        link-icon icofont-image"></x-cw-icon>
                        <x-cw-inline-span class="cw-app_user-nav_title cw-app_link_title
                        nav-link-label">My Photos</x-cw-inline-span>
                    </x-cw-flex-box>
                </a>
            </li>
            <li class="nav-item px-0">
                <a href="<?= Router::url('/' . $appUser->getUsername() . '/videos') ?>"
                   class="nav-link w-100 px-0" title="My Videos">
                    <x-cw-flex-box class="flex-mat bzakvszf
                    cH-grey-900 lh_w4J px-4 py-2 w-100 wsnuxou6">
                        <cw-icon class="cw-app_user-nav_icon icon icon-prepend
                        link-icon icofont-video-alt"></cw-icon>
                        <cw-inline-span class="cw-app_user-nav_title cw-app_link_title
                        nav-link-label">My Videos</cw-inline-span>
                    </x-cw-flex-box>
                </a>
            </li>
            <li class="nav-item px-0">
                <a href="<?= Router::url([
                    'controller' => 'Music',
                    'action' => 'my-music'
                ]) ?>"
                   class="nav-link w-100 px-0" title="My Music">
                    <x-cw-flex-box class="flex-mat bzakvszf
                    cH-grey-900 lh_w4J px-4 py-2 w-100 wsnuxou6">
                        <cw-icon class="cw-app_user-nav_icon icon icon-prepend
                        link-icon icofont-music"></cw-icon>
                        <cw-inline-span class="cw-app_user-nav_title cw-app_link_title
                        nav-link-label">My Music</cw-inline-span>
                    </x-cw-flex-box>
                </a>
            </li>
            <li class="nav-item px-0">
                <a href="<?= Router::url([
                    'controller' => 'Movies',
                    'action' => 'my-movies'
                ]) ?>"
                   class="nav-link w-100 px-0" title="My Movies">
                    <x-cw-flex-box class="flex-mat bzakvszf
                    cH-grey-900 lh_w4J px-4 py-2 w-100 wsnuxou6">
                        <cw-icon class="cw-app_user-nav_icon icon icon-prepend
                        link-icon mdi mdi-movie-open-outline"></cw-icon>
                        <cw-inline-span class="cw-app_user-nav_title cw-app_link_title
                        nav-link-label">My Movies</cw-inline-span>
                    </x-cw-flex-box>
                </a>
            </li>
            <li class="nav-item px-0">
                <a href="<?= Router::url('/' . $appUser->getUsername() . '/recent-plays'); ?>"
                   class="nav-link w-100 px-0" title="History">
                    <x-cw-flex-box class="flex-mat bzakvszf
                    cH-grey-900 lh_w4J px-4 py-2 w-100 wsnuxou6">
                        <cw-icon class="cw-app_user-nav_icon icon icon-prepend
                        link-icon icofont-history"></cw-icon>
                        <cw-inline-span class="cw-app_user-nav_title cw-app_link_title
                        nav-link-label">History</cw-inline-span>
                    </x-cw-flex-box>
                </a>
            </li>
            <li class="nav-item px-0">
                <a href="<?= Router::url('/' . $appUser->getUsername() . '/playlists'); ?>"
                   class="nav-link w-100 px-0" title="Playlists">
                    <x-cw-flex-box class="flex-mat bzakvszf
                    cH-grey-900 lh_w4J px-4 py-2 w-100 wsnuxou6">
                        <cw-icon class="cw-app_user-nav_icon icon icon-prepend
                        link-icon mdi mdi-playlist-play"></cw-icon>
                        <cw-inline-span class="cw-app_user-nav_title cw-app_link_title
                        nav-link-label">Playlists</cw-inline-span>
                    </x-cw-flex-box>
                </a>
            </li>
            <li class="separator border-bottom">
                <x-cw-block-span class="mb-0 py-2 px-4 fw-normal fsz-20 text-muted-dark">Subscriptions</x-cw-block-span>
            </li>
        </ul>
    </div>
</div>

