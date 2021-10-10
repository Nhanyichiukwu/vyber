<?php

/**
 *
 */
?>
<?php $this->start('page_top'); ?>

<div class="collapse d-lg-flex p-0 mb-4" id="headerMenuCollapse">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                    <li class="nav-item">
                        <?= $this->Html->link(__('My Network'), [
                            'action' => 'index'
                        ], [
                            'class' => 'nav-link'
                        ])
                        ; ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Connections'), [
                            'action' => 'connections'
                        ], [
                            'class' => 'nav-link'
                        ])
                        ; ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Introductions'), [
                            'action' => 'introductions'
                        ], [
                            'class' => 'nav-link'
                        ]); ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Recommendations'), [
                            'action' => 'recommendations'
                        ], [
                            'class' => 'nav-link'
                        ]); ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?= $this->fetch('page_top'); ?>
<?php $this->end(); ?>

<?= $this->fetch('content'); ?>
<?php //if (!in_array($this->getOption('show'), [false,null])): ?>
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Suggested Connections</h6>
            <div class="">
                <?php $suggestions = $this->cell('Suggestions::connections', [$user]); ?>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">People You May Know</h6>
            <div class="">
                <?php $suggestions = $this->cell('Suggestions::familiarUsers', [$user]); ?>
            </div>
        </div>
    </div>
<?php //endif; ?>

<?php $this->start('right_sidebar'); ?>
<div class="card">
    <div class="card-body">
        <div class="card-deck">
            <div class="section mb-4">
                <div class="px-4"><h6 class="section-title">In Music</h6></div>
                <ul class="nav navbar-nav">
                    <li class="nav-item">
                        <?= $this->Html->link(__('<span class="mr-4"><i class="mdi mdi-account-group"></i></span> <span>Connections</span>'),
                                ['action' => 'index'],
                                ['class' => 'nav-link', 'escapeTitle' => false]
                            ); ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('<span class="mr-4"><i class="mdi mdi-account-group"></i></span> <span>Artists</span>'),
                                ['action' => 'artists'],
                                ['class' => 'nav-link', 'escapeTitle' => false]
                            ); ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('<span class="mr-4"><i class="mdi mdi-account-group"></i></span> <span>Song Writers</span>'),
                                ['action' => 'song-writers'],
                                ['class' => 'nav-link', 'escapeTitle' => false]
                            ); ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('<span class="mr-4"><i class="mdi mdi-account-group"></i></span> <span>Choriographers</span>'),
                                ['action' => 'choriographers'],
                                ['class' => 'nav-link', 'escapeTitle' => false]
                            ); ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('<span class="mr-4"><i class="mdi mdi-account-group"></i></span> <span>Producers</span>'),
                                ['action' => 'producers'],
                                ['class' => 'nav-link', 'escapeTitle' => false]
                            ); ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('<span class="mr-4"><i class="mdi mdi-account-group"></i></span> <span>Record Labels</span>'),
                                ['action' => 'record_labels'],
                                ['class' => 'nav-link', 'escapeTitle' => false]
                            ); ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('<span class="mr-4"><i class="mdi mdi-account-group"></i></span> <span>Marketers</span>'),
                                ['action' => 'marketers'],
                                ['class' => 'nav-link', 'escapeTitle' => false]
                            ); ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('<span class="mr-4"><i class="mdi mdi-account-group"></i></span> <span>Directors</span>'),
                                ['action' => 'directors'],
                                ['class' => 'nav-link', 'escapeTitle' => false]
                            ); ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('<span class="mr-4"><i class="mdi mdi-account-group"></i></span> <span>Movie Stars</span>'),
                                ['action' => 'movie_stars'],
                                ['class' => 'nav-link', 'escapeTitle' => false]
                            ); ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('<span class="mr-4"><i class="mdi mdi-account-group"></i></span> <span>DJs</span>'),
                                ['action' => 'disc_jokies'],
                                ['class' => 'nav-link', 'escapeTitle' => false]
                            ); ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('<span class="mr-4"><i class="mdi mdi-account-group"></i></span> <span>Presenters</span>'),
                                ['action' => 'presenters'],
                                ['class' => 'nav-link', 'escapeTitle' => false]
                            ); ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-deck">
            <div class="section mb-4">
                <div class="px-4"><h6 class="section-title">In Movie</h6></div>
                <ul class="nav navbar-nav">
                    <li class="nav-item">
                        <?= $this->Html->link(__('<span class="mr-4"><i class="mdi mdi-account-group"></i></span> <span>Actors</span>'),
                                ['action' => 'actors'],
                                ['class' => 'nav-link', 'escapeTitle' => false]
                            ); ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('<span class="mr-4"><i class="mdi mdi-account-group"></i></span> <span>Actresses</span>'),
                                ['action' => 'actresses'],
                                ['class' => 'nav-link', 'escapeTitle' => false]
                            ); ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('<span class="mr-4"><i class="mdi mdi-account-group"></i></span> <span>Script Writers</span>'),
                                ['action' => 'script-writers'],
                                ['class' => 'nav-link', 'escapeTitle' => false]
                            ); ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('<span class="mr-4"><i class="mdi mdi-account-group"></i></span> <span>Producers</span>'),
                                ['action' => 'producers'],
                                ['class' => 'nav-link', 'escapeTitle' => false]
                            ); ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('<span class="mr-4"><i class="mdi mdi-account-group"></i></span> <span>Marketers</span>'),
                                ['action' => 'marketers'],
                                ['class' => 'nav-link', 'escapeTitle' => false]
                            ); ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('<span class="mr-4"><i class="mdi mdi-account-group"></i></span> <span>Directors</span>'),
                                ['action' => 'directors'],
                                ['class' => 'nav-link', 'escapeTitle' => false]
                            ); ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('<span class="mr-4"><i class="mdi mdi-camera"></i></span> <span>Photographers</span>'),
                                ['action' => 'photographers'],
                                ['class' => 'nav-link', 'escapeTitle' => false]
                            ); ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('<span class="mr-4"><i class="mdi mdi-video"></i></span> <span>Videographers</span>'),
                                ['action' => 'videographers'],
                                ['class' => 'nav-link', 'escapeTitle' => false]
                            ); ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Sent'), ['action' => 'sent-requests'], ['class' => 'nav-link']); ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Pending'), ['action' => 'pending-requests'], ['class' => 'nav-link']); ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?= $this->fetch('right_sidebar'); ?>
<?php $this->end(); ?>
