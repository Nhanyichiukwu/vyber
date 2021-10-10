<?php

/**
 * @var \App\View\AppView $this
 */
use Cake\Utility\Text;
use Cake\Core\Configure;
use Cake\Utility\Security;
?>
<header class="app-header fixed-top">
    <nav class="navbar flex-nowrap px-5">
        <div class="d-flex ml-n4 px-5 w_upO1RQ align-items-center">
            <div class="brand-identity">
                <?= $this->Html->image('logo.png', ['class' => 'brand-img', 'alt' => Configure::read('Site.name')]); ?>
            </div>
            <div class="pane-toggle ml-auto" aria-controls="side-nav">
                <a class="toggler" href="javascript:void(0);" data-toggle="class" data-classname="side-nav-open" data-target="body">
                    <span class="c-grey-200"><i class="mdi mdi-menu mdi-24px"></i></span>
                </a>
            </div>
        </div>
        <div class="pl-4 pr-8 w_nFj2CN">
            <div class="flex-nowrap gutters-sm justify-content-between row">
                <div class="Sai45L col header-main-search-form w_IsfXJh">
            <?= $this->Form->create(null, ['type' => 'get', 'name' => 'header-basic-search-form', 'class' => 'form-inline w-100']); ?>
                    <div class="input-icon w-100">
                <?= $this->Form->control(__('keyword'), [
                    'templates' => [
                        'inputContainer' => '{{content}}'
                    ],
                    'label' => false,
                    'type' => 'text',
                    'class' => '_ntlK custom-control form-control form-control-md rounded-lg w-100',
                    'placeholder' => 'Search...'
                    ]); ?>
                        <div class="input-icon-addon p-e_All">
                            <button type="submit" class="btn btn-icon btn-sm btn-transparent">
                                <i class="mdi mdi-18px mdi-magnify"></i>
                            </button>
                        </div>
                    </div>
            <?= $this->Form->end(); ?>
                </div>
        <?php if (isset($activeUser)): ?>
                <div class="jPI2bA col-auto ml-auto">
                    <?= $this->element('Widgets/dashboard'); ?>
                </div>
                <div class="col-auto user_tab dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggleno-after" data-toggle="dropdown">
                        <div class="peer"><img class="avatar avatar-placeholder" src="https://randomuser.me/api/portraits/men/10.jpg"></div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-menu-arrow fsz-sm mr-3">
                        <li>
                        <?= $this->Html->link(__('<i class="icon mdi mdi-settings mR-10"></i> <span>Setting</span>'),
                            ['controller' => 'settings', 'action' => 'index'],
                            ['class' => 'd-b td-n pY-5 pX-5 bgcH-grey-100 c-grey-700', 'escapeTitle' => false]
                        ); ?>
                        </li>
                        <li>
                        <?= $this->Html->link(__('<i class="icon mdi mdi-account mR-10"></i> <span>Profile</span>'),
                            ['controller' => 'e', 'action' => h($activeUser->username)],
                            ['class' => 'd-b td-n pY-5 pX-5 bgcH-grey-100 c-grey-700', 'escapeTitle' => false]
                        ); ?>
                        </li>
                        <li>
                        <?= $this->Html->link(__('<i class="icon mdi mdi-email mR-10"></i> <span>Messages</span>'),
                            ['controller' => 'messages', 'action' => 'index'],
                            ['class' => 'd-b td-n pY-5 pX-5 bgcH-grey-100 c-grey-700', 'escapeTitle' => false]
                        ); ?>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                        <?= $this->Form->postLink(__('<i class="icon mdi mdi-power mR-10"></i> <span>Logout</span>'),
                            ['controller' => '/', 'action' => 'logout'],
                            ['class' => 'd-b td-n pY-5 pX-5 bgcH-grey-100 c-grey-700', 'escapeTitle' => false]
                        ); ?>
                        </li>
                    </ul>
                </div>
        <?php else: ?>
                <div class="float-right">
            <?=
            $this->Html->link(__('Login'),
                ['controller' => '/', 'action' => 'login'],
                ['class' => 'btn btn-primary btn-sm']
            );
            ?>
            <?=
            $this->Html->link(__('Signup'),
                ['controller' => '/', 'action' => 'signup'],
                ['class' => 'btn btn-outline-warning btn-sm']
            );
            ?>
                </div>
        <?php endif; ?>
            </div>
        </div>
    </nav>
</header>
