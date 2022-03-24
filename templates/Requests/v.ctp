<?php

use Cake\Utility\Inflector;
use App\Utility\TimeCalculator;
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Request $request
 */
?>
<div class="requests content">
    <!--            <nav class="large-3 medium-4 columns" id="actions-sidebar">
                <ul class="side-nav">
                    <li class="heading"><?= __('Actions') ?></li>
                    <li><?= $this->Form->postLink(__('Delete Request'), ['action' => 'delete', $request->id], ['confirm' => __('Are you sure you want to delete # {0}?', $request->id)]) ?> </li>
                    <li><?= $this->Html->link(__('List Requests'), ['action' => 'index']) ?> </li>
                </ul>
            </nav>-->
    <div class="card card-profile">
        <div class="card-header" style="background-image: url(demo/photos/eberhard-grossgasteiger-311213-500.jpg);"></div>
        <div class="card-body text-center card-profile">
            <div class="avatar avatar-xxl box-square-8 card-profile-img" style="background-image: url(demo/photos/eberhard-grossgasteiger-311213-500.jpg);"></div>
            <div class="user-data">
                <div class="account-name">
                    <h3><?= $this->Html->link(
                                __($this->Text->truncate(h($requester->fullname), 45, ['ellipsis' => '...'])),
                                [
                                    'controller' => 'e',
                                    'action' => h($requester->username)
                                ],
                                [
                                    'class' => 'd-b'
                                ]
                                ); ?>
                    </h3>
                        <?= $this->Html->link(
                                __('@' . h($requester->username)),
                                [
                                    'controller' => 'e',
                                    'action' => h($requester->username)
                                ],
                                [
                                    'class' => 'd-inblock'
                                ]
                                ); ?>
                </div>
                <div class="meta-data my-3 py-2">
                    <span class="user-desc"><?= $this->Text->truncate(h($requester->about), 80, ['ellipsis' => '...']); ?></span>
                    <span class="user-misc :has-location :has-time :has"><?= h($requester->location); ?></span>
                </div>
            </div>
            <div class="cta request-response">
                    <?= $this->Form->create(
                            'Actions',
                            [
                                'type' => 'post',
                                'url' => [
                                    'controller' => 'async-requests-handler',
                                    'action' => 'request-confirmation'
                                ],
                                'class' => 'req_con_form',
                                'target' => h($requester->refid) . '_ajaxSimulator'
                            ]
                            ); ?>
                <input type="hidden" name="request_type" value="<?= h($request->type) ?>">
                <input type="hidden" name="request_id" value="<?= h($request->refid) ?>">
                <button
                    class="btn btn-md btn-success"
                    type="submit"
                    name="response_action"
                    value="accept"
                    onclick="acceptRequest(<?= h($request->refid) ?>)"
                    >Accept</button>
                <button
                    class="btn btn-md btn-warning"
                    type="submit"
                    name="response_action"
                    value="decline"
                    onclick="declineRequest(<?= h($request->refid) ?>)"
                    >Decline</button>
                <button class="btn btn-md btn-danger" onclick="block(<?= h($requester->refid) ?>)">Block</button>
                    <?= $this->Form->end(); ?>

                <div class="d-n w-0">
                    <iframe name="<?= h($requester->refid); ?>_ajaxSimulator" id="<?= h($requester->refid); ?>-ajaxSimulator" class="ajaxSimulator" hidden="hidden" width="0" height="0"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pending-requests">
            <?php if (count($pendingRequests)): ?>
    <div class="card pending-requests">
        <div class="card-header bg-transparent">
            <span class="fsz-sm fw-600 c-grey-900">Pending Requests</span>
        </div>
        <div class="card-body p-0">
            <div class="e_requests">
                <div class="ovY-a pos-r scrollable lis-n p-0 m-0 fsz-sm">
                                <?php foreach ($pendingRequests as $pendingRequest): ?>
                    <div class="request <?= h($pendingRequest->type); ?>-request">
                                    <?php
                                    $status = ' unread';
                                    if ((int) $pendingRequest->is_read === 1) {
                                        $status = ' read';
                                    }
                                    ?>
                        <a
                            href="<?= $this->Url->request->getAttribute('base') ?>/requests/v/<?= h($pendingRequest->refid) ?>?e_notif_obj=<?= h($pendingRequest->type) ?>"
                            class="ntf<?= $status; ?> peers fxw-nw td-n py-2 px-3 c-grey-800 cH-blue bgcH-grey-100">
                            <div class="peer mR-15">
                                <img class="w-3r bdrs-50p avatar avatar-lg" src="<?= $this->Url->webroot('public-files/' . h($pendingRequest->sender->profile_image_url)); ?>" alt="">
                            </div>
                            <div class="peer peer-greed">
                                <div>
                                    <div class="jc-sb fxw-nw mB-5">
                                        <strong class="mB-0"><?= h($pendingRequest->sender->fullname); ?></strong>
                                        <?php
                                        $message = '';
                                        switch ($pendingRequest->type) {
                                            case 'connection': $message = 'wants to connect with you';
                                                break;
                                            case 'meeting': $message = 'would like you two to meet';
                                                break;
                                            case 'introduction': $message = 'wants you to introduce you to someone';
                                        }
                                        ?>
                                        <span class="c-grey-600 fsz-sm"><?= $message ?></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                                <?php endforeach; ?>
                </div>
            </div>
        </div>
        <footer class="card-footer text-right">
            <?= $this->Html->link(
                __('All Requests'),
                [
                    'controller' => 'requests',
                    'action' => 'index'
                ],
                [
                    'class' => 'link-sm'
                ]
                ); ?>
        </footer>
    </div>
            <?php endif; ?>
</div>
