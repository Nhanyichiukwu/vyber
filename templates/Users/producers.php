<?php
/**
 * @var \App\View\AppView $this
 */

$this->enablePageHeader();
$this->pageTitle('Producers');

$get = $this->getRequest()->getQueryParams();
?>

<section class="mb-2 bg-white">
    <div class="filter-toolbar">
        <div class="container-fluid py-2">
            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-block']); ?>
            <div class="d-none">
                <input type="hidden" class="hidden" name="filtered" value="1">
            </div>
            <div class="form-row q3ywbqi8">
                <div class="col-auto">
                    <select id="artists-category" name="artists_category"
                            class="form-select form-select-sm border-0 ttffipg2"
                            aria-label=".form-select-sm example">
                        <option value="top_artists" <?= isset($get['producers_category'])
                        && $get['producers_category'] === 'top_producers' ? 'selected' : ''?>>Top
                            producers</option>
                        <option value="popular" <?= isset($get['producers_category'])
                        && $get['producers_category'] === 'popular' ? 'selected' : ''?>>
                            Popular</option>
                        <option value="all" <?= isset($get['producers_category'])
                        && $get['producers_category'] === 'all' ? 'selected' : ''?>>
                            All</option>
                    </select>
                </div>
                <div class="col-auto">
                    <div class="btns">
                        <button class="btn btn-sm no-focus" type="button"
                                data-bs-toggle="collapse"
                                aria-expanded="false"
                                data-bs-target="#filter-pane">Filter <i class="mdi mdi-chevron-down"></i></button>
                        <button class="btn btn-sm no-focus" type="button"
                                data-bs-toggle="collapse"
                                aria-expanded="false"
                                data-bs-target="#sort-pane">Sort <i class="mdi mdi-chevron-down"></i></button>
                    </div>
                </div>
            </div>
            <div id="filter-pane" class="collapse <?= isset($get['filtered']) ? 'show' : '' ?> border-top mt-2">
                <div class="row gutters-sm">
                    <div class="col-auto">
                        <label for="industry" class="lh-sm mb-1 small">Industry:</label>
                        <select id="industry" name="industry"
                                class="form-select form-select-sm kfjlsihm neh5467l"
                                aria-label="Select Industry">
                            <option value="">Industry</option>
                        </select>
                    </div>
                    <div class="align-self-end col-auto">
                        <button class="btn btn-sm btn-orange" type="submit">Submit</button>
                    </div>
                </div>
            </div>
            <div id="sort-pane" class="collapse border-top mt-2">....</div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
    <?php
    $params = json_encode([
        'resource_handle' => 'users',
        'resource_path' => '/Users/users_circles',
        'content' => 'producer',
    ]);
    $token = base64_encode(
        serialize($params)
    );
    $filters = http_build_query($get);
    $dataSrc = 'users?_u_p=producer';
    if (!empty($filters)) {
        $dataSrc .= '&' . $filters;
    }
    $dataSrc .= '&_i=' . base64_encode(
            serialize('any')
        );
    $dataSrc .= '&token=' . $token;

    $pymk = json_encode([
        'content' => 'producers',
        'src' => $dataSrc,
        'remove_if_no_content' => 'no',
        'check_for_update' => 'yes',
        'auto_update' => 'yes',
        'use_data_prospect' => 'yes',
        'load_type' => 'overwrite',
    ]);
    ?>
    <div data-load-type="async"
         class="ajaxify mb-n3"
         data-category="widget" data-config='<?= $pymk ?>'>
        <?= $this->element('App/loading', ['modifier' => 'py-3']); ?>
    </div>
</section>
