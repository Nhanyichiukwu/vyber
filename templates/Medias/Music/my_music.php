<?php

/**
 * @var \App\View\AppView $this
 */
use Cake\Routing\Router;
use Cake\Utility\Security;
use Cake\Utility\Inflector;
use App\Utility\DateTimeFormatter;

$this->extend('common');

$section = $this->Url->request->getQuery('section');
if (!$section) $section = 'default';
$this->set('pageHeaderClass', 'row');
?>
<?php $this->start('header'); ?>
    <div class="page-header">
        <h2 class="page-title">
                <?= __('My Music') ?>
        </h2>
    </div>
    <div class="U1Ls mb-4">
    <nav class="music-nav border-bottom">
        <ul class="nav nav-tabs border-0 flex-row">
            <li class="nav-item">
                <a href="<?= Router::url(['action' => 'my-music']) ?>" class="nav-link">
                    <i class="link-icon mdi mdi-18px mr-3 mdi-home"></i>
                    <span class="link-text">Explore</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= Router::url(['action' => 'my-music', 'songs']) ?>" class="nav-link">
                    <i class="link-icon mdi mdi-18px mr-3 mdi-music"></i>
                    <span class="link-text">Songs</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= Router::url(['action' => 'my-music', 'videos']) ?>" class="nav-link">
                    <i class="link-icon mdi mdi-18px mr-3 mdi-movie-open"></i>
                    <span class="link-text">Videos</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= Router::url(['action' => 'my-music', 'lyrics']) ?>" class="nav-link">
                    <i class="link-icon mdi mdi-18px mr-3 mdi-book-music"></i>
                    <span class="link-text">Lyrics</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= Router::url(['action' => 'my-music', 'playlists']) ?>" class="nav-link">
                    <i class="link-icon mdi mdi-18px mr-3 mdi-playlist-play"></i>
                    <span class="link-text">Playlists</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= Router::url(['action' => 'my-music', 'albums']) ?>" class="nav-link">
                    <i class="link-icon mdi mdi-18px mr-3 mdi-chart-line"></i>
                    <span class="link-text">Albums</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
<?php $this->end(); ?>

<?php if ($this->fetch('sub_content')): ?>
    <?= $this->fetch('sub_content'); ?>
<?php else: ?>
    <?php $history = (int) 0 // $this->cell('Counter::count', ['recent_plays', [$activeUser]])->render(); ?>
    <?php if ($history > 0): ?>
    <div class="section :recent-plays">
        <h3 class="font-weight-light fsz-22 section-title">Recent Plays</h3>
        <?php
        $recentPlays = $this->cell('ContentLoader::recentPlays', [$activeUser]);
        $recentPlays->render();
        ?>
    </div>
    <?php endif; ?>

    <?php $mySongs = (int) $this->cell('ContentLoader::count', [
        'songs', ['author', $activeUser->get('refid')]])->render(); ?>
    <?php if ($mySongs > 0): ?>
    <div class="section songs">
    <h3 class="font-weight-light fsz-22 section-title">Latest Songs</h3>
        <?php
        $songs = $this->cell('ContentLoader::load', ['songs', [$activeUser]]);
        $songs->render();
        ?>
    </div>
    <?php endif; ?>
    <?php $myVideos = (int) $this->cell('ContentLoader::count', ['videos', ['author', $activeUser->get('refid')]])
        ->render(); ?>
    <?php if ($myVideos > 0): ?>
    <div class="section videos">
        <h3 class="font-weight-light fsz-22 section-title">Latest Videos</h3>
        <?php
//        $videos = $this->cell('ContentLoader::load', ['videos', [$activeUser]]);
//        echo $videos->render();
        $dataSrc = '/videos?token=' . base64_encode(Security::randomString() . '_'.
        $activeUser->get('refid') . time());
        ?>
        <div class="_Hc0qB9 row" data-load-type="r" data-src="<?= $dataSrc ?>" data-rfc="videos"
             data-su="false"
             data-limit="24" data-r-ind="false">
            <?php for ($i = 0; $i < $myVideos; $i++): ?>
                <div class="_3ucILu mb-5 col-md-4 col-lg-3"></div>
                <div class="_3ucILu mb-5 col-md-4 col-lg-3"></div>
                <div class="_3ucILu mb-5 col-md-4 col-lg-3"></div>
                <div class="_3ucILu mb-5 col-md-4 col-lg-3"></div>
                <div class="_3ucILu mb-5 col-md-4 col-lg-3"></div>
                <div class="_3ucILu mb-5 col-md-4 col-lg-3"></div>
                <div class="_3ucILu mb-5 col-md-4 col-lg-3"></div>
                <div class="_3ucILu mb-5 col-md-4 col-lg-3"></div>
                <div class="_3ucILu mb-5 col-md-4 col-lg-3"></div>
                <div class="_3ucILu mb-5 col-md-4 col-lg-3"></div>
                <div class="_3ucILu mb-5 col-md-4 col-lg-3"></div>
                <div class="_3ucILu mb-5 col-md-4 col-lg-3"></div>
            <?php endfor; ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-6 col-lg-4 my-playlists">
            <?php
            $playlists = $this->cell('ContentLoader::load', ['playlists', [$activeUser, 'music']]);
            $playlists->render();
            ?>
        </div>
        <div class="col-md-6 col-lg-4 my-albums">
            <?php
            $albums = $this->cell('ContentLoader::load', ['albums', [$activeUser]]);
            $albums->render();
            ?>
        </div>
        <div class="col-md-6 col-lg-4 my-lyrics">
            <?php
            $albums = $this->cell('ContentLoader::load', ['lyrics', [$activeUser]]);
            $albums->render();
            ?>
        </div>
    </div>
<?php endif; ?>
<div id="upload-dialog" class="modal fade" aria-labelledby="uploadModalLabel" role="dialog">
    <div class="modal-dialog w_t7LmBB w_fMGsRw">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="uploadModalLabel">Add New Video</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe id="upload-frame" class="full-width" onload="resizeFrame(this)"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">Cancel</span>
                </button>
            </div>
        </div>
    </div>
</div>
<div id="media-preview" class="modal fade" aria-labelledby="mediaPreview" role="dialog">
    <div class="modal-dialog w_t7LmBB w_fMGsRw">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mediaPreview"></h4>
                <ul class="nav ml-auto">
                    <li class="nav-item">
                        <?= $this->Html->link(__('Open full page'), '#',
                            [
                                'class' => 'btn btn-outline-primary btn-sm',
                                'escapeTitle' => false
                            ]); ?>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </li>
                </ul>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">Close</span>
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->Html->scriptStart(['block' => 'scriptBottom', 'type' => 'text/javascript', 'charset' => 'utf-8']); ?>
(function($) {
$('[role="item-add-btn"]').on('click', function () {
let $btn = $(this);
let href = $btn.attr('href');
let newModalTitle = $btn.data('modal-title');
let uploadDialog = $('#upload-dialog');

uploadDialog.find('.modal-title').html(newModalTitle);
uploadDialog.find('iframe').attr('src', href);
});

$('#media-list.click-action tbody').find('tr').click(function(e) {
let row = $(this);
let modal = row.data('target');
let mHeader = $(modal).find('.modal-header');
let output = $(modal).find('.modal-body');
let loading = $('.content-loading').clone();

mHeader.find('.modal-title').html(row.data('title'));
mHeader.find('ul.nav li a').attr('href',row.data('uri'));
output.html(loading);
doAjax(row.data('uri') + '?request_origin=container', function(data, status, xhr) {
if (status === 'success') {
output.html(data);
}
}, {method: 'get', contentType: 'html'});
//            $(modal).find('iframe').attr('src', row.data('uri'));
//            if (! $(e.target).hasClass('menu-icon'))
//                window.location.assign($(this).data('edit'));
});
})(jQuery);
<?= $this->Html->scriptEnd(); ?>
