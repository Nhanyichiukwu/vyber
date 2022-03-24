<?php
/**
 * @var \App\View\AppView $this
 *
 * Page specific sorting options
 * Specify the options by which data can be sorted
 */

use Cake\Routing\Router;

$get = (array) $this->getRequest()->getQueryParams();

$genres = json_decode($this->cell('ContentLoader::list', [
    'genres', [
        'byIndustry',
        ['industry' => 'music']
    ]
])->render(), false);
$categories = json_decode($this->cell('ContentLoader::list', [
    'categories', [
        'byType',
        ['type' => 'music']
    ]
])->render(), false);
?>
<?php $this->start('sort_options'); ?>
    <option value="date_added">Date Added</option>
    <option value="release_year" <?= isset($get['sort_by'])
    && $get['sort_by'] === 'release_year' ? 'selected' : '' ?>>Release year
    </option>
    <option value="artist" <?= isset($get['sort_by'])
    && $get['sort_by'] === 'artist' ? 'selected' : '' ?>>Artist
    </option>
<?php $this->end(); ?>


<?php
/**
 * The common layout shared by the entire music space
 */
$this->extend('common');
?>

<?php
/**
 * Page specific content
 */
?>
<div class="all-music-home">
    <section class="mb-2 card">
        <div class="section-body p-3">
            <h4 class="title-bar row justify-content-between">
                <div class="col-auto">
                    <div class="text-muted"><span class="small">Trending</span></div>
                </div>
                <div class="col-auto">
                    <a href="#" class="align-items-center d-inline-flex fsz-12">
                        <span class="link-text">All</span>
                        <i class="mdi mdi-chevron-down mdi-18px"></i>
                    </a>
                </div>
            </h4>
            <div class="vmj3u4o2 flex-nowrap flex-row foa3ulpk mgriukcz n1ft4jmn ofx-auto pl-3 tvdg2pcc compact">
                <div class="media-list-item">
                    <div class="we4ycpph square-media mmhtpn7c">
                        <div class="media-poster _3PpE _XZA1 _kx7 _poYC _v6nr h-100 o-hidden w-100 hlhgxv73"
                             style="background-image:
                    url(<?= Router::url('/media/zpbTbMSnFOeGQdFzFMTS?type=photo&format=jpg&size=small',
                                 true) ?>);">
                            <img src="<?=
                            Router::url('/media/zpbTbMSnFOeGQdFzFMTS?type=photo&format=jpg&size=small',
                                true); ?>"
                            class="media _Aqj"
                                 alt="">
                        </div>
                        <div class="media-overlay o-hidden">
                            <a href="#" class="icon lh_Ut7 xteddw8y music-play-btn"></a>
                        </div>
                    </div>
                </div>
                <div class="media-list-item">
                    <div class="we4ycpph square-media mmhtpn7c">
                        <div class="media-poster _3PpE _XZA1 _kx7 _poYC _v6nr h-100 o-hidden w-100 hlhgxv73"
                             style="background-image:
                    url(media/zpbTbMSnFOeGQdFzFMTS?type=photo&format=jpg&size=small);">
                            <img src="media/zpbTbMSnFOeGQdFzFMTS?type=photo&format=jpg&size=small" class="media _Aqj"
                                 alt="">
                        </div>
                        <div class="media-overlay o-hidden">
                            <a href="#" class="icon lh_Ut7 xteddw8y music-play-btn"></a>
                        </div>
                    </div>
                </div>
                <div class="media-list-item">
                    <div class="we4ycpph square-media mmhtpn7c">
                        <div class="media-poster _3PpE _XZA1 _kx7 _poYC _v6nr h-100 o-hidden w-100 hlhgxv73"
                             style="background-image:
                    url(media/zpbTbMSnFOeGQdFzFMTS?type=photo&format=jpg&size=small);">
                            <img src="media/zpbTbMSnFOeGQdFzFMTS?type=photo&format=jpg&size=small" class="media _Aqj"
                                 alt="">
                        </div>
                        <div class="media-overlay o-hidden">
                            <a href="#" class="icon lh_Ut7 xteddw8y music-play-btn"></a>
                        </div>
                    </div>
                </div>
                <div class="media-list-item">
                    <div class="we4ycpph square-media mmhtpn7c">
                        <div class="media-poster _3PpE _XZA1 _kx7 _poYC _v6nr h-100 o-hidden w-100 hlhgxv73"
                             style="background-image:
                    url(media/zpbTbMSnFOeGQdFzFMTS?type=photo&format=jpg&size=small);">
                            <img src="media/zpbTbMSnFOeGQdFzFMTS?type=photo&format=jpg&size=small" class="media _Aqj"
                                 alt="">
                        </div>
                        <div class="media-overlay o-hidden">
                            <a href="#" class="icon lh_Ut7 xteddw8y music-play-btn"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="playing" class="section bg-white mb-2">
        <div class="section-body p-3">
            <h6 class="section-title n1ft4jmn align-items-baseline">
                <!--            <i class="icofont-sound-wave-alt fsz-24 me-2"></i>-->
                Now Playing
                <span class="align-items-baseline d-flex">
                <span class="musicbar animate inline _oFb7Hd ms-2" style="width:20px;height:15px">
                    <span class="bar1 a1 bg-primary lter"></span>
                    <span class="bar2 a2 bg-info lt"></span>
                    <span class="bar3 a3 bg-success"></span>
                    <span class="bar4 a4 bg-lime dk"></span>
                    <span class="bar5 a5 bg-green dker"></span>
                </span>
                <span class="musicbar animate inline _oFb7Hd" style="width:20px;height:20px">
                    <span class="bar3 a3 bg-yellow"></span>
                    <span class="bar4 a4 bg-orange dk"></span>
                    <span class="bar5 a5 bg-red dker"></span>
                    <span class="bar1 a1 bg-primary lter"></span>
                    <span class="bar2 a2 bg-info lt"></span>
                    <span class="bar3 a3 bg-success"></span>
                </span>
                <span class="musicbar animate inline _oFb7Hd" style="width:20px;height:25px">
                    <span class="bar1 a1 bg-primary lter"></span>
                    <span class="bar2 a2 bg-info lt"></span>
                    <span class="bar3 a3 bg-yellow"></span>
                    <span class="bar4 a4 bg-orange dk"></span>
                    <span class="bar5 a5 bg-red dker"></span>
                </span>
            </span>
            </h6>
            <?= $this->element('App/loading', ['modifier' => 'py-3']); ?>
        </div>
    </section>
    <section id="trends-and-recommendation" class="section mb-3">
        <div class="section-body p-3">
            <div class="row gutters-sm">
                <div class="col-lg-6">
                    <h3 class="section-title n1ft4jmn bzakvszf fw-light text-red">
                        <i class="icofont-signal fsz-24 me-2"></i> Trending
                    </h3>
                    <div class="bg-white p-3">
                        <?= $this->contentUnavailable('trending music'); ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h3 class="section-title n1ft4jmn bzakvszf fw-light text-lime">
                        <i class="icofont-signal fsz-24 me-2"></i> Recommended For You
                    </h3>
                    <div class="bg-white p-3">
                        <?= $this->contentUnavailable('any recommendations'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="new-music" class="card _4gUj0 _gGsso shadow-none">
        <div class="card-header border-0 d-block p-3 toolbar">
            <ul class="mx-n3 nav nav-tabs" role="tablist">
                <li class="nav-item px-3">
                    <a href="javascript:void()"
                       id="new-releases-tab"
                       class="nav-link ofjtagoh py-2 text-dark font-weight-normal active tab-pane"
                       data-action="loadContent"
                       data-src="<?= Router::url('media/music?filter=new_releases') ?>"
                       data-bs-toggle="tab"
                       data-bs-target="#new-releases"
                       role="tab"
                       aria-selected="true"
                       aria-controls="new-releases">
                        <span class="link-text">New Releases</span>
                    </a>
                </li>
                <li class="nav-item px-3">
                    <a href="javascript:void()"
                       id="new-songs-tab"
                       class="nav-link ofjtagoh py-2 text-dark font-weight-normal tab-pane"
                       data-action="loadContent"
                       data-src="<?= Router::url('media/music?filter=new_songs') ?>"
                       data-bs-toggle="tab"
                       data-bs-target="#new-songs"
                       role="tab"
                       aria-selected="true"
                       aria-controls="new-songs">
                        <span class="link-text">New Songs</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="tab-content px-3">
            <div id="new-releases" class="tab-pane fade show active" role="tabpanel" aria-labelledby="new-releases-tab">
                <ul class="media-grid flex-lg-wrap flex-sm-nowrap ofx-auto foa3ulpk px-0 row unstyled"
                    data-column-layout="row-cols-2 row-cols-lg-5 row-cols-md-3">
                    <li class="media-list-item col-sm-5 col-md-4 col-lg-3">
                        <div class="card media-card">
                            <div class="media-cover-image uibt0xlv we4ycpph">
                                <div class="media-poster _3PpE _XZA1 _kx7 _poYC _v6nr h-100 o-hidden w-100 hlhgxv73" style="background-image:
                    url(media/zpbTbMSnFOeGQdFzFMTS?type=photo&amp;format=jpg&amp;size=small);">
                                    <img src="media/zpbTbMSnFOeGQdFzFMTS?type=photo&amp;format=jpg&amp;size=small" class="media _Aqj" alt="">
                                </div>
                                <div class="media-overlay o-hidden">
                                    <a href="#" class="icon lh_Ut7 music-play-btn">
                                        <i class="fsz-32 mdi mdi-play-circle"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body media-details px-3 py-2">
                                <h4 class="media-title">The title of the media</h4>
                                <div class="media-meta">
                                    <div class="media-cast fsz-12">
                                    <span class="media-cast-list small"><i class="mdi mdi-account"></i> Primary
                                        Cast</span>
                                    </div>
                                    <div class="d-flex fsz-12 gutters-sm lh-sm mt-1 mx-0 row">
                                        <span class="col gutters-sm media-genre text-red">Hip-Hop</span><span class="col media-category text-azure">Gospel</span>
                                    </div>
                                    <div class="d-flex media-activity mt-1 text-">
                                        <span class="media-category pr-2"><i class="mdi mdi-eye"></i> <span class="small">1.8M views</span></span><span class="media-date"><i class="mdi mdi-clock-outline"></i> <span class="small">2yrs</span></span>
                                    </div><div class="d-md-flex fsz-14 gutters-xs justify-content-between justify-content-md-start mt-1 row text-gray">
                                    <span class="col-auto">
                                        <span class="d-grid d-md-flex lh-sm media-reactions small text-center"><i class="mdi mdi-thumb-up me-md-1"></i>
                                            1k+</span>
                                    </span>
                                        <span class="col-auto">
                                        <span class="d-grid d-md-flex lh-sm medida-share small text-center"><i class="mdi mdi-share me-md-1"></i>
                                            800+</span>
                                    </span>
                                        <span class="col-auto">
                                        <span class="d-grid d-md-flex lh-sm media-comments small text-center"><i class="mdi mdi-comment me-md-1"></i>
                                            10k+</span>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="media-list-item col-sm-5 col-md-4 col-lg-3">
                        <div class="card media-card">
                            <div class="media-cover-image uibt0xlv we4ycpph">
                                <div class="media-poster _3PpE _XZA1 _kx7 _poYC _v6nr h-100 o-hidden w-100 hlhgxv73" style="background-image:
                    url(media/zpbTbMSnFOeGQdFzFMTS?type=photo&amp;format=jpg&amp;size=small);">
                                    <img src="media/zpbTbMSnFOeGQdFzFMTS?type=photo&amp;format=jpg&amp;size=small" class="media _Aqj" alt="">
                                </div>
                                <div class="media-overlay o-hidden">
                                    <a href="#" class="icon lh_Ut7 music-play-btn">
                                        <i class="fsz-32 mdi mdi-play-circle"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body media-details px-3 py-2">
                                <h4 class="media-title">The title of the media</h4>
                                <div class="media-meta">
                                    <div class="media-cast fsz-12">
                                    <span class="media-cast-list small"><i class="mdi mdi-account"></i> Primary
                                        Cast</span>
                                    </div>
                                    <div class="d-flex fsz-12 gutters-sm lh-sm mt-1 mx-0 row">
                                        <span class="col gutters-sm media-genre text-red">Hip-Hop</span><span class="col media-category text-azure">Gospel</span>
                                    </div>
                                    <div class="d-flex media-activity mt-1 text-">
                                        <span class="media-category pr-2"><i class="mdi mdi-eye"></i> <span class="small">1.8M views</span></span><span class="media-date"><i class="mdi mdi-clock-outline"></i> <span class="small">2yrs</span></span>
                                    </div><div class="d-md-flex fsz-14 gutters-xs justify-content-between justify-content-md-start mt-1 row text-gray">
                                    <span class="col-auto">
                                        <span class="d-grid d-md-flex lh-sm media-reactions small text-center"><i class="mdi mdi-thumb-up me-md-1"></i>
                                            1k+</span>
                                    </span>
                                        <span class="col-auto">
                                        <span class="d-grid d-md-flex lh-sm medida-share small text-center"><i class="mdi mdi-share me-md-1"></i>
                                            800+</span>
                                    </span>
                                        <span class="col-auto">
                                        <span class="d-grid d-md-flex lh-sm media-comments small text-center"><i class="mdi mdi-comment me-md-1"></i>
                                            10k+</span>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="media-list-item col-sm-5 col-md-4 col-lg-3">
                        <div class="card media-card">
                            <div class="media-cover-image uibt0xlv we4ycpph">
                                <div class="media-poster _3PpE _XZA1 _kx7 _poYC _v6nr h-100 o-hidden w-100 hlhgxv73" style="background-image:
                    url(media/zpbTbMSnFOeGQdFzFMTS?type=photo&amp;format=jpg&amp;size=small);">
                                    <img src="media/zpbTbMSnFOeGQdFzFMTS?type=photo&amp;format=jpg&amp;size=small" class="media _Aqj" alt="">
                                </div>
                                <div class="media-overlay o-hidden">
                                    <a href="#" class="icon lh_Ut7 music-play-btn">
                                        <i class="fsz-32 mdi mdi-play-circle"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body media-details px-3 py-2">
                                <h4 class="media-title">The title of the media</h4>
                                <div class="media-meta">
                                    <div class="media-cast fsz-12">
                                    <span class="media-cast-list small"><i class="mdi mdi-account"></i> Primary
                                        Cast</span>
                                    </div>
                                    <div class="d-flex fsz-12 gutters-sm lh-sm mt-1 mx-0 row">
                                        <span class="col gutters-sm media-genre text-red">Hip-Hop</span><span class="col media-category text-azure">Gospel</span>
                                    </div>
                                    <div class="d-flex media-activity mt-1 text-">
                                        <span class="media-category pr-2"><i class="mdi mdi-eye"></i> <span class="small">1.8M views</span></span><span class="media-date"><i class="mdi mdi-clock-outline"></i> <span class="small">2yrs</span></span>
                                    </div><div class="d-md-flex fsz-14 gutters-xs justify-content-between justify-content-md-start mt-1 row text-gray">
                                    <span class="col-auto">
                                        <span class="d-grid d-md-flex lh-sm media-reactions small text-center"><i class="mdi mdi-thumb-up me-md-1"></i>
                                            1k+</span>
                                    </span>
                                        <span class="col-auto">
                                        <span class="d-grid d-md-flex lh-sm medida-share small text-center"><i class="mdi mdi-share me-md-1"></i>
                                            800+</span>
                                    </span>
                                        <span class="col-auto">
                                        <span class="d-grid d-md-flex lh-sm media-comments small text-center"><i class="mdi mdi-comment me-md-1"></i>
                                            10k+</span>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!--<li class="media-list-item bgcH-grey-300 p-3">
                        <div class="row gutters-sm">
                            <div class="col-4 col-lg-2 col-md-4">
                                <div class="we4ycpph square-media">
                                    <div class="media-poster _3PpE _XZA1 _kx7 _poYC _v6nr h-100 o-hidden w-100 hlhgxv73"
                                         style="background-image:
                            url(media/zpbTbMSnFOeGQdFzFMTS?type=photo&format=jpg&size=small);">
                                        <img src="media/zpbTbMSnFOeGQdFzFMTS?type=photo&format=jpg&size=small"
                                             class="media _Aqj"
                                             alt="">
                                    </div>
                                    <div class="media-overlay o-hidden">
                                        <a href="#" class="icon lh_Ut7 music-play-btn">
                                            <i class="fsz-32 mdi mdi-play-circle"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="media-details card-body p-3">
                                    <h4 class="media-title">The title of the media</h4>
                                    <div class="media-meta">
                                        <div class="media-cast fsz-12">
                                            <span class="media-cast-list small"><i class="mdi mdi-account"></i> Primary
                                                Cast</span>
                                        </div>
                                        <div class="d-flex justify-content-between media-activity fsz-12">
                                            <span class="media-date small"><i class="mdi mdi-clock-outline"></i> 2yrs</span>
                                        </div>
                                        <div class="justify-content-between justify-content-md-start media-activity row row-cols-3 row-cols-md-6 small">
                                            <span class="media-reactions small"><i class="mdi mdi-thumb-up"></i> 1k+</span>
                                            <span class="medida-share small"><i class="mdi mdi-share"></i> 800+</span>
                                            <span class="media-comments small"><i class="mdi mdi-comment"></i> 10k+</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>-->
                </ul>
            </div>
            <div id="new-songs" class="tab-pane fade" role="tabpanel" aria-labelledby="new-songs-tab">
                <?php
                $token = base64_encode(
                    serialize(
                        json_encode([
                            'resource_handle' => 'media',
                            'resource_path' => '/element/media/large_icons',
                            'content' => 'music',
                        ])
                    )
                );

                $latestSongsQuery = array_merge($get,[
                    'filter' => 'latest',
                    'token' => $token,
                ]);
                $latestSongsQueryStr = http_build_query($latestSongsQuery);
                $latestSongsDataSrc = 'media/music?' . $latestSongsQueryStr;
                ?>
                <div id="fetch-new-songs"
                     data-load-type="async"
                     class="ajaxify mb-n3"
                     data-category="page_data"
                     data-src="<?= $latestSongsDataSrc ?>"
                     data-config='<?= json_encode([
                         'content' => 'new_songs',
                         'remove_if_no_content' => 'no',
                         'check_for_update' => 'yes',
                         'auto_update' => 'yes',
                         'use_data_prospect' => 'yes',
                         'load_type' => 'overwrite',
                     ]); ?>'>
                    <?= $this->element('App/loading', ['modifier' => 'py-3']); ?>
                </div>
            </div>
        </div>
    </section>
    <div id="top-music" class="container-fluid px-3">
        <div class="row gutters-sm">
            <div class="col-md-6 col-lg-4">
                <section class="section">
                    <div class="section-header">
                        <ul class="nav nav-tabs mx-0" role="tablist">
                            <li class="nav-item px-3">
                                <a href="javascript:void()"
                                   id="top-songs-tab"
                                   class="nav-link ofjtagoh py-2 text-dark font-weight-normal active tab-pane"
                                   data-action="loadContent"
                                   data-src="<?= Router::url('media/music?filter=top_songs') ?>"
                                   data-bs-toggle="tab"
                                   data-bs-target="#top-songs"
                                   role="tab"
                                   aria-selected="true"
                                   aria-controls="top-songs">
                                    <span class="link-text">Top Songs</span>
                                </a>
                            </li>
                            <li class="nav-item px-3">
                                <a href="javascript:void()"
                                   id="top-videos-tab"
                                   class="nav-link ofjtagoh py-2 text-dark font-weight-normal tab-pane"
                                   data-action="loadContent"
                                   data-src="<?= Router::url('media/music?filter=top_videos') ?>"
                                   data-bs-toggle="tab"
                                   data-bs-target="#top-videos"
                                   role="tab"
                                   aria-selected="true"
                                   aria-controls="top-videos">
                                    <span class="link-text">Top Videos</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content py-3">
                        <div id="top-songs" class="tab-pane fade show active" role="tabpanel"
                             aria-labelledby="top-songs-tab">
                            <?php
                            $token = base64_encode(
                                serialize(
                                    json_encode([
                                        'resource_handle' => 'media',
                                        'resource_path' => '/element/media/ordered_list',
                                        'content' => 'music',
                                    ])
                                )
                            );

                            $topSongsQuery = array_merge($get, [
                                'filter' => 'top',
                                'type' => 'songs',
                                'token' => $token,
                            ]);
                            $topSongsQueryStr = http_build_query($topSongsQuery);
                            $topSongsDataSrc = 'media/music?' . $topSongsQueryStr;
                            ?>
                            <div data-load-type="async"
                                 class="ajaxify mb-n3"
                                 data-category="page_data"
                                 data-src="<?= $topSongsDataSrc ?>"
                                 data-config='<?= json_encode([
                                     'content' => 'top_songs',
                                     'remove_if_no_content' => 'no',
                                     'check_for_update' => 'yes',
                                     'auto_update' => 'yes',
                                     'use_data_prospect' => 'yes',
                                     'load_type' => 'overwrite',
                                 ]); ?>'>
                                <?= $this->element('App/loading', ['modifier' => 'py-3']); ?>
                            </div>
                        </div>
                        <div id="top-videos" class="tab-pane fade" role="tabpanel"
                             aria-labelledby="top-videos-tab">
                            <?php
                            $token = base64_encode(
                                serialize(
                                    json_encode([
                                        'resource_handle' => 'media',
                                        'resource_path' => '/element/media/ordered_list',
                                        'content' => 'music',
                                    ])
                                )
                            );

                            $topSongsQuery = array_merge($get, [
                                'filter' => 'top',
                                'type' => 'videos',
                                'token' => $token,
                            ]);
                            $topSongsQueryStr = http_build_query($topSongsQuery);
                            $topSongsDataSrc = 'media/music?' . $topSongsQueryStr;
                            ?>
                            <div data-load-type="async"
                                 class="ajaxify mb-n3"
                                 data-category="page_data"
                                 data-src="<?= $topSongsDataSrc ?>"
                                 data-config='<?= json_encode([
                                     'content' => 'top_songs',
                                     'remove_if_no_content' => 'no',
                                     'check_for_update' => 'yes',
                                     'auto_update' => 'yes',
                                     'use_data_prospect' => 'yes',
                                     'load_type' => 'overwrite',
                                 ]); ?>'>
                                <?= $this->element('App/loading', ['modifier' => 'py-3']); ?>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-6 col-lg-4">

            </div>
        </div>
    </div>
</div>

<?php $this->start('scriptBottom'); ?>
    (function($) {
        const FORM = $('.filter-form');
        FORM.on('submit', function (e) {
            e.preventDefault();
            let $f = $(this),
                t = $f.data('target'),
                url = new URL($f.attr('action')),
                s = $f.serialize();
            let params = $.extend(url.search.deserializeString(), s.deserializeString());
            const tds = $(t).data('src');
            const sp = tds.split('?');
            params = $.extend(params, sp.pop().deserializeString());
            const query = $(params).serializeObject();
            const newUrl = sp[0] + '?' + query;
            $(t).attr('data-src', newUrl);
            const cwApp = new App();
            cwApp.ajaxLoader.ajaxify(t);
        });
    })(jQuery);
<?php $this->end() ?>


