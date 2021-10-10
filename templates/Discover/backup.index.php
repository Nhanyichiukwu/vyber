<nav class="toolbar"
     id="headerMenuCollapse">
    <div class="nav-grid-wrap px-3">
        <div class="flex-nowrap flex-row foa3ulpk mgriukcz n1ft4jmn ofx-auto pl-3 tvdg2pcc">
            <ul class="nav nav-grid row-cols-4 row-cols-sm-6">
                <li class="nav-grid-item">
                    <a href="<?= Router::url([
                        'action' => 'artists',
                        '?' => [
                            'rfc' => 'discover_whats_hot',
                            'data' => 'artists',
                            'cat' => 'all'
                        ]
                    ]) ?>"
                       vibely-id="v4fU0H5"
                       data-target='#pageContent'
                       class="nav-link">
                        <i class="lh-1 mdi mdi-24px mdi-account-multiple"></i> Artists</a>
                </li>
                <li class="nav-grid-item">
                    <a href="<?= Router::url([
                        'action' => 'actors',
                        '?' => [
                            'rfc' => 'discover_whats_hot',
                            'data' => 'artists',
                            'cat' => 'all'
                        ]
                    ]) ?>"
                       vibely-id="v4fU0H5"
                       data-target='#pageContent'
                       class="nav-link">
                        <i class="lh-1 mdi mdi-24px mdi-account-multiple"></i> Actors</a>
                </li>
                <li class="nav-grid-item">
                    <a href="<?= Router::url([
                        'action' => 'producers',
                        '?' => [
                            'rfc' => 'discover_whats_hot',
                            'data' => 'artists',
                            'cat' => 'all'
                        ]
                    ]) ?>"
                       vibely-id="v4fU0H5"
                       data-target='#pageContent'
                       class="nav-link">
                        <i class="lh-1 mdi mdi-24px mdi-account-multiple"></i> Producers</a>
                </li>
                <li class="nav-grid-item">
                    <a href="<?= Router::url(['action' => 'people',
                        'rfc' => 'discover_whats_hot', 'data' => 'people',
                        'cat' => 'all']) ?>"
                       vibely-id="v4fU0H5"
                       data-target='#pageContent'
                       class="nav-link">
                        <i class="lh-1 mdi mdi-24px mdi-account-multiple"></i> People</a>
                </li>
                <li class="nav-grid-item">
                    <a href="<?= Router::url(['action' => 'hashtags',
                        'rfc' => 'discover_whats_hot', 'data' => 'hashtags']) ?>"
                       vibely-id="v4fU0H5"
                       data-target='#pageContent'
                       class="nav-link">
                        <i class="lh-1 mdi mdi-24px mdi-pound"></i> Hashtags</a>
                </li>
                <li class="nav-grid-item">
                    <a href="<?= Router::url(['action' => 'posts',
                        'rfc' => 'discover_whats_hot', 'data' => 'posts',
                        'cat' => 'all']) ?>"
                       vibely-id="v4fU0H5"
                       data-target='#pageContent'
                       class="nav-link">
                        <i class="lh-1 mdi mdi-24px mdi-text-subject"></i> Posts</a>
                </li>
                <li class="nav-grid-item">
                    <a href="<?= Router::url(['action' => 'music',
                        'rfc' => 'discover_whats_hot', 'data' => 'music',
                        'cat' => 'all']) ?>"
                       vibely-id="v4fU0H5"
                       data-target='#pageContent'
                       class="nav-link">
                        <i class="lh-1 mdi mdi-24px mdi-music"></i>
                        Music</a>
                </li>
                <li class="nav-grid-item">
                    <a href="<?= Router::url(['action' => 'movies',
                        'rfc' => 'discover_whats_hot', 'data' => 'movies',
                        'cat' => 'all']) ?>"
                       vibely-id="v4fU0H5"
                       data-target='#pageContent'
                       class="nav-link">
                        <i class="lh-1 mdi mdi-24px mdi-movie-open"></i> Movies</a>
                </li>
                <li class="nav-grid-item">
                    <a href="<?= Router::url(['action' => 'comedies',
                        'rfc' => 'discover_whats_hot', 'data' => 'comedies',
                        'cat' => 'all']) ?>"
                       vibely-id="v4fU0H5"
                       data-target='#pageContent'
                       class="nav-link">
                        <i class="lh-1 mdi mdi-24px mdi-account-voice"></i> Comedies</a>
                </li>
                <li class="nav-grid-item">
                    <a href="<?= Router::url(['controller' => 'shows', 'action' => 'tv-shows',
                        'rfc' => 'discover_whats_hot', 'data' => 'tv-shows',
                        'cat' => 'all']) ?>"
                       vibely-id="v4fU0H5"
                       data-target='#pageContent'
                       class="nav-link">
                        <i class="lh-1 mdi mdi-24px mdi-television-clean"></i> TV Shows</a>
                </li>
                <li class="nav-grid-item">
                    <a href="<?= Router::url(['action' => 'events',
                        'rfc' => 'discover_whats_hot', 'data' => 'events',
                        'cat' => 'all']) ?>"
                       vibely-id="v4fU0H5"
                       data-target='#pageContent'
                       class="nav-link">
                        <i class="lh-1 mdi mdi-24px mdi-calendar"></i>
                        Events</a>
                </li>
                <li class="nav-grid-item">
                    <a href="<?= Router::url(['action' => 'places',
                        'rfc' => 'discover_whats_hot', 'data' => 'places',
                        'cat' => 'all']) ?>"
                       vibely-id="v4fU0H5"
                       data-target='#pageContent'
                       class="nav-link">
                        <i class="lh-1 mdi mdi-24px mdi-map-marker"></i>
                        Places</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!--<nav class="toolbar bg-white d-flex border-bottom p-0"
         id="headerMenuCollapse">
        <div class="align-items-center page-nav px-3 toolbar w-100">
            <ul class="border-0 flex-nowrap flex-row foa3ulpk nav nav-tabs
            nav-tabs-sm ofy-h row-cols-auto">
                <li class="nav-item">
                    <a href="<?/*= Router::url('/people?rfc=discover&data=people&cat=all') */?>"
                       vibely-id="v4fU0H5"
                       data-target='.dynamic-data'
                       data-loading="true"
                       data-type="fragment"
                       class="nav-link"><i class="mdi mdi-account-multiple"></i> People</a>
                </li>
                <li class="nav-item">
                    <a href="<?/*= Router::url('/hashtags/?rfc=discover') */?>"
                       vibely-id="v4fU0H5"
                       data-target='.dynamic-data'
                       data-loading="true"
                       data-type="fragment"
                       class="nav-link active"><i class="mdi mdi-pound"></i> Hashtags</a>
                </li>
                <li class="nav-item">
                    <a href="<?/*= Router::url('/posts/?tab') */?>"
                       vibely-id="v4fU0H5"
                       data-target='.dynamic-data'
                       data-loading="true"
                       data-type="fragment"
                       class="nav-link"><i class="mdi mdi-text-subject"></i> Posts</a>
                </li>
                <li class="nav-item">
                    <a href="<?/*= Router::url('/explore/people?tab') */?>"
                       vibely-id="v4fU0H5"
                       data-target='.dynamic-data'
                       data-loading="true"
                       data-type="fragment"
                       class="nav-link"><i class="mdi mdi-music"></i>
                        Music</a>
                </li>
                <li class="nav-item">
                    <a href="<?/*= Router::url('/videos/movies') */?>"
                       vibely-id="v4fU0H5"
                       data-target='.dynamic-data'
                       data-loading="true"
                       data-type="fragment"
                       class="nav-link"><i class="mdi mdi-movie-open"></i> Movies</a>
                </li>
                <li class="nav-item">
                    <a href="<?/*= Router::url('/videos/comedies?tab') */?>"
                       vibely-id="v4fU0H5"
                       data-target='.dynamic-data'
                       data-loading="true"
                       data-type="fragment"
                       class="nav-link"><i class="mdi mdi-account-voice"></i> Comedies</a>
                </li>
                <li class="nav-item">
                    <a href="<?/*= Router::url('/shows/tv-shows?tab') */?>"
                       vibely-id="v4fU0H5"
                       data-target='.dynamic-data'
                       data-loading="true"
                       data-type="fragment"
                       class="nav-link"><i class="mdi mdi-television-clean"></i> TV Shows</a>
                </li>
                <li class="nav-item">
                    <a href="<?/*= Router::url('/events?tab') */?>"
                       vibely-id="v4fU0H5"
                       data-target='.dynamic-data'
                       data-loading="true"
                       data-type="fragment" class="nav-link"><i class="mdi mdi-calendar"></i>
                        Events</a>
                </li>
                <li class="nav-item">
                    <a href="<?/*= Router::url('/places') */?>"
                       vibely-id="v4fU0H5"
                       data-target='.dynamic-data'
                       data-loading="true"
                       data-type="fragment" class="nav-link"><i class="mdi mdi-map-marker"></i>
                        Places</a>
                </li>
            </ul>
        </div>
    </nav>-->
<!--<div class="section-body d-block dynamic-data p-2" data-load-type="on_demand">
    <div class="_Hc0qB9"
         data-load-type="r"
         data-src="/people"
         data-rfc="users"
         data-su="false"
         data-limit="24"
         data-r-ind="false">
    </div>
</div>-->
