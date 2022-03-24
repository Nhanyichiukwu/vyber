<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $connection
 */
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\Routing\Router;
use Cake\Utility\Text;
use Cake\Utility\Inflector;
use Cake\Utility\Security;
?>
<?php
$this->enablePageHeader();
$this->pageTitle('Connections');
//
//$this->element('App/page_header');
?>

<?php $this->start('header_widget'); ?>
<div class="dropdown">
    <button 
        class="btn btn-sm btn-default btn-icon text-gray"
        data-bs-toggle="dropdown">
        <cw-icon class="fe fe-settings fsz-16"></cw-icon>
    </button>
    <div class="dropdown-menu">
        ...
    </div>
</div>
<?php $this->end(); ?>

<div class="connections mx-n3">
    <div class="list-group list-group-flush">
        <?php foreach ($connections as $connection): ?>
            <div class="border-bottom list-group-item list-group-item-action px-2 px-md-3">
                <x-cw-flex-box class="_oFb7Hd flex-nowrap gutters-sm row">
                    <div class="col-auto">
                        <span class="avatar avatar-lg"
                          style="background-image: url(<?= $this->Url->assetUrl
                          ('img/profile-photos/img_avatar.png')
                          ?>)"></span>
                    </div>      
                    <div class="col">
                        <x-cw-flex-box class="flex-nowrap gutters-xs h-100 q3ywbqi8 row">
                            <div class="user-info col o44ladgt lh-1">
                                <h6 class="mb-0 profile-name x40udu9v">
                                    <a href="<?= Router::url('/'. h($connection->getUsername())) ?>" class="d-inline a3jocrmt">
                                        <span class="d-inline">
                                            <?= h($connection->getFullName()); ?>
                                        </span>
                                    </a>
                                </h6>
                                <?php if (count($connection->profile->getRoles())): ?>
                                    <div class="meta-data">
                                        <x-cw-inline-block class="bzakvszf flex-mat w-100 wsnuxou6 text-gray">
                                            <cw-inline-span class="cw-app_user-nav_title cw-app_link_title
                                    nav-link-label x40udu9v"><?= $connection->profile->getRolesAsString() ?></cw-inline-span>
                                        </x-cw-inline-block>
                                    </div>
                                <?php endif; ?>
                                <?php if (!$connection->isEmpty('description')): ?>
                                    <div class="fsz-12 lh_f5 mb-3">
                                        <?= Text::truncate(
                                            h($connection->profile->getDescription()),
                                            30
                                        ); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="actionable mo68r2ly col-auto align-self-start">
                                <div class="mt-auto n1ft4jmn qrfe0hvl">
                                    <?php if (isset($appUser) && $appUser->isConnectedTo($connection)): ?>
                                        <?= $this->element('App/buttons/connection_disconnect_btn', ['account' => $connection]); ?>
                                    <?php elseif (isset($appUser) && $connection->hasPendingInvitation($appUser)): ?>
                                        <?= $this->element('App/buttons/connection_cancel_btn', ['account' => $connection]); ?>
                                    <?php elseif (isset($appUser) && $appUser->hasPendingInvitation($connection)): ?>
                                        <div class="col"><?= $this->element('App/buttons/connection_confirm_btn', ['account' =>
                                                $connection]);
                                            ?></div>
                                        <div class="col"><?= $this->element('App/buttons/connection_reject_btn', ['account' =>
                                                $connection]);
                                            ?></div>
                                    <?php elseif(isset($appUser)): ?>
                                        <?= $this->element('App/buttons/connection_invite_btn', ['account' => $connection]); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </x-cw-flex-box>
                    </div>
                </x-cw-flex-box>
            </div>
        <?php endforeach; ?>
    </div>
</div>
