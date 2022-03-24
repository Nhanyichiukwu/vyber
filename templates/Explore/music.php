<?php

/**
 * @var \App\View\AppView $this
 */
$queryParams = (array) $this->getRequest()->getQueryParams();
$this->pageTitle('Music');
$this->enablePageHeader();
?>

<section class="section bg-white mb-2">
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

<section class="section mb-3">
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
<div class="container-fluid px-3">
    <div class="row gutters-lg">
        <div class="col-lg-7">
            <section class="section">
                <h3 class="section-title n1ft4jmn bzakvszf fw-light text-orange">
                    <i class="icofont-star-alt-2 fsz-24 me-2"></i>
                    New Songs
                </h3>
                <div class="section-body pb-3">
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

                    $latestSongsQuery = array_merge($queryParams,[
                        'filter' => 'latest',
                        'token' => $token,
                    ]);
                    $latestSongsQueryStr = http_build_query($latestSongsQuery);
                    $latestSongsDataSrc = 'media/music?' . $latestSongsQueryStr;
                    ?>
                    <div data-load-type="async"
                         class="ajaxify mb-n3"
                         data-category="page_data"
                         data-config='<?= json_encode([
                        'content' => 'new_songs',
                        'src' => $latestSongsDataSrc,
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
        <div class="col-lg-5">
            <section class="section">
                <h3 class="section-title n1ft4jmn bzakvszf fw-light text-azure">
                    <i class="fsz-24 mdi mdi-sort-descending me-2"></i>
                    Top Songs
                </h3>
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

                    $topSongsQuery = array_merge($queryParams, [
                        'filter' => 'top',
                        'token' => $token,
                    ]);
                    $topSongsQueryStr = http_build_query($topSongsQuery);
                    $topSongsDataSrc = 'media/music?' . $topSongsQueryStr;
                    ?>
                    <div data-load-type="async"
                         class="ajaxify mb-n3"
                         data-category="page_data"
                         data-config='<?= json_encode([
                             'content' => 'top_songs',
                             'src' => $topSongsDataSrc,
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
