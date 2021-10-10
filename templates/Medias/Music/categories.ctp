<?php

/**
 * @var App\View\AppView $this
 */

$this->extend('common');

use Cake\Routing\Router; ?>

<?php $this->start('header'); ?>
<div class="page-header">
    <h2 class="page-title"><?= __('Categories') ?></h2>
</div>
<?php $this->end(); ?>

<div class="categories row row-cards">
    <?php foreach ($categories as $category): ?>
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card category-item mb-0 mt-0">
                <div class="card-body text-center">
                    <a href="<?= Router::url('/music/categories/' . $category->slug) ?>"
                       class="text-decoration-none">
                        <img class="img-fluid" src="./VIDOE - Video Streaming Website HTML category-movie_files/s1.png" alt="">
                        <h6 class="text-dark"><?= h($category->name) ?></h6>
                    </a>
                    <p>
                        <span class="small"><?= $this->Number->format($category->views) ?> views</span> | <span
                            class="small"><?= $this->Number->format($category->items_count) ?>
                            items</span>
                    </p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<?php if ($categories->count() > 0): ?>
    <nav class="categories-paginator paginator">
        <ul class="pagination pagination-simple pagination-sm">
            <?= $this->Paginator->first('<< ' . __('First')) ?>
            <?= $this->Paginator->prev('< ' . __('Previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Next') . ' >') ?>
            <?= $this->Paginator->last(__('Last') . ' >>') ?>
        </ul>
    </nav>
<?php endif; ?>
