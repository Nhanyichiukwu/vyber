<?php
/**
 * @var \App\View\AppView $this ;
 */

use Cake\Routing\Router;
use Cake\Utility\Text;

?>

<div class="section-body p-3 border-top">
    <?php if (isset($users) && $users->count() > 0): ?>
<!--    <div class="dwbzcbar flex-nowrap flex-row foa3ulpk mgriukcz n1ft4jmn ofx-auto pl-3 tvdg2pcc">-->
    <div class="row row-cols-3 row-cols-md-6">
        <?php foreach ($users as $user): ?>
<!--        <div class="col-5 col-lg-1 col-md-2 col-sm-3 muilk3da">-->
        <div class="auto-col">
            <div class="oxemcjsk user-circle text-center mb-3">
                <span class="avatar avatar-xxl mb-2"
                      style="background-image: url(<?= $this->Url->assetUrl('img/profile-photos/img_avatar.png')
                ?>)"></span>
                <h6 class="account-name mb-0">
                    <a href="<?= Router::url('/' . $user->getUsername()) ?>"
                       class="d-block fsz-12 lh_f5 text-break text-dark text-wrap"><?=
                        Text::truncate($user->getFullName(), 18);
                    ?></a>
                </h6>
                <div class="profile-details">
                    <a href="<?= Router::url('/' . $user->getUsername()) ?>"
                       class="d-block lh-1 small text-muted-dark">
                        <span class="small _ah49Gn">@<?=
                            Text::truncate($user->getUsername(), 10, ['ellipsis' => '']);
                        ?></span>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <!--<div class="col-4 col-lg-1 col-md-1 col-sm-2 muilk3da">
            <div class="oxemcjsk">
                        <span class="avatar avatar-xxl"
                              style="background-image: url(./demo/faces/female/29.jpg)"></span>
            </div>
        </div>
        <div class="col-4 col-lg-1 col-md-1 col-sm-2 muilk3da">
            <div class="oxemcjsk">
                        <span class="avatar avatar-xxl"
                              style="background-image: url(./demo/faces/female/29.jpg)"></span>
            </div>
        </div>
        <div class="col-4 col-lg-1 col-md-1 col-sm-2 muilk3da">
            <div class="oxemcjsk">
                        <span class="avatar avatar-xxl"
                              style="background-image: url(./demo/faces/female/29.jpg)"></span>
            </div>
        </div>
        <div class="col-4 col-lg-1 col-md-1 col-sm-2 muilk3da">
            <div class="oxemcjsk">
                        <span class="avatar avatar-xxl"
                              style="background-image: url(./demo/faces/female/29.jpg)"></span>
            </div>
        </div>-->
    </div>
    <?php else: ?>
    <div class="text-center text-muted">Sorry, we couldn't find any <?= $content ?> matching your query.</div>
    <?php endif; ?>
</div>
