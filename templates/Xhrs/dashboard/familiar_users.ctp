<?php

/*
 * Widget for People You May know
 */

?>
<?php if (count($familiarUsers)): ?>
<div class="card">
    <div class="card-body">
        <h6 class="afh">People You May Know <small class="fl-r"> . <?=
        $this->Html->link(
                __('See More'),
                [
                    'controller' => 'sugggestions',
                    'action' => 'people',
                    'people-you-may-know'
                ],
                [
                    'class' => 'link',
                ]
                ) ?></small></h6>
        <ul class="people-list unstyled">
            <?php foreach ($familiarUsers as $someoneYouMayKnow): ?>
                <li class="clearfix d-flex py-2">
                    <img class="avatar avatar-lg border-0 fl-l mr-2" src="assets/img/avatar-fat.jpg">
                    <div class="account-info">
                        <p class="account-name d-b lh-1 mb-2"><?= $this->Html->link(
                                __('<strong>' . $this->Text->truncate(h($someoneYouMayKnow->getFullname()), '21', ['ellipsis' => '...']) . '</strong>'),
                                [
                                    'controller' => 'e',
                                    'action' => h($someoneYouMayKnow->username)
                                ],
                                [
                                    'class' => '',
                                    'escapeTitle' => false
                                ]); ?>
                            <?= $this->Html->link(
                                __('<small class="text-muted-dark">@' . h($someoneYouMayKnow->username) . '</small>'),
                                [
                                    'controller' => 'e',
                                    'action' => h($someoneYouMayKnow->username)
                                ],
                                [
                                    'class' => '',
                                    'escapeTitle' => false
                                ]); ?></p>
                        <?= (! empty($someoneYouMayKnow->personality) ? '<p class="about-content-block">' . h($someoneYouMayKnow->about) . '</p>' : ''); ?>
                        <?php if (! empty($someoneYouMayKnow->about) || ! empty($someoneYouMayKnow->location) || ! empty($someoneYouMayKnow->genre)): ?>
                            <div class="meta-data text-small text-muted-dark">
                                <?= (! empty($someoneYouMayKnow->personality) ? '<span class="personality">' . h($someoneYouMayKnow->personality) . '</span>' : ''); ?>
                                <?= (! empty($someoneYouMayKnow->location) ? '<span class="location">' . h($someoneYouMayKnow->location) . '</span>' : ''); ?>
                                <?= (! empty($someoneYouMayKnow->genre) ? '<span class="genre">' . h($someoneYouMayKnow->genre) . '</span>' : ''); ?>
                            </div>
                        <?php endif; ?>
                        <div class="">
                            <a href="javascript:void()" class="btn btn-control-small btn-outline-primary btn-rounded btn-sm pY-2 px-2"
                               data-action="connect" data-url="<?= $this->Url->webroot('/e/' . h($someoneYouMayKnow->refid)); ?>">
                                <span class="mdi mdi-account-plus"></span> Connect</a>
                            <a href="javascript:void()" class="btn btn-control-small btn-danger btn-rounded btn-sm pY-2 px-2">
                                <span class="mdi mdi-cancel"></span> Remove</a>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php endif; ?>
<div class="card">
    <div class="card-body">
        <h6 class="card-title"><?= __('People You May Know') ?></h6>
        <div class="segment sTn"
             data-name="familiar_users"
             data-src="<?= Router::url('/xhrs/fetch_segment/familiar_users?actor=' . $activeUser->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed'));  ?>"
             data-conditions='{"remove_if_no_content":"no","check_for_update":"yes","auto_update":"yes","use_data_prospect":"yes"}'
            >
        </div>
    </div>
</div>