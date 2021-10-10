<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$tab = $this->Url->request->getQuery('action');
if (!$tab) $tab = 'default';
$profileUrl = '/u/' . h($account->username);
?>
<div class="user-profile">
    <?= $this->element('header'); ?>
    <div class="profile-body col-md-10 mx-auto">
        <div class="row">
            <div class="col-md-12 mb-3">
                
            </div>
            <div class="col-md-8">
                <div class="col-inner content-wrap">
                    <div class="scrollbar-dynamic position-relative">
                        <div class="feed-notification-bar">
                            Latest News
                        </div>
                        <div id="newsfeed" class="mb-5 newsfeed-home pb-5" role="newsfeed">
                        <?php if (count($newsfeed)): ?>
                            <?php foreach ($newsfeed as $post): ?>
                                <?= $this->Template->addTemplate($post, 'post'); ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <h5 class="text-muted text-center text-light">Your newsfeed is empty...</h5>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <aside class="col-md-4">
                <div class="col-inner">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">Suggestions</h6>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
