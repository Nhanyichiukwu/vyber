<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Connection[]|\Cake\Collection\CollectionInterface $connections
 */
//
$section = $this->Url->request->getQuery('section');
if (!$section) $section = 'default';
?>
<?php $this->start('page_header'); ?>
<div class="page-header">
    <h2 class="page-title"><?= __('Songs') ?> <small class="page-subtitle">You have <?= count($songs) ?> songs</small></h2>
    <div class="ml-auto">
        <?=
        $this->Html->link(__('<span class="mdi mdi-cloud-upload"></span> New Song'), 
                [
                    'controller' => 'upload',
                    'action' => 'index',
                    '?' => [
                        '_enctype' => 'audio'
                    ]
                ],
                [
                    'class' => 'btn btn-warning rounded-pill',
                    'escapeTitle' => false
                ]
        );
        ?>
    </div>
</div>
<?php $this->end(); ?>
<nav class="toolbar page-nav border-top py-2">
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
                    <span class="input-group-prepend">
                        <label for="search-input" class="input-group-text bg-transparent">Search</label>
                    </span>
                    <input id="search-input" class="form-control input-sm" name="keyword">
                    <span class="input-group-append">
                        <button type="submit" class="btn btn-warning">Go</button>
                    </span>
                </div>
            </div>
        </div>
        <?= $this->Form->end(); ?>
    </div>
</nav>

<nav class="toolbar page-nav border-top border-bottom mb-3 py-2">
    <div class="align-items-center row">
        <div class="col-md-1 order-first text-capitalize">Sort By:</div>
        <div class="col-md-11" data-role="sortOptions">
        <div class="row">
            <div class="col"><?= $this->Paginator->sort('privacy') ?></div>
            <div class="col"><?= $this->Paginator->sort('author_location') ?></div>
            <div class="col"><?= $this->Paginator->sort('genre') ?></div>
            <div class="col"><?= $this->Paginator->sort('category') ?></div>
            <div class="col"><?= $this->Paginator->sort('release_date') ?></div>
        </div>
    </div>
</nav>
<div id="songs" class="row">
    <?php if (count($songs)): ?>
        <?php foreach ($songs as $song): ?>
    
        <?php endforeach; ?>
    <?php else: ?>
    
    <?php endif; ?>
</div>