<?php /** @noinspection ALL */

/**
 * @var \App\View\AppView $this
 */

use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\Utility\Security;

$get = (array) filter_input_array(INPUT_GET);

$trendingArtists = (int) $this->cell('Counter::count', [
    'users', [
        'trending',
        ['category' => 'artist']
    ]
])->render();

$options = [
    'layout' => 'users_grid',
    'colSize' => 6
];
$this->set('options', $options);
$this->pageTitle('Artists');

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
$roles = json_decode($this->cell('ContentLoader::list', [
    'roles', [
        'byIndustry',
        ['industry' =>'music']
    ]
])->render(), false);
?>

<?php if (!$this->getRequest()->is('ajax')): ?>
    <?php $this->enablePageHeader() ?>
<?php endif; ?>


<?php $this->start('page_style'); ?>
<?= $this->Html->css('atAccordionOrTabs/jquery.atAccordionOrTabs'); ?>
<?php $this->end(); ?>
<?php if ($trendingArtists > 0): ?>
    <section class="mb-2 bg-white">
        <div class="section-body p-3">
            <h4 class="section-title mb-3">Trending</h4>
<!--            <div class="dulmx5k4 flex-nowrap flex-row foa3ulpk mgriukcz n1ft4jmn ofx-auto pl-3 tvdg2pcc">-->
            <div class="flex-nowrap flex-row foa3ulpk gutters-sm mgriukcz ofx-auto pl-3 row">
                <div class="col-auto muilk3da">
                    <div class="oxemcjsk">
                        <span class="avatar avatar-xxl"
                              style="background-image: url(./demo/faces/female/29.jpg)"></span>
                    </div>
                </div>
                <div class="col-auto muilk3da">
                    <div class="oxemcjsk">
                        <span class="avatar avatar-xxl"
                              style="background-image: url(./demo/faces/female/29.jpg)"></span>
                    </div>
                </div>
                <div class="col-auto muilk3da">
                    <div class="oxemcjsk">
                        <span class="avatar avatar-xxl"
                              style="background-image: url(./demo/faces/female/29.jpg)"></span>
                    </div>
                </div>
                <div class="col-auto muilk3da">
                    <div class="oxemcjsk">
                        <span class="avatar avatar-xxl"
                              style="background-image: url(./demo/faces/female/29.jpg)"></span>
                    </div>
                </div>
                <div class="col-auto muilk3da">
                    <div class="oxemcjsk">
                        <span class="avatar avatar-xxl"
                              style="background-image: url(./demo/faces/female/29.jpg)"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-top p-2 section-footer text-center">
            <a href="<?= Router::url('/people/artists?filter=trending') ?>"
               class="_ah49Gn">More</a>
        </div>
    </section>
<?php endif; ?>
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
                            aria-label="form-select-sm example">
                        <option value="top_artists" <?= isset($get['artists_category'])
                        && $get['artists_category'] === 'top_artists' ? 'selected' : ''?>>Top
                            Artists</option>
                        <option value="popular" <?= isset($get['artists_category'])
                        && $get['artists_category'] === 'popular' ? 'selected' : ''?>>
                            Popular</option>
                        <option value="all" <?= isset($get['artists_category'])
                        && $get['artists_category'] === 'all' ? 'selected' : ''?>>
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
                        <label for="genre" class="lh-sm mb-1 small">Music Genre:</label>
                        <select id="genre" name="genre"
                                class="form-select form-select-sm kfjlsihm neh5467l"
                                aria-label="Select Music Genre">
                            <option value="">Genre</option>
                            <?php foreach ($genres as $genre): ?>
                                <option value="<?= $genre->slug ?>" <?= isset($get['genre'])
                                && $get['genre'] === $genre->slug ? 'selected' : ''?>><?= $genre->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-auto">
                        <label for="role" class="lh-sm mb-1 small">User Role:</label>
                        <select id="role" name="role"
                                class="form-select form-select-sm kfjlsihm neh5467l"
                                aria-label="Select User Role">
                            <option value="">Role</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role->slug ?>" <?= isset($get['role'])
                                && $get['role'] === $role->slug ? 'selected' : ''?>><?= $role->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-auto">
                        <label for="category" class="lh-sm mb-1 small">Music Category:</label>
                        <select id="category" name="category"
                                class="form-select form-select-sm kfjlsihm neh5467l"
                                aria-label="Select Music Category">
                            <option value="">Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->slug ?>" <?= isset($get['category'])
                                && $get['category'] === $category->slug ? 'selected' : ''?>><?= $category->name ?></option>
                            <?php endforeach; ?>
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
        'content' => 'artists',
    ]);
    $token = base64_encode(
        serialize($params)
    );
    $filters = http_build_query($get);
    $dataSrc = 'users?_u_p=artist';
    if (!empty($filters)) {
        $dataSrc .= '&' . $filters;
    }
    $dataSrc .= '&_i=' . base64_encode(
            serialize('music')
        );
    $dataSrc .= '&token=' . $token;

    $pymk = json_encode([
        'content' => 'artists',
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
<?php $this->start('page_script'); ?>
<?= $this->Html->script('atAccordionOrTabs/jquery.bbq.min'); ?>
<?= $this->Html->script('atAccordionOrTabs/jquery.atAccordionOrTabs.min'); ?>
<?php $this->end(); ?>
<?php $this->Html->scriptStart(['block' => 'scriptBottom']); ?>
<!--$('.filtering-tools').accordionortabs({-->
<!--    defaultOpened: 0-->
<!--});-->
<?php $this->Html->scriptEnd(); ?>
