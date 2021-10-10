<?php

use Cake\Utility\Text;
use Cake\Utility\Inflector;
use App\Utility\Calculator;
?>
<div class="d-b e__sBs mb-2">
    <?php if (! empty($comment->author->profile_image_url)): ?>
    <img class="avatar avatar-placeholder fl-l mr-3 e__sBs-l" src="<?= h($comment->author->profile_image_url)?>">
    <?php else: ?>
    <div class="avatar avatar-placeholder fl-l mr-3 e__sBs-l"></div>
    <?php endif; ?>
    <div class="e__sBs-r kUR235 offset-2 w-auto">
        <div class="post-content-wrap  mb-5">
        <div class="speech-bubble :has-author-name :has-reaction-btn :meta-data bdrs-5 card mb-0 pos-r">
            <div class="card-body px-3 py-1">
            <p class="mb-0 account-name">
            <?php
                    $screenName = $comment->author->username;
                    if ($comment->author->hasStageName) {
                        $screenName = $comment->author->username;
                    }
                    ?>
                <?= $this->Html->link(
                    __('<strong class="account-fullname d-b mb-0 pb-0 d-inline-block">{fullname}</strong>', 
                            ['fullname' => h($comment->author->getFullname())]), 
                    [
                        'controller' => 'e',
                        'action' => h($screenName)
                    ],
                    [
                        'class' => 'profileUrl',
                        'data-hover-event' => 'profile.preview',
                        'data-profile-url' => $this->Url->request->getAttribute('base') . '/e/async/prfilecard/',
                        'aria-expanded' => 'true',
                        'aria-has-hoverprofilecard' => 'true',
                        'escapeTitle' => false
                    ]
                ); ?>
                <?= (isset($comment->author->role) ? '<span class="badge badge-info">' . h($comment->author->role) . '</span>' : '') ?>
            </p>
        <?php if (! empty($comment->text)): ?>
            <div class="content-text pb-2" data-role="status-text">
                <?= htmlspecialchars_decode(html_entity_decode($comment->text)); ?>
            </div>
            <?php endif; ?>
            <?php if ((int) $comment->has_attachment === 0): ?>
            <!-- -->
            <!-- -->
            <!-- -->
            <!-- Create a function to load the attachment depending on the type -->
            <div class="attachment-container content-attachment image mb-2 media-attachment ov-h rounded-lg" role="attachment-container">
                <figure class="figure mb-0 pos-r" role="photo">
                    <img src="./img/bg/bg-3.jpg" alt="A Photo">
                    <figcaption class="b-0 description l-0 p-3 pos-a r-0">This is the imaage description...</figcaption>
                </figure>
            </div>
            <!-- -->
            <!-- -->
            <!-- -->
            <?php endif; ?>
            
            <span class="clearfix"></span>
            </div>
        </div>
        <div class="nHK3i mb-3">
            <div class="row gutters-sm">
                <div class="col-5">
                    <div class="content-meta small pt-1">
                        <span class="meta-publish-date small" role="datetime">
                            <i class="icon mdi mdi-clock"></i> 
                            <small class="fsz-xs"><?= (new Calculator)->calculateTimePassedSince(h($comment->created), 2); ?></small>
                        </span>
                <?php if ($comment->hasLocationInfo): ?>
                        <span class="meta-publish-location small" role="location"><i class="mdi mdi-map-marker-radius"></i> From: <?= h($comment->location); ?></span>
                <?php endif; ?>
                    </div>
                </div>
                <div class="col-7">
                    <ul class="reactions-counter nav">
                        <li>
                            <button type="button" name="reply_to_<?= $comment->refid; ?>" class="btn btn-sm btn-transparent">
                                <span class="mdi mdi-reply"></span> <span class="">Reply</span>
                            </button>
            <?php if (isset($comment->replies)): ?>
                            <small class="small counter"><?= $this->Number->format($comment->replies->count); ?></small>
            <?php endif; ?>
                        </li>
                        <li>
                            <button type="button" name="reply_to_<?= $comment->refid; ?>" class="btn btn-sm btn-transparent">
                                <span class="mdi mdi-heart-outline"></span> <span class="">Like</span>
                            </button>
                <?php if (property_exists($comment, 'likes')): ?>
                            <small class="small counter"><?= $this->Number->format($comment->likes->count); ?></small>
                <?php endif; ?>
                        </li>
                        <li>
                            <button type="button" name="reply_to_<?= $comment->refid; ?>" class="btn btn-sm btn-transparent">
                                <span class="mdi mdi-share-variant"></span> <span class="">Share</span>
                            </button>
                <?php if (property_exists($comment, 'shares')): ?>
                            <small class="small counter"><?= $this->Number->format($comment->shares->count); ?></small>
                <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        </div>
    </div>  
</div>