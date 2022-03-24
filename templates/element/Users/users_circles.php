<?php

use Cake\Routing\Router;
use Cake\Utility\Text;

?>
<div class="oxemcjsk user-circle text-center mb-3">
                    <span class="avatar avatar-xxl mb-2"
                          style="background-image: url(<?= $this->Url->assetUrl('img/profile-photos/img_avatar.png')
                          ?>)"></span>

    <x-cw-conpact-renderer>
        <div class="account-name">
            <a href="<?= Router::url('/' . $user->getUsername()) ?>"
               class="d-block lh_wxx text-dark">
                <cw-block-span class="mje8a6nu x40udu9v fade-end"><?= $user->getFullName(); ?></cw-block-span>
            </a>
        </div>
        <div class="profile-details">
            <a href="<?= Router::url('/' . $user->getUsername()) ?>"
               class="d-block lh-1 small text-muted-dark">
                <span class="small _ah49Gn">@<?= $user->getUsername(); ?></span>
            </a>
        </div>
        <?php if (count($user->profile->getRoles())): ?>
            <div class="mb-3">
                <?php
                $userRoles = collection($user->profile->getRoles())->extract('name')->toArray();
                ?>
                <x-cw-flex-box class="bzakvszf flex-mat w-100 wsnuxou6 text-gray fsz-12 x40udu9v fade-end">
                    <cw-inline-span class="cw-app_user-nav_title cw-app_link_title
                            nav-link-label"><?= Text::toList($userRoles) ?></cw-inline-span>
                </x-cw-flex-box>
            </div>
        <?php endif; ?>
        <?php if (isset($appUser)): ?>
            <?= $this->element('App/buttons/connection_invite_btn', ['account' => $user]); ?>
        <?php endif; ?>
    </x-cw-conpact-renderer>

</div>
