<?php 
/**
 * 
 */
use Cake\Utility\Text;
use Cake\Utility\Inflector;
use Cake\Routing\Router;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
?>
<?php
$imgPath = WWW_ROOT . str_replace('/', DS, 'img/profile-headers/entertainer_profile_cover_image_915x240.jpg');
$file = new File($imgPath, false);
//pr(get_class_methods($file));
//$stream = $file->read();
//$encoded = base64_encode($stream);
$basename = $file->info()['basename'];
$filename = substr($basename, 0, strrpos($basename, '.'));
$dataUri = $this->Url->assetUrl('/media/' . $filename . '?type=photo&role=profile_header&format=' . $file->ext()); 
//'data:image/image/jpeg;base64,' . $encoded;
?>
<!-- Add the bg color to the header using any of the bg-* classes -->
<div class="profile_header_img profile-cover rounded-top" style="background: url(<?= $dataUri ?>)" data-dimensions="840x240" aria-dimension-unit="px" aria-standout-onhover="true">
    <div class="w-100 h-100 d-flex justify-content-between pos-r p-4">
        <?php /** Administrator Action Buttons **/ ?>
        <div class="pos-a-t pos-a-r py-3 px-4">
            <div class="dropdown">
                <a
                    href="javascript:void(0)"
                    data-toggle="dropdown"
                    class="box-square-2 text-white no-after rounded-circle sQrBx text-center text-muted-dark"
                 >
                    <i class="mdi mdi-24px mdi-chevron-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#basicModal" data-uri="<?= Router::url('/settings/profile/image?_type=cover_image&_opt=update&_ref=user_profile') ?>">
                        <i class="dropdown-icon mdi mdi-shape-rectangle-plus"></i> 
                    <?php if ($account->profile->getProfileHeaderImageUrl()): ?>
                        <span class="link-text">Change Cover Image</span>
                    <?php else: ?>
                        <span class="link-text">Add Cover Image</span>
                    <?php endif; ?>
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#basicModal" data-uri="<?= Router::url('/settings/profile/image?_type=cover_image&_opt=edit&_ref=user_profile') ?>">
                        <i class="dropdown-icon mdi mdi-photo-edit"></i> Edit
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)" onclick="requestProfileImageRemoval('cover_image')" data-uri="<?= Router::url('/settings/profile/image?_type=cover_image&_opt=remove&_ref=user_profile') ?>">
                        <i class="dropdown-icon mdi mdi-delete-forever"></i> Remove
                    </a>
<!--                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <i class="dropdown-icon fe fe-help-circle"></i> Need help?
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="dropdown-icon fe fe-log-out"></i> Sign out
                    </a>-->
                </div>
            </div>
        </div>
        
        <?php /** Public Action Buttons **/ ?>
        <div id="profilePublicBasicActions" class="pos-a-r pos-a-b py-3 px-4">
            <ul class="ab list-inline mb-0">
                <li class="list-inline-item">
                    <a href="javascript:void(0)" class="btn btn-outline-light bx bx-rnd h_30 px-3" data-toggle="tooltip" title="Connect">
                        <i class="mdi mdi-account-plus mr-1"></i> 
                        <span class="btn-text">Connect</span>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="javascript:void(0)" class="btn btn-outline-light bx bx-rnd h_30 px-3" data-toggle="tooltip" title="Send Message">
                        <i class="mdi mdi-email-plus mr-1"></i>
                        <span class="btn-text">Message</span>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="javascript:void(0)" class="btn btn-outline-light bx bx-rnd wh_30 px-3" data-toggle="dropdown">
                        <i class="mdi mdi-chevron-down"></i> 
                        <span class="wd btn-text" aria-hidden="true">More</span>
                    </a>
                    <e-dropmenu
                        class="dropdown-menu keep-open dropdown-menu-right dropdown-menu-arrow fsz-sm shadow-lg"
                        data-auto-close="false"
                        >
                        <ul class="unstyled m-0 p-0">
                            <?php if (isset($activeUser)): ?>
                            <li>
                                <?= $this->Form->postLink(__('<icon class="d-inline-block mr-4"><i class="icon mdi mdi-account-star mdi-24px"></i></icon>
                                <div class="d-inline-block">
                                    <span class="d-block fsz-18 fsz-def">Add {firstname} to my favourites.</span>
                                </div>', ['firstname' => $account->getFirstName()]), 
                                    [
                                        'controller' => 'commit',
                                        'action' => 'favourite',
                                        '?' => ['_ref' => 'user_profile_page']
                                    ],
                                    [
                                        'class' => 'bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap',
                                        'data' => ['account' => h($account->getUsername())],
                                        'escapeTitle' => false
                                    ]
                                ); ?>
                            </li>
                                <?php endif; ?>
                            <li>
                                <?= $this->Html->link(__('<icon class="d-inline-block mr-4"><i class="icon mdi mdi-link-variant mdi-24px"></i></icon>
                                    <div class="d-inline-block">
                                        <span class="d-block fsz-18 fsz-def">Copy/Share profile link</span>
                                    </div>'), 
                                        [
                                            'controller' => 'share',
                                            'action' => 'link',
                                            '?' => ['_lt' => 'profile_link', '_acct' => h($account->getUsername()), '_ref' => 'user_profile_page']
                                        ],
                                        [
                                            'class' => 'bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap',
                                            'data-toggle' => 'modal',
                                            'data-target' => '#basicModal',
                                            'escapeTitle' => false
                                        ]
                                    ); ?>
                            </li>
                            <li>
                                <?= $this->Html->link(__('<icon class="d-inline-block mr-4"><i class="icon mdi mdi-bell mdi-24px"></i></icon>
                                    <div class="d-inline-block">
                                        <span class="d-block fsz-18 fsz-def">Notifications Option</span>
                                        <span class="text-muted small">Turn notifications on/off for {firstname}.</span>
                                    </div>', ['firstname' => $account->getFirstName()]), 
                                        [
                                            'controller' => 'settings',
                                            'action' => 'notifications',
                                            '?' => ['option' => 'user_activities','_ref' => $account->getUsername()]
                                        ],
                                        [
                                            'class' => 'bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap',
                                            'data-toggle' => 'modal',
                                            'data-target' => '#basicModal',
                                            'escapeTitle' => false
                                        ]
                                    ); ?>
                            </li>
                            <li>
                                <?= $this->Html->link(__('<icon class="d-inline-block mr-4"><i class="icon mdi mdi-account-switch mdi-24px"></i></icon>
                                    <div class="d-inline-block">
                                        <span class="d-block fsz-18 fsz-def">Introduce to a friend</span>
                                    </div>'), 
                                        [
                                            'controller' => 'commit',
                                            'action' => 'introduce',
                                            '?' => ['_acct' => $account->getUsername(), '_ref' => 'user_profile_page']
                                        ],
                                        [
                                            'class' => 'bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap',
                                            'data-toggle' => 'modal',
                                            'data-target' => '#basicModal',
                                            'escapeTitle' => false
                                        ]
                                    ); ?>
                            </li>
                            <li>
                                <?= $this->Html->link(__('<icon class="d-inline-block mr-4"><i class="icon mdi mdi-male-female mdi-24px"></i></icon>
                                    <div class="d-inline-block">
                                        <span class="d-block fsz-18 fsz-def">Ask to meet</span>
                                    </div>'), 
                                        [
                                            'controller' => 'commit',
                                            'action' => 'meet',
                                            '?' => ['_acct' => $account->getUsername(), '_ref' => 'user_profile_page']
                                        ],
                                        [
                                            'class' => 'bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap',
                                            'data-toggle' => 'modal',
                                            'data-target' => '#basicModal',
                                            'escapeTitle' => false
                                        ]
                                    ); ?>
                            </li>
                                <?php
                                if (isset($activeUser) && !$account->isSameAs($activeUser) && $account->isConnectedTo($activeUser)): ?>
                            <li>
                                <?= $this->Form->postLink(__('<icon class="d-inline-block mr-4"><i class="icon mdi mdi-account-multiple-minus mdi-24px"></i></icon>
                                    <div class="d-inline-block">
                                        <span class="d-block fsz-18 fsz-def">Disconnect</span>
                                        <span class="text-muted small">You won\'t see posts from {firstname} again.</span>
                                    </div>', ['firstname' => $account->getFirstName()]), 
                                        [
                                            'controller' => 'commit',
                                            'action' => 'disconnect',
                                            '?' => ['_ref' => 'user_profile_page']
                                        ],
                                        [
                                            'class' => 'bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap',
                                            'data' => ['account' => $account->getUsername()],
                                            'escapeTitle' => false
                                        ]
                                    ); ?>
                            </li>
                            <li>
                                <?= $this->Form->postLink(__('<icon class="d-inline-block mr-4"><i class="icon mdi mdi-24px mdi-walk"></i></icon>
                                <div class="d-inline-block">
                                    <span class="d-block fsz-18 fsz-def">Unfollow</span>
                                    <span class="text-muted small">You won\'t see any more posts from {firstname} on <br>your timeline, though you\'re still connected.</span>
                                </div>', ['firstname' => $account->getFirstName()]), 
                                    [
                                        'controller' => 'commit',
                                        'action' => 'unfollow_feed',
                                        '?' => ['_ref' => $account->getUsername()]
                                    ],
                                    [
                                        'class' => 'bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap',
                                        'data' => [],
                                        'escapeTitle' => false,
                                        'confirm' => __('Are you sure you want to unfollow {firstname}\'s feed?', ['firstname' => $account->getFirstName()])
                                    ]
                                ); ?>
                            </li>
                                <?php elseif (
                                    isset($profile) &&
                                    isset($activeUser) &&
                                    !$account->isSameAs($activeUser) &&
                                    !$account->isConnectedTo($activeUser->get('refid'))
                                ): ?>
                            <li>
                                <a href="/musicsound/settings" class="bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap">
                                    <icon class="d-inline-block mr-4"><i class="icon mdi mdi-account-remove mdi-24px"></i></icon>
                                    <div class="d-inline-block">
                                        <span class="d-block fsz-18 fsz-def">Add <?= h($account->getFirstName()); ?>'s $timeline to my feed</span>
                                    </div>
                                </a>
                                <?= $this->Form->postLink(__('<icon class="d-inline-block mr-4"><i class="icon mdi mdi-24px mdi-account-check"></i></icon>
                                <div class="d-inline-block">
                                    <span class="d-block fsz-18 fsz-def">Add {firstname}\'s activities to my feed</span>
                                </div>', ['firstname' => $account->getFirstName()]), 
                                    [
                                        'controller' => 'commit',
                                        'action' => 'follow_feed',
                                        '?' => ['_acct' => $account->getUsername(), '_ref' => 'user_profile_page']
                                    ],
                                    [
                                        'class' => 'bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap',
                                        'data' => [],
                                        'escapeTitle' => false,
                                        'confirm' => __('Are you sure you want to unfollow {firstname}\'s feed?', ['firstname' => $account->getFirstName()])
                                    ]
                                ); ?>
                            </li>
                            <?php endif; ?>
                            <li>
                                <?= $this->Html->link(__('<icon class="d-inline-block mr-4"><i class="icon mdi mdi-flag mdi-24px"></i></icon>
                                    <div class="d-inline-block">
                                        <span class="d-block fsz-18 fsz-def">Block or Report {firstname}.</span>
                                        <span class="text-muted small">{firstname} will no longer see you or see posts <br>from you.</span>
                                    </div>', ['firstname' => $account->getFirstName()]), 
                                        [
                                            'controller' => 'settings',
                                            'action' => 'blocking',
                                            '?' => ['_ref' => 'user_profile_page', '_acct' => $account->getUsername()]
                                        ],
                                        [
                                            'class' => 'bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap',
                                            'data' => [],
                                            'escapeTitle' => false
                                        ]
                                    ); ?>
                            </li>
                        </ul>
                    </e-dropmenu>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="bg-white px-4 py-3 rounded-bottom">
    <div class=":shows-engagement-counter :shows-profile-image :shows-user-bio align-items-center basic-account-info row gutters-sm">
        <!--<img class="img-circle" src="../dist/img/user3-128x128.jpg" alt="User Avatar">-->
        <div class="col-auto pos-r R9">
            <span class="align-items-center avatar avatar-red avatar-xxl d-flex justify-content-center profile-photo profile-photo-lg text-center widget-user-image">
                <span class="avatar-text"><?= $this->Text->truncate(h($account->getNameAccronym()), 1, ['ellipsis' => false]); ?></span>
            </span>
        </div>
        <div class="about-profile col">
            <div class="km">
                <div class="cZ">
                    <div class="row justify-content-between gutters-sm">
                        <div class="col w_fMGsRw">
                            <h3 class="profile-account-name"><?= h($account->getFullname()) ?></h3>
                            <?php if ($account->profile->has('about')): ?>
                            <h6 class="font-weight-normal profile-user-desc"><?= h($account->profile->getBio()); ?></h6>
                            <?php endif; ?>
                        </div>
                        <div class="col-auto">
                            <div class="btns">
                                <?= $this->Html->link(__('<i class="btn-icon mdi mdi-pencil"></i> <span class="btn-text">Edit Profile</span>'),
                                        [
                                            'controller' => 'settings',
                                            'action' => 'profile',
                                            '?' => ['_ref' => 'profile_page']
                                        ],
                                        [
                                            'class' => 'btn btn-outline-primary btn-sm',
                                            'escapeTitle' => false
                                        ]);
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer py-4">
                        <div class="row fsz-smaller">
                            <div class="border-right col-auto">
                                <div class="description-block">
                                    <span class="description-header"><?= $this->Number->format($account->postsCount()) ?></span>
                                    <span class="description-text">Posts</span>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="border-right col-auto">
                                <div class="description-block">
                                    <span class="description-header"><?= $this->Number->format($account->followingsCount()) ?></span>
                                    <span class="description-text">Followings</span>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="border-right col-auto">
                                <div class="description-block">
                                    <span class="description-header"><?= $this->Number->format($account->followersCount()) ?></span>
                                    <span class="description-text">Fans</span>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-auto">
                                <div class="description-block">
                                    <span class="description-header"><?= $this->Number->format($account->connectionsCount()) ?></span>
                                    <span class="description-text">Connections</span>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

