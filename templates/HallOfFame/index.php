<?php

/**
 * @var \App\View\AppView $this
 */

use Cake\Routing\Router;
?>
<header class="page-header bg-white border-bottom p-3 my-0 mgriukcz">
    <h3 class="page-title mb-0"><?= __('Hall of Fame') ?></h3>
</header>
<section class="section mgriukcz bg-white mb-2 border-bottom">
    <div class="section-body p-3">
        <div class="n1ft4jmn q3ywbqi8 bzakvszf mb-4">
            <h5 class="section-title mb-0">Who's here?</h5>
            <div class="col-auto px-0">
                <button
                    class="bgcH-grey-200 btn btn-sm c-grey-600 close-drawer
                    n1ft4jmn lzkw2xxp patuzxjv qrfe0hvl rmgay8tp"
                    data-role="button"
                    data-toggle="modal"
                    data-target="#basicModal">
                    <i class="mdi mdi-magnify mdi-18px"></i>
                </button>
            </div>
        </div>

        <?php
        $params = [
            "type" => "random",
            "layout" => "flex_row",
            "colSize" => 5
        ];
        $token = base64_encode(
            serialize($params)
        );
        $dataSrc = Router::url('/hall-of-fame/active-members/' . $token, true);
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
            <div class="col-3 col-md-1 col-sm-2 djmlyve7 text-center">
                <a href="#" class="avatar avatar-xl">
                    <span class="avatar-status bg-green"></span>
                </a>
            </div>
            <div class="col-3 col-md-1 col-sm-2 djmlyve7 text-center">
                <a href="#" class="avatar avatar-xl">
                    <span class="avatar-status bg-green"></span>
                </a>
            </div>
            <div class="col-3 col-md-1 col-sm-2 djmlyve7 text-center">
                <a href="#" class="avatar avatar-xl">
                    <span class="avatar-status bg-green"></span>
                </a>
            </div>
            <div class="col-3 col-md-1 col-sm-2 djmlyve7 text-center">
                <a href="#" class="avatar avatar-xl">
                    <span class="avatar-status bg-green"></span>
                </a>
            </div>
            <div class="col-3 col-md-1 col-sm-2 djmlyve7 text-center">
                <a href="#" class="avatar avatar-xl">
                    <span class="avatar-status bg-green"></span>
                </a>
            </div>
            <div class="col-3 col-md-1 col-sm-2 djmlyve7 text-center">
                <a href="#" class="avatar avatar-xl">
                    <span class="avatar-status bg-green"></span>
                </a>
            </div>
        </div>
    </div>
</section>
<section class="section mgriukcz bg-white mb-3 border-bottom">
    <nav class="toolbar bg-white d-flex border-bottom p-0" id="headerMenuCollapse">
        <div class="align-items-center page-nav px-3 toolbar w-100">
            <ul class="border-0 flex-nowrap flex-row foa3ulpk nav nav-tabs
            nav-tabs-sm ofy-h row-cols-auto">
                <li class="nav-item">
                    <a href="<?= Router::url('/hall-of-fame/discussions?data_payload=async') ?>"
                       vibely-id="v4fU0H5"
                       data-target='.dynamic-data'
                       data-loading="true"
                       data-type="fragment"
                       class="nav-link"><i class="mdi mdi-account-multiple"></i> Discussions</a>
                </li>
                <li class="nav-item">
                    <a href="<?= Router::url('/hall-of-fame/activities/?data_payload=async') ?>"
                       vibely-id="v4fU0H5"
                       data-target='.dynamic-data'
                       data-loading="true"
                       data-type="fragment"
                       class="nav-link active"><i class="mdi mdi-calendar"></i> Activities</a>
                </li>
                <li class="nav-item">
                    <a href="<?= Router::url('/hall-of-fame/events?data_payload=async') ?>"
                       vibely-id="v4fU0H5"
                       data-target='.dynamic-data'
                       data-loading="true"
                       data-type="fragment" class="nav-link"><i class="mdi mdi-calendar"></i>
                        Events</a>
                </li>
                <li class="nav-item">
                    <a href="<?= Router::url('/hall-of-fame/groups/?data_payload=async') ?>"
                       vibely-id="v4fU0H5"
                       data-target='.dynamic-data'
                       data-loading="true"
                       data-type="fragment"
                       class="nav-link"><i class="mdi mdi-account-group-outline"></i> Groups</a>
                </li>
                <li class="nav-item">
                    <a href="<?= Router::url('/hall-of-fame/members/?data_payload=async') ?>"
                       vibely-id="v4fU0H5"
                       data-target='.dynamic-data'
                       data-loading="true"
                       data-type="fragment"
                       class="nav-link"><i class="mdi mdi-account-multiple-outline"></i>
                        Members</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="section-body d-block dynamic-data p-2" data-load-type="on_demand">
        <div class="_Hc0qB9"
             data-load-type="ow"
             data-src="<?= Router::url('/hall-of-fame/discussions', true) ?>"
             data-rfc="users"
             data-su="false"
             data-limit="24"
             data-r-ind="false">
        </div>
    </div>
</section>
