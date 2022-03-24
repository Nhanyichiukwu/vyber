<?php

use Cake\Routing\Router;
use Cake\Utility\Text;
?>
<?php
if (isset($posts) && count($posts)) {
    echo '<div class="flex-nowrap flex-row foa3ulpk mx-n3 n1ft4jmn ofx-auto px-1 row">';
    foreach ($posts as $post): ?>
    <?php 
    $postLink = $post->author->getUsername() . '/posts/' . $post->refid; 
    ?>
    <div class="col-11 col-md-5 col-sm-7 col-xl-5 djmlyve7">
        <div class="card shadow-sm mmhtpn7c ajqwjj6r e8wksrsz">
            <!--<a href="#" class="align-items-center border-bottom d-flex justify-content-center p-2 text-center">
                <span class="avatar avatar-xl">
                    <i class="mdi mdi-pound mdi-48px"></i>
                </span>
            </a>-->
            <div class="card-body d-flex flex-column">
                <?php if (!$post->isEmpty('post_text')): ?>
                    <div class="text-muted">
                        <?php
                        $fontSize = ' fsz-16';
                        $excerptLimit = 240;
                        $words = explode(' ', h($post->getBody()));
                        $postLength = (int)strlen(h($post->getBody()));

                        if ($postLength <= 160) {
                            $fontSize = ' fsz-24';
                            $excerptLimit = 180;
                        } elseif ($postLength <= 240) {
//                                                $fontSize = ' fsz-18';
                            $excerptLimit = 200;
                        }
                        ?>
                        <div class="i__pc-b h_jLXcJpA0 foa3ulpk ofy-auto">
                            <?php if ($post->isCoppied()): ?>
                                <div class="copied-post">
                                    <?php if ($post->isCopiedAs('quote')): ?>
                                        <div class="<?= $fontSize ?> text-muted">
                                            <blockquote class="quote text-quoted">
                                                <?= Text::truncate($post->getBody(), 160, ['foo' => 'bar']); ?>
                                                <?php if ($postLength > 160): ?>
                                                    <small class="small">
                                                        <a href="javascript:void(fullText() ||
                                                                            window.location.assign('<?= $postLink ?>'))">See
                                                            More <i class="fe fe-chevron-right"></i></a>
                                                    </small>
                                                <?php endif; ?>
                                            </blockquote>
                                        </div>
                                        <div class="mt-6 fsz-16 text-right me-6">
                                            <?= $this->Html->link(__('<span class="avatar
                                                                    avatar-placeholder me-3" style="background-image: url()"></span>
                                                                    <span class="username">@{username}</span>', [
                                                'username' => $post->originalAuthor->getUsername(),
                                                'avatar' => $post->originalAuthor->profile->getImageUrl()]),
                                                Router::url('/' . h($post->originalAuthor->getUsername())
                                                    . '/posts/' . h($post->originalPost->refid) . '?_ref=' .
                                                    h($post->refid) . '&_referer='
                                                    . urlencode($this->getRequest()->getAttribute('here')), true),
                                                [
                                                    'class' => 'text-muted font-italic text-decoration-none d-inline-flex align-items-center justify-content-end',
                                                    'escapeTitle' => false
                                                ]); ?>
                                        </div>
                                    <?php elseif ($post->copied_as === 'plain'): ?>
                                        <div
                                            class="text-plain <?= $fontSize ?>"><?=
                                            Text::truncate($post->getBody(), $excerptLimit, [
                                                'ellipses' => '<a href="javascript:void(fullText())">See More</a>']); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="lh-sm<?= $fontSize ?>">
                                    <?= Text::truncate($post->getBody(), $excerptLimit); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-footer p-2 bg-light">
                <div class="d-flex align-items-center justify-content-between mt-auto">
                    <div class="author d-flex">
                        <div class="avatar avatar-md me-3"></div>
                        <div class="author-name">
                            <a href="./" class="text-default">
                                @<?= $post->author->getUsername() ?>
                            </a>
                            <small class="d-block text-muted">
                                <?= $post->date_published ?>
                            </small>
                        </div>
                    </div>
                    <div class="ml-auto text-muted d-flex flex-column text-end">
                        <a href="#" class="icon d-none d-block">
                            <i class="mdi mdi-heart-outline"></i>
                        </a>
                        <span class="comments-counter d-block">
                                            <?php if (!$post->isEmpty('comments')): ?>
                                                <span class="me-1"><?= count($post->get('comments')); ?></span>
                                            <?php endif; ?>
                            <?= $this->Html->link(
                                __('<i class="mdi mdi-comment-outline"></i>'),
                                '/' . $postLink . '/thread?ref=comment_counter',
                                [
                                    'class' => 'icon text-muted-dark fsz-smaller',
                                    'escapeTitle' => false
                                ]
                            ); ?>
                                            </span>
                        <span class="shares-counter d-block">
                                            <?php if (!$post->isEmpty('shares')): ?>
                                                <span class="me-1"><?= count($post->get('shares')); ?></span>
                                            <?php endif; ?>
                            <?= $this->Html->link(
                                __('<i class="fe fe-share-2"></i>'),
                                '/' . $postLink . '/shares?ref=share_counter',
                                [
                                    'class' => 'icon text-muted-dark fsz-smaller',
                                    'escapeTitle' => false
                                ]
                            ); ?>
                                            </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach;
    echo '</div>';
} else {
    echo '<div>Nothing to show here right now.</div>';
}
?>
