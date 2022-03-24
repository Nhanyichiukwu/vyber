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
    <section id="new-releases" class="card _4gUj0 _gGsso shadow-none">
        <div class="card-header ofjtagoh q3ywbqi8 toolbar border-0 p-3">
            <div class="bzakvszf gutters-xs q3ywbqi8 row w-100">
                <div class="col-auto">
                    <h5 class="bzakvszf paewjkki mb-0 n1ft4jmn section-title">
                        New Releases
                    </h5>
                </div>
                <div class="col-auto">
                    <div class="align-items-center filter-tools-btns gutters-0 justify-content-between
                justify-content-md-start lh-1 row small">
                    <span class="col-auto">
                        <button class="btn btn-sm lh-1" data-bs-toggle="collapse" data-bs-target="#nr-filter-pane"
                                aria-expanded="true">
                            <span class="d-none d-sm-inline"><i class="mdi mdi-filter"></i></span> Filter
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                    </span>
                        <span class="col-auto">
                        <button class="btn btn-sm lh-1" data-bs-toggle="collapse" data-bs-target="#nr-sort-pane"
                                aria-expanded="false">
                            <span class="d-none d-sm-inline"><i class="mdi mdi-sort"></i></span> Sort
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                    </span>
                        <span class="col-auto">
                        <button class="btn btn-sm lh-1" data-bs-toggle="collapse" data-bs-target="#nr-search-pane"
                                aria-expanded="true">
                            <span class="d-none d-sm-inline"><i class="mdi mdi-magnify"></i></span> Search
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                    </span>
                    </div>
                </div>
            </div>
            <div class="filter-panes flex-md-row gutters-sm ofjtagoh row w-100">
                <div class="col-md-auto flex-fill">
                    <?= $this->Form->create(null, [
                        'id' => 'new-songs-filter',
                        'name' => 'new_songs_filter',
                        'url' => Router::url($this->getRequest()->getRequestTarget(), true),
                        'type' => 'get',
                        'data-target' => '#fetch-new-songs',
                        'class' => 'filter-form form-block flex-column flex-md-row row gutters-sm'
                    ]); ?>
                    <div id="nr-filter-pane" class="collapse col-md-6 flex-fill <?= isset($get['filtered']) ? 'show' :
                        '' ?>">
                        <div class="filter-tools py-2">
                            <div class="d-none">
                                <input type="hidden" class="hidden" name="filtered" value="1">
                            </div>
                            <div class="gutters-xs row">
                                <div class="align-self-center col-auto">
                                    <span class="lh-sm mb-2 small">Filter By:</span>
                                </div>
                                <div class="col">
                                    <label for="genre" class="lh-sm mb-1 small"><small>Genre:</small></label>
                                    <select id="genre" name="genre"
                                            class="form-select form-select-sm kfjlsihm "
                                            aria-label=".form-select-sm example">
                                        <option value="all">All</option>
                                        <?php foreach ($genres as $genre): ?>
                                            <option value="<?= $genre->slug ?>" <?= isset($get['genre'])
                                            && $get['genre'] === $genre->slug ? 'selected' : '' ?>><?= $genre->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!--<div class="col-auto">
                        <label for="role" class="lh-sm mb-1 small">Artists Role:</label>
                        <select id="role" name="role"
                                class="form-select form-select-sm kfjlsihm neh5467l"
                                aria-label=".form-select-sm example">
                            <option value="">Role</option>
                            <?php /*foreach ($roles as $role): */ ?>
                                <option value="<? /*= $role->slug */ ?>" <? /*= isset($get['role'])
                                && $get['role'] === $role->slug ? 'selected' : ''*/ ?>><? /*= $role->name */ ?></option>
                            <?php /*endforeach; */ ?>
                        </select>
                    </div>-->
                                <div class="col">
                                    <label for="category" class="lh-sm mb-1 small"><small>Category:</small></label>
                                    <select id="category" name="category"
                                            class="form-select form-select-sm kfjlsihm "
                                            aria-label=".form-select-sm example">
                                        <option value="all">All</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= $category->slug ?>" <?= isset($get['category'])
                                            && $get['category'] === $category->slug ? 'selected' : '' ?>><?= $category->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="align-self-end col-auto">
                                    <button class="btn btn-sm btn-orange" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="nr-sort-pane"
                         class="align-self-md-end col-md-6 flex-fill collapse <?= isset($get['sorted']) ?
                             'show' : '' ?>">
                        <div class="sort-tools py-2">
                            <div class="d-none">
                                <input type="hidden" class="hidden" name="sorted" value="1">
                            </div>
                            <div class="row gutters-xs">
                                <div class="align-self-center col-auto">
                                    <span class="lh-sm mb-2 small">Sort:</span>
                                </div>
                                <div class="col">
                                    <select id="sort-by" name="sort"
                                            class="form-select form-select-sm kfjlsihm "
                                            aria-label="form-select-sm example">
                                        <?php if ($this->fetch('sort_options')): ?>
                                            <?= $this->fetch('sort_options'); ?>
                                        <?php endif; ?>
                                        <option value="alphabetical" <?= isset($get['sort'])
                                        && $get['sort'] === 'alphabetical' ? 'selected' : '' ?>>A to Z
                                        </option>
                                    </select>
                                </div>
                                <!--<div class="col-auto">
                        <label for="role" class="lh-sm mb-1 small">Artists Role:</label>
                        <select id="role" name="role"
                                class="form-select form-select-sm kfjlsihm neh5467l"
                                aria-label=".form-select-sm example">
                            <option value="">Role</option>
                            <?php /*foreach ($roles as $role): */ ?>
                                <option value="<? /*= $role->slug */ ?>" <? /*= isset($get['role'])
                                && $get['role'] === $role->slug ? 'selected' : ''*/ ?>><? /*= $role->name */ ?></option>
                            <?php /*endforeach; */ ?>
                        </select>
                    </div>-->
                                <div class="col">
                                    <select id="sort-dir" name="direction"
                                            class="form-select form-select-sm kfjlsihm "
                                            aria-label="Sort Direction">
                                        <option value="asc" <?= isset($get['direction'])
                                        && $get['direction'] === 'asc' ? 'selected' : '' ?>>Asc
                                        </option>
                                        <option value="desc" <?= isset($get['direction'])
                                        && $get['direction'] === 'desc' ? 'selected' : '' ?>>Desc
                                        </option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-sm btn-orange" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?= $this->Form->end(); ?>
                </div>
                <div id="nr-search-pane" class="align-self-md-end col-md-4 collapse flex-fill">
                    <div class="search-form py-2">
                        <form class="input-icon">
                            <input type="search"
                                   class="bgc-grey-100 form-control form-control-sm header-search rounded-pill"
                                   placeholder="Search…" tabindex="1">
                            <div class="input-icon-addon">
                                <i class="fe fe-search py-2"></i>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-3">
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
    </section>
    <section id="new-music" class="card _4gUj0 _gGsso shadow-none">
        <div class="card-header ofjtagoh q3ywbqi8 toolbar border-0 p-3">
            <div class="bzakvszf gutters-xs q3ywbqi8 row w-100">
                <div class="col-auto">
                    <h3 class="bzakvszf paewjkki mb-0 n1ft4jmn section-title text-orange">
                        <i class="icofont-star-alt-2 fsz-24 me-2 d-none d-sm-block"></i>
                        New Songs
                    </h3>
                </div>
                <div class="col-auto">
                    <div class="align-items-center filter-tools-btns gutters-0 justify-content-between
                justify-content-md-start lh-1 row small">
                    <span class="col-auto">
                        <button class="btn btn-sm lh-1" data-bs-toggle="collapse" data-bs-target="#nm-filter-pane"
                                aria-expanded="true">
                            <span class="d-none d-sm-inline"><i class="mdi mdi-filter"></i></span> Filter
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                    </span>
                        <span class="col-auto">
                        <button class="btn btn-sm lh-1" data-bs-toggle="collapse" data-bs-target="#nm-sort-pane"
                                aria-expanded="false">
                            <span class="d-none d-sm-inline"><i class="mdi mdi-sort"></i></span> Sort
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                    </span>
                        <span class="col-auto">
                        <button class="btn btn-sm lh-1" data-bs-toggle="collapse" data-bs-target="#nm-search-pane"
                                aria-expanded="true">
                            <span class="d-none d-sm-inline"><i class="mdi mdi-magnify"></i></span> Search
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                    </span>
                    </div>
                </div>
            </div>
            <div class="filter-panes flex-md-row gutters-sm ofjtagoh row w-100">
                <div class="col-md-auto flex-fill">
                    <?= $this->Form->create(null, [
                        'id' => 'new-songs-filter',
                        'name' => 'new_songs_filter',
                        'url' => Router::url($this->getRequest()->getRequestTarget(), true),
                        'type' => 'get',
                        'data-target' => '#fetch-new-songs',
                        'class' => 'filter-form form-block flex-column flex-md-row row gutters-sm'
                    ]); ?>
                    <div id="nm-filter-pane" class="collapse col-md-6 flex-fill <?= isset($get['filtered']) ? 'show' :
                        '' ?>">
                        <div class="filter-tools py-2">
                            <div class="d-none">
                                <input type="hidden" class="hidden" name="filtered" value="1">
                            </div>
                            <div class="gutters-xs row">
                                <div class="align-self-center col-auto">
                                    <span class="lh-sm mb-2 small">Filter By:</span>
                                </div>
                                <div class="col">
                                    <label for="genre" class="lh-sm mb-1 small"><small>Genre:</small></label>
                                    <select id="genre" name="genre"
                                            class="form-select form-select-sm kfjlsihm "
                                            aria-label=".form-select-sm example">
                                        <option value="all">All</option>
                                        <?php foreach ($genres as $genre): ?>
                                            <option value="<?= $genre->slug ?>" <?= isset($get['genre'])
                                            && $get['genre'] === $genre->slug ? 'selected' : '' ?>><?= $genre->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!--<div class="col-auto">
                        <label for="role" class="lh-sm mb-1 small">Artists Role:</label>
                        <select id="role" name="role"
                                class="form-select form-select-sm kfjlsihm neh5467l"
                                aria-label=".form-select-sm example">
                            <option value="">Role</option>
                            <?php /*foreach ($roles as $role): */ ?>
                                <option value="<? /*= $role->slug */ ?>" <? /*= isset($get['role'])
                                && $get['role'] === $role->slug ? 'selected' : ''*/ ?>><? /*= $role->name */ ?></option>
                            <?php /*endforeach; */ ?>
                        </select>
                    </div>-->
                                <div class="col">
                                    <label for="category" class="lh-sm mb-1 small"><small>Category:</small></label>
                                    <select id="category" name="category"
                                            class="form-select form-select-sm kfjlsihm "
                                            aria-label=".form-select-sm example">
                                        <option value="all">All</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= $category->slug ?>" <?= isset($get['category'])
                                            && $get['category'] === $category->slug ? 'selected' : '' ?>><?= $category->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="align-self-end col-auto">
                                    <button class="btn btn-sm btn-orange" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="nm-sort-pane"
                         class="align-self-md-end col-md-6 flex-fill collapse <?= isset($get['sorted']) ?
                             'show' : '' ?>">
                        <div class="sort-tools py-2">
                            <div class="d-none">
                                <input type="hidden" class="hidden" name="sorted" value="1">
                            </div>
                            <div class="row gutters-xs">
                                <div class="align-self-center col-auto">
                                    <span class="lh-sm mb-2 small">Sort:</span>
                                </div>
                                <div class="col">
                                    <select id="sort-by" name="sort"
                                            class="form-select form-select-sm kfjlsihm "
                                            aria-label="form-select-sm example">
                                        <?php if ($this->fetch('sort_options')): ?>
                                            <?= $this->fetch('sort_options'); ?>
                                        <?php endif; ?>
                                        <option value="alphabetical" <?= isset($get['sort'])
                                        && $get['sort'] === 'alphabetical' ? 'selected' : '' ?>>A to Z
                                        </option>
                                    </select>
                                </div>
                                <!--<div class="col-auto">
                        <label for="role" class="lh-sm mb-1 small">Artists Role:</label>
                        <select id="role" name="role"
                                class="form-select form-select-sm kfjlsihm neh5467l"
                                aria-label=".form-select-sm example">
                            <option value="">Role</option>
                            <?php /*foreach ($roles as $role): */ ?>
                                <option value="<? /*= $role->slug */ ?>" <? /*= isset($get['role'])
                                && $get['role'] === $role->slug ? 'selected' : ''*/ ?>><? /*= $role->name */ ?></option>
                            <?php /*endforeach; */ ?>
                        </select>
                    </div>-->
                                <div class="col">
                                    <select id="sort-dir" name="direction"
                                            class="form-select form-select-sm kfjlsihm "
                                            aria-label="Sort Direction">
                                        <option value="asc" <?= isset($get['direction'])
                                        && $get['direction'] === 'asc' ? 'selected' : '' ?>>Asc
                                        </option>
                                        <option value="desc" <?= isset($get['direction'])
                                        && $get['direction'] === 'desc' ? 'selected' : '' ?>>Desc
                                        </option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-sm btn-orange" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?= $this->Form->end(); ?>
                </div>
                <div id="nm-search-pane" class="align-self-md-end col-md-4 collapse flex-fill">
                    <div class="search-form py-2">
                        <form class="input-icon">
                            <input type="search"
                                   class="bgc-grey-100 form-control form-control-sm header-search rounded-pill"
                                   placeholder="Search…" tabindex="1">
                            <div class="input-icon-addon">
                                <i class="fe fe-search py-2"></i>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-3">
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
    </section>

    <div id="top-music" class="container-fluid px-3">
        <div class="row gutters-sm">
            <div class="col-lg-4">
                <section class="section">
                    <div class="mb-2 n1ft4jmn patuzxjv q3ywbqi8 section-header section-toolbar title-bar">
                        <div class="col-auto">
                            <h3 class="bzakvszf paewjkki mb-0 n1ft4jmn section-title text-azure">
                                <i class="fsz-24 mdi mdi-sort-descending me-2"></i>
                                Top Songs
                            </h3>
                        </div>
                        <div class="col-auto">
                            <a href="<?= Router::url(['action' => 'songs', '?' => ['category' => 'top_songs']]) ?>"
                               class="small text-gray">See All <i class="mdi mdi-chevron-right"></i></a>
                        </div>
                    </div>
                    <div class="section-body pb-3">
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
                </section>
            </div>
            <div class="col-lg-4">
                <section class="section">
                    <div class="mb-2 n1ft4jmn patuzxjv q3ywbqi8 section-header section-toolbar title-bar">
                        <div class="col-auto">
                            <h3 class="bzakvszf paewjkki mb-0 n1ft4jmn section-title text-azure">
                                <i class="fsz-24 mdi mdi-sort-descending me-2"></i>
                                Top Videos
                            </h3>
                        </div>
                        <div class="col-auto">
                            <a href="<?= Router::url(['action' => 'videos', '?' => ['category' => 'top_videos']]) ?>"
                               class="small text-gray">See All <i class="mdi mdi-chevron-right"></i></a>
                        </div>
                    </div>
                    <div class="section-body pb-3">
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
                </section>
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


