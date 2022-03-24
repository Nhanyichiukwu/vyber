<?php

/**
 *
 */

//$counter = $this->cell('Counter::posts', ['byAuthor', $this->get('account')->get('refid')]);
//$posts = $this->cell('Posts::index', ['byAuthor', ['author' => $this->get('account')->get('refid')]]);
//$postsCount = $posts->count();
//pr($posts->render());
//exit;
$this->extend('common');
?>
<?php
if (
    !isset($feedLayout) ||
    !$this->elementExists('Widgets/TimelineLayouts/' . $feedLayout)
) {
    $feedLayout = 'grid';
}
?>
<div class="posts">
    <div class="row gutters-sm">
        <div class="col-lg-7 col-md-8">
            <div id="posts" class="_RrFC43">
                <?php
                $params = json_encode([
                    'resource_handle' => 'threads',
                    'resource_path' => 'posts/threads'
                ]);
                $token = base64_encode(serialize($params));
                $dataSrc = '/newsfeed/posts?cw_fdr=by_author&cw_aid=' . $account->refid . '&token=' . $token;
                $fetchTimeline = json_encode([
                    'content' => 'posts_by_user',
                    'src' => $dataSrc,
                    'remove_if_no_content' => 'no',
                    'check_for_update' => 'yes',
                    'auto_update' => 'no',
                    'use_data_prospect' => 'yes',
                    'load_type' => 'overwrite',
                ]);
                ?>
                <div data-request-type="async"
                     class="ajaxify"
                     data-category="main_content"
                     data-config='<?= $fetchTimeline ?>'>
                    <?= $this->element('App/loading', ['size' => 'spinner-md']); ?>
                </div>
                <?php
                //                $suggestedReading = $this->cell('Suggestions::suggestedPosts');
                //                echo $suggestedReading->render();
                ?>
            </div>
        </div>
        <div class="profile-pagelet-left-sidebar col-md-4 col-lg-5">
            <div class="I3r">
                <div class="card">
                    <div class="card-header post-search-form p-3">
                        <div class="input-icon w-100">
                            <input type="text" name="keyword" class="custom-control form-control rounded-pill w-100"
                                   placeholder="Search..." id="keyword">
                            <div class="input-icon-addon text-muted p-e_All">
                                <button type="submit" class="btn btn-sm btn-transparent">
                                    <i class="mdi mdi-18px mdi-magnify"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="U1Ls">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action"><i
                                    class="link-icon mdi mdi-calendar-today"></i> <span
                                    class="link-text">Date</span></a>
                            <a href="#" class="list-group-item list-group-item-action"><i
                                    class="link-icon mdi mdi-reply"></i> <span class="link-text">Replies</span></a>
                            <a href="#" class="list-group-item list-group-item-action"><i
                                    class="link-icon mdi mdi-floppy"></i> <span class="link-text">Copied</span></a>
                            <a href="#" class="list-group-item list-group-item-action"><i
                                    class="link-icon mdi mdi-chart-line"></i> <span
                                    class="link-text">Trending</span></a>
                            <a href="#" class="list-group-item list-group-item-action"><i
                                    class="link-icon mdi mdi-star"></i> <span class="link-text">Most Popular</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->Html->scriptStart(['block' => 'scriptBottom']); ?>

<?php $this->Html->scriptEnd(); ?>
