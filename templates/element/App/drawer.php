<?php
use App\Utility\RandomString;

$drawerID = $this->get('drawerID') ?? RandomString::generateString(32, 'mixedalpha');
?>
<drawer
    class="drawer shadow-lg pos-r"
    data-auto-close="false"
    data-role="drawer">
    <div class="ml-auto hls5zrir px-0 z_24fwo fnd05akr et9hrxaz">
        <button class="patuzxjv lzkw2xxp border btn close-drawer qMjccw rmgay8tp"
                data-toggle="drawer"
                aria-controls="#<?= $drawerID ?>">
            <i class="mdi mdi-close mdi-24px"></i>
        </button>
    </div>
    <div class="drawer-body view-port pos-r h-100"></div>
</drawer>
