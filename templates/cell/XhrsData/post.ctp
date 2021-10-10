<?php

/**
 * Single Post View
 */

use Cake\Routing\Router;
use Cake\Utility\Text;
use Cake\Utility\Inflector;

if (strtolower($this->getTheme()) === 'mobile') {
    $this->setLayout('default');
} else {
    $this->setLayout('dual_sidebar');
}

                        
$postLink = urlencode(Router::url($post->author->getUsername() . '/posts/' . $post->refid, true));
?>
<div id="post_<?= $post->get('refid') ?>" class="post">
    <div class="card">
        <div class="rounded-top p-4">
            <div class="float-left mr-4">
                <a href="#" class="avatar avatar-lg" style="background-image: url(./demo/photos/david-klaasen-54203-500.jpg)"></a>
            </div>
            <div class="border-bottom ml-8">
                <div class="i__pc-h pos-r">
                    <e-action-menu class="action-menu e-custom-dropdown dropdown pos-a-r">
                        <a
                            href="javascript:void(0)"
                            data-toggle="dropdown"
                            class="align-items-center box-square-2 btn-white d-inline-flex dropdown-toggle justify-content-center no-after rounded-circle text-decoration-none text-muted-dark"
                            >
                            <i class="fe fe-chevron-down fsz-20"></i></a>

                        <e-dropmenu
                            class="dropdown-menu keep-open dropdown-menu-right dropdown-menu-arrow fsz-sm shadow-lg"
                            data-auto-close="false"
                            >
                            <ul class="unstyled m-0 p-0">
                                                        <?php if (isset($activeUser)): ?>
                                <li>
                                                                <?= $this->Form->postLink(__('<icon class="d-inline-block mr-4"><i class="icon mdi mdi-floppy mdi-24px"></i></icon>
                                                                    <div class="d-inline-block">
                                                                        <span class="d-block fsz-18 fsz-def">Save this post to my collections</span>
                                                                        <span class="text-muted small">Saving a post let\'s you retain a copy even if the <br>original owner deletes it</span>
                                                                    </div>'), 
                                                                    [
                                                                        'controller' => 'collections',
                                                                        'action' => 'add_item',
                                                                        '?' => ['type' => $post->get('type'), 'obj_iid' => $post->get('refid')],
                                                                        'fullBase' => true
                                                                    ],
                                                                    [
                                                                        'class' => 'bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap',
                                                                        'escapeTitle' => false
                                                                    ]); ?>
                                </li>
                                                        <?php endif; ?>
                                <li>
                                    <a href="<?= Router::url('/share/link?_lt=post_link&post_id=' . $post->get('refid') . '&_ref=i_base', ['fullBase' => true]) ?>" class="bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap">
                                        <icon class="d-inline-block mr-4"><i class="icon mdi mdi-link-variant mdi-24px"></i></icon>
                                        <div class="d-inline-block">
                                            <span class="d-block fsz-18 fsz-def">Copy link to post</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Router::url('/share/embed?what=post&link=' . $postLink, ['fullBase' => true]) ?>" class="bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap">
                                        <icon class="d-inline-block mr-4"><i class="icon mdi mdi-xml mdi-24px"></i></icon>
                                        <div class="d-inline-block">
                                            <span class="d-block fsz-18 fsz-def">Embed this post</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Router::url('/share/recommend?what=post&link=' . $postLink . '&referer=' . urlencode($this->getRequest()->getAttribute('here')), ['fullBase' => true]) ?>" class="bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap">
                                        <icon class="d-inline-block mr-4"><i class="icon mdi mdi-account-star mdi-24px"></i></icon>
                                        <div class="d-inline-block">
                                            <span class="d-block fsz-18 fsz-def">Recommend to a friend</span>
                                        </div>
                                    </a>
                                </li>
                                                        <?php
                                                        if (
                                                            (
                                                                isset($activeUser) &&
                                                                !$post->author->isSameAs($activeUser) &&
                                                                $activeUser->isConnectedTo($post->author)
                                                            ) ||
                                                            (
                                                                isset($profile) &&
                                                                isset($activeUser) &&
                                                                !$post->author->isSameAs($activeUser) &&
                                                                $activeUser->isConnectedTo($post->author)
                                                            )
                                                        ): ?>
                                <li>
                                                                <?= $this->Form->postLink(__('<icon class="d-inline-block mr-4"><i class="icon mdi mdi-cancel mdi-24px"></i></icon>
                                                                    <div class="d-inline-block">
                                                                        <span class="d-block fsz-18 fsz-def">Remove from my feed</span>
                                                                        <span class="text-muted small">You wont see this post again</span>
                                                                    </div>'), 
                                                                    Router::url('/action/remove?what=post&post=' . $postLink . '&intent=exclude_from_feed', ['fullBase' => true]),    
                                                                    [
                                                                        'class' => 'bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap',
                                                                        'escapeTitle' => false
                                                                    ]) ?>
                                </li>
                                <li>
                                    <a href="<?= Router::url('/', ['fullBase' => true]) ?>" class="bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap">
                                        <icon class="d-inline-block mr-4"><i class="icon mdi mdi-account-remove mdi-24px"></i></icon>
                                        <div class="d-inline-block">
                                            <span class="d-block fsz-18 fsz-def">Unfollow <?= h($post->author->getFirstName()); ?></span>
                                            <span class="text-muted small">You won't see any more $timeline from him/her, though <br>you're still connected</span>
                                        </div>
                                    </a>
                                </li>
                                                        <?php elseif (
                                                            (isset($profile) || isset($account)) &&
                                                            isset($activeUser) &&
                                                            !$post->author->isSameAs($activeUser) &&
                                                            !$activeUser->isConnectedTo($post->author)
                                                        ): ?>
                                <li>
                                                                <?= $this->Form->postLink(__('<icon class="d-inline-block mr-4"><i class="icon mdi mdi-account-remove mdi-24px"></i></icon>
                                                                    <div class="d-inline-block">
                                                                        <span class="d-block fsz-18 fsz-def">Add {0}\'s timeline to my feed</span>
                                                                    </div>', h($post->author->getFirstName())), 
                                                                        [
                                                                            'controller' => 'my_feed',
                                                                            'action' => 'add_timeline',
                                                                            '?' => [
                                                                                'timeline' => urlencode(Router::url('/e/' . $account->getUsername() . '/posts', true)),
                                                                                'referer' => urlencode($this->getRequest()->getAttribute('here'))
                                                                            ]
                                                                        ],
                                                                        [
                                                                            'class' => 'bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap',
                                                                            'escapeTitle' => false
                                                                        ]); ?>
                                </li>
                                                        <?php endif; ?>
                                <li>
                                    <a href="<?= Router::url('/report?what=post&post=' . $postLink . '&referer=' . urlencode($this->getRequest()->getAttribute('here')), ['fullBase' => true]) ?>" class="bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap">
                                        <icon class="d-inline-block mr-4"><i class="icon mdi mdi-flag-outline mdi-24px"></i></icon>
                                        <div class="d-inline-block">
                                            <span class="d-block fsz-18 fsz-def">Report this post</span>
                                            <span class="text-muted small">Report this post if you think it is inappropriate<br>violates the community standards</span>
                                        </div>
                                    </a>
                                </li>
                                                        <?php /* Limit this items to the account owner only **/ ?>
                                                        <?php if (isset($activeUser) && $post->author->isSameAs($activeUser)): ?>
                                <li role="separator" class="dropdown-divider my-0"></li>
                                <li>
                                    <a href="<?= Router::url('/e/' . $post->author->getUsername() . '/posts/' . $post->refid . '?action=edit', ['fullBase' => true]) ?>"
                                       class="bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap">
                                        <icon class="d-inline-block mr-4"><i class="icon mdi mdi-pencil mdi-24px"></i></icon>
                                        <div class="d-inline-block">
                                            <span class="d-block fsz-18 fsz-def">Edit post</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="dropdown d-block">
                                    <a href="javascript:void(1)"
                                       class="bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap"
                                       data-toggle="dropdown">
                                        <icon class="d-inline-block mr-4"><i class="icon mdi mdi-delete-forever mdi-24px"></i></icon>
                                        <div class="d-inline-block">
                                            <span class="d-block fsz-18 fsz-def">Delete post</span>
                                        </div>
                                    </a>
                                <e-dropmenu id="<?= $this->Number->format($post->id) ?>-delete-sub-drop" class="dropdown-menu dropdown-menu-right dropdown-menu-arrow fsz-sm shadow-lg">
                                    <ul class="unstyled m-0 p-0">
                                        <li>
                                                                            <?= $this->Form->postLink(__('<icon class="d-inline-block mr-4"><i class="icon mdi mdi-floppy mdi-24px"></i></icon>
                                                                                <div class="d-inline-block">
                                                                                    <span class="d-block fsz-18 fsz-def">Send to recycle bin?</span>
                                                                                    <span class="text-muted small">Send items to recycle bin if you wish to recover <br>
                                                                                    them later, or if you are unsure what you want to <br>
                                                                                    do with it. However, objects in the recycle bin <br>are automatically delete after 30 days</span>
                                                                                </div>'),
                                                                                    [
                                                                                        'controller' => 'posts',
                                                                                        'action' => 'delete',
                                                                                        $post->get('refid')
                                                                                    ],
                                                                                    [
                                                                                        'data' => ['mode' => 'recoverable'],
                                                                                        'class' => 'bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap',
                                                                                        'escapeTitle' => false
                                                                                    ]); ?>
                                        </li>
                                        <li>
                                                                            <?= $this->Form->postLink(__('<icon class="d-inline-block mr-4"><i class="icon mdi mdi-floppy mdi-24px"></i></icon>
                                                                                <div class="d-inline-block">
                                                                                    <span class="d-block fsz-18 fsz-def">Delete Permanently?</span>
                                                                                    <span class="text-muted small">Deleted items cannot be recovered. If you\'re <br>
                                                                                    not sure what to do with this post, send it to recycle bin</span>
                                                                                </div>'),
                                                                                    [
                                                                                        'controller' => 'posts',
                                                                                        'action' => 'delete',
                                                                                        $post->get('refid')
                                                                                    ],
                                                                                    [
                                                                                        'data' => ['mode' => 'permanent'],
                                                                                        'class' => 'bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap',
                                                                                        'escapeTitle' => false
                                                                                    ]); ?>
                                        </li>
                                    </ul>
                                </e-dropmenu>
                                </li>
                                                        <?php endif; ?>
                            </ul>
                        </e-dropmenu>
                    </e-action-menu>
                    <div class="author-info post-meta pr-5 mb-3">
                        <h5 class="account-name">
                                                    <?php
                                                    $screenName = $post->author->username;
                                                    if ($post->author->hasStageName) {
                                                        $screenName = $post->author->username;
                                                    }
                                                    ?>
                                                    <?= $this->Html->link(
                                                        __('<strong class="account-fullname d-b mb-0 pb-0 d-inline-block">{fullname}</strong> <span class="account-screenname d-inline-block small">@{screenname}</span>',
                                                            ['fullname' => Text::truncate(h($post->author->getFullname()), 25, ['ellipsis' => '...']), 'screenname' => h($screenName)]),
                                                        [
                                                            'controller' => 'e',
                                                            'action' => h($screenName)
                                                        ],
                                                        [
                                                            'class' => 'profileUrl',
                                                            'data-hover-event' => 'profile.preview',
                                                            'data-profile-url' => $this->getRequest()->getAttribute('base') . '/e/async/prfilecard/',
                                                            'aria-expanded' => 'true',
                                                            'aria-has-hoverprofilecard' => 'true',
                                                            'escapeTitle' => false
                                                        ]
                                                    ); ?>
                                                    <?= (isset($post->author->role) ? '<span class="badge badge-info">' . h($post->author->role) . '</span>' : '') ?>
                        </h5>
                                                <?= ($post->author->has('tagline') ? '<div class="user-tagline small">' . h($post->author->tagline) . '</div>' : ''); ?>
                        <div class="content-meta small d-flex">
                            <div class="meta-publish-date" role="datetime">
                                <i class="icon mdi mdi-clock"></i>
                                <span class="fsz-xs"><?= ucfirst($this->formatTime($post->get('date_published'))); ?></span>
                            </div>
                                                    <?php if (!$post->isEmpty('location')): ?>
                            <div class="meta-publish-location small" role="location">
                                <i class="mdi mdi-map-marker-radius"></i> From: <?= h($post->getLocation()); ?>
                            </div>
                                                    <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4">
            <div class="i__p-c-w">
                                <?php
                                $fontSize = 'fsz-16';
                                $postTextLen = (int) strlen(h($post->post_text));

                                if ($postTextLen <= 160) {
                                    $fontSize = 'fsz-24';
                                } elseif ($postTextLen <= 240) {
                                    $fontSize = 'fsz-20';
                                }
                                ?>
                                <?php if ($post->isCoppied()): ?>
                <div class="i__pc-b">
                                        <?php if ($post->copied_as === 'quote'): ?>
                    <div class="<?= $fontSize ?> text-muted">
                        <blockquote class="quote text-quoted post-quoted"><?= h($post->post_text); ?></blockquote>
                    </div>
                    <div class="mt-6 fsz-16 text-right mr-6">
                                            <?= $this->Html->link(__('<span class="avatar avatar-placeholder mr-3" style="background-image: url({avartar})"></span><span class="username">@{username}</span>', ['username' => $post->originalAuthor->getUsername(), 'avatar' => $post->originalAuthor->profile->getProfileImageUrl()]),
                                                Router::url('/e/' . h($post->originalAuthor->getUsername()) . '/posts/' . h($post->originalPost->refid) . '?_ref=' .  h($post->refid) . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')), true),
                                                [
                                                    'class' => 'text-muted font-italic text-decoration-none d-inline-flex align-items-center justify-content-end',
                                                    'escapeTitle' => false
                                                ]); ?>
                    </div>
                                        <?php elseif ($post->copied_as === 'plain'): ?>
                    <div class="text-plain <?= $fontSize ?>"><?= h($post->post_text); ?></div>
                                        <?php endif; ?>
                </div>
                                <?php else: ?>
                <div class="i__pc-b <?= $fontSize ?>"><?= h($post->post_text); ?></div>
                                <?php endif; ?>
                <div class="border-top d-flex mt-5 pt-4">
                                    <?php if ($post->has('comments') && count($post->get('comments'))): ?>
                    <div class="post-commenters">
                        <div class="d-flex">
                            <div class="avatar-list avatar-list-stacked">
                                                <?php for ($i = 0; $i <= 5; $i++): ?>
                                                <?php $commenter = $post->comments[$i]; ?>
                                <span class="avatar" style="background-image: url(./demo/faces/female/12.jpg)"></span>
                                                <?php endfor; ?>
                                                <?php if (sizeof($post->comments) > 5): ?>
                                <span class="avatar">+<?= (sizeof($post->reactors)) - 5 ?></span>
                                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                                    <?php endif; ?>
                    <!-- Call To Action Buttons -->
                    <div class="d-flex i__p-cta-btns ml-auto">
                        <div class="dropdown">
                                            <?php
                                            $reacted = 'unreacted';
                                            if (isset($activeUser) && $post->hasUserReaction($activeUser->refid)) {
                                                $reacted = 'reacted';
                                            }
                                            ?>
                            <button class="react btn btn-icon btn-sm px-1 rounded-circle dropdown-toggle no-after" data-toggle="dropdown" aria-state="<?= $reacted ?>">
                                <i class="mdi mdi-white-balance-sunny mdi-18px"></i>
                            </button>
                                            <?php if (count($post->get('reactions'))): ?>
                            <span class="counter reaction-counter"><?= /*$this->Formatter->format(*/count($post->reactions)/*)*/; ?></span>
                                            <?php endif; ?>

                                            <?php if ($this->get('activeUser')): ?>
                            <div class="dropdown-menu">
                                <div class="grid-2c">
                                    <div class="reaction-picker icons-list-wrap">
                                        <ul class="icons-list">
                                            <li class="icons-list-item">
                                                <button
                                                    class="btn btn-icon btn-lg reaction react_like i__p-committer"
                                                    role="button"
                                                    data-target="#e__cb-<?= h($post->refid); ?>"
                                                    data-commit="reaction"
                                                    data-intent="like"
                                                    title="Like"
                                                    data-toggle="tooltip"
                                                    data-original-title="Like"
                                                    data="<?= h($post->type); ?>_<?= h($post->refid); ?>_<?= h($post->author->refid); ?>_<?= h($activeUser->refid); ?>"
                                                    >
                                                    <i class="mdi mdi-18px mdi-heart-outline"></i>
                                                </button>
                                            </li>
                                            <li class="icons-list-item">
                                                <button
                                                    class="btn btn-icon btn-lg reaction react_dislike i__p-committer"
                                                    role="button"
                                                    data-target="#e__cb-<?= h($post->refid); ?>"
                                                    data-commit="reaction"
                                                    data-intent="dislike"
                                                    title="Dislike"
                                                    data-title="Dislike"
                                                    data-toggle="tooltip"
                                                    data-original-title="Dislike"
                                                    data="<?= h($post->type); ?>_<?= h($post->refid); ?>_<?= h($post->author->refid); ?>_<?= h($activeUser->refid); ?>"
                                                    >
                                                    <i class="mdi mdi-18px mdi-heart-outline"></i>
                                                </button>
                                            </li>
                                            <li class="icons-list-item">
                                                <button
                                                    class="btn btn-icon btn-lg reaction react_love i__p-committer"
                                                    role="button"
                                                    data-target="#e__cb-<?= h($post->refid); ?>"
                                                    data-commit="reaction"
                                                    data-intent="love"
                                                    title="Love"
                                                    data-title="Love"
                                                    data-toggle="tooltip"
                                                    data-original-title="Love"
                                                    data="<?= h($post->type); ?>_<?= h($post->refid); ?>_<?= h($post->author->refid); ?>_<?= h($activeUser->refid); ?>"
                                                    >
                                                    <i class="mdi mdi-18px mdi-heart-outline"></i>
                                                </button>
                                            </li>
                                            <li class="icons-list-item">
                                                <button
                                                    class="btn btn-icon btn-lg reaction react_perfect i__p-committer"
                                                    role="button"
                                                    data-target="#e__cb-<?= h($post->refid); ?>"
                                                    data-commit="reaction"
                                                    data-intent="perfect"
                                                    title="Perfect"
                                                    data-title="Perfect"
                                                    data-toggle="tooltip"
                                                    data-original-title="Perfect"
                                                    data="<?= h($post->type); ?>_<?= h($post->refid); ?>_<?= h($post->author->refid); ?>_<?= h($activeUser->refid); ?>"
                                                    >
                                                    <i class="mdi mdi-18px mdi-heart-outline"></i>
                                                </button>
                                            </li>
                                            <li class="icons-list-item">
                                                <button
                                                    class="btn btn-icon btn-lg reaction react_excellent i__p-committer"
                                                    role="button"
                                                    data-target="#e__cb-<?= h($post->refid); ?>"
                                                    data-commit="reaction"
                                                    data-intent="excellent"
                                                    title="Excellent"
                                                    data-title="Excellent"
                                                    data-toggle="tooltip"
                                                    data-original-title="Excellent"
                                                    data="<?= h($post->type); ?>_<?= h($post->refid); ?>_<?= h($post->author->refid); ?>_<?= h($activeUser->refid); ?>"
                                                    >
                                                    <i class="mdi mdi-18px mdi-heart-outline"></i>
                                                </button>
                                            </li>
                                            <li class="icons-list-item">
                                                <button
                                                    class="btn btn-icon btn-lg reaction react_laugh i__p-committer"
                                                    role="button"
                                                    data-target="#e__cb-<?= h($post->refid); ?>"
                                                    data-commit="reaction"
                                                    data-intent="laugh"
                                                    title="Laugh"
                                                    data-title="Laugh"
                                                    data-toggle="tooltip"
                                                    data-original-title="Laugh"
                                                    data="<?= h($post->type); ?>_<?= h($post->refid); ?>_<?= h($post->author->refid); ?>_<?= h($activeUser->refid); ?>"
                                                    >
                                                    <i class="mdi mdi-18px mdi-heart-outline"></i>
                                                </button>
                                            </li>
                                            <li class="icons-list-item">
                                                <span
                                                    class="btn reaction react_cry i__p-committer"
                                                    role="button"
                                                    data-target="#e__cb-<?= h($post->refid); ?>"
                                                    data-commit="reaction"
                                                    data-intent="cry"
                                                    title="Cry"
                                                    data-title="Cry"
                                                    data-toggle="tooltip"
                                                    data-original-title="Cry"
                                                    data="<?= h($post->type); ?>_<?= h($post->refid); ?>_<?= h($post->author->refid); ?>_<?= h($activeUser->refid); ?>"
                                                    >
                                                    <i class="mdi mdi-18px mdi-heart-outline"></i>
                                                </span>
                                            </li>
                                            <li class="icons-list-item">
                                                <span
                                                    class="btn reaction react_sad i__p-committer"
                                                    role="button"
                                                    data-target="#e__cb-<?= h($post->refid); ?>"
                                                    data-commit="reaction"
                                                    data-intent="sad"
                                                    title="Sad"
                                                    data-title="Sad"
                                                    data-toggle="tooltip"
                                                    data-original-title="Sad"
                                                    data="<?= h($post->type); ?>_<?= h($post->refid); ?>_<?= h($post->author->refid); ?>_<?= h($activeUser->refid); ?>"
                                                    >
                                                    <i class="mdi mdi-18px mdi-heart-outline"></i>
                                                </span>
                                            </li>
                                            <li class="icons-list-item">
                                                <span
                                                    class="btn reaction react_happy i__p-committer"
                                                    role="button"
                                                    data-target="#e__cb-<?= h($post->refid); ?>"
                                                    data-commit="reaction"
                                                    data-intent="happy"
                                                    title="Happy"
                                                    data-title="Happy"
                                                    data-toggle="tooltip"
                                                    data-original-title="Happy"
                                                    data="<?= h($post->type); ?>_<?= h($post->refid); ?>_<?= h($post->author->refid); ?>_<?= h($activeUser->refid); ?>"
                                                    >
                                                    <i class="mdi mdi-18px mdi-heart-outline"></i>
                                                </span>
                                            </li>
                                            <li class="icons-list-item">
                                                <span
                                                    class="btn reaction react_supper_excited i__p-committer"
                                                    role="button"
                                                    data-target="#e__cb-<?= h($post->refid); ?>"
                                                    data-commit="reaction"
                                                    data-intent="super_excited"
                                                    title="Super Excited"
                                                    data-title="Super Excited"
                                                    data-toggle="tooltip"
                                                    data-original-title="Supper Excited"
                                                    data="<?= h($post->type); ?>_<?= h($post->refid); ?>_<?= h($post->author->refid); ?>_<?= h($activeUser->refid); ?>"
                                                    >
                                                    <i class="mdi mdi-18px mdi-heart-outline"></i>
                                                </span>
                                            </li>
                                            <li class="icons-list-item">
                                                <span
                                                    class="btn btn-icon btn-lg reaction react_impressed i__p-committer"
                                                    role="button"
                                                    data-target="#e__cb-<?= h($post->refid); ?>"
                                                    data-commit="reaction"
                                                    data-intent="impressed"
                                                    title="Impressed"
                                                    data-title="Impressed"
                                                    data-toggle="tooltip"
                                                    data-original-title="Impressed"
                                                    data="<?= h($post->type); ?>_<?= h($post->refid); ?>_<?= h($post->author->refid); ?>_<?= h($activeUser->refid); ?>"
                                                    >
                                                    <i class="mdi mdi-18px mdi-heart-outline"></i>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                                            <?php endif; ?>
                        </div>
                        <div>
                            <button
                                type="button"
                                class="btn btn-icon btn-sm px-1 rounded-circle"
                                role="button"
                                data-action="comment"
                                data-target="#e__cb-<?= h($post->refid); ?>">
                                <i class="mdi mdi-18px mdi-comment-outline"></i>
                            </button>
                                            <?php if (count($post->comments)): ?>
                            <span class="bdrs-r-15 border border-left-0 reaction-counter">
                                                <?= $this->Html->link(
                                                    __('{0}', count($post->comments)),
                                                    [
                                                        'controller' => 'post',
                                                        'action' => h($post->get('refid')),
                                                        'comments',
                                                        '?' => [
                                                            'type' => 'comment'
                                                        ]
                                                    ],
                                                    [
                                                        'class' => 'text-muted-dark link',
                                                        'escapeTitle' => false
                                                    ]
                                                ); ?>
                            </span>
                                            <?php endif; ?>
                        </div>
                        <div class="dropdown">
                            <button type="button" class="btn btn-icon btn-sm px-1 rounded-circle dropdown-toggle no-after" data-toggle="dropdown">
                                <i class="mdi mdi-18px mdi-vector-arrange-above"></i>
                            </button>
                            <div class="dropdown-menu">
                                <div class="bg-light border-bottom mt-n2 px-5 py-2">Copy As:</div>
                                <a class="dropdown-item i__p-cloner"
                                   href="javascript:void(0)"
                                   data-action="clone"
                                   data-id="<?= h($post->refid); ?>"
                                   data-clone-as="quote">Quote</a>
                                <a class="dropdown-item i__p-cloner"
                                   href="javascript:void(0)"
                                   data-action="clone"
                                   data-id="<?= h($post->refid); ?>"
                                   data-clone-as="plain">Plain</a>
                            </div>
                        </div>
                        <div class="dropdown">
                                            <?= $this->Html->link(
                                                __('<i class="mdi mdi-18px mdi-share"></i><span class="sr-only">Share</span>'),
                                                'javascript:void(0);',
                                                [
                                                    'class' => 'btn btn-icon btn-sm px-1 rounded-circle dropdown-toggle no-after',
                                                    'data-toggle' => 'dropdown',
                                                    'escapeTitle' => false
                                                ]
                                            ); ?>
                            <div class="dropdown-menu">
                                                <?= $this->Form->postButton(
                                                    __('<span class="mdi mdi-share"></span> To my wall'),
                                                    [
                                                        'controller' => 'contents',
                                                        'action' => 'share',
                                                        '?' => [
                                                            'intent' => 'adopt',

                                                            // Id of the post that is being shared
                                                            'p_id' => h($post->refid),

//                      Id of the original post where this was curled from
                                                            'op_id' => (! empty($post->original_post_refid) ? h($post->original_post_refid) : h($post->refid)),

//                        The user on whose wall this post is being shared from
                                                            'utm_data_referer' => h($post->author->refid)
                                                        ]
                                                    ],
                                                    [
                                                        'class' => 'dropdown-item',
                                                        'escapeTitle' => false
                                                    ]
                                                ); ?>
                                                <?= $this->Html->link(
                                                    __('<span class="mdi mdi-share"></span> Share with comment'),
                                                    [
                                                        'controller' => 'contents',
                                                        'action' => 'share',
                                                        '?' => [
                                                            'intent' => 'comment',

//                        Id of the current post
                                                            'p_id' => h($post->refid),

//                        Id of the original post where this was curled from
                                                            'op_id' => (! empty($post->original_post_refid) ? h($post->original_post_refid) : h($post->refid)),

//                        The user on whose wall this post is being shared from
                                                            'utm_data_referer' => h($post->author->refid)
                                                        ]
                                                    ],
                                                    [
                                                        'class' => 'dropdown-item',
                                                        'escapeTitle' => false
                                                    ]
                                                ) ?>
                                                <?= $this->Html->link(
                                                    __('<span class="mdi mdi-share"></span> Send as message'),
                                                    [
                                                        'controller' => 'contents',
                                                        'action' => 'share',
                                                        '?' => [
                                                            'intent' => 'message',
                                                            'msg_type' => 'attachment',
//                        Id of the current post
                                                            'p_id' => h($post->refid),
                                                            'op_id' => (! empty($post->original_post_refid) ? h($post->original_post_refid) : h($post->refid)),

//                        The user on whose wall this post is being shared from
                                                            'utm_data_referer' => h($post->author->refid),
                                                            'p_type' => h($post->type),
                                                            'permalink' => 'some_url_goes_here',
                                                        ]
                                                    ],
                                                    [
                                                        'class' => 'dropdown-item',
                                                        'escapeTitle' => false
                                                    ]
                                                ); ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Separated link</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mx-n4">
            <div id="i__pc-<?= h($post->refid); ?>-cmnt-container" class="i__cmnts has-form mt-5">
                <div class="form-container">
                                        <?= $this->Form->create(null, ['type' => 'file', 'class' => '']); ?>
                                        <?= $this->Form->hidden('comment', ['class' => 'invisible d-none', 'type' => 'hidden']) ?>
                    <div class="d-flex gutters-sm">
                        <div class="col-auto">
                            <a href="#" class="has-avatar">
                                <span class="avatar avatar-md"></span>
                            </a>
                        </div>
                        <div class="col">
                            <div class="form-control bdrs-20 h-auto"
                                 contenteditable="true"
                                 accesskey="i"
                                 role="textbox"
                                 spellcheck="true"
                                 aria-multiline="true"
                                 aria-placeholder="Comment"></div>
                        </div>
                    </div>
                                        <?= $this->Form->end(['Upload']); ?>
                </div>
                <div class="thread-container">
                    <div class="i__pc-comment-thread">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>