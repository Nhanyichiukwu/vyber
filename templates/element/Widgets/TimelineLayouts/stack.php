<?php

/**
 * @package Timeline Layout
 * @group Stack Layout
 * @name stack
 * @var App\View\AppView $this
 */
use Cake\Utility\Text;
use Cake\Utility\Inflector;
use Cake\Routing\Router;
use App\Utility\RandomString;
use App\Utility\DateTimeFormatter;

$user_timezone = $user->get('timezone');
?>
<?php if (!$this->get('timeline') || !count($this->get('timeline'))): ?>
    <h5 class="text-muted text-center text-light">Your newsstream is empty...</h5>
<?php else:
    $thisYear = date('Y');
    $timeline = $this->get('timeline');
    foreach ($timeline as $year => $posts): ?>
        <div id="timeline_<?= h($year); ?>" class="e_user-timeline timeline-stack">
            <?php
                /**    <div class="timeline-title year">
            $this->Html->link(
                __('{0}', h($year)),
                [
                    'controller' => 'i',
                    'action' => 'timeline',
                    '?' => [
                        'filter' => 'by_year',
                        'year' => $year
                    ]
                ],
                [
                    'class' => 'year',
                    'escapeTitle' => false
                ]
            );
    </div> **/ ?>
            <?php if ($year <= $thisYear): ?>
                <?php $posts = array_reverse($posts); ?>
                <div class="flex-column list-group list-group-flush post-list">
                    <?php foreach ($posts as $post): ?>
                    <?php
                        $postLink = Router::url('/' . $post->author->getUsername() . '/posts/' . $post->refid);
                        $randID = RandomString::generateString(16, 'mixedalpha');
//                        $vibelyData = json_encode(
//                            array(
//                                'hoverAction' => 'prefetch',
//                                'clickAction' => 'render',
//                                'handler' => 'Drawer.open',
//                                'src' => '/dynamic-contents/menu/context-menu?for=post&postid='
//                                    . $post->refid,
//                                'output' => '.bottom-drawer',
//                                'drawerTitle' => $post->author->getFirstName() . "&apos;s post"
//                            )
//                        );
                        ?>
                    <div id="post_<?= $randID ?>" class="_aQtRd7eh border-top i__post list-group-item mb-2 news-item p-0 shadow-sm viewable">
                        <div class="_1yT1Ry _SDyPWa p-3 _w5w has-context" aria-haspopup="true" data-focusable="true"
                             data-id="<?= $post->refid ?>" data-uri="<?= $postLink ?>">
                            <div class="_VDKqxd">
                                <div class="clearfix d-block">
                                    <div class="XwEdci">
                                        <div class="float-left mr-4">
                                            <a href="#" class="avatar avatar-lg"></a>
                                        </div>
                                        <div class="ml-8">
                                            <div class="i__pc-h pos-r">
                                                <x-vibely-post-context-menu class="action-menu e-custom-dropdown dropdown pos-a-r">
                                                    <?php
                                                    $drawerConfig = json_encode(
                                                        array(
                                                            'direction' => 'fb',
                                                            'drawerMax' => '95%',
                                                            'drawerTitle' => $post->author->getFirstName() . "&apos;s post",
                                                            'dataSrc' => Router::url(
                                                                '/dynamic-contents/menu/context-menu?for=post&postid='
                                                                . $post->refid, true
                                                            )
                                                        )
                                                    );
                                                    ?>
                                                    <a
                                                        href="javascript:void(0)"
                                                        data-toggle="drawer"
                                                        aria-controls="#<?= RandomString::generateString(
                                                            32,
                                                            'mixed',
                                                            'alpha'
                                                        ) ?>"
                                                        data-config='<?= $drawerConfig ?>'
                                                        class="align-items-center box-square-2 btn-white d-flex dropdown-toggle justify-content-center no-after rounded-circle text-center text-muted-dark"
                                                        >
                                                        <i class="mdi mdi-24px mdi-dots-vertical"></i></a>
                                                </x-vibely-post-context-menu>
                                                <div class="author-info post-meta pr-5">
                                                    <div class="account-name">
                                                    <?php
                                                    $screenName = $post->author->username;
                                                    if ($post->author->hasStageName) {
                                                        $screenName = $post->author->username;
                                                    }
                                                    ?>
                                                    <?= $this->Html->link(
                                                        __('<span class="account-fullname d-inline-block h6 mb-0 pb-0 text-dark">{fullname}</span>',
                                                            ['fullname' => Text::truncate(h
                                                            ($post->author->getFullname()), 40, ['ellipsis' => '...'])]),
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
                                                    <?php if (!$post->author->isEmpty('role')): ?>
                                                        <span class="badge badge-info">
                                                            <?= h($post->author->role)?>
                                                        </span>
                                                    <?php endif; ?>
                                                    </div>
                                                    <?php if (!$post->author->isEmpty('tagline')): ?>
                                                        <div class="user-tagline small">
                                                            <?= h($post->author->tagline) ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="content-meta small d-flex">
                                                        <div class="meta-publish-date small" data-role="post-date">
                                                            <i class="icon mdi mdi-clock"></i>
                                                            <span class="small">
                                                                <?= ucfirst(
                                                                    (new DateTimeFormatter())
                                                                    ->humanizeDatetime(
                                                                        $post->get('date'),
                                                                        $user_timezone
                                                                    )
                                                                ); ?>
                                                            </span>
                                                        </div>
                                                        <?php if (!$post->isEmpty('location')): ?>
                                                            <div class="meta-publish-location small" data-role="location">
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
                                                    <?php if ($postLength > 160): ?><small class="small"><a
                                                            href="javascript:void(fullText() || window.location.assign('<?= $postLink ?>'))">See More <i class="fe fe-chevron-right"></i></a></small><?php endif; ?>
                                                    </blockquote>
                                                </div>
                                                <div class="mt-6 fsz-16 text-right mr-6">
                                                <?= $this->Html->link(__('<span class="avatar avatar-placeholder mr-3" style="background-image: url()"></span><span class="username">@{username}</span>', ['username' => $post->originalAuthor->getUsername(), 'avatar' => $post->originalAuthor->profile->getImageUrl()]),
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
                                        <div class="i__pc-embedment mgriukcz mgziwfv1">
                                        <?= $this->PostHtml->frameAttachments($post->getAttachments()); ?>
                                        </div>
                                <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="_viG">
                            <div class="align-items-center">
                                <?php if (count($post->get('comments')) || count($post->get('reactions'))): ?>
                                    <div class="align-items-center d-flex interaction-counter justify-content-between p-3">
                                    <?= $this->PostHtml->buildCommentersList($post->comments); ?>
                                    <?php if (!$post->isEmpty('comments')): ?>
                                        <span class="comments-counter">
                                            <?= $this->Html->link(
                                                __('{0} Comments', count($post->get('comments'))),
                                                $postLink . '/comments?ref=comment_counter',
                                                [
                                                    'class' => 'text-muted-dark link fsz-smaller',
                                                    'escapeTitle' => false
                                                ]
                                            ); ?>
                                        </span>
                                    <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <!-- User Interaction Buttons -->
                                <div class="i__p-cta border-top _EowDPO _viG bgc-grey-900">
                                    <div class="_isCB42C _viG align-items-center d-flex justify-content-between px-3
                                    py-2f">
                                        <div class="dropdown _8iVgvJ">
                                            <?php
                                            $state = 'no-reaction';
                                            $reactionClass = '';
                                            if (isset($user) && $post->hasReactionFromUser($user->refid)) {
                                                $state = 'reacted';
                                                $reactionClass = ' reacted';
                                            }
                                            ?>
                                            <a
                                                href="javascript:void(0)"
                                                class="_8iVgvJ _KpdPyj align-items-center btn btn-icon btn-sm
                                                    d-inline-flex justify-content-center flex-column col py-2 lh-1<?=
                                                $reactionClass ?>
                                                    dropdown-toggle no-after"
                                                role="button"
                                                data-action="react"
                                                data-state="<?= $state ?>"
                                                data-toggle="dropdown"
                                                data-uri="<?= $postLink ?>/reactions"
                                                aria-haspopup="false">
                                                <i class="mdi mdi-18px mdi-emoticon-outline"></i>
                                                <span class="screen-reader-text" aria-hidden="false">React</span>
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
                                                                        data="<?= h($post->type); ?>_<?= h($post->refid); ?>_<?= h($post->author->refid); ?>_<?= h($user->refid); ?>"
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
                                                                        data="<?= h($post->type); ?>_<?= h($post->refid); ?>_<?= h($post->author->refid); ?>_<?= h($user->refid); ?>"
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
                                                                        data="<?= h($post->type); ?>_<?= h($post->refid); ?>_<?= h($post->author->refid); ?>_<?= h($user->refid); ?>"
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
                                                                        data="<?= h($post->type); ?>_<?= h($post->refid); ?>_<?= h($post->author->refid); ?>_<?= h($user->refid); ?>"
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
                                                                        data="<?= h($post->type); ?>_<?= h($post->refid); ?>_<?= h($post->author->refid); ?>_<?= h($user->refid); ?>"
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
                                                                        data="<?= h($post->type); ?>_<?= h($post->refid); ?>_<?= h($post->author->refid); ?>_<?= h($user->refid); ?>"
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
                                                                                    data="<?= h($post->type); ?>_<?= h($post->refid); ?>_<?= h($post->author->refid); ?>_<?= h($user->refid); ?>"
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
                                                                                    data="<?= h($post->type); ?>_<?= h($post->refid); ?>_<?= h($post->author->refid); ?>_<?= h($user->refid); ?>"
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
                                                                                    data="<?= h($post->type); ?>_<?= h($post->refid); ?>_<?= h($post->author->refid); ?>_<?= h($user->refid); ?>"
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
                                                                                    data="<?= h($post->type); ?>_<?= h($post->refid); ?>_<?= h($post->author->refid); ?>_<?= h($user->refid); ?>"
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
                                                                                    data="<?= h($post->type); ?>_<?= h($post->refid); ?>_<?= h($post->author->refid); ?>_<?= h($user->refid); ?>"
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
                                        <div class="_8iVgvJ">
                                            <a
                                                href="<?= $postLink ?>/comments"
                                                class="_n2Cuoj _8iVgvJ _KpdPyj align-items-center btn
                                                    btn-icon btn-sm d-inline-flex justify-content-center flex-column
                                                    col py-2 lh-1"
                                                role="button"
                                                data-action="comment"
                                                aria-controls="#<?= $randID; ?>CommentContainer"
                                                aria-haspopup="false">
                                                <i class="mdi mdi-18px mdi-comment-plus"></i>
                                                <span class="screen-reader-text" aria-hidden="false">Comment</span>
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
                                        </div>
                                        <div class="_8iVgvJ dropdown">
                                            <button type="button" class="_8iVgvJ _KpdPyj align-items-center
                                                btn btn-icon btn-sm d-inline-flex justify-content-center
                                                flex-column col py-2 lh-1
                                                dropdown-toggle no-after" data-toggle="dropdown">
                                                <i class="mdi mdi-18px mdi-vector-arrange-above"></i> <span
                                                    class="screen-reader-text" aria-hidden="true">Copy</span>
                                            </button>
                                            <div class="dropdown-menu">
                                                <div class="bg-light border-bottom mt-n2 px-5 py-2">Copy As:</div>
                                                <div class="">
                                                    <?= $this->Form->postButton(
                                                        __('<span class="mdi mdi-18px mdi-comment-quote mr-2 align-middle"></span> <span class="link-text">Quote</span>'),
                                                        'share/post?intent=clone&as=quote&post=' . urlencode($postLink),
                                                        [
                                                            'class' => 'dropdown-item',
                                                            'escapeTitle' => false,
                                                            'data-action' => "clone",
                                                            'data-clone-as' => "quote"
                                                        ]
                                                    ); ?>
                                                    <?= $this->Form->postButton(
                                                        __('<span class="mdi mdi-18px mdi-account-box-multiple mr-2 align-middle"></span> <span class="link-text">Own</span>'),
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
                                        <div class="_8iVgvJ dropdown">
                                            <?= $this->Html->link(
                                                __('<i class="mdi mdi-18px mdi-share"></i> <span class="screen-reader-text">Share</span>'),
                                                'javascript:void(0);',
                                                [
                                                    'class' => '_8iVgvJ text-dark py-2 lh-1 _KpdPyj align-items-center btn btn-icon btn-sm d-inline-flex justify-content-center flex-column col dropdown-toggle no-after',
                                                    'data-toggle' => 'dropdown',
                                                    'escapeTitle' => false
                                                ]
                                            ); ?>
                                            <div class="dropdown-menu shadow-sm">
                                                <?= $this->Form->postButton(
                                                    __('<span class="mdi mdi-18px mdi-account-arrow-left mr-2 align-middle"></span> To my wall'),
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
                                                    __('<span class="mdi mdi-18px mdi-comment-text-multiple mr-2 align-middle"></span> Share with comment'),
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
                                                    __('<span class="mdi mdi-message-reply-text mdi-18px mr-2 align-middle"></span> Send as message'),
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
                            <div id="<?= $randID; ?>CommentContainer" class="_Ad53 _ezNu _lyAO5Z border-top collapsable collapse comment-area comments-container mb--3 mb-n3 mt-3 mx--3 pb-4">
                                <div class="has-form i__cmnts">
                                    <?php if (!$post->isEmpty('comments')): ?>
                                        <div class="_LaiiXU _SHzJez _eTakD thread-container">
                                            <div class="comments-thread" data-role="thread" data-thread="comments" data-default-length="5">
                                                <?php $this->PostHtml->getCommentsThread($post->comments, $post, ['threadType' => 'comments', 'category' => 'latest', 'quantity' => 5]); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div id="commentComposer_<?= $randID ?>" class="composer comment-composer form-container _viG" data-uri="<?= $postLink . '/comments/add_comment' ?>">
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
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div><!-- End <?= h($year); ?> -->
    <?php endforeach;
endif; ?>
