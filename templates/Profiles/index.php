<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $appUser
 * @var \App\Model\Entity\User $account
 */

use App\Utility\AjaxMaskedRoutes;
use Cake\Routing\Router;
use App\Utility\RandomString;
use Cake\Utility\Text;
use Cake\Utility\Inflector;

$this->extend('common');
?>
<div class="">
    <section id="cw_profile-featured-contents-section" class="card r8upjl1q _gGsso _4gUj0 _UxaA _jr vllbqapx">
        <div class="card-body p-3">
            <h4 class="section-title card-title">Featured</h4>
            <?= $this->element('Profile/featured', ['actor']) ?>
        </div>
    </section>
    <?php if ((int)$this->cell('Counter::count', [
            'posts', [
                'recent', $account, [
                    'limit' => 5
                ]
            ]
        ])->render() > 0): ?>
    <section id="cw_profile-recent-posts-section" class="card r8upjl1q card-variant section _gGsso _4gUj0 _UxaA _jr vllbqapx">
        <div class="card-body p-3">
            <h4 class="section-title card-title">Recent Posts</h4>
            <?php
            $params = json_encode([
                'resource_handle' => 'posts',
                'resource_path' => 'Profiles/recent_posts'
            ]);

            $token = base64_encode(serialize($params));
            $routeMask = AjaxMaskedRoutes::getRouteMaskFor('Newsfeed');
            $dataSrc = '/' . $routeMask . '/posts?cw_fdr=recent&cw_aid=' . $account->get('refid') . '&token=' . $token;
            $fetchTimeline = json_encode([
                'content' => 'timeline',
                'src' => $dataSrc,
                'remove_if_no_content' => 'no',
                'check_for_update' => 'yes',
                'auto_update' => 'no',
                'use_data_prospect' => 'yes',
                'load_type' => 'overwrite',
            ]);
            ?>
            <div data-request-type="async"
                 class="ajaxify"
                 data-category="main_content"
                 data-config='<?= $fetchTimeline ?>'>
                <?= $this->element('App/loading', ['size' => 'spinner-md']); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <?php
         $options = ['target_user' => $account];
         if (isset($appUser)) {$options['user'] = $appUser;}
         if ((int) $this->cell('Counter::count', [
        'users', ['usersSimilarTo', $options]
        ])->render() > 0):
             ?>
    <section id="cw_profile-similar-accounts-section" class="card r8upjl1q section _gGsso _4gUj0 _UxaA _jr vllbqapx">
        <div class="card-body p-3">
            <?php
            $cardTitle = 'Similar to ' . $account->getFirstName();
            if (isset($appUser) && $appUser->isSameAs($account)) {
                $appUserRoles = collection($account->profile->getRoles())->extract('name')->toArray();
                $roles = Text::toList($appUserRoles);
                $cardTitle = 'People with similar roles as you';
                $description = 'Based on your roles as ' . $roles . ', here are some ' .
                    'persons of interest you might want to connect with or follow.';
            }
            ?>
            <div class="bzakvszf flex-nowrap mb-3 q3ywbqi8 row section-header">
                <div class="col col-md-7">
                    <div class="card-title mb-0 x40udu9v vf2f9n3z"><?= $cardTitle ?></div>
                    <?php if (isset($description)): ?>
                        <div class="text-gray"><?= $description ?></div>
                    <?php endif; ?>
                </div>
                <div class="align-self-start col-auto">
                    <x-cw-context-menu class="d-block">
                        <?= $this->Html->link(
                            __('<cw-icon class="cw-app_user-nav_icon d-inline-block fs-5 lh-1 mdi mdi-dots-horizontal"></cw-icon>'),
                            [
                                'controller' => 'foo',
                                'action' => 'bar',
                            ],
                            [
                                'escapeTitle' => false,
                                'class' => 'text-gray'
                            ]
                        ) ?>
                    </x-cw-context-menu>
                </div>
            </div>
            <?php
            $params = json_encode([
                'resource_handle' => 'users',
                'resource_path' => 'Users/common/users_minimal'
            ]);

            $token = base64_encode(serialize($params));
            $routeMask = AjaxMaskedRoutes::getRouteMaskFor('Suggestion');
            $dataSrc = '/' . $routeMask . '/similar_accounts?cw_acct='
                . $account->getUsername() . '&token=' . $token;
            $fetchTimeline = json_encode([
                'content' => 'similar_accounts',
                'src' => $dataSrc,
                'remove_if_no_content' => 'no',
                'check_for_update' => 'yes',
                'auto_update' => 'yes',
                'use_data_prospect' => 'yes',
                'load_type' => 'overwrite',
            ]);
            ?>
            <div data-request-type="async"
                 class="ajaxify"
                 data-category="main_content"
                 data-config='<?= $fetchTimeline ?>'>
                <?= $this->element('App/loading', ['size' => 'spinner-md']); ?>
            </div>
        </div>
        <div class="card-footer py-1">
            <div class="text-center">
                <?= $this->Html->link(__('See all'), [
                    'controller' => 'people',
                    'action' => 'similar-people',
                    $account->getUsername()
                ],[
                    'class' => '_zeN4uW text-gray-dark u1owkvqx'
                ]) ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <section id="cw_profile-recent-songs-section" class="card r8upjl1q section _gGsso _4gUj0 _UxaA _jr vllbqapx">
        <div class="card-body p-3">
            <div class="row">
                <section class="col-md-6">
                    <div class="xzg02mh0">
                        <h6 class="card-title">Recent Videos</h6>
                        <?= $this->element('Profile/featured', ['actor']) ?>
                    </div>
                </section>
                <section class="col-md-6">
                    <div class="xzg02mh0">
                        <h6 class="card-title">Recent Songs</h6>
                        <?= $this->element('Profile/featured', ['actor']) ?>
                    </div>
                </section>
            </div>
        </div>
    </section>
    <?php if (
        (isset($appUser) && !$appUser->isSameAs($account)) &&
        (int) $this->cell('Counter::count', ['users', [
            'possibleAcquaintances', ['user' => $appUser, 'account' => $account]
        ]])->render() > 0
    ):?>
    <section id="cw_profile-familiar-accounts-section" class="card r8upjl1q section _gGsso _4gUj0 _UxaA _jr vllbqapx">
        <div class="card-body p-3">
            <h6 class="card-title">People You May Know</h6>
            <?php
            $params = json_encode([
            'resource_handle' => 'users',
            'resource_path' => 'Users/common/users_minimal',
            'content' => 'anyone you may know'
            //    'resource_path' => 'element/Users/flex_row'
            ]);

            $token = base64_encode(serialize($params));
            $routeMask = AjaxMaskedRoutes::getRouteMaskFor('Suggestion');
            $dataSrc = '/' . $routeMask . '/people_you_may_know?cw_acct='
            . $account->getUsername() . '&token=' . $token;
            $fetchTimeline = json_encode([
            'content' => 'people_you_may_know',
            'src' => $dataSrc,
            'remove_if_no_content' => 'no',
            'check_for_update' => 'yes',
            'auto_update' => 'no',
            'use_data_prospect' => 'yes',
            'load_type' => 'overwrite',
            ]);
            ?>
            <div data-request-type="async"
                 class="ajaxify"
                 data-category="main_content"
                 data-config='<?= $fetchTimeline ?>'>
                <?= $this->element('App/loading', ['size' => 'spinner-md']); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
</div>
