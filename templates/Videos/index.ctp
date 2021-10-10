<?php
use Cake\Routing\Router;
/**
 * @var \App\View\AppView $this
 */
//
$section = $this->Url->request->getQuery('section');
if (!$section) $section = 'default';
$this->set('pageHeaderClass', 'row');
?>
<?php $this->start('page_top'); ?>
<div class="page-header row gutters-lg justify-content-between align-items-center">
    <div class="col"><h2 class="page-title"><?= __('Videos') ?> <small class="page-subtitle">You have <?= count
                ($videos) ?>
                videos</small></h2></div>
    <div class="col-auto ml-auto">
        <?= $this->Html->link(__('<span class="mdi mdi-18px mdi-plus-circle-outline mr-2"></span> <span class="btn-label">New Video</span>'),
            [
                'controller' => 'upload',
                'action' => 'media',
                '?' => [
                    'mtp' => 'video',
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
<div class="ml-n4">
    <nav class="border-top border-bottom page-nav px-3 py-2 toolbar">
        <div class="align-items-center row">
            <div class="col-auto text-capitalize">Filter By:</div>
            <?= $this->Form->create('FilterOptions', ['type' => 'get', 'class' => 'col']); ?>
            <div class="d-none">
                <input type="hidden" name="filter" value="1">
            </div>
            <div class="row gutters-sm row-sm">
                <div class="col">
                    <input type="hidden" name="cat" value="">
                    <select name="cat" class="custom-select custom-select-sm border-0 bg-transparent">
                        <option>Category</option>
                        <option>Category One</option>
                        <option>Category Two</option>
                        <option>Category Three</option>
                        <option>Category Four</option>
                    </select>
                </div>
                <div class="col">
                    <input type="hidden" name="genre" value="">
                    <select name="genre" class="custom-select custom-select-sm border-0 bg-transparent">
                        <option>Genre</option>
                        <option>Category One</option>
                        <option>Category Two</option>
                        <option>Category Three</option>
                        <option>Category Four</option>
                    </select>
                </div>
                <div class="col">
                    <input type="hidden" name="album" value="">
                    <select name="album" class="custom-select custom-select-sm border-0 bg-transparent">
                        <option>Album</option>
                        <option>Category One</option>
                        <option>Category Two</option>
                        <option>Category Three</option>
                        <option>Category Four</option>
                    </select>
                </div>
                <div class="col">
                    <input type="hidden" name="privacy" value="">
                    <select name="privacy" class="custom-select custom-select-sm border-0 bg-transparent">
                        <option>Privacy</option>
                        <option>Category One</option>
                        <option>Category Two</option>
                        <option>Category Three</option>
                        <option>Category Four</option>
                    </select>
                </div>
                <div class="col-3">
                    <div class="input-group input-group-sm">
                        <input id="search-input" class="form-control input-sm" name="keyword" placeholder="Type video title or artist's name">
                        <span class="input-group-append">
                        <button type="submit" class="btn btn-green">Go</button>
                    </span>
                    </div>
                </div>
            </div>
            <?= $this->Form->end(); ?>
        </div>
    </nav>
    <nav class="border-bottom mb-3 page-nav px-3 py-2 toolbar">
        <div class="align-items-center row">
            <div class="col-auto text-capitalize">Sort By:</div>
            <div class="col" data-role="sortOptions">
                <div class="row">
                    <div class="col"><?= $this->Paginator->sort('privacy') ?></div>
                    <div class="col"><?= $this->Paginator->sort('author_location') ?></div>
                    <div class="col"><?= $this->Paginator->sort('genre') ?></div>
                    <div class="col"><?= $this->Paginator->sort('category') ?></div>
                    <div class="col"><?= $this->Paginator->sort('release_date') ?></div>
                    <div class="col"><?= $this->Paginator->sort('created', 'Date Published') ?></div>
                </div>
            </div>
        </div>
    </nav>
</div>

<?php if (count($videos)): ?>
    <div class="ml-n4">
        <div class="card rounded-0 border-left-0">
            <div class="table-responsive">
                <table id="media-list" class="table table-hover table-outline table-vcenter text-nowrap card-table click-action">
                    <thead>
                    <tr>
                        <th class="text-center w-1"><i class="mdi mdi-picture"></i></th>
                        <th>Title</th>
                        <th class="text-center">Status</th>
                        <th>Privacy</th>
                        <th>Language</th>
                        <th>Date</th>
                        <th class="text-center"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($videos as $video): ?>
                        <tr
                            data-toggle="modal"
                            data-target="#media-preview"
                            data-id="<?= h($video->get('refid')); ?>"
                            data-title="<?= h($video->get('title')); ?>"
                            data-uri="<?= Router::url('videos/' . h($video->get('refid')), true) ?>">
                            <td class="text-center">
                                <div class="avatar d-block" style="background-image: url(demo/faces/female/26.jpg)">
                                    <span class="avatar-status bg-green"></span>
                                </div>
                            </td>
                            <td>
                                <div><?= h($video->get('title')); ?></div>
                                <?php if (! $video->isEmpty('description')): ?>
                                    <div class="small text-muted"><?= Text::truncate(h($video->get('description')), 100, ['ellipsis' => '...']); ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php
                                $statusDictionary = [
                                    'draft' => 'warning',
                                    'published' => 'green',
                                    'pending' => 'dark',
                                    'suspended' => 'danger'
                                ];
                                $badgeState = $statusDictionary[h($video->get('status'))];
                                ?>
                                <div class="badge badge-pill badge-<?= $badgeState ?>"><?= ucfirst(h($video->get('status'))) ?></div>
                            </td>
                            <td>
                                <?= ucfirst(h($video->get('privacy'))); ?>
                            </td>
                            <td>
                                <?= ucfirst(h($video->get('language') ?? 'english')); ?>
                            </td>
                            <td>
                                <?= (new \App\Utility\DateTimeFormatter)->humanizeDatetime($video->get('created')); ?>
                            </td>
                            <td class="text-center">
                                <div class="item-action dropdown">
                                    <a href="javascript:void(0)" data-toggle="dropdown" class="menu"><i class="menu-icon mdi mdi-dots-vertical"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="play/<?= h($video->get('refid')); ?>" class="dropdown-item"><i class="dropdown-icon mdi mdi-video"></i> Play</a>
                                        <a href="play/<?= h($video->get('refid')); ?>" class="dropdown-item"><i class="dropdown-icon mdi mdi-video"></i> Copy Link</a>
                                        <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon mdi mdi-eye"></i> View Details</a>
                                        <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon mdi mdi-pencil"></i> Share</a>
                                        <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon mdi mdi-pencil"></i> Modify</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon mdi mdi-delete-forever"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php else: ?>

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
<!--<script>-->
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
