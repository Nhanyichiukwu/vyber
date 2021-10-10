<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
use Cake\Routing\Router;
use App\Utility\RandomString;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use App\Utility\File;


//$this->loadHelper('MediaResolver');
?>
<div class="border-0 card card-profile rounded-0 shadow-none">
    <div class="card-header qjX h_LjH0" style="background: url(<?=
    $this->MediaResolver->resolveProfileHeaderImage(
        $user->profile->getHeaderImageUrl()
    ); ?>) center center;"></div>
    <div class="card-body text-center p-3">
        <div class="mb-4 mt-n5">
            <div class="mx-n2">
                <div class="mb-2">
                    <span class="avatar avatar-xxl"
                          style="background-image: url(<?= $this->Url->assetUrl('img/profile-photos/img_avatar.png')
                          ?>)"></span>
                </div>
                <div class="">
                    <h4 class=""><span class="_LsGU5g"><?= h($user->getFullname()) ?></span></h4>
                </div>
            </div>
        </div>
        <div class="fsz-16 activity-counter text-left">
            <div class="followers d-flex px-3 bgcH-grey-200 py-1 justify-content-between mb-2">
                <?= $this->Html->link(__('<span class="link-icon mr-3"><i class="mdi mdi-18px mdi-account-group"></i></span> <span class="link-text">Connections</span>'),
                    '/' . $user->getUsername() . '/connections',
                    [
                        'class' => 'link _zeN4uW c-grey-600 cH-grey-800 lh_wxx',
                        'role' => 'link',
                        'escapeTitle' => false
                    ]
                ); ?>
                <span class="badge badge-default badge-pill count lh_wxx"><?= $this->Number->format($user->connectionsCount()) ?></span>
            </div>
            <div class="followers d-flex px-3 bgcH-grey-200 py-1 justify-content-between mb-2">
                <?= $this->Html->link(__('<span class="link-icon mr-3"><i class="mdi mdi-18px mdi-account-arrow-left"></i></span> <span class="link-text">Followers</span>'),
                    '/' . $user->getUsername() . '/followers',
                    [
                        'class' => 'link _zeN4uW c-grey-600 cH-grey-800 lh_wxx',
                        'role' => 'link',
                        'escapeTitle' => false
                    ]
                ); ?>
                <span class="badge badge-default badge-pill count lh_wxx"><?= $this->Number->format($user->followersCount()) ?></span>
            </div>
            <div class="followers d-flex px-3 bgcH-grey-200 py-1 justify-content-between mb-2">
                <?= $this->Html->link(__('<span class="link-icon mr-3"><i class="mdi mdi-18px mdi-account-arrow-right"></i></span> <span class="link-text">Followings</span>'),
                    '/' . $user->getUsername() . '/followings',
                    [
                        'class' => 'link _zeN4uW c-grey-600 cH-grey-800 lh_wxx',
                        'role' => 'link',
                        'escapeTitle' => false
                    ]
                ); ?>
                <span class="badge badge-default badge-pill count lh_wxx"><?= $this->Number->format($user->followingsCount()) ?></span>
            </div>
            <div>
                <?php
                $menuID = RandomString::generateString(8, 'mixedalpha');
                ?>
                <div id="<?= $menuID ?>" class="hidden-details collapsable collapse">
                    <div class="followers d-flex px-3 bgcH-grey-200 py-1 justify-content-between mb-2">
                        <?= $this->Html->link(__('<span class="link-icon mr-3"><i class="mdi mdi-18px mdi-email"></i></span> <span class="link-text">Messages</span>'),
                            '/messages',
                            [
                                'class' => 'link _zeN4uW c-grey-600 cH-grey-800 lh_wxx',
                                'role' => 'link',
                                'escapeTitle' => false
                            ]
                        ); ?>
                        <span class="badge badge-default badge-pill count lh_wxx"><?= $this->Number->format($user->followingsCount()) ?></span>
                    </div>
                </div>
                <div class="" data-toggle="collapse" data-target="#<?= $menuID ?>" role="button" aria-haspopup="false">
                    <div class="_5MsrQ5 bgcH-grey-200 justify-content-between px-3 py-1 d-flex _w5w">
                        <span class="_zeN4uW">Expand</span>
                        <span class=""><i class="mdi mdi-chevron-down mdi-18px"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="card-footer p-3 text-center">
        <div class="btn-group-sm">
            <?= $this->Html->link(__('<span class="link-text"><i class="mdi mdi-18px mdi-eye"></i></span>'),
                '/' . $user->getUsername(),
                [
                    'class' => '_zeN4uW bdrs-20 btn btn-azure d-inline-flex justify-content-center align-items-center wh_30',
                    'role' => 'button',
                    'aria-haspopup' => 'false',
                    'escapeTitle' => false
                ]
            ); ?>
            <?= $this->Html->link(__('<span class="link-text"><i class="mdi mdi-18px mdi-account-edit-outline"></i></span>'),
                '/settings/profile',
                [
                    'class' => '_zeN4uW bdrs-20 btn btn-azure d-inline-flex justify-content-center align-items-center wh_30',
                    'role' => 'button',
                    'aria-haspopup' => 'false',
                    'escapeTitle' => false
                ]
            ); ?>
            <?= $this->Html->link(__('<span class="link-text"><i class="mdi mdi-18px mdi-share-variant"></i></span>'),
                'javascript:void(0)',
                [
                    'class' => '_zeN4uW bdrs-20 btn btn-green d-inline-flex justify-content-center align-items-center wh_30',
                    'role' => 'button',
                    'aria-haspopup' => 'false',
                    'data-uri' => Router::url('/' . $user->getUsername(), true),
                    'escapeTitle' => false
                ]
            ); ?>
        </div>
    </footer>
</div>

