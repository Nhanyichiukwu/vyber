<?php
/**
 * @var \App\View\AppView $this
 * @var array $users
 */

use Cake\Routing\Router;
use Cake\Utility\Text;
?>
<div class="flex-nowrap flex-row foa3ulpk mgriukcz n1ft4jmn ofx-auto pl-3 tvdg2pcc">
    <?php foreach ($users as $account): ?>
    <div class="col-5 col-md-2 col-sm-3">
        <div class="card nYJsFM nYJsFM-md nYJsFM-lg xoj5za5y _oFb7Hd mb-0">
            <div class="card-header yhbirx ebhwdzhs bg-yellow" style="background-image: url
            (demo/photos/eberhard-grossgasteiger-311213-500.jpg);"></div>
            <div class="card-body p-2 text-center">
                <img class="avatar avatar-xxl nYJsFM-img"
                     src="<?= $this->Url->assetUrl('img/profile-photos/img_avatar.png')
                ?>">
                <div class="d-flex flex-column tck5ivv0">
                    <h6 class="profile-name">
                        <a href="<?= Router::url('/' . h($account->getUsername())) ?>" class="d-block _zeN4uW">
                        <span class="dfv1l4">
                            <?= Text::truncate(
                                h($account->getFullName()),
                                20
                            ); ?>
                        </span>
                        </a>
                    </h6>
                    <?php if (!$account->profile->isEmpty('about')): ?>
                        <div class="fsz-12 lh_f5 mb-3">
                            <?= Text::truncate(
                                h($account->profile->about),
                                30
                            ); ?>
                        </div>
                    <?php endif; ?>
                    <div class="mt-auto actionable n1ft4jmn qrfe0hvl">
                        <?php if (isset($user) && $user->isConnectedTo($account)): ?>
                            <?= $this->element('App/buttons/connection_disconnect_btn', ['account' => $account]); ?>
                        <?php elseif (isset($user) && $account->hasPendingInvitation($user)): ?>
                            <?= $this->element('App/buttons/connection_cancel_btn', ['account' => $account]); ?>
                        <?php elseif (isset($user) && $user->hasPendingInvitation($account)): ?>
                            <div class="col"><?= $this->element('App/buttons/connection_confirm_btn', ['account' =>
                                    $account]);
                            ?></div>
                            <div class="col"><?= $this->element('App/buttons/connection_reject_btn', ['account' =>
                                    $account]);
                            ?></div>
                        <?php else: ?>
                            <?= $this->element('App/buttons/connection_invite_btn', ['account' => $account]); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
