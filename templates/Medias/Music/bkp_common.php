<?php
/**
 * @var \App\View\AppView $this;
 * Music listings
 * Includes audios and videos of both the current user's music and those of
 * their connections and those they follow and are connected to
 */

use Cake\Core\Configure;
use Cake\Routing\Router;

$get = $this->getRequest()->getQueryParams();


$roles = json_decode($this->cell('ContentLoader::list', [
    'roles', [
        'byIndustry',
        ['industry' =>'music']
    ]
])->render(), false);

$this->enablePageHeader();
$title = $pageTitle ?? $this->fetch('title','Music');
$this->pageTitle($title);
?>
<?php /** Music Navigation **/ ?>

<div class="<?= Configure::read('Site.slug') ?>-music">
    <nav class="music-nav bg-white mb-2">
        <ul class="flex-nowrap flex-row foa3ulpk ldk4goct mx-md-0 nav nav-tabs ofx-auto px-3 px-lg-0 row-cols-auto">
            <li class="nav-item px-lg-0 px-2">
                <a href="<?= Router::url(['action' => 'discover']) ?>"
                   class="flex-fill font-weight-normal nav-link px-lg-3 py-2 text-dark active">
                    <i class="link-icon mdi mdi-18px me-2 mdi-lightbulb-on-outline"></i>
                    <span class="link-text">Discover</span>
                </a>
            </li>
            <li class="nav-item px-lg-0 px-2">
                <a href="<?= Router::url(['action' => 'my-music']) ?>"
                   class="flex-fill font-weight-normal nav-link px-lg-3 py-2 text-dark">
                    <i class="link-icon mdi mdi-18px me-2 mdi-account-music"></i>
                    <span class="link-text">My Music</span>
                </a>
            </li>
            <li class="nav-item px-lg-0 px-2">
                <a href="<?= Router::url(['action' => 'songs']) ?>" class="flex-fill font-weight-normal
                nav-link px-lg-3 py-2 text-dark">
                    <i class="link-icon mdi mdi-18px me-2 mdi-music"></i>
                    <span class="link-text">Songs</span>
                </a>
            </li>
            <li class="nav-item px-lg-0 px-2">
                <a href="<?= Router::url(['action' => 'videos']) ?>" class="flex-fill font-weight-normal
                nav-link px-lg-3 py-2 text-dark">
                    <i class="link-icon mdi mdi-18px me-2 mdi-movie"></i>
                    <span class="link-text">Videos</span>
                </a>
            </li>
            <li class="nav-item px-lg-0 px-2">
                <a href="<?= Router::url(['action' => 'artists']) ?>"
                   class="flex-fill font-weight-normal nav-link px-lg-3 py-2 text-dark">
                    <i class="link-icon mdi mdi-18px me-2 mdi-account-multiple"></i>
                    <span class="link-text">Artists</span>
                </a>
            </li>
            <li class="nav-item px-lg-0 px-2">
                <a href="<?= Router::url(['action' => 'albums']) ?>" class="flex-fill font-weight-normal
                nav-link px-lg-3 py-2 text-dark">
                    <i class="link-icon mdi mdi-18px me-2 mdi-music-circle"></i>
                    <span class="link-text">Albums</span>
                </a>
            </li>
            <li class="nav-item px-lg-0 px-2">
                <a href="<?= Router::url(['action' => 'categories']) ?>"
                   class="flex-fill font-weight-normal nav-link px-lg-3 py-2 text-dark">
                    <i class="link-icon mdi mdi-18px me-2 mdi-format-list-bulleted"></i>
                    <span class="link-text">Categories</span>
                </a>
            </li>
            <li class="nav-item px-lg-0 px-2">
                <a href="<?= Router::url(['action' => 'genres']) ?>"
                   class="flex-fill font-weight-normal nav-link px-lg-3 py-2 text-dark">
                    <i class="link-icon mdi mdi-18px me-2 mdi-music-clef-treble"></i>
                    <span class="link-text">Genres</span>
                </a>
            </li>
            <li class="nav-item px-lg-0 px-2">
                <a href="<?= Router::url(['action' => 'trends']) ?>" class="flex-fill
                    font-weight-normal nav-link px-lg-3 py-2 text-dark">
                    <i class="link-icon mdi mdi-18px me-2 mdi-chart-line"></i>
                    <span class="link-text">Trends</span>
                </a>
            </li>
            <li class="nav-item px-lg-0 px-2">
                <a href="<?= Router::url(['action' => 'producers']) ?>" class="flex-fill
                    font-weight-normal nav-link px-lg-3 py-2 text-dark">
                    <i class="link-icon mdi mdi-18px me-2 mdi-piano"></i>
                    <span class="link-text">Producers</span>
                </a>
            </li>
            <li class="nav-item px-lg-0 px-2">
                <a href="<?= Router::url(['action' => 'song-writers']) ?>" class="flex-fill
                    font-weight-normal nav-link px-lg-3 py-2 text-dark">
                    <i class="link-icon mdi mdi-18px me-2 mdi-pen"></i>
                    <span class="link-text">Song Writers</span>
                </a>
            </li>
            <li class="nav-item px-lg-0 px-2">
                <a href="<?= Router::url(['action' => 'vocalists']) ?>" class="flex-fill
                    font-weight-normal nav-link px-lg-3 py-2 text-dark">
                    <i class="link-icon mdi mdi-18px me-2 mdi-microphone-variant"></i>
                    <span class="link-text">Vocalists</span>
                </a>
            </li>
            <li class="nav-item px-lg-0 px-2">
                <a href="<?= Router::url(['action' => 'directors']) ?>" class="flex-fill
                    font-weight-normal nav-link px-lg-3 py-2 text-dark">
                    <i class="link-icon mdi mdi-18px me-2 mdi-account-cowboy-hat"></i>
                    <span class="link-text">Directors</span>
                </a>
            </li>
            <li class="nav-item px-lg-0 px-2">
                <a href="<?= Router::url(['action' => 'video-makers']) ?>" class="flex-fill
                    font-weight-normal nav-link px-lg-3 py-2 text-dark">
                    <i class="link-icon mdi mdi-18px me-2 mdi-camcorder"></i>
                    <span class="link-text">Video Makers</span>
                </a>
            </li>
            <li class="nav-item px-lg-0 px-2">
                <a href="<?= Router::url(['action' => 'choreographers']) ?>" class="flex-fill
                    font-weight-normal nav-link px-lg-3 py-2 text-dark">
                    <i class="link-icon mdi mdi-18px me-2 mdi-kabaddi"></i>
                    <span class="link-text">Choreographers</span>
                </a>
            </li>
            <li class="nav-item px-lg-0 px-2">
                <a href="<?= Router::url(['action' => 'trends']) ?>" class="flex-fill
                    font-weight-normal nav-link px-lg-3 py-2 text-dark">
                    <i class="link-icon mdi mdi-18px me-2 mdi-chart-line"></i>
                    <span class="link-text">Trends</span>
                </a>
            </li>
        </ul>
    </nav>

    <?php if ($this->fetch('subheader')): ?>
        <?= $this->fetch('subheader'); ?>
    <?php endif; ?>
    <?php if ($this->fetch('submenu')): ?>
        <nav class="ml-auto">
            <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                <?= $this->fetch('submenu'); ?>
            </ul>
        </nav>
    <?php endif; ?>
    <?= $this->fetch('content'); ?>
</div>

