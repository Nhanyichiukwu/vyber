<?php

/**
 * 
 */
use Cake\Utility\Security;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use App\Utility\RandomString;
use Cake\Routing\Router;

//$counter = $this->cell('Counter::posts', ['byAuthor', $this->get('account')->get('refid')]);
//$posts = $this->cell('Posts::index', ['byAuthor', ['author' => $this->get('account')->get('refid')]]);
//$postsCount = $posts->count();
//pr($posts->render());
//exit;
?>
<?php
if (!isset($feedLayout) || ! $this->elementExists('Widgets/TimelineLayouts/' . $feedLayout)):
    $feedLayout = 'grid';
endif;
?>
<div class="row gutters-sm">
    <div class="profile-pagelet-left-sidebar w_rk2ARF col">
        <div class="I3r">
            <div class="card">
                <div class="card-header post-search-form p-3">
                    <div class="input-icon w-100">
                        <input type="text" name="keyword" class="custom-control form-control rounded-pill w-100" placeholder="Search..." id="keyword">                        <div class="input-icon-addon text-muted p-e_All">
                            <button type="submit" class="btn btn-sm btn-transparent">
                                <i class="mdi mdi-18px mdi-magnify"></i>
                            </button>
                        </div>
                    </div>             
                </div>
                <div class="U1Ls">
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action"><i class="link-icon mdi mdi-calendar-today"></i> <span class="link-text">Date</span></a>
                        <a href="#" class="list-group-item list-group-item-action"><i class="link-icon mdi mdi-reply"></i> <span class="link-text">Replies</span></a>
                        <a href="#" class="list-group-item list-group-item-action"><i class="link-icon mdi mdi-floppy"></i> <span class="link-text">Copied</span></a>
                        <a href="#" class="list-group-item list-group-item-action"><i class="link-icon mdi mdi-chart-line"></i> <span class="link-text">Trending</span></a>
                        <a href="#" class="list-group-item list-group-item-action"><i class="link-icon mdi mdi-star"></i> <span class="link-text">Most Popular</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w_fMGsRw col">
            <?php if ($this->get('activeUser')): ?>
        <div class="mb-3">
            <?= $this->element('Widgets/post_editor', ['publisherType' => 'publisher-large db-basic-publisher']); ?>
        </div>
            <?php endif; ?>
        <div id="posts" class="_RrFC43">
            <?php if ($posts->count() > 0): ?>
            <div class="timeline">
                <div class="list-group">
                <?php foreach ($posts->toArray() as $post): ?>
                    <?php
                        $dataSrc = 'post/'.$post->get('refid') . '?token=' . base64_encode(Security::randomString() . '_'. $account->get('refid') . time());
                    ?>
                    <div class="list-group-item p-0 mb-0 _kG2vdB _Hc0qB9" data-load-type="r" data-src="<?= $dataSrc ?>" data-rfc="post<?= $post->get('id') ?>" data-su="false" data-limit="1" data-r-ind="false" id="post<?= $post->get('id') ?>"></div>
                <?php endforeach; ?>
                </div>
            </div>
            <?php else: ?>
                    <?php
                $suggestedReading = $this->cell('Suggestions::suggestedPosts');
                echo $suggestedReading->render();
                    ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<!--<script>-->
<?php $this->Html->scriptStart(['block' => 'scriptBottom']); ?>

<?php $this->Html->scriptEnd(); ?>