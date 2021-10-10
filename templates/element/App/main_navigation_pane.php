<?php

/**
 *
 */
use Cake\Routing\Router;
use Cake\Core\Configure;
use App\Utility\RandomString;
?>

<div class="_vYaq _viG">
<?php if ($this->get('activeUser')): ?>
    <div class="">
        <ul id="mainmenu" class="flex-fill nav navbar-nav pos-r" role="menu">
                <?php
                $currentPage = $this->getRequest()->getAttribute('here');
                foreach ($this->Navigation->getMenu('main_menu') as $keyIndex => $menuitem):
                    $menuitem = (object) $menuitem;
                    $menuItemHref = Router::url(['controller' => $menuitem->controller, 'action' => $menuitem->action]);
                ?>
                <?php
                $active = '';

                if (rtrim($currentPage, '/') === $menuItemHref) {
                    $active = ' active';
                }
                ?>
            <li class="nav-item px-0<?= $active ?>">
                    <?= $this->Html->link(__('<span class="link-icon mr-4"><i class="mdi ' . (property_exists($menuitem,
                            'icon') ? $menuitem->icon : '') . ' mdi-24px"></i> </span> '
                            . '<span class="link-text _fw5Hu">' . (property_exists($menuitem, 'title') ? ucfirst($menuitem->title) : ucfirst($menuitem->controller)) . '</span>'),
                            Router::url(['controller' => $menuitem->controller, 'action' => $menuitem->action], true),
                            [
                                'class' => 'bgcH-grey-300 flex-fill font-weight-normal nav-link px-3 py-2 text-dark',
                                'escapeTitle' => false
                            ]
                    ) ?>
            </li>
                <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
</div>
<div class="_27b9uW _uXY7 _3og border-top _qRwCre _viG">
    <div class="px-4 py-2 _viG">
    <?php if ($this->get('activeUser')): ?>
        <div class="_viG align-items-center clearfix d-inline-flex">
            <div class="avatar avatar-md"></div>
            <div class="col _fw5Hu">
                <div class="lh_f5  small">
                    <span><?= $user->getFullName() ?></span>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="btn-group btn-group-sm">
            <?= $this->Html->link(__('Login'), 'login', [
                'class' => 'btn btn-primary',
            ]); ?>
        </div>
    <?php endif; ?>
    </div>
</div>

