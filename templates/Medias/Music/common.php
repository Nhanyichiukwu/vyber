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

<div class="<?= Configure::read('Site.slug') ?>-music mx-n3">
    <nav class="music-nav foa3ulpk ldk4goct mb-2 bg-white ofx-auto">
        <ul class="flex-nowrap flex-row nav nav-tabs px-3 row-cols-auto">
            <li class="nav-item">
                <a href="<?= Router::url(['action' => 'discover']) ?>"
                   class="nav-link ofjtagoh py-2 text-dark font-weight-normal active">
                    <i class="link-icon mdi mdi-18px mdi-lightbulb-on-outline"></i>
                    <span class="link-text">Discover</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= Router::url(['action' => 'my-music']) ?>"
                   class="nav-link ofjtagoh py-2 text-dark font-weight-normal">
                    <i class="link-icon mdi mdi-18px mdi-account-music"></i>
                    <span class="link-text">My Music</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= Router::url(['action' => 'songs']) ?>"
                   class="nav-link ofjtagoh py-2 text-dark font-weight-normal">
                    <i class="link-icon mdi mdi-18px mdi-music"></i>
                    <span class="link-text">Songs</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= Router::url(['action' => 'videos']) ?>"
                   class="nav-link ofjtagoh py-2 text-dark font-weight-normal">
                    <i class="link-icon mdi mdi-18px mdi-movie"></i>
                    <span class="link-text">Videos</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= Router::url(['action' => 'artists']) ?>"
                   class="nav-link ofjtagoh py-2 text-dark font-weight-normal">
                    <i class="link-icon mdi mdi-18px mdi-account-multiple"></i>
                    <span class="link-text">Artists</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= Router::url(['action' => 'albums']) ?>"
                   class="nav-link ofjtagoh py-2 text-dark font-weight-normal">
                    <i class="link-icon mdi mdi-18px mdi-music-circle"></i>
                    <span class="link-text">Albums</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= Router::url(['action' => 'categories']) ?>"
                   class="nav-link ofjtagoh py-2 text-dark font-weight-normal">
                    <i class="link-icon mdi mdi-18px mdi-format-list-bulleted"></i>
                    <span class="link-text">Categories</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= Router::url(['action' => 'genres']) ?>"
                   class="nav-link ofjtagoh py-2 text-dark font-weight-normal">
                    <i class="link-icon mdi mdi-18px mdi-music-clef-treble"></i>
                    <span class="link-text">Genres</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= Router::url(['action' => 'trends']) ?>"
                   class="nav-link ofjtagoh py-2 text-dark font-weight-normal">
                    <i class="link-icon mdi mdi-18px mdi-chart-line"></i>
                    <span class="link-text">Trends</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= Router::url(['action' => 'producers']) ?>"
                   class="nav-link ofjtagoh py-2 text-dark font-weight-normal">
                    <i class="link-icon mdi mdi-18px mdi-piano"></i>
                    <span class="link-text">Producers</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= Router::url(['action' => 'song-writers']) ?>"
                   class="nav-link ofjtagoh py-2 text-dark font-weight-normal">
                    <i class="link-icon mdi mdi-18px mdi-pen"></i>
                    <span class="link-text">Song Writers</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= Router::url(['action' => 'vocalists']) ?>"
                   class="nav-link ofjtagoh py-2 text-dark font-weight-normal">
                    <i class="link-icon mdi mdi-18px mdi-microphone-variant"></i>
                    <span class="link-text">Vocalists</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= Router::url(['action' => 'directors']) ?>"
                   class="nav-link ofjtagoh py-2 text-dark font-weight-normal">
                    <i class="link-icon mdi mdi-18px mdi-account-cowboy-hat"></i>
                    <span class="link-text">Directors</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= Router::url(['action' => 'video-makers']) ?>"
                   class="nav-link ofjtagoh py-2 text-dark font-weight-normal">
                    <i class="link-icon mdi mdi-18px mdi-camcorder"></i>
                    <span class="link-text">Video Makers</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= Router::url(['action' => 'choreographers']) ?>"
                   class="nav-link ofjtagoh py-2 text-dark font-weight-normal">
                    <i class="link-icon mdi mdi-18px mdi-kabaddi"></i>
                    <span class="link-text">Choreographers</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= Router::url(['action' => 'trends']) ?>"
                   class="nav-link ofjtagoh py-2 text-dark font-weight-normal">
                    <i class="link-icon mdi mdi-18px mdi-chart-line"></i>
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

