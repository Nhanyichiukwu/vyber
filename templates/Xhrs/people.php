<?php
/**
 * @var App\View\AppView $this
 */

?>
<div class="users index qYakgu mb-0">
    <div class="py-2 px-3 qYakgu-header mhc3nn justify-content-between gutters-0">
        <div class="i4c3nnfq"><h6 class="qYakgu-title">People In Your Region</h6></div>
        <div class="kvgyyd0a">
            <button type="button" role="button"
                    data-toggle="collapse"
                    data-target="#xoyv5ogz-filterToolbar"
                    class="btn btn-sm p-0 text-muted">
                <i class="mdi mdi-chevron-down mdi-18px"></i></button>
        </div>
    </div>
    <div id="xoyv5ogz-filterToolbar" class="filter-toolbar collapse _SHzJez header py-2 toolbar">
        <div class="container-fluid">
            <div class="row gutters-sm">
                <div class="col">
                    <form class="filter-options">
                        <select class="bdrs-15 form-select form-select-sm lh_q8m py-1">
                            <option value="location">Location</option>
                            <option value="industry">Industry</option>
                        </select>
                    </form>
                </div>
                <div class="col-auto">
                    <form id="idnl5pwl" method="get" accept-charset="utf-8" class="m-0 p-0"
                          action="#">
                        <div class="input-icon">
                            <input type="search" class="bg-translucent bdrs-0 form-control form-control-sm
                            drmsy0vx bdrs-20"
                                   placeholder="Search for...">
                        </div>
                    </form>
<!--                    <button type="button" role="button" data-role="button"-->
<!--                            aria-controls="#idnl5pwl"-->
<!--                            class="bdrs-20 border btn btn-sm px-0 wh_30">-->
<!--                        <i class="mdi mdi-magnify"></i>-->
<!--                    </button>-->
                </div>
            </div>
        </div>
    </div>
    <div class="users-list qYakgu-body p-3">
        <?php if (isset($people->inSameCity) && count($people->inSameCity)): ?>
        <?= $this->element( 'Users/flex_row', ['users' => $people->inSameCity]); ?>
        <?php endif; ?>
    </div>
    <div class="qYakgu-footer py-2 px-3 text-center bg-azure-lightest">
        <?= $this->Html->link(__('See More'), [
            'controller' => 'people',
            'action' => 'index',
            'who-to-follow'
        ], [
            "vibely-id" => "v4fU0H5",
            "data-target" => '#pageContent'
        ]); ?>
    </div>
</div>
