<?php
/**
 * @var App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
use App\Utility\RandomString;
use Cake\Routing\Router;
?>

<div class="profile-widget">
    <div class="h_LjH0 qjX" style="background: url(<?=
    $this->MediaResolver->resolveProfileHeaderImage(
        $user->profile->getHeaderImageUrl()
    ); ?>) center center;"></div>
    <div class="mb-4 mt--6 px-4">
        <div class="d-flex align-items-end">
            <div class="mr-3 mb-2">
                    <span class="avatar avatar-xxl h-8 w-8"
                          style="background-image: url(<?= $this->Url->assetUrl('img/profile-photos/img_avatar.png')
                          ?>)"></span>
            </div>
            <div class="">
                <h4 class="mb-0"><span class="_LsGU5g"><?= h($user->getFullname()) ?></span></h4>
            </div>
        </div>
    </div>
</div>
<ul class="unstyled p-0 fsz-16 mx--3">
    <li class="p-3 text-center">
        <div class="btn-group-sm d-flex justify-content-center">
            <div class="col-auto">
                <?= $this->Html->link(__('<span class="link-text"><i class="mdi mdi-18px mdi-eye"></i></span>'),
                    '/' . $user->getUsername(),
                    [
                        'class' => '_zeN4uW bdrs-20 btn btn-azure d-inline-flex justify-content-center align-items-center wh_30',
                        'role' => 'button',
                        'aria-haspopup' => 'false',
                        'escapeTitle' => false
                    ]
                ); ?>
            </div>
            <div class="col-auto">
                <?= $this->Html->link(__('<span class="link-text"><i class="mdi mdi-18px mdi-account-edit-outline"></i></span>'),
                    '/settings/profile',
                    [
                        'class' => '_zeN4uW bdrs-20 btn btn-azure d-inline-flex justify-content-center align-items-center wh_30',
                        'role' => 'button',
                        'aria-haspopup' => 'false',
                        'escapeTitle' => false
                    ]
                ); ?>
            </div>
            <div class="col-auto">
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
        </div>
    </li>
    <li role="separator" class="dropdown-divider my-0"></li>
    <?php /*
    <li>
        <a href="<?= Router::url('/i/' . $user->getUsername(), true) ?>"
           class="bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none">
            <icon class="d-inline-block mr-4"><i class="icon mdi mdi-account-circle-outline mdi-18px"></i></icon>
            <div class="d-inline-block">
                <span class="d-block fsz-def">View Profile</span>
            </div>
        </a>
    </li>
    */ ?>
    <li>
        <a href="<?= Router::url('/activities/my-activities', true) ?>"
           class="bgcH-grey-100 c-grey-700 d-flex px-4 py-2 td-n text-decoration-none">
            <icon class="d-inline-block mr-4"><i class="icon mdi mdi-account-clock-outline mdi-18px"></i></icon>
            <div class="d-inline-block">
                <span class="d-block fsz-def">Recent Activities</span>
            </div>
        </a>
    </li>
    <li role="separator" class="dropdown-divider my-0"></li>
    <li>
        <a href="<?= Router::url('/events/my-events', true) ?>"
           class="bgcH-grey-100 c-grey-700 d-flex px-4 py-2 td-n text-decoration-none">
            <icon class="d-inline-block mr-4"><i class="icon mdi mdi-calendar-clock mdi-18px"></i></icon>
            <div class="d-inline-block">
                <span class="d-block fsz-def">My Events</span>
            </div>
        </a>
    </li>
    <li role="separator" class="dropdown-divider my-0"></li>
    <li>
        <a href="<?= Router::url('/i/' . $user->getUsername() . '/interactions', true) ?>"
           class="bgcH-grey-100 c-grey-700 d-flex px-4 py-2 td-n text-decoration-none">
            <icon class="d-inline-block mr-4"><i class="icon mdi mdi-comment-text-multiple-outline mdi-18px"></i></icon>
            <div class="d-inline-block">
                <span class="d-block fsz-def">Interactions</span>
            </div>
        </a>
    </li>
    <li role="separator" class="dropdown-divider my-0"></li>
    <li>
        <a href="<?= Router::url('/settings', true) ?>"
           class="bgcH-grey-100 c-grey-700 d-flex px-4 py-2 td-n text-decoration-none">
            <icon class="d-inline-block mr-4"><i class="icon mdi mdi-cog mdi-18px"></i></icon>
            <div class="d-inline-block">
                <span class="d-block fsz-def">Settings</span>
            </div>
        </a>
    </li>
    <li role="separator" class="dropdown-divider my-0"></li>
    <li>
        <?= $this->Form->postLink(__('<icon class="d-inline-block mr-4">
                    <i class="icon mdi mdi-logout mdi-18px"></i></icon>
                <div class="d-inline-block">
                    <span class="d-block fsz-def">Logout</span>
                </div>'),
            [
                'controller' => 'auth',
                'action' => 'logout'
            ],
            [
                'class' => 'bgcH-grey-100 c-grey-700 d-flex px-4 py-2 td-n text-decoration-none',
                'escapeTitle' => false,
                'fullBase' => true
            ]); ?>
    </li>
</ul>
