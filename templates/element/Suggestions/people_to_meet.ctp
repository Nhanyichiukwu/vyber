<?php if (count($peopleToMeet)): ?>
    <div class="people-list user-list-sm">
    <?php foreach ($peopleToMeet as $personToMeet): ?>
        <div class="user clearfix py-2">
            <img class="avatar avatar-lg border-0 fl-l" src="assets/img/avatar-fat.jpg">
            <div class="account-info ml-8" actionable="true">
                <p class="account-name d-b lh-1 mb-2">
                <?= $this->Html->link(
                        __('<strong>' . $this->Text->truncate(h($personToMeet->getFullname()), '21', ['ellipsis' => '...']) . '</strong>'),
                        [
                            'controller' => 'e',
                            'action' => h($personToMeet->getUsername())
                        ],
                        [
                            'class' => '',
                            'escapeTitle' => false
                        ]); ?>
                <?= $this->Html->link(
                        __('<small class="text-muted-dark">@' . h($personToMeet->getUsername()) . '</small>'),
                        [
                            'controller' => 'e',
                            'action' => h($personToMeet->getUsername())
                        ],
                        [
                            'class' => '',
                            'escapeTitle' => false
                        ]); ?>
                        </p>
                <?= (! empty($personToMeet->personality) ? '<p class="about-content-block">' . h($personToMeet->about) . '</p>' : ''); ?>
                <?php if (! empty($personToMeet->about) || ! empty($personToMeet->location) || ! empty($personToMeet->genre)): ?>
                <div class="meta-data text-small text-muted-dark">
                    <?= (! empty($personToMeet->personality) ? '<span class="personality">' . h($personToMeet->personality) . '</span>' : ''); ?>
                    <?= (! empty($personToMeet->location) ? '<span class="location">' . h($personToMeet->location) . '</span>' : ''); ?>
                    <?= (! empty($personToMeet->genre) ? '<span class="genre">' . h($personToMeet->genre) . '</span>' : ''); ?>
                </div>
                <?php endif; ?>
                <div class="">
                    <button
                    class="btn btn-control-small btn-sm btn-outline-primary btn-rounded pY-2 px-2"
                    data-action="commit"
                    data-intent="connect"
                    data-screen-name="<?= h($activeUser->getUsername()); ?>"
                    data-account="<?= h($personToMeet->getUsername()) ?>"
                    data-referer="<?= $this->Url->request->getRequestTarget(); ?>"
                    data-url="<?= $this->Url->request->getAttribute('base') ?>"
                    data-origin="suggested_users">
                        <span class="mdi mdi-account-plus"></span>
                        <span class="btn-text">Connect</span>
                    </button>
                        <a href="javascript:void()" data-url="" class="btn btn-control-small btn-danger btn-rounded btn-sm pY-2 px-2" onclick="remove(this)">
                        <span class="mdi mdi-cancel"></span> Remove</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
<?php endif; ?>
