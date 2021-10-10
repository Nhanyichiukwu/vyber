<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Connection[]|\Cake\Collection\CollectionInterface $connections
 */

use Cake\Routing\Router;
use Cake\Utility\Security;

//$this->extend('common');
$this->extend('my_music');
$this->assign('heading', 'Videos');
?>

<?php $myVideos = (int) $this->cell('ContentLoader::count', ['videos', [
    'author', $activeUser->get('refid')]])->render(); ?>

<?php $this->start('header'); ?>
<div class="page-header row gutters-lg justify-content-between align-items-center">
    <div class="col"><h2 class="page-title"><?= __('Videos') ?>
            <small class="page-subtitle">
                You have <?= $this->Number->format($myVideos); ?> videos
            </small>
        </h2>
    </div>
    <div class="col-auto ml-auto">
        <?= $this->Html->link(__('<span class="mdi mdi-18px mdi-plus-circle-outline mr-2"></span> <span class="btn-label">New Video</span>'),
            [
                'controller' => 'upload',
                'action' => 'media',
                '?' => [
                    'mtp' => 'audio',
                    'cls' => 'video',
                    'request_origin' => 'container'
                ]
            ],
            [
                'role' => 'item-add-btn',
                'class' => 'align-items-center btn btn-secondary btn-sm d-flex flex-fill justify-content-center px-3 rounded-lg text-uppercase',
                'escapeTitle' => false,
                'data-toggle' => 'modal',
                'data-target' => '#upload-dialog',
                'data-modal-title' => 'Upload New Video'
            ]
        ); ?>
    </div>
</div>
<?php $this->end(); ?>

<?php $this->start('sub_content'); ?>
    <?php if (count($newlyReleasedVideos)): ?>
        <div class="section new-releases">
            <h3 class="font-weight-light fsz-22 section-title">New Releases</h3>
            <?php
            $dataSrc = '/videos/new-release' . '?token=' . base64_encode($activeUser->get('refid'));
            ?>
            <div class="_Hc0qB9 row" data-load-type="r" data-src="<?= $dataSrc ?>" data-rfc="videos"
                 data-su="false"
                 data-limit="24" data-r-ind="false">
                <?php for ($i = 0; $i < $myVideos; $i++): ?>
                    <div class="_3ucILu mb-5 col-md-4 col-lg-3"></div>
                <?php endfor; ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (count($trendingVideos)): ?>
        <div class="section new-releases">
            <h3 class="font-weight-light fsz-22 section-title">New Releases</h3>
            <?php
            $dataSrc = '/videos/new-release' . '?token=' . base64_encode($activeUser->get('refid'));
            ?>
            <div class="_Hc0qB9 row" data-load-type="r" data-src="<?= $dataSrc ?>" data-rfc="videos"
                 data-su="false"
                 data-limit="24" data-r-ind="false">
                <?php for ($i = 0; $i < $myVideos; $i++): ?>
                    <div class="_3ucILu mb-5 col-md-4 col-lg-3"></div>
                <?php endfor; ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (count($bestSellingVideos)): ?>
        <div class="section new-releases">
            <h3 class="font-weight-light fsz-22 section-title">New Releases</h3>
            <?php
            $dataSrc = '/videos/best-selling' . '?token=' . base64_encode($activeUser->get('refid'));
            ?>
            <div class="_Hc0qB9 row" data-load-type="r" data-src="<?= $dataSrc ?>" data-rfc="videos"
                 data-su="false"
                 data-limit="24" data-r-ind="false">
                <?php for ($i = 0; $i < $myVideos; $i++): ?>
                    <div class="_3ucILu mb-5 col-md-4 col-lg-3"></div>
                <?php endfor; ?>
            </div>
        </div>
    <?php endif; ?>
<?php $this->end() ?>

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

<?php $this->Html->scriptStart(['block' => 'scriptBottom', 'type' => 'text/javascript', 'charset' => 'utf-8']); ?>
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
