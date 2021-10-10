<?php

/**
 * Comments list for a single post
 */
?>
<div class="_nWagqk">
    <div class="card">
        <div class="card-header">
            <h6 class="card-title"><?= __("Comments on {firstname}'s Post", ['firstname' =>
                    $post->author->getFirstName()]); ?></h6>
        </div>
        <div class="card-body">
            <div>
                <?php $this->PostHtml->getCommentsThread($comments, $post); ?>
            </div>
        </div>
    </div>
</div>
