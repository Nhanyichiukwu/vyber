<?php

use App\Utility\RandomString;
use Cake\Routing\Router;

$postLink = Router::url('/' . $post->author->getUsername() . '/posts/' . $post->refid);
$randID = RandomString::generateString(16, 'mixedalpha');
?>
<ul class="unstyled m-0 p-0" data-post-id="<?= $post->id ?>">
    <?php if (isset($user)): ?>
        <li>
            <?= $this->Form->postLink(__('<icon class="d-inline-block mr-4">
                    <i class="icon mdi mdi-floppy mdi-24px"></i></icon>
                <div class="d-inline-block">
                    <span class="d-block fsz-18 fsz-def">Save post</span>
                    <span class="text-muted small">Saving a post let\'s you retain a copy even if the original owner deletes it</span>
                </div>'),
                [
                    'controller' => 'collections',
                    'action' => 'add_item',
                    '?' => ['type' => $post->get('type'), 'obj_iid' => $post->refid],
                    'fullBase' => true
                ],
                [
                    'class' => 'bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none',
                    'escapeTitle' => false
                ]); ?>
        </li>
    <?php endif; ?>
    <li>
        <a href="<?= Router::url('/share/link?_lt=post_link&post_id=' . $post->refid . '&_ref=i_base', true) ?>"
           class="bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none">
            <icon class="d-inline-block mr-4"><i class="icon mdi mdi-link-variant mdi-24px"></i></icon>
            <div class="d-inline-block">
                <span class="d-block fsz-18 fsz-def">Copy link to post</span>
            </div>
        </a>
    </li>
    <li>
        <a href="<?= Router::url('/share/embed?what=post&link=' . urlencode($postLink), true) ?>"
           class="bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none">
            <icon class="d-inline-block mr-4"><i class="icon mdi mdi-xml mdi-24px"></i></icon>
            <div class="d-inline-block">
                <span class="d-block fsz-18 fsz-def">Embed this post</span>
            </div>
        </a>
    </li>
    <li>
        <a href="<?= Router::url('/share/recommend?what=post&link=' . urlencode($postLink) . '&referer=' . urlencode($this->getRequest()->getAttribute('here')), true) ?>"
           class="bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none">
            <icon class="d-inline-block mr-4"><i class="icon mdi mdi-account-star mdi-24px"></i></icon>
            <div class="d-inline-block">
                <span class="d-block fsz-18 fsz-def">Recommend to a friend</span>
            </div>
        </a>
    </li>
    <?php
    if (
        (
            isset($user) &&
            !$post->author->isSameAs($user) &&
            $user->isConnectedTo($post->author)
        ) ||
        (
            isset($profile) &&
            isset($user) &&
            !$post->author->isSameAs($user) &&
            $user->isConnectedTo($post->author)
        )
    ): ?>
        <li>
            <?= $this->Form->postLink(
                __('<icon class="d-inline-block mr-4"><i class="icon mdi mdi-cancel mdi-24px"></i></icon>
                <div class="d-inline-block">
                <span class="d-block fsz-18 fsz-def">Remove from my feed</span>
                <span class="text-muted small">You wont see this post again</span>
                </div>'),
                Router::url('/action/remove/'.$post->refid.'?what=post&post=' . urlencode($postLink) .
                '&intent=exclude_from_feed',
                    true),
                [
                    'class' => 'bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none',
                    'escapeTitle' => false
                ]) ?>
        </li>
        <li>
            <a href="<?= Router::url('#', true) ?>"
               class="bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none">
                <icon class="d-inline-block mr-4"><i class="icon mdi mdi-account-remove mdi-24px"></i></icon>
                <div class="d-inline-block">
                    <span class="d-block fsz-18 fsz-def">Unfollow <?= h($post->author->getFirstName()); ?></span>
                    <span class="text-muted small">You won't see any more posts from him/her, though you're still
                        connected</span>
                </div>
            </a>
        </li>
    <?php elseif (
        (isset($profile) || isset($account)) &&
        isset($user) &&
        !$post->author->isSameAs($user) &&
        !$user->isConnectedTo($post->author)
    ): ?>
        <li>
            <?= $this->Form->postLink(
                __('<icon class="d-inline-block mr-4"><i class="icon mdi mdi-account-remove mdi-24px"></i></icon>
                <div class="d-inline-block">
                    <span class="d-block fsz-18 fsz-def">Add {0}\'s timeline to my feed</span>
                </div>', h($post->author->getFirstName())),
                [
                    'controller' => 'my_feed',
                    'action' => 'add_timeline',
                    '?' => [
                        'timeline' => urlencode(Router::url('/' . $account->getUsername() . '/posts', true)),
                        'referer' => urlencode($this->getRequest()->getAttribute('here'))
                    ]
                ],
                [
                    'class' => 'bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none',
                    'escapeTitle' => false
                ]); ?>
        </li>
    <?php endif; ?>
    <li>
        <a href="<?= Router::url('/report?what=post&post=' . urlencode($postLink) . '&referer=' . urlencode($this->getRequest()->getAttribute('here')), true) ?>"
           class="bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none">
            <icon class="d-inline-block mr-4"><i class="icon mdi mdi-flag-outline mdi-24px"></i></icon>
            <div class="d-inline-block">
                <span class="d-block fsz-18 fsz-def">Report this post</span>
                <span class="text-muted small">Report this post if you think it is inappropriate or violates the
                    community standards</span>
            </div>
        </a>
    </li>
    <?php /* Limit this items to the account owner only **/ ?>
    <?php if (isset($user) && $post->author->isSameAs($user)): ?>
        <li role="separator" class="dropdown-divider my-0"></li>
        <li>
            <a href="<?= Router::url('/' . $post->author->getUsername() . '/posts/' . $post->refid . '?action=edit', true) ?>"
               class="bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none">
                <icon class="d-inline-block mr-4"><i class="icon mdi mdi-pencil mdi-24px"></i></icon>
                <div class="d-inline-block">
                    <span class="d-block fsz-18 fsz-def">Edit post</span>
                </div>
            </a>
        </li>
        <li class="d-block">
            <a href="javascript:void(0)"
               class="bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none"
               data-toggle="modal"
               data-target="#post_<?= $post->refid ?>">
                <icon class="d-inline-block mr-4"><i class="icon mdi mdi-delete-forever mdi-24px"></i></icon>
                <div class="d-inline-block">
                    <span class="d-block fsz-18 fsz-def">Delete post</span>
                </div>
            </a>
            <div id="post_<?= $post->refid ?>" class="modal fade fsz-sm shadow-lg">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="btn-group">
                                <div>
                                    <?= $this->Form->postLink(__('<icon class="d-inline-block mr-4"><i class="icon mdi mdi-floppy mdi-24px"></i></icon>
                                        <div class="d-inline-block">
                                            <span class="d-block fsz-18 fsz-def">Hide from timeline</span>
                                        </div>'),
                                        [
                                            'controller' => 'posts',
                                            'action' => 'delete'
                                        ],
                                        [
                                            'data' => ['post' => $post->refid, 'mode' => 'recoverable'],
                                            'class' => 'bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none',
                                            'escapeTitle' => false
                                        ]); ?>
                                    <span class="text-muted small">
                                        Send items to recycle bin if you wish to recover them later, or if you are
                                        unsure what you want to do with it. However, objects in the recycle bin are
                                        automatically disposed of after 30 days.</span>
                                </div>
                                <div>
                                    <?= $this->Form->postLink(__('<icon class="d-inline-block mr-4"><i class="icon mdi mdi-floppy mdi-24px"></i></icon>
                                                                                    <div class="d-inline-block">
                                                                                        <span class="d-block fsz-18 fsz-def">Delete Permanently?</span>
                                                                                    </div>'),
                                        [
                                            'controller' => 'posts',
                                            'action' => 'delete'
                                        ],
                                        [
                                            'data' => ['post' => $post->refid, 'mode' => 'permanent'],
                                            'class' => 'bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none',
                                            'escapeTitle' => false
                                        ]); ?>
                                    <span class="text-muted small">Deleted items cannot be recovered. If you're
                                                                                            not sure what to do with this post, send it to recycle bin</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    <?php endif; ?>
</ul>
