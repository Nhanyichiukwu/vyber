<?php if (count($peopleYouMayKnow)): ?>
    <ul class="people-list unstyled">
    <?php foreach ($peopleYouMayKnow as $someoneYouMayKnow): ?>
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
<?php endif; ?>