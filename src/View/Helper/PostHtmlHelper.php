<?php
namespace App\View\Helper;

use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\View\Helper;
use Cake\View\Helper\HtmlHelper;
use Cake\View\Helper\UrlHelper;
use Cake\View\StringTemplateTrait;
use Cake\View\View;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use App\Utility\DateTimeFormatter;
use Cake\I18n\Time;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\Utility\FileManager;
use Cake\Routing\Router;
use App\Utility\RandomString;
use Cake\Collection\Collection;
use App\Model\Entity\Post;


/**
 * PostHtml helper
 */
class PostHtmlHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public $helpers = ['Html','Url', 'Form'];

    const UPLOAD_DIR = WWW_ROOT . 'public-files' . DS;

//    public function initialize(array $config) {
//        parent::initialize($config);
//    }

    public function addTemplate($data, $data_type)
    {
        $_dataTemplate = '_' . lcfirst(Inflector::camelize($data_type)).'Template';
        return $this->$_dataTemplate($data);
    }
    protected function _postTemplater($post)
    {
        return '<div class="news-item card mb-3">'
                    . '<div class="card-header bg-white border-bottom-0 d-flex news-item-header">' .
                        '<div class="action-menu position-absolute">' .
                            '<a class="btn"><i class="mdi mdi-menu"></i></a>' .
                        '</div>' .
                        '<!--<img src="img.jpg" class="user-thumb mr-3  d-inline-block border rounded-circle bg-light" alt="">-->' .
                        ($post->author->profile_image_url ?
                        '<span class="avatar avatar-lg mr-3" style="background: url(' . h($post->author->profile_image_url) . ')"></span>' :
                        '<span class="avatar avatar-placeholder avatar-lg mr-3"></span>') .
                        '<div class="author-info col-md-10 px-0 border-bottom pb-2">' .
                            '<p class="mb-0">' .
                                (isset($post->author->stageName) ?
                                '<a href="' . $this->Url->webroot('e/' . h($post->author->username)) . '" class="stagename _LsGU5g">' . h($post->author->stageName) . '</a>' :
                                '<a href="' . $this->Url->webroot('u/' . h($post->author->username)) . '" class="username _LsGU5g">' . h($post->author->username) . '</a>') .
                                (isset($post->author->role) ? '<span class="badge badge-info">' . h($post->author->role) . '</span>' : '') .
                            '</p>' .
                            (isset($post->author->tagline) ? '<div class="user-tagline _LsGU5g">' . h($post->author->tagline) . '</div>' : '') .
                            '<div class="content-meta _LsGU5g">' .
                                '<span class="meta-publish-date _LsGU5g" role="datetime">20m ago</span>' .
                                '<span class="meta-publish-location _LsGU5g" role="location"><i class="mdi mdi-map-marker-radius"></i> From: </span>' .
                            '</div>' .
                        '</div>'
                    . '<span id="' . h($post->refid) . '"></span>'
                    . '</div><!-- /End header -->'

                    . '<div class="pb-3 pl-3 pr-3">' .
                        '<div class="news-item-content" onclick="window.location = \'' . $this->Url->webroot('post/' . $post->refid) .'\'">' .
                            (!empty($post->post_text) ?
                            '<div class="content-text pb-2" role="status-text">' .
                                h($post->post_text) .
                            '</div>' : '' ) .
                            ($post->has_attachment <= 1 ?
                            '<div class="attachment-container card-deck content-attachment image mb-n3 media-attachment" role="attachment-container">'
                            . '<figure class="figure mb-0" role="photo">' . // Do a function for loading the attachment depending on the type
                                '<img src="./img/bg/bg-3.jpg" alt="A Photo">' .
                                '<figcaption class="description p-3">This is the imaage description...</figcaption>' .
                            '</figure>'
                            . '</div>' : '') .
                        '</div>' .
                    '</div><!-- / End body section -->' .

                    '<div class="bg-white card-footer news-item-footer position-relative">' .
                        '<ul class="reactions nav">' .
                            '<li>Comments</li>' .
                            '<li>Likes</li>' .
                            '<li>Shares</li>' .
                        '</ul>' .
                        '<div class="cta-btns btn-list position-absolute">' .
                            '<button type="button" class="btn btn-icon btn-light border rounded-circle mb-2 shadow-sm" role="cta" data-action="like" data-target="' . $post->refid . '"><span class="mdi mdi-heart-outline"></span></button>' .
                            '<button type="button" class="btn btn-icon btn-light border rounded-circle mb-2 shadow-sm" role="cta" data-action="comment" data-target="' . $post->refid . '"><span class="mdi mdi-comment-outline"></span></button>' .

                            $this->Html->link(__('<span class="mdi mdi-share"></span><span class="sr-only">Share</span>'),
                                    'javascript:void(0);',
                                    [
                                        'class' => 'btn btn-icon btn-light border rounded-circle shadow-sm dropdown-toggle-split',
                                        'data-toggle' => 'dropdown',
                                        'aria-expanded' => true,
                                        'aria-haspopup' => true,
                                        'escapeTitle' => false
                                    ]
                            )
                            . '<div class="dropdown-menu">'
                            . $this->Form->postLink(__('<span class="mdi mdi-share"></span> To my wall'),
                                    [
                                        'controller' => 'contents',
                                        'action' => 'share',
                                        '?' => [
                                            'intent' => 'adopt',
                                            '_c_id' => (!empty($post->shared_post_refid)? h($post->shared_post_refid) : h($post->refid)),
                                            'origin' => h($post->author->refid),
                                            '_s_src' => h($post->refid)
                                        ]
                                    ],
                                    [
                                        'class' => 'dropdown-item',
                                        'escapeTitle' => false
                                    ]
                            )
                            . $this->Html->link(__('<span class="mdi mdi-share"></span> Share with comment'),
                                    [
                                        'controller' => 'content-share',
                                        'action' => 'index',
                                        '?' => [
                                            'intent' => 'add_comment',
                                            'top_level_cid' => (!empty($post->shared_post_refid)? h($post->shared_post_refid) : h($post->refid)),
                                            'c_type' => 'photo',
                                            't_type' => 'user',
                                            't_id' => h($post->author->refid)
                                        ]
                                    ],
                                    [
                                        'class' => 'dropdown-item',
                                        'escapeTitle' => false
                                    ]
                            )
                            . $this->Html->link(__('<span class="mdi mdi-share"></span> Send as message'),
                                    [
                                        'controller' => 'content-share',
                                        'action' => 'index',
                                        '?' => [
                                            'intent' => 'message',
                                            'msg_type' => 'attachment',
                                            'permalink' => 'some_url_goes_here',
                                            'top_level_cid' => '80530835085533',
                                            'c_type' => 'photo'
                                        ]
                                    ],
                                    [
                                        'class' => 'dropdown-item',
                                        'escapeTitle' => false
                                    ]
                            )
                            . ' <div class="dropdown-divider"></div>'
                            . '<a class="dropdown-item" href="#">Separated link</a>'
                            . '</div>' .
                        '</div>' .
                        '<div class="comments-thread">' .

                        '</div>' .
                    '</div><!-- End footer section -->' .
                '</div>';
    }

    public function embedAttachments($attachments) {
?>
        <?php $attachments = array_chunk($attachments, 2); ?>
        <div class="mt-4 o-hidden post-media-container">
            <div class="_tqGl post-media-list hma8sd2c" data-layout="grid">
                <?php
                $max = 4;
                $pointer = 0;
                ?>
                <?php foreach($attachments as $column => $items): ?>
                    <?php
                        if (count($items) > $max && $pointer >= $max) {
                            // I am tring to limit the number of attachments that
                            // can b
                        }
                    ?>
                <div class="post-media-groups _LFwB _2w5s" data-role="column" data-layout="stack">
                    <?php foreach($items as $attachment): ?>
                    <div class="media-group mpfiqsne pos-r half-height" role="group" id="m<?= $pointer ?>">
                        <div class="mr-2 mt-2 pos-a-r pos-a-t z-9">
                            <div class="align-items-center bdrs-20 bgcH-grey-700
                                 btn cH-grey-300 text-muted d-flex justify-content-center p-0 wh_30" role="button" aria-haspopup="false">
                                <span class="lh_Ut7" aria-hidden="false" data-toggle="tooltip" title="Options" data-placement="top">
                                    <i class="mdi mdi-24px mdi-chevron-down"></i>
                                </span>
                            </div>
                        </div>
                        <?php
                        $_getPostAttachmentWrapper = '_getPost' . Inflector::camelize($attachment->get('attachment_type')) . 'Wrapper';
                        $this->{$_getPostAttachmentWrapper}($attachment);
                        ?>

                        <div class="_kx7 _3oz"></div>
                    </div>
                    <?php $pointer += 1; ?>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
<?php
    }

    protected function _getPostPhotoWrapper($attachment)
    {
        $ext = FileManager::getFileExtension($attachment->file_path);
        $photoUri = Router::url('/media/' .  $attachment->attachment_refid . '?type=photo&format=' . $ext . '&size=small', true);
?>
        <div class="s428vimu" data-media-type="photo">
            <div class="media-box _kx7 _poYC _3PpE o-hidden _XZA1 _v6nr"
                 style="background-image: url(<?= $this->Url->assetUrl($photoUri, ['fullBase' => true]) ?>);">
                <?= $this->Html->image($photoUri, ['class' => 'media _Aqj']); ?>
            </div>
        </div>

<?php
    }

    protected function _getPostVideoWrapper($attachment)
    {
//        $videoUri = str_replace('\\', '/', h($attachment->file_path));
        $video = new File(rtrim(WWW_ROOT, DS) . DS . 'media' . DS . $attachment->file_path);
        $ext = FileManager::getFileExtension($video->path);
        $videoUri = Router::url('/media/' .  $attachment->attachment_refid . '?type=video&format=' . $ext . '&controls=true', true);
?>
        <div class="s428vimu" data-media-type="video">
            <div class="media-box _kx7 _poYC _3PpE o-hidden _XZA1 _v6nr">
                <?php $this->Html->media($videoUri,
                        [ 'type' => 'video', 'fullBase' => true, 'class' => 'media']); ?>
                <video class="media" src="<?= $videoUri ?>" controls="true">Unsupported!</video>
            </div>
        </div>
<?php
    }

    protected function _enclosedPost($post) {

    }

    public function getCommentsThread(array $threads, $originalPost = null, array $params = [])
    {
        $threadType = 'comments';

        if (array_key_exists('threadType', $params)) {
            $threadType = $params['threadType'];
        }
        if (!count($threads)) {
            return null;
        }

        $filter = 'latest';
        $quantiy = 3;
        $groupSimultaneousCommentsBySameAuthor = false;

        if (array_key_exists('filter', $params)) {
            $filter = $params['filter'];
        }
        if (array_key_exists('simultaneous_author_grouping', $params)) {
            $groupSimultaneousCommentsBySameAuthor = (bool) $params['simultaneous_author_grouping'];
        }

        $collection = new Collection($threads);
        $result = [];

        switch ($filter) {
            case 'latest':
                $result = $collection->take($quantiy, 0)->toArray();
                break;
            case 'trending':
                $result = $collection->take($quantiy, 0)->max(function ($comment) {
                    return $comment->replies;
                });
                break;
            case 'random':
                $result = $collection->sample($quantiy)->toArray();
                break;
            default:
                $result = $collection->take($quantiy, 0)->toArray();
                break;
        }

        echo '<div class="_5w3VqI">';
        echo     '<div class="_h3M3vO">';
        echo         '<ul class="_TikBHt _Ax2no mx-0 px-0">';
                echo $this->buildCommentsThread($result, $originalPost, $groupSimultaneousCommentsBySameAuthor);
        echo         '</ul>';
        echo     '</div>';
        echo '</div>';
    }

    public function buildCommentsThread(array $comments, $originalPost, $enableSameAuthorCommentGrouping = false)
    {
        $comments = new \ArrayIterator($comments);
        $currentIndex = 0;
        $groupedComments = [];

        do {
            $prevComment = null;
            $thisComment = $comments->current();
            $nextComment = null;
            $nextOffset = $currentIndex + 1;

            if ($comments->offsetExists($nextOffset)) {
                $nextComment = $comments->offsetGet($currentIndex + 1);
            }

            /*
             * When the index increases by 1, it means the iterator just walked pass 1
             * comment, so we acknowledge that as the previous comment
             */
            if ($currentIndex >= 2) {
                $prevComment = $comments->offsetGet($currentIndex - 1);
            }

            $thisCommentAuthor = $thisComment->author;
            $nextCommentAuthor = null;
            if ($nextComment instanceof \App\Model\Entity\Post) {
                $nextCommentAuthor = $nextComment->author;
            }

            /*
             * On each iteration, we check if the current comment and the next one inline
             * are by the same author. If so, we group both of them in one container.
             * We repeat the procedure for each incoming comment, until the author changes.
             */
            if (
                    $enableSameAuthorCommentGrouping &&
                    $nextCommentAuthor instanceof \App\Model\Entity\User &&
                    $thisCommentAuthor->isSameAs($nextCommentAuthor)
                ) {
                // Add the previous comment only if it had not been added during the
                // previous iteration
                if (!in_array($thisComment, $groupedComments)) {
                    $groupedComments[] = $thisComment;
                }
                $groupedComments[] = $nextComment;
            } else {
                /*
                 * At this point, we are now dealing with a different author.
                 * But first we check the previously grouped comments
                 * container to see if we'll find anything. If so, we
                 * wrap them sequencilly and attribute them all to
                 * one author, and then empty the container
                 */

                $groupedComments = array_unique($groupedComments);
                if (sizeof($groupedComments) >= 2) {
                    $limit = 3;
                    $shouldHaveHeader = true;
                    for ($x = 0, $x < $limit; $x < count($groupedComments); $x++):
    //                    if ($x > 0) {
    //                        $shouldHaveHeader = false;
    //                    }
                        $comment = $groupedComments[$x];
                        $params = ['class_list' => ['_yPsgik']];
                        echo '<li class="_cxXFxo _aQtRd7eh _yPsgik">';
                        echo  $this->beautifyComment($comment, $originalPost, $params);
                        echo '</li>';
                    endfor;
                    $groupedComments = [];
                } else {
                    /*
                     * Otherwise we just treat this comment as of a whole different
                     * author.
                     */
                    echo '<li class="_cxXFxo _aQtRd7eh">';
                    echo $this->beautifyComment($thisComment, $originalPost);
                    echo '</li>';
                }
            }

            $comments->next();
            $currentIndex += 1;
        } while ($comments->valid());

    }

    /**
     * Generate wrapper for a single comment line
     *
     * @param \App\Model\Entity\Post $comment
     * @param \App\Model\Entity\Post $originalPost The post that owns the thread
     * @param array $params
     */
    public function beautifyComment(Post $comment, Post $originalPost, array $params = [])
    {
        $includeAttribution = true;
        $wrapper = null;
        $commentID = '_' . RandomString::generateString(8, 'mixed');
        $additionalClasses = '';
        $id = '';
        if (array_key_exists('attribution', $params)) {
            $includeAttribution = (bool) $params['attribution'];
        }
        if (array_key_exists('wrapper', $params)) {
            $wrapper = (string) $params['wrapper'];
        }
        if (array_key_exists('id', $params)) {
            $id = ' id="' . $params['id'] . '"';
        }
        if (array_key_exists('class_list', $params)) {
            $additionalClasses = implode(' ', $params['class_list']);
            $additionalClasses = ' ' . $additionalClasses;
        }
?>
    <?php if ($wrapper !== null): ?>
        <?= '&lt;'. $wrapper . $id . 'class="_cxXFxo ' . $additionalClasses . '"&gt;'; ?> <?php /* Opening Tag */ ?>
    <?php endif; ?>
            <div class="_SDyPWa" data-id="<?= $comment->refid ?>">
                <div class="_f3bP2e clearfix">
                    <?php
                    $avatarSize = 'avatar-md';
                    $bubbleOffset = 'offset-1 ps-2';
                    if ($comment->type === 'reply') {
                        $avatarSize = 'avatar-sm';
                        $bubbleOffset = 'offset-1';
                    }
                    ?>
                    <?php if ($includeAttribution): ?>
                    <div class="_4dGjA _zJyLVm">
                        <span class="avatar <?= $avatarSize ?>"></span>
                    </div><!-- Author Avatar -->
                    <?php endif; ?>
                    <div class="_xouDIQ <?= $bubbleOffset ?>">
                        <div class="_M22YBE">
                            <div class="_ex5BsO">
                                <div class="bgc-grey-200 speech-bubble text-dark _oFb7Hd d-inline-block py-2 _xouDIQ" data-toggle="collapse" data-target="#c<?= $commentID ?>">
                                    <div class="comment-header">
                                    <?php if ($includeAttribution): ?>
                                        <a href="<?= h($comment->author->getUsername()); ?>" class="account-fullname font-weight-bold lh_f5 _LsGU5g text-dark text-nowrap"><?= $comment->author->getFullname(); ?></a>
                                        <?php /*
                                        <span class="replying-to"> &gt; </span>
                                        <a href="<?= $post->author->getUsername(); ?>" class="recipients _LsGU5g">@<?= h($post->author->getUsername()); ?></a>
                                        */ ?>
                                    <?php endif; ?>
                                        <div class="_Ax2no _LsGU5g _Y7wf _qRwCre _wf7p mr-1">
                                            <?php
                                            /*
                                             * <div class="dropdown">
                                                <span class="align-items-center bgcH-grey-300 btn btn-sm d-flex justify-content-center rounded-circle text-muted wh_30" data-toggle="dropdown">
                                                    <i class="mdi mdi-24px mdi-chevron-down" aria-hidden="true"></i>
                                                </span>
                                                <div class="dropdown-menu shadow-sm">
                                                    <?=
                                                    $this->Form->postButton(
                                                            __('<span class="mdi mdi-24px mdi-account-arrow-left mr-2 align-middle"></span> To my wall'), [
                                                        'controller' => 'share',
                                                        'action' => 'post',
                                                        '?' => [
                                                            'intent' => 'adopt',
                                                            // Id of the post that is being shared
                                                            'p_id' => h($thread->refid),
                                                            //                      Id of the original post where this was curled from
                                                            'op_id' => (!empty($thread->original_post_refid) ? h($thread->original_post_refid) : h($thread->refid)),
                                                            //                        The user on whose wall this post is being shared from
                                                            'utm_data_referer' => h($thread->author->refid)
                                                        ]
                                                            ], [
                                                        'class' => 'dropdown-item',
                                                        'escapeTitle' => false
                                                            ]
                                                    );
                                                    ?>
                                                    <?=
                                                    $this->Html->link(
                                                            __('<span class="mdi mdi-24px mdi-comment-text-multiple mr-2 align-middle"></span> Share with comment'), [
                                                        'controller' => 'share',
                                                        'action' => 'post',
                                                        '?' => [
                                                            'intent' => 'comment',
                                                            //                        Id of the current post
                                                            'p_id' => h($thread->refid),
                                                            //                        Id of the original post where this was curled from
                                                            'op_id' => (!empty($thread->original_post_refid) ? h($thread->original_post_refid) : h($thread->refid)),
                                                            //                        The user on whose wall this post is being shared from
                                                            'utm_data_referer' => h($thread->author->refid)
                                                        ]
                                                            ], [
                                                        'class' => 'dropdown-item',
                                                        'escapeTitle' => false
                                                            ]
                                                    )
                                                    ?>
                                                </div>
                                            </div>
                                             */
                                            ?>
                                        </div>
                                    </div>
                                    <div class="comment-body _rvx8Cm _LsGU5g">
                                        <span class="comment-text"><?= $comment->getBody() ?></span>
                                    </div>
                                </div>
                                <div id="c<?= $commentID ?>" class="_psE3sD datetime lh_f5 pt-1">
                                    <div class="_KcBAni px-3">
                                        <div class="row justify-content-start">
                                            <div class="comment-time reply-time _LsGU5g px-2">
                                                <span class="text-muted"><i class="mdi mdi-clock"></i></span>
                                                <span class="_LsGU5g">
                                                    <a
                                                        href="<?= $originalPost->author->getUsername() ?>/posts/<?= $originalPost->refid ?>/comments/<?= $comment->refid ?>"
                                                        class="_oFb7Hd _zeN4uW _dBHmq _LsGU5g text-muted-dark">
                                                        <?= h(DateTimeFormatter::humanizeDateTime($comment->date_published)) ?>
                                                    </a>
                                                </span>
                                            </div>
                                            <div class="_LsGU5g px-2">
                                                <div class="_LsGU5g _dBHmq px-3">
                                                    <span class="mx-1"><a href="" class="link _zeN4uW" role="button"><span class="_alrAs c-primary">Like</span></a></span>
                                                    <span class="mx-1">
                                                        <a href="<?= Router::url('/' . h($originalPost->author->getUsername()) . '/posts/' . $originalPost->refid . '/comments/add_comment?reply_to=' . $comment->refid) ?>"
                                                           data-action="reply"
                                                           class="link _zeN4uW"
                                                           role="button">
                                                            <span class="_alrAs c-green">Reply</span>
                                                            <span class="_179 _Ad53 _sdDZ4U">
                                                                <?php $data = json_encode([
                                                                    'replyingto' => $comment->author->getUsername() . ' ' . ($comment->hasValue('cc') ? h($comment->cc) : ''),
                                                                    'uri' => Router::url('/' . h($originalPost->author->getUsername()) . '/posts/' . $originalPost->refid . '/comments/add_comment?reply_to=' . $comment->refid),
                                                                    'id' => $comment->refid,
                                                                    'type' => $comment->type
                                                                ]); ?>
                                                                <span class="data" data='<?= $data ?>'></span>
                                                            </span>
                                                        </a>
                                                    </span>
                                                    <?php
                                                    /*
                                                     * <div class="mx-1 dropdown">
                                                        <a href="#" class="link _zeN4uW" role="button" data-toggle="dropdown"><span class="_alrAs c-amber">Share</span></a>
                                                        <div class="dropdown-menu shadow-sm">
                                                            <?=
                                                            $this->Form->postButton(
                                                                    __('<span class="mdi mdi-24px mdi-account-arrow-left mr-2 align-middle"></span> To my wall'), [
                                                                'controller' => 'share',
                                                                'action' => 'post',
                                                                '?' => [
                                                                    'intent' => 'adopt',
                                                                    // Id of the post that is being shared
                                                                    'p_id' => h($originalPost->refid),
                                                                    //                      Id of the original post where this was curled from
                                                                    'op_id' => (!$originalPost->isEmpty('original_post_refid') ? h($originalPost->original_post_refid) : h($originalPost->refid)),
                                                                    //                        The user on whose wall this post is being shared from
                                                                    'utm_data_referer' => h($originalPost->author->refid)
                                                                ]
                                                                    ], [
                                                                'class' => 'dropdown-item',
                                                                'escapeTitle' => false
                                                                    ]
                                                            );
                                                            ?>
                                                            <?=
                                                            $this->Html->link(
                                                                    __('<span class="mdi mdi-24px mdi-comment-text-multiple mr-2 align-middle"></span> Share with comment'), [
                                                                'controller' => 'share',
                                                                'action' => 'post',
                                                                '?' => [
                                                                    'intent' => 'comment',
                                                                    //                        Id of the current post
                                                                    'p_id' => h($originalPost->refid),
                                                                    //                        Id of the original post where this was curled from
                                                                    'op_id' => (!empty($originalPost->original_post_refid) ? h($originalPost->original_post_refid) : h($originalPost->refid)),
                                                                    //                        The user on whose wall this post is being shared from
                                                                    'utm_data_referer' => h($originalPost->author->refid)
                                                                ]
                                                                    ], [
                                                                'class' => 'dropdown-item',
                                                                'escapeTitle' => false
                                                                    ]
                                                            )
                                                            ?>
                                                        </div>
                                                    </div>
                                                     */
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php if (!$comment->isEmpty('replies')): ?>
                                <div class="replies replies-thread _psE3sD lh_f5 px-2 mt-4" data-role="thread" data-thread="replies" data-default-length="3">
                                    <?= $this->getCommentsThread($comment->replies, $originalPost, ['threadType' => 'replies', 'category' => 'latest', 'quantity' => 3]); ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div><!-- Comment Details -->
                </div>
            </div>
        <?php if ($wrapper !== null): ?>
        <?= '&lt;/' . $wrapper . '&gt;'; ?> <?php /* Closing Tag */ ?>
        <?php endif; ?>
<?php
    }

    public function buildCommentersList($comments)
    {
        // Make a list of at most 5 recent commenters
        if (is_array($comments)) {
            $comments = new Collection($comments);
        }

        $commenters = $comments->extract(
            function ($comment) {
                return $comment->author;
            }
        )->toArray();

        if (is_array($commenters)) {
            $commenters = array_unique($commenters);
            // Cast ii back to collection object
            $commenters = new Collection($commenters);
        }

        if (!$commenters->isEmpty()): ?>
            <div class="post-commenters">
                <div class="_toAbNX">
                    <div class="avatar-list avatar-list-stacked">
                    <?php $commenters->take(5, 0)->each(function ($commenter) { ?>
                        <div class="avatar avatar-sm o-hidden avatar-placeholder" style="background-image: url(<?= $commenter->profile->getImageUrl() ?>)">
                            <a class="d-block h-100 w-100 pos-r"
                               href="<?= Router::url('/' . h($commenter->getUsername()), true); ?>"
                               data-hoveraction="profilecard"
                               data-focusable="true"
                               target="_blank"
                               aria-haspopup="false"
                               role="profile-link"
                               ><span class="sr-only"><?= h($commenter->getFullname()) ?></span></a>
                        </div>
                    <?php }); ?>
                    <?php if ($commenters->count() > 5): ?>
                        <div class="avatar avatar-sm">+<?= ($commenters->count() - 5) ?></div>
                    <?php endif; ?>
                    </div>
                </div>
            </div>

<?php   endif;
    }
}
