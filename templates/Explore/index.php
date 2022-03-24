<?php

/**
 * @var \App\View\AppView $this ;
 */

use App\Utility\RandomString;
use Cake\Routing\Router;
$this->enablePageHeader();
?>
<section class="_UxaA py-3 mx-n3 section bg-white">
    <div class="px-3">
        <h4 class="section-title mb-3">Discover People</h4>
    </div>
    <div id="carousel-controls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner px-3">
            <div class="carousel-item active">
                <ul class="nav nav-grid row-cols-2 row-cols-lg-5 row-cols-sm-4">
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'artists',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'artists',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 icofont-group fsz-36"></i> Artists</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'actors',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'actors',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 icofont-tracking fsz-36"></i> Actors</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'producers',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'producers',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-piano"></i> Producers</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'index',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'people',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 fsz-36 icofont-people"></i> People</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'song-writers',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'song_writers',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-music"></i>
                            Song Writers</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'script-writers',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'script_writers',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-music"></i>
                            Script Writers</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'comedians',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'comedians',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-account-voice"></i>Comedians</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'athletes',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 fsz-36 icofont-jumping"></i>Athletes</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'athletes',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'cat' => 'soccer_players'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 fsz-36 icofont-kick"></i>Soccer Players</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'athletes',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'cat' => 'tennis_players'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 fsz-36 icofont-tennis-player"></i> Tennis Players</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'athletes',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'cat' => 'baseball_players'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 fsz-36 icofont-baseballer"></i> Baseball Players</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'athletes',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'cat' => 'basket_ball_players'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 fsz-36 icofont-basketball-hoop"></i> Basket Ball Players</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'athletes',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'cat' => 'golfers'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 fsz-36 icofont-golfer"></i>Golfers</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'athletes',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'cat' => 'runners'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 fsz-36 icofont-runner-alt-1"></i>Runners</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'athletes',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'cat' => 'referees'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 fsz-36 icofont-referee"></i>Referees</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'athletes',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'cat' => 'coaches'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 fsz-36 icofont-team-alt"></i>Coaches</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'nearby',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'places',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="greedy"
                           class="nav-link">
                            <i class="lh-1 fsz-36 icofont-map-pins"></i>
                            Nearby</a>
                    </li>
                </ul>
            </div>
        </div>
<!--        <a class="carousel-control-prev" href="#carousel-controls" role="button" data-slide="prev">-->
<!--            <span class="c-grey-500 mdi mdi-48px mdi-chevron-left" aria-hidden="true"></span>-->
<!--            <span class="sr-only">Previous</span>-->
<!--        </a>-->
<!--        <a class="carousel-control-next" href="#carousel-controls" role="button" data-slide="next">-->
<!--            <span class="c-grey-500 mdi mdi-48px mdi-chevron-right" aria-hidden="true"></span>-->
<!--            <span class="sr-only">Next</span>-->
<!--        </a>-->
    </div>
</section>
<section class="_UxaA py-3 mx-n3 section bg-white">
    <div class="px-3">
        <h4 class="section-title mb-3">Explore Entertainment</h4>
    </div>
    <div id="carousel-controls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner px-3">
            <div class="carousel-item active">
                <ul class="nav nav-grid row-cols-2 row-cols-lg-5 row-cols-sm-4">
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'music',
                            'action' => 'index',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'music',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-behaviour="greedy"
                           data-target='#page-content-wrapper'
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-music"></i>
                            Music</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'movies',
                            'action' => 'index',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'movies',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="greedy"
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-movie-open"></i> Movies</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'sports',
                            'action' => 'index',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'sports',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="greedy"
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-music"></i>
                            Sports</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'comedies',
                            'action' => 'index',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'comedies',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-account-voice"></i> Comedies</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'shows',
                            'action' => 'tv-shows',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'tv-shows',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="greedy"
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-television-clean"></i> TV Shows</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'events',
                            'action' => 'index',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'events',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="greedy"
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-calendar"></i>
                            Events</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'nearby',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'places',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="greedy"
                           class="nav-link">
                            <i class="lh-1 fsz-36 icofont-map-pins"></i>
                            Nearby</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="_UxaA py-3 mx-n3 section bg-white">
    <div class="px-3">
        <h4 class="section-title mb-3">Thrill Base</h4>
    </div>
    <div id="carousel-controls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner px-3">
            <div class="carousel-item active">
                <ul class="nav nav-grid row-cols-2 row-cols-lg-5 row-cols-sm-4">
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'artists',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'artists',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 icofont-group fsz-36"></i> Artists</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'actors',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'actors',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 icofont-tracking fsz-36"></i> Actors</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'producers',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'producers',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-piano"></i> Producers</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'index',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'people',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 fsz-36 icofont-people"></i> People</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'hashtags',
                            'actions' => 'index',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'hashtags'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-pound"></i> Hashtags</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'posts',
                            'action' => 'index',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'posts',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-text-subject"></i> Posts</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'music',
                            'action' => 'index',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'music',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-behaviour="greedy"
                           data-target='#page-content-wrapper'
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-music"></i>
                            Music</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'movies',
                            'action' => 'index',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'movies',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="greedy"
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-movie-open"></i> Movies</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'sports',
                            'action' => 'index',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'sports',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="greedy"
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-music"></i>
                            Sports</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'song-writers',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'song_writers',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-music"></i>
                            Song Writers</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'script-writers',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'script_writers',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-music"></i>
                            Script Writers</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'places',
                            'action' => 'index',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'places',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-map-marker"></i>
                            Places</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'comedies',
                            'action' => 'index',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'comedies',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-account-voice"></i> Comedies</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'comedians',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'comedians',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="content"
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-account-voice"></i> Comedians</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'shows',
                            'action' => 'tv-shows',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'tv-shows',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="greedy"
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-television-clean"></i> TV Shows</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'events',
                            'action' => 'index',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'events',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="greedy"
                           class="nav-link">
                            <i class="lh-1 mdi fsz-36 mdi-calendar"></i>
                            Events</a>
                    </li>
                    <li class="nav-grid-item">
                        <a href="<?= Router::url([
                            'controller' => 'people',
                            'action' => 'nearby',
                            '?' => [
                                'rfc' => 'discover_whats_hot',
                                'data' => 'places',
                                'cat' => 'all'
                            ]
                        ]) ?>"
                           vibely-id="v4fU0H5"
                           data-target='#page-content-wrapper'
                           data-behaviour="greedy"
                           class="nav-link">
                            <i class="lh-1 fsz-36 icofont-map-pins"></i>
                            Nearby</a>
                    </li>
                </ul>
            </div>
        </div>
<!--        <a class="carousel-control-prev" href="#carousel-controls" role="button" data-slide="prev">-->
<!--            <span class="c-grey-500 mdi mdi-48px mdi-chevron-left" aria-hidden="true"></span>-->
<!--            <span class="sr-only">Previous</span>-->
<!--        </a>-->
<!--        <a class="carousel-control-next" href="#carousel-controls" role="button" data-slide="next">-->
<!--            <span class="c-grey-500 mdi mdi-48px mdi-chevron-right" aria-hidden="true"></span>-->
<!--            <span class="sr-only">Next</span>-->
<!--        </a>-->
    </div>
</section>
<section id="trending" class="mb-3 py-3 mx-n3 section bg-white border-bottom">
    <div class="section-body p-3">
        <h4 class="section-title mb-3">Trending</h4>
        <?php
        $params = [
            "type" => "random",
            "layout" => "flex_row",
            "colSize" => 5
        ];
        $token = base64_encode(
            serialize($params)
        );
        $dataSrc = '/trends/' . $token;
        ?>
        <div class="_Hc0qB9"
             data-load-type="r"
             data-src="<?= $dataSrc ?>"
             data-su="false"
             data-rfc="trends"
             data-limit="24"
             data-r-ind="false">
        </div>
        <div class="flex-nowrap flex-row foa3ulpk mgriukcz n1ft4jmn ofx-auto pl-3 tvdg2pcc">
            <div class="djmlyve7 col-5 col-md-2 col-sm-3">
                <div class="card">
                    <a href="#" class="align-items-center border-bottom d-flex justify-content-center p-2 text-center">
                                    <span class="avatar avatar-xl">
                                        <i class="mdi mdi-pound mdi-48px"></i>
                                    </span>
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h4><a href="#">And this isn't my nose. This is a false one.</a></h4>
                        <div class="text-muted">Look, my liege! The Knights Who Say Ni demand a sacrifice! …Are you suggesting that coconuts migr...</div>
                        <div class="d-flex align-items-center pt-5 mt-auto">
                            <div class="avatar avatar-md mr-3"></div>
                            <div>
                                <a href="./profile.html" class="text-default">Rose Bradley</a>
                                <small class="d-block text-muted">3 days ago</small>
                            </div>
                            <div class="ml-auto text-muted">
                                <a href="#" class="icon d-none d-md-inline-block ml-3"><i class="fe fe-heart mr-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="djmlyve7 col-5 col-md-2 col-sm-3">
                <div class="card">
                    <a href="#" class="align-items-center border-bottom d-flex justify-content-center p-2 text-center">
                                    <span class="avatar avatar-xl">
                                        <i class="mdi mdi-pound mdi-48px"></i>
                                    </span>
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h4><a href="#">And this isn't my nose. This is a false one.</a></h4>
                        <div class="text-muted">Look, my liege! The Knights Who Say Ni demand a sacrifice! …Are you suggesting that coconuts migr...</div>
                        <div class="d-flex align-items-center pt-5 mt-auto">
                            <div class="avatar avatar-md mr-3"></div>
                            <div>
                                <a href="./profile.html" class="text-default">Rose Bradley</a>
                                <small class="d-block text-muted">3 days ago</small>
                            </div>
                            <div class="ml-auto text-muted">
                                <a href="#" class="icon d-none d-md-inline-block ml-3"><i class="fe fe-heart mr-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="djmlyve7 col-5 col-md-2 col-sm-3">
                <div class="card">
                    <a href="#" class="align-items-center border-bottom d-flex justify-content-center p-2 text-center">
                                    <span class="avatar avatar-xl">
                                        <i class="mdi mdi-pound mdi-48px"></i>
                                    </span>
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h4><a href="#">And this isn't my nose. This is a false one.</a></h4>
                        <div class="text-muted">Look, my liege! The Knights Who Say Ni demand a sacrifice! …Are you suggesting that coconuts migr...</div>
                        <div class="d-flex align-items-center pt-5 mt-auto">
                            <div class="avatar avatar-md mr-3"></div>
                            <div>
                                <a href="./profile.html" class="text-default">Rose Bradley</a>
                                <small class="d-block text-muted">3 days ago</small>
                            </div>
                            <div class="ml-auto text-muted">
                                <a href="#" class="icon d-none d-md-inline-block ml-3"><i class="fe fe-heart mr-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="djmlyve7 col-5 col-md-2 col-sm-3">
                <div class="card">
                    <a href="#" class="align-items-center border-bottom d-flex justify-content-center p-2 text-center">
                                    <span class="avatar avatar-xl">
                                        <i class="mdi mdi-pound mdi-48px"></i>
                                    </span>
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h4><a href="#">And this isn't my nose. This is a false one.</a></h4>
                        <div class="text-muted">Look, my liege! The Knights Who Say Ni demand a sacrifice! …Are you suggesting that coconuts migr...</div>
                        <div class="d-flex align-items-center pt-5 mt-auto">
                            <div class="avatar avatar-md mr-3"></div>
                            <div>
                                <a href="./profile.html" class="text-default">Rose Bradley</a>
                                <small class="d-block text-muted">3 days ago</small>
                            </div>
                            <div class="ml-auto text-muted">
                                <a href="#" class="icon d-none d-md-inline-block ml-3"><i class="fe fe-heart mr-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="djmlyve7 col-5 col-md-2 col-sm-3">
                <div class="card">
                    <a href="#" class="align-items-center border-bottom d-flex justify-content-center p-2 text-center">
                                    <span class="avatar avatar-xl">
                                        <i class="mdi mdi-pound mdi-48px"></i>
                                    </span>
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h4><a href="#">And this isn't my nose. This is a false one.</a></h4>
                        <div class="text-muted">Look, my liege! The Knights Who Say Ni demand a sacrifice! …Are you suggesting that coconuts migr...</div>
                        <div class="d-flex align-items-center pt-5 mt-auto">
                            <div class="avatar avatar-md mr-3"></div>
                            <div>
                                <a href="./profile.html" class="text-default">Rose Bradley</a>
                                <small class="d-block text-muted">3 days ago</small>
                            </div>
                            <div class="ml-auto text-muted">
                                <a href="#" class="icon d-none d-md-inline-block ml-3"><i class="fe fe-heart mr-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="djmlyve7 col-5 col-md-2 col-sm-3">
                <div class="card">
                    <a href="#" class="align-items-center border-bottom d-flex justify-content-center p-2 text-center">
                        <span class="avatar avatar-xl">
                            <i class="mdi mdi-pound mdi-48px"></i>
                        </span>
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h4><a href="#">And this isn't my nose. This is a false one.</a></h4>
                        <div class="text-muted">Look, my liege! The Knights Who Say Ni demand a sacrifice! …Are you suggesting that coconuts migr...</div>
                        <div class="d-flex align-items-center pt-5 mt-auto">
                            <div class="avatar avatar-md mr-3"></div>
                            <div>
                                <a href="./profile.html" class="text-default">Rose Bradley</a>
                                <small class="d-block text-muted">3 days ago</small>
                            </div>
                            <div class="ml-auto text-muted">
                                <a href="#" class="icon d-none d-md-inline-block ml-3"><i class="fe fe-heart mr-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--<section id="peopleYouMayKnow" class="section mgriukcz bg-white mb-2 border-bottom">
    <div class="section-header p-3 border-bottom">
        <h4 class="section-title mb-0">People you may know</h4>
    </div>
    <div class="section-body p-3">
        <?php
/*        $params = [
            "what" => "users",
            "type" => "people_you_may_know",
            "layout" => "flex_row",
            "colSize" => 5
        ];
        $token = base64_encode(
            serialize($params)
        );
        $dataSrces = '/suggestion/' . $token;
        */?>
        <div class="_Hc0qB9"
             data-load-type="r"
             data-src="<?/*= $dataSrces */?>"
             data-rfc="people_you_may_know"
             data-su="false"
             data-limit="24"
             data-r-ind="false">
            <?/*= $this->element('App/loading'); */?>
        </div>
    </div>
    <div class="qYakgu-footer p-2 text-center">
        <?php
/*//        $this->Html->link(__('See More'), [
//            'controller' => 'discover',
//            'action' => 'people',
//            'people-you-may-know'
//        ], [
//            "vibely-id" => "v4fU0H5",
//            "data-target" => '#page-content-wrapper',
//            'class' => '_ah49Gn'
//        ]);
        */?>
        <?php
/*        $trackingCode = [
            'ref' => 'discover',
            'ref_url' => urlencode(
                $this->getRequest()->getRequestTarget()
            )
        ];
        $vibelyData = [
            'drawerMax' => '100%',
            'direction' => 'rtl',
            'drawerType' => 'page',
            'hasCloseBtn' => false
        ];
        $vibelyData = json_encode($vibelyData);
        */?>
        <?/*= $this->Html->link(__('See More'), [
            'controller' => 'Explore',
            'action' => 'people',
            'people-you-may-know',
            '?' => $trackingCode
        ], [
            "data-toggle" => "drawer",
            "aria-controls" => '#'.RandomString::generateString(32,'mixed','alpha'),
            "data-config" => $vibelyData,
            'class' => '_ah49Gn'
        ]); */?>
    </div>
</section>
<section id="recommendedFollows" class="section mgriukcz bg-white mb-2 border-bottom">
    <div class="section-body p-3">
        <h4 class="section-title mb-3">Suggested Follows</h4>
        <?php
/*        $params = [
            "what" => "users",
            "type" => "who_to_follow",
            "layout" => "flex_row",
            "colSize" => 5
        ];
        $token = base64_encode(
            serialize($params)
        );
        $dataSr = '/suggestion/' . $token;
        */?>
        <div class="_Hc0qB9"
             data-load-type="r"
             data-src="<?/*= $dataSr */?>"
             data-rfc="who_to_follow"
             data-su="false"
             data-limit="24"
             data-r-ind="false">
        </div>
    </div>
    <div class="card-footer p-2 text-center">
        <?php
/*//        $this->Html->link(__('See More'), [
//            'controller' => 'discover',
//            'action' => 'people',
//            'who-to-follow'
//        ], [
//            "vibely-id" => "v4fU0H5",
//            "data-target" => '#page-content-wrapper',
//            'class' => '_ah49Gn'
//        ]);
        */?>
        <?php
/*        $trackingCode = [
            'ref' => 'discover',
            'ref_url' => urlencode(
                $this->getRequest()->getRequestTarget()
            )
        ];
        $vibelyData = [
            'drawerMax' => '100%',
            'direction' => 'rtl',
            'drawerType' => 'page',
            'hasCloseBtn' => false
        ];
        $vibelyData = json_encode($vibelyData);
        */?>
        <?/*= $this->Html->link(__('See More'), [
            'controller' => 'Explore',
            'action' => 'people',
            'who-to-follow',
            '?' => $trackingCode
        ], [
            "data-toggle" => "drawer",
            "aria-controls" => '#'.RandomString::generateString(32,'mixed','alpha'),
            "data-config" => $vibelyData,
            'class' => '_ah49Gn'
        ]); */?>
    </div>
</section>-->
