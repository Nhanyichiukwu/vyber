<?php
/**
 * Page specific sorting options
 * Specify the options by which data can be sorted
 */

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
<div class="col-lg-10 px-0 px-lg-3 py-lg-3">
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
    <section class="mb-2">
        <div class="section-header title-bar toolbar section-toolbar p-3 px-lg-0">
            <div class="align-items-center gutters-xs justify-content-between row">
                <div class="col-auto">
                    <h4 class="text-muted mb-0"><span class="small">New Releases</span></h4>
                </div>
                <div class="col-auto">
                    <div class="align-items-center filter-tools-btns gutters-0 justify-content-between
                justify-content-md-start lh-1 row small">
                    <span class="col-auto">
                        <button class="btn btn-sm lh-1" data-toggle="collapse" data-target="#filter-pane"
                                aria-expanded="true">
                            <span class="d-none d-sm-inline"><i class="mdi mdi-filter"></i></span> Filter
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                    </span>
                        <span class="col-auto">
                        <button class="btn btn-sm lh-1" data-toggle="collapse" data-target="#sort-pane"
                                aria-expanded="false">
                            <span class="d-none d-sm-inline"><i class="mdi mdi-sort"></i></span> Sort
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                    </span>
                        <span class="col-auto">
                        <button class="btn btn-sm lh-1" data-toggle="collapse" data-target="#search-pane"
                                aria-expanded="true">
                            <span class="d-none d-sm-inline"><i class="mdi mdi-magnify"></i></span> Search
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                    </span>
                    </div>
                </div>
            </div>
            <div class="filter-panes flex-column flex-md-row row row-cols-md-2">
                <div id="filter-pane" class="collapse flex-fill <?= isset($get['filtered']) ? 'show' : '' ?>">
                    <div class="filter-tools py-3">
                        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-block']); ?>
                        <div class="d-none">
                            <input type="hidden" class="hidden" name="filtered" value="1">
                        </div>
                        <div class="gutters-xs row">
                            <div class="align-self-center col-auto">
                                <span class="lh-sm mb-2 small">Filter By:</span>
                            </div>
                            <div class="col-3 col-lg-2 col-md-4">
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
                            <div class="col-3 col-lg-2 col-md-4">
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
                        <?= $this->Form->end(); ?>
                    </div>
                </div>
                <div id="sort-pane"
                     class="collapse align-self-md-end flex-fill <?= isset($get['sorted']) ? 'show' : '' ?>">
                    <div class="sort-tools py-3">
                        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-block']); ?>
                        <div class="d-none">
                            <input type="hidden" class="hidden" name="sorted" value="1">
                        </div>
                        <div class="row gutters-xs">
                            <div class="align-self-center col-auto">
                                <span class="lh-sm mb-2 small">Sort By:</span>
                            </div>
                            <div class="col-3 col-lg-2 col-md-4">
                                <select id="sort-by" name="sort_by"
                                        class="form-select form-select-sm kfjlsihm "
                                        aria-label=".form-select-sm example">
                                    <?php if ($this->fetch('sort_options')): ?>
                                        <?= $this->fetch('sort_options'); ?>
                                    <?php endif; ?>
                                    <option value="alphabetical" <?= isset($get['sort_by'])
                                    && $get['sort_by'] === 'alphabetical' ? 'selected' : '' ?>>A to Z
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
                            <div class="col-3 col-lg-2 col-md-4">

                            </div>
                            <div class="col-auto">
                                <button class="btn btn-sm btn-orange" type="submit">Submit</button>
                            </div>
                        </div>
                        <?= $this->Form->end(); ?>
                    </div>
                </div>
                <div id="search-pane" class="collapse align-self-md-end flex-fill">
                    <div class="search-form py-3">
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
        <div class="section-body p-3 px-lg-0">
            <ul class="media-grid px-0 row unstyled"
                data-column-layout="row-cols-2 row-cols-lg-5 row-cols-md-3">
                <li class="col-lg-3 col-md-4 col-sm-4 col-xl-3 media-list-item px-0 px-sm-3">
                    <div class="card d-flex flex-row flex-sm-column mb-0 mb-sm-3 media-card shadow-none">
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
                <li class="col-lg-3 col-md-4 col-sm-4 col-xl-3 media-list-item px-0 px-sm-3">
                    <div class="card d-flex flex-row flex-sm-column mb-0 mb-sm-3 media-card shadow-none">
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
                <li class="col-lg-3 col-md-4 col-sm-4 col-xl-3 media-list-item px-0 px-sm-3">
                    <div class="card d-flex flex-row flex-sm-column mb-0 mb-sm-3 media-card shadow-none">
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
</div>


