<?php 
use Cake\Utility\Text;
use Cake\Utility\Inflector;
use App\Utility\Calculator;
?>
<div class="news-item card post-card mb-3">
    <div class="card-header bg-white border-bottom-0 d-flex news-item-header">
        <div class="action-menu position-absolute">
            <a class="btn"><i class="mdi mdi-menu"></i></a>
        </div>
        <?php if (! empty($post->author->profile_image_url)): ?>
            <img class="avatar avatar-lg mr-3" src="<?= h($post->author->profile_image_url)?>">
        <?php else: ?>
            <div class="avatar avatar-placeholder avatar-lg mr-3"></div>
        <?php endif; ?>
        <div class="author-info col-md-10 px-0 border-bottom pb-2">
            <h4 class="mb-0 account-name">
                <?= $this->Html->link(
                    __('<strong class="account-fullname d-b mb-0 pb-0">{0}</strong>', h($post->author->getFullname())), 
                    [
                        'controller' => 'e',
                        'action' => h($post->author->username)
                    ],
                    [
                        'class' => 'profileUrl small',
                        'data-hover-event' => 'profile.preview',
                        'data-profile-url' => $this->Url->request->getAttribute('base') . '/e/async/prfilecard/',
                        'aria-expanded' => 'true',
                        'aria-has-hoverprofilecard' => 'true',
                        'escapeTitle' => false
                    ]
                ); ?>
                <!-- Username -->
                <?php if ($post->author->hasStageName): ?>
                    <?= $this->Html->link(
                        __('<span class="account-screenname">{0}</span>', h($post->author->stagename)), 
                        [
                            'controller' => 'e',
                            'action' => h($post->author->username)
                        ],
                        [
                            'class' => 'stagename small',
                            'aria-expanded' => 'true',
                            'aria-has-hoverpopcard' => 'true',
                            'escapeTitle' => false
                        ]
                    ); ?>
                <?php else: ?>
                    <?= $this->Html->link(
                        __('{0}', h($post->author->username)), 
                        [
                            'controller' => 'e',
                            'action' => h($post->author->username)
                        ],
                        [
                            'class' => 'stagename small',
                            'aria-expanded' => 'true',
                            'aria-has-hoverpopcard' => 'true',
                            'escapeTitle' => false
                        ]
                    ); ?>
                <?php endif; ?>
                <?= (isset($post->author->role) ? '<span class="badge badge-info">' . h($post->author->role) . '</span>' : '') ?>
            </h4>
            <?= ($post->author->hasTagline ? '<div class="user-tagline small">' . h($post->author->tagline) . '</div>' : ''); ?>
            <div class="content-meta small">
                <span class="meta-publish-date small" role="datetime">
                    <i class="icon mdi mdi-clock"></i> 
                    <small class="fsz-xs"><?= (new Calculator)->calculateTimePassedSince(h($post->created), 2); ?></small>
                </span>
                <?php if ($post->hasLocationInfo): ?>
                <span class="meta-publish-location small" role="location"><i class="mdi mdi-map-marker-radius"></i> From: <?= h($post->location); ?></span>
                <?php endif; ?>
            </div>
        </div> 
        <span id="<?= h($post->refid) ?>"></span>
    </div><!-- /End Post header -->

    <div class="pb-3 pl-3 pr-3">
        <div 
            class="news-item-content" 
            data-url="<?= $this->Url->webroot('e/'. h($post->author->username).'/posts/'.h($post->refid))
                        ?>/?p_type=<?= h($post->type) 
                        ?>&op_id=<?= h($post->original_post_refid) 
                        ?>" data-role="post-body" >
            
            <?php if (! empty($post->post_text)): ?>
            <div class="content-text pb-2" data-role="status-text">
                <?= $post->post_text; ?>
            </div>
            <?php endif; ?>
            <?php if ((int) $post->has_attachment === 1): ?>
            <!-- -->
            <!-- -->
            <!-- -->
            <!-- Create a function to load the attachment depending on the type -->
            <div class="attachment-container card-deck content-attachment image mb-n3 media-attachment" role="attachment-container">
                <figure class="figure mb-0" role="photo">
                    <img src="./img/bg/bg-3.jpg" alt="A Photo">
                    <figcaption class="description p-3">This is the imaage description...</figcaption>
                </figure>
            </div>
            <!-- -->
            <!-- -->
            <!-- -->
            <?php endif; ?>
        </div>
    </div><!-- / End body section -->

    <div class="bg-gray-lightest card-footer news-item-footer position-relative">
        <ul class="reactions nav">
            <li><label class="label">Comments</label> <small class="small counter"></small></li>
            <li><label class="label">Like</label> <small class="small counter"></small></li>
            <li><label class="label">Shares</label> <small class="small counter"></small></li>
        </ul>
        <div class="cta-btns btn-list position-absolute">
            <button type="button" class="btn btn-icon btn-light border rounded-circle mb-2 shadow-sm" role="cta" data-action="like" data-target="<?= h($post->refid) ?>">
                <span class="mdi mdi-heart-outline"></span>
            </button>
            <button type="button" class="btn btn-icon btn-light border rounded-circle mb-2 shadow-sm" role="cta" data-action="comment" data-target="<?= h($post->refid) ?>">
                <span class="mdi mdi-comment-outline"></span>
            </button>
            <?= $this->Html->link(
                    __('<span class="mdi mdi-share"></span><span class="sr-only">Share</span>'), 
                    'javascript:void(0);',
                    [
                        'class' => 'btn btn-icon btn-light border rounded-circle shadow-sm dropdown-toggle-split',
                        'data-toggle' => 'dropdown',
                        'aria-expanded' => true,
                        'aria-haspopup' => true,
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
        <?php if (count($post->comments)): ?>
        <div id="e__post_<?= h($post->refid); ?>-comments" class="e__post-comments" role="comments-thread">
            <?= $this->element('Singletons/post_comments_singleton', [$post->comments]); ?>
        </div>
        <?php endif; ?>
    </div><!-- End footer section -->
</div>

