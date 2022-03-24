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
$this->set('page_title', 'Connections');

$this->element('App/page_header');
?>

<div class="content p-3 px-md-0">
    <div class="_M22YBE flex-wrap row row-cols-2 row-cols-lg-5 row-cols-md-4 row-cols-sm-5">
        <?php foreach ($connections as $connection): ?>
            <div class="col">
                <div class="_oFb7Hd nYJsFM nYJsFM-lg nYJsFM-md card xoj5za5y">
                    <div class="card-header yhbirx ebhwdzhs bg-light" style="background-image: url
                (demo/photos/eberhard-grossgasteiger-311213-500.jpg);"></div>
                    <div class="ybzbve p-2 text-center">
                        <img class="nYJsFM-img avatar avatar-xxl" src="<?= $this->Url->assetUrl('img/profile-photos/img_avatar.png')
                        ?>">
                        <h6 class="profile-name">
                            <a href="<?= Router::url('/'. h($connection->getUsername())) ?>">
                        <span class="d-block">
                            <?= Text::truncate(
                                h($connection->getFullName()),
                                20
                            ); ?>
                        </span>
                            </a>
                        </h6>
                        <?php if (!$connection->isEmpty('description')): ?>
                        <div class="fsz-12 lh_f5 mb-3">
                            <?= Text::truncate(
                                h($connection->profile->getDescription()),
                                30
                            ); ?>
                        </div>
                        <?php endif; ?>
                        <div class="mt-auto actionable n1ft4jmn qrfe0hvl">
                            <?php if (isset($user) && $user->isConnectedTo($connection)): ?>
                                <?= $this->element('App/buttons/connection_disconnect_btn', ['account' => $connection]); ?>
                            <?php elseif (isset($user) && $connection->hasPendingInvitation($user)): ?>
                                <?= $this->element('App/buttons/connection_cancel_btn', ['account' => $connection]); ?>
                            <?php elseif (isset($user) && $user->hasPendingInvitation($connection)): ?>
                                <div class="col"><?= $this->element('App/buttons/connection_confirm_btn', ['account' =>
                                        $connection]);
                                    ?></div>
                                <div class="col"><?= $this->element('App/buttons/connection_reject_btn', ['account' =>
                                        $connection]);
                                    ?></div>
                            <?php else: ?>
                                <?= $this->element('App/buttons/connection_invite_btn', ['account' => $connection]); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
