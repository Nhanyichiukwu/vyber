<?php
/**
 * @var \App\View\AppView $this
 * @var array $users
 */

use Cake\Routing\Router;
use Cake\Utility\Text;
?>
<?php foreach ($users as $account): ?>
    <div class="col">
        <div class="_oFb7Hd nYJsFM card _UxaA nYJsFM-lg nYJsFM-md qYakgu xoj5za5y">
            <div class="BTkvJF _Y7wf _qRwCre _wf7p m-1 object-remove">
                <?php
                $data = [
                    'what' => 'profile',
                    'from' => 'suggestion',
                    'account_id' => $account->refid
                ];
                ?>
                <?= $this->Form->postLink(__('<i class="mdi mdi-close"></i>'), [
                    'controller' => 'postback',
                    'action' => 'remove'
                ], [
                    'data' => $data,
                    'escapeTitle' => false,
                    'class' => 'bgc-grey-300 bgcH-grey-500 box-square-2 btn
                        btn-sm bx cH-grey-100 mmhtpn7c n1ft4jmn patuzxjv qrfe0hvl'
                ]); ?>
            </div>
            <div class="bmtch631 ebhwdzhs qYakgu-header yhbirx bg-light" style="background-image: url
                (demo/photos/eberhard-grossgasteiger-311213-500.jpg);"></div>
            <div class="card-body p-2 text-center">
                <img class="xf7itmq2 avatar avatar-xxl mb-2"
                     src="<?= $this->Url->assetUrl('img/profile-photos/img_avatar.png')
                     ?>">
                <div class="d-flex flex-column tck5ivv0">
                    <div class="lh_wxx mb-2 profile-name">
                        <a href="<?= Router::url('/' . h($account->getUsername())) ?>"
                           class="_zeN4uW d-inline-block w-100 text-gray">
                        <span class="x40udu9v">
                            @<?= h($account->getUsername()); ?>
                        </span>
                        </a>
                        <a href="<?= Router::url('/' . h($account->getUsername())) ?>"
                           class="_zeN4uW d-inline-block w-100 text-dark">
                        <span class="x40udu9v">
                            <?= h($account->getFullName()); ?>
                        </span>
                        </a>
                    </div>
                    <?php if (count($account->profile->getRoles())): ?>
                    <div class="user-roles">
                        <?php
                        $userRoles = collection($account->profile->getRoles())->extract('name')->toArray();
                        ?>
                        <x-cw-flex-box class="bzakvszf flex-mat w-100 wsnuxou6 text-gray">
                            <cw-inline-span class="cw-app_user-nav_title cw-app_link_title
                        nav-link-label x40udu9v"><?= Text::toList($userRoles) ?></cw-inline-span>
                        </x-cw-flex-box>
                    </div>
                    <?php endif; ?>
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
                        <?php elseif(isset($user)): ?>
                            <?= $this->element('App/buttons/connection_invite_btn', ['account' => $account]); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
