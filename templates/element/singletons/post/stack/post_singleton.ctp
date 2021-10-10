<?php

use Cake\Routing\Router;
use Cake\Utility\Text;
use Cake\Utility\Inflector;
use App\Utility\RandomString;
use App\Utility\DateTimeFormatter;
?>
<?php
    $postLink = Router::url('/' . $post->author->getUsername() . '/posts/' . $post->refid);
    $randID = RandomString::generateString(16, 'mixedalpha');
?>
<div id="post_<?= $randID ?>" class="i__post viewable _aQtRd7eh news-item p-0 list-group-item list-group-item-action
mb-0">
    <div class="_1yT1Ry _SDyPWa p-4 _w5w" aria-haspopup="true" data-focusable="true" data-id="<?= $post->refid ?>" data-uri="<?= $postLink ?>">
        <div class="_VDKqxd">
            <div class="clearfix d-block">
                <div class="XwEdci">
                    <div class="float-left mr-4">
                        <a href="#" class="avatar avatar-lg" style="background-image: url(./demo/photos/david-klaasen-54203-500.jpg)"></a>
                    </div>
                    <div class="ml-8">
                        <div class="i__pc-h pos-r">
                            <e-action-menu class="action-menu e-custom-dropdown dropdown pos-a-r">
                                <a
                                    href="javascript:void(0)"
                                    data-toggle="dropdown"
                                    class="box-square-2 btn-white dropdown-toggle no-after rounded-circle sQrBx text-center text-muted-dark"
                                    >
                                    <i class="mdi mdi-24px mdi-dots-vertical"></i></a>

                                <menu
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
                                                                        '?' => ['type' => $post->get('type'), 'obj_iid' => $post->refid],
                                                                        'fullBase' => true
                                                                    ],
                                                                    [
                                                                        'class' => 'bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap',
                                                                        'escapeTitle' => false
                                                                    ]); ?>
                                        </li>
                                                        <?php endif; ?>
                                        <li>
                                            <a href="<?= Router::url('/share/link?_lt=post_link&post_id=' . $post->refid . '&_ref=i_base', ['fullBase' => true]) ?>" class="bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap">
                                                <icon class="d-inline-block mr-4"><i class="icon mdi mdi-link-variant mdi-24px"></i></icon>
                                                <div class="d-inline-block">
                                                    <span class="d-block fsz-18 fsz-def">Copy link to post</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= Router::url('/share/embed?what=post&link=' . urlencode($postLink), ['fullBase' => true]) ?>" class="bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap">
                                                <icon class="d-inline-block mr-4"><i class="icon mdi mdi-xml mdi-24px"></i></icon>
                                                <div class="d-inline-block">
                                                    <span class="d-block fsz-18 fsz-def">Embed this post</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= Router::url('/share/recommend?what=post&link=' . urlencode($postLink) . '&referer=' . urlencode($this->getRequest()->getAttribute('here')), ['fullBase' => true]) ?>" class="bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap">
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
                                                                    Router::url('/action/remove?what=post&post=' . urlencode($postLink) . '&intent=exclude_from_feed', ['fullBase' => true]),
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
                                                                                'timeline' => urlencode(Router::url('/' . $account->getUsername() . '/posts', true)),
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
                                            <a href="<?= Router::url('/report?what=post&post=' . urlencode($postLink) . '&referer=' . urlencode($this->getRequest()->getAttribute('here')), ['fullBase' => true]) ?>" class="bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap">
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
                                            <a href="<?= Router::url('/' . $post->author->getUsername() . '/posts/' . $post->refid . '?action=edit', ['fullBase' => true]) ?>"
                                               class="bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap">
                                                <icon class="d-inline-block mr-4"><i class="icon mdi mdi-pencil mdi-24px"></i></icon>
                                                <div class="d-inline-block">
                                                    <span class="d-block fsz-18 fsz-def">Edit post</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="d-block">
                                            <a href="javascript:void(0)"
                                               class="bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap"
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
                                                                                            'class' => 'bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap',
                                                                                            'escapeTitle' => false
                                                                                        ]); ?>
                                                                    <span class="text-muted small">Send items to recycle bin if you wish to recover
                                                                        them later, or if you are unsure what you want to
                                                                        do with it. However, objects in the recycle bin are automatically delete after 30 days</span>
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
                                                                                            'class' => 'bgcH-grey-100 c-grey-700 d-flex px-3 py-2 td-n text-decoration-none text-nowrap',
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
                                </menu>
                            </e-action-menu>
                            <div class="author-info post-meta pr-5">
                                <div class="account-name">
                                                    <?php
                                                    $screenName = $post->author->username;
                                                    if ($post->author->hasStageName) {
                                                        $screenName = $post->author->username;
                                                    }
                                                    ?>
                                                    <?= $this->Html->link(
                                                        __('<span class="account-fullname d-inline-block font-weight-bold fsz-16 mb-0 pb-0 text-dark">{fullname}</span>',
                                                            ['fullname' => Text::truncate(h($post->author->getFullname()), 30, ['ellipsis' => '...'])]),
                                                        '/' . $screenName,
                                                        [
                                                            'class' => 'profileUrl',
                                                            'data-hover-event' => 'profile.preview',
                                                            'data-account-screenname' => h($screenName),
                                                            'data-profile-url' => $this->getRequest()->getAttribute('base') . '/async/prfilecard/',
                                                            'aria-expanded' => 'true',
                                                            'aria-has-hoverprofilecard' => 'true',
                                                            'escapeTitle' => false
                                                        ]
                                                    ); ?>
                                                    <?= (isset($post->author->role) ? '<span class="badge badge-info">' . h($post->author->role) . '</span>' : '') ?>
                                </div>
                                                <?= ($post->author->has('tagline') ? '<div class="user-tagline small">' . h($post->author->tagline) . '</div>' : ''); ?>
                                <div class="content-meta small d-flex">
                                    <div class="meta-publish-date" role="datetime">
                                        <i class="icon mdi mdi-clock"></i>
                                        <span class="fsz-xs"><?= ucfirst(DateTimeFormatter::humanizeDateTime($post->get('date_published'), $user_timezone)); ?></span>
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
            </div>
            <div class="_lyAO5Z">
                <div class="i__p-c-w">
                                <?php if (!$post->isEmpty('post_text')): ?>
                                    <?php
                                    $fontSize = 'fsz-16';
                                    $words = explode(' ', h($post->getBody()));
                                    $postLength = (int)  strlen(h($post->getBody()));

                                    if ($postLength <= 160) {
                                        $fontSize = 'fsz-24';
                                    } elseif ($postLength <= 240) {
                                        $fontSize = 'fsz-20';
                                    }
                                    ?>
                    <div class="i__pc-b mb-3">
                                    <?php if ($post->isCoppied()): ?>
                        <div class="copied-post">
                                        <?php if ($post->isCopiedAs('quote')): ?>
                            <div class="<?= $fontSize ?> text-muted">
                                <blockquote class="quote text-quoted">
                                                    <?= Text::truncate($post->getBody(), 160, ['foo' => 'bar']); ?>
                                                    <?php if ($postLength > 160): ?><small class="small"><a href="javascript:void(fullText() || window.location.asign('<?= $postLink ?>'))">See More <i class="fe fe-chevron-right"></i></a></small><?php endif; ?>
                                </blockquote>
                            </div>
                            <div class="mt-6 fsz-16 text-right mr-6">
                                                <?= $this->Html->link(__('<span class="avatar avatar-placeholder mr-3" style="background-image: url({avartar})"></span><span class="username">@{username}</span>', ['username' => $post->originalAuthor->getUsername(), 'avatar' => $post->originalAuthor->profile->getProfileImageUrl()]),
                                                    Router::url('/' . h($post->originalAuthor->getUsername()) . '/posts/' . h($post->originalPost->refid) . '?_ref=' .  h($post->refid) . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')), true),
                                                    [
                                                        'class' => 'text-muted font-italic text-decoration-none d-inline-flex align-items-center justify-content-end',
                                                        'escapeTitle' => false
                                                    ]); ?>
                            </div>
                                            <?php elseif ($post->copied_as === 'plain'): ?>
                            <div class="text-plain <?= $fontSize ?>"><?= Text::truncate($post->getBody(), 240, ['ellipses' => '<a href="javascript:void(fullText())">See More</a>']); ?></div>
                                        <?php endif; ?>
                        </div>
                                    <?php else: ?>
                        <div class="<?= $fontSize ?>">
                                                <?= Text::truncate($post->getBody(), 240); ?>
                        </div>
                                    <?php endif; ?>
                    </div>
                                <?php endif; ?>
                                <?php if ($post->hasAttachments()): ?>
                    <div class="i__pc-embedment mb-3">
                                        <?= $this->PostHtml->frameAttachments($post->getAttachments()); ?>
                    </div>
                                <?php endif; ?>

                    <div class="d-flex align-items-center">
                                            <?= $this->PostHtml->buildCommentersList($post->comments); ?>
                        <!-- Call To Action Buttons -->
                        <div class="ml-auto _viG">
                            <div class="_EowDPO _viG bgc-grey-900">
                                <div class="_isCB42C _viG i__p-cta d-flex">
                                    <div class="dropdown _8iVgvJ ml-3 w_z1vxgS">
                                                        <?php
                                                        $state = 'no-reaction';
                                                        $reactionClass = '';
                                                        if (isset($activeUser) && $post->hasReactionFromUser($activeUser->refid)) {
                                                            $state = 'reacted';
                                                            $reactionClass = ' reacted';
                                                        }
                                                        ?>
                                        <a
                                            href="javascript:void(0)"
                                            class="_8iVgvJ _KpdPyj align-items-center bdrs-20 btn btn-icon btn-sm d-inline-flex justify-content-center mr-2 px-1 wh_30<?= $reactionClass ?> dropdown-toggle no-after"
                                            role="button"
                                            data-action="react"
                                            data-state="<?= $state ?>"
                                            data-toggle="dropdown"
                                            data-uri="<?= $postLink ?>/reactions"
                                            aria-haspopup="false">
                                            <i class="mdi mdi-18px mdi-emoticon-outline"></i>
                                            <span class="sr-only" aria-hidden="true">React</span>
                                        </a>
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
                                                                data-target="#e__cb-<?= h($randID); ?>"
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
                                                                data-target="#e__cb-<?= $randID; ?>"
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
                                                                data-target="#e__cb-<?= $randID; ?>"
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
                                                                data-target="#e__cb-<?= $randID; ?>"
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
                                                                data-target="#e__cb-<?= $randID; ?>"
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
                                                                data-target="#e__cb-<?= $randID; ?>"
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
                                                                data-target="#e__cb-<?= $randID; ?>"
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
                                                                data-target="#e__cb-<?= $randID; ?>"
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
                                                                data-target="#e__cb-<?= $randID; ?>"
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
                                                                data-target="#e__cb-<?= $randID; ?>"
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
                                                                data-target="#e__cb-<?= $randID; ?>"
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
                                    <div class="_8iVgvJ ml-3 w_z1vxgS">
                                        <a
                                            href="<?= $postLink ?>/comments"
                                            class="_n2Cuoj _8iVgvJ _KpdPyj align-items-center bdrs-20 btn btn-icon btn-sm d-inline-flex justify-content-center mr-2 px-1 wh_30"
                                            role="button"
                                            data-action="comment"
                                            aria-controls="#<?= $randID; ?>CommentContainer"
                                            aria-haspopup="false">
                                            <i class="mdi mdi-18px mdi-comment-plus"></i>
                                            <span class="sr-only" aria-hidden="true">Add Comment</span>
                                            <span class="_179 _Ad53 _sdDZ4U">
                                                                    <?php $data = json_encode([
                                                                        'replyingto' => $post->author->getUsername() . ' ' . ($post->hasValue('cc') ? h($post->cc) : ''),
                                                                        'uri' => Router::url('/' . h($post->author->getUsername()) . '/posts/' . $post->refid . '/comments/add_comment?reply_to=' . $post->refid),
                                                                        'id' => $post->refid,
                                                                        'type' => $post->type
                                                                    ]); ?>
                                                <span class="data" data='<?= $data ?>'></span>
                                            </span>
                                        </a>
                                                            <?php if (!$post->isEmpty('comments')): ?>
                                        <span class="reaction-counter">
                                                                <?= $this->Html->link(
                                                                    __('{0}', count($post->get('comments'))),
                                                                        $postLink . '/comments?ref=comment_counter',
                                                                    [
                                                                        'class' => 'text-muted-dark link',
                                                                        'escapeTitle' => false
                                                                    ]
                                                                ); ?>
                                        </span>
                                                            <?php endif; ?>
                                    </div>
                                    <div class="_8iVgvJ dropdown ml-3 w_z1vxgS">
                                        <button type="button" class="_8iVgvJ _KpdPyj align-items-center bdrs-20 btn btn-icon btn-sm d-inline-flex justify-content-center mr-2 px-1 wh_30 dropdown-toggle no-after" data-toggle="dropdown">
                                            <i class="mdi mdi-18px mdi-vector-arrange-above"></i><span class="sr-only" aria-hidden="true">Copy</span>
                                        </button>
                                        <div class="dropdown-menu">
                                            <div class="bg-light border-bottom mt-n2 px-5 py-2">Copy As:</div>
                                            <div class="">
                                                        <?= $this->Form->postButton(
                                                            __('<span class="mdi mdi-24px mdi-comment-quote mr-2 align-middle"></span> <span class="link-text">Quote</span>'),
                                                            'share/post?intent=clone&as=quote&post=' . urlencode($postLink),
                                                            [
                                                                'class' => 'dropdown-item',
                                                                'escapeTitle' => false,
                                                                'data-action' => "clone",
                                                                'data-clone-as' => "quote"
                                                            ]
                                                        ); ?>
                                                        <?= $this->Form->postButton(
                                                            __('<span class="mdi mdi-24px mdi-account-box-multiple mr-2 align-middle"></span> <span class="link-text">Own</span>'),
                                                            'share/post?intent=clone&as=verbatim&post=' . urlencode($postLink),
                                                            [
                                                                'class' => 'dropdown-item',
                                                                'escapeTitle' => false,
                                                                'data-action' => "clone",
                                                                'data-clone-as' => "quote"
                                                            ]
                                                        ); ?>
                                                        <?php /*
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
                                                         *
                                                         */ ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="_8iVgvJ dropdown bdrs-15 ml-3 w_z1vxgS">
                                            <?= $this->Html->link(
                                                __('<i class="mdi mdi-18px mdi-share"></i><span class="sr-only">Share</span>'),
                                                'javascript:void(0);',
                                                [
                                                    'class' => '_8iVgvJ _KpdPyj align-items-center bdrs-20 btn btn-icon btn-sm d-inline-flex justify-content-center mr-2 px-1 wh_30 dropdown-toggle no-after',
                                                    'data-toggle' => 'dropdown',
                                                    'escapeTitle' => false
                                                ]
                                            ); ?>
                                        <div class="dropdown-menu shadow-sm">
                                                <?= $this->Form->postButton(
                                                    __('<span class="mdi mdi-24px mdi-account-arrow-left mr-2 align-middle"></span> To my wall'),
                                                    [
                                                        'controller' => 'share',
                                                        'action' => 'post',
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
                                                    __('<span class="mdi mdi-24px mdi-comment-text-multiple mr-2 align-middle"></span> Share with comment'),
                                                    [
                                                        'controller' => 'share',
                                                        'action' => 'post',
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
                                                    __('<span class="mdi mdi-message-reply-text mdi-24px mr-2 align-middle"></span> Send as message'),
                                                    [
                                                        'controller' => 'share',
                                                        'action' => 'post',
                                                        '?' => [
                                                            'intent' => 'message',
                                                            'msg_type' => 'attachment',
//                        Id of the current post
                                                            'p_id' => h($post->refid),
                                                            'op_id' => (! empty($post->original_post_refid) ? h($post->original_post_refid) : h($post->refid)),

//                        The user on whose wall this post is being shared from
                                                            'utm_data_referer' => h($post->author->refid),
                                                            'p_type' => h($post->type),
                                                            'permalink' => urlencode($postLink),
                                                        ]
                                                    ],
                                                    [
                                                        'class' => 'dropdown-item',
                                                        'escapeTitle' => false
                                                    ]
                                                ); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="<?= $randID; ?>CommentContainer" class="comments-container collapsable collapse comment-area _Ad53 _lyAO5Z _ezNu bg-white mb-n3 mx-n3 p-4 pb-4 mt-3">
                <div class="has-form i__cmnts my-n3">
                                    <?php if (!$post->isEmpty('comments')): ?>
                    <div class="thread-container _JmTjyj _LaiiXU _SHzJez _aMJ203 _eTakD">
                        <div class="comments-thread" data-role="thread" data-thread="comments" data-default-length="5">
                                                <?php $this->PostHtml->getCommentsThread($post->comments, $post, ['threadType' => 'comments', 'category' => 'latest', 'quantity' => 5]); ?>
                        </div>
                    </div>
                                    <?php endif; ?>
                    <div id="commentComposer_<?= $randID ?>" class="my-5 composer comment-composer form-container _viG"
                         data-uri="<?= $postLink . '/comments/add_comment' ?>">
                        <div class="HDpHu _viG">
                            <div class="float-left mr-4">
                                <a href="#" class="has-avatar">
                                    <span class="avatar avatar-md"></span>
                                </a>
                            </div>
                            <div class="ml-7 pl-2 pos-r _viG">
                                <div class="d-flex gutters-xs">
                                    <div class="col">
                                        <div class="editor-wrapper">
                                            <div class="editor _VrtdFS pos-r _viG">
                                                <div id="cp_<?= $randID ?>" class="_mWZ _mpK lh-w4J n-Hk_Gw placeholder pos-a-l pos-a-r pos-a-t text-left textbox-placeholder" aria-hidden="true">
                                                    <span class="placeholder-text fsz-16 text-muted">Add comment...</span>
                                                </div>
                                                <div class="textbox-wrapper _viG">
                                                    <div id="<?= $randID ?>CommentTextEditor"
                                                         class="bdrs-20 text-editor comment-editor _Vy4 form-control fsz-16 h_I4Py h_aZ7 o-auto"
                                                         contenteditable="true"
                                                         role="textbox"
                                                         data-max="2000"
                                                         data-draftable="false"
                                                         spellcheck="true"
                                                         data-post-type="comment"
                                                         aria-multiline="true"
                                                         translate="true"
                                                         data-placeholder="#cp_<?= $randID ?>"
                                                         dir="auto"></div>
                                                </div>
                                            </div>
                                            <div id="<?= $randID ?>CommentComposerMediaContainer" class="media-container bdrs-15 o-hidden my-3 border _Ad53" aria-hidden="true"></div>
                                        </div>
                                        <div class="_d4ku mt-2">
                                            <div class="d-flex gutters-0 justify-content-between">
                                                <div class="col-auto d-inline-flex">
                                                    <div class="eY tool" data-content-type="media">
                                                        <div class="d-none invisible">
                                                            <input id="e_<?= $randID ?>_commentMedia" name="media" type="file" class="comment-media media-uploader" accept="image/jpg,image/jpeg,image/png,image/gif,video/ogg,video/mpeg4,video/mp4,video/mov,audio/ogg,audio/mpeg3,audio/mp3,audio/wav" multiple data-haspreview="true" data-preview="#commentComposerMediaContainer_<?= $randID ?>" aria-hidden="true">
                                                        </div>
                                                        <div class="media-btn btn btn-icon align-items-center bdrs-20 bgcH-grey-300 cH d-inline-flex icon justify-content-center wh_30" role="button" data-media-types="image,gif,video,audio" data-action="select-file" data-target="#e_<?= $randID ?>_commentMedia" aria-haspopup="false">
                                                            <span aria-hidden="true"><i class="mdi mdi-18px mdi-shape-square-plus"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="eY tool" data-content-type="emoji">
                                                        <div class="media-btn btn btn-icon align-items-center bdrs-20 bgcH-grey-300 cH d-inline-flex icon justify-content-center wh_30" role="button" aria-haspopup="false">
                                                            <span aria-hidden="true"><i class="mdi mdi-18px mdi-emoticon-outline"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="eY tool dropdown" data-content-type="options">
                                                        <div class="media-btn btn btn-icon align-items-center bdrs-20 bgcH-grey-300 cH d-inline-flex icon justify-content-center wh_30" role="button" data-toggle="dropdown">
                                                            <span aria-hidden="true"><i class="mdi mdi-18px mdi-chevron-down"></i></span>
                                                        </div>
                                                        <div class="dropdown-menu"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="_nyW6SD">
                                            <div class="submitBtn commentSubmit btn btn-azure disabled btn-pill" role="button" aria-haspopup="false" aria-disabled="true"><span class="btn-text">Send</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

