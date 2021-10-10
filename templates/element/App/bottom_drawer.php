<?php
use App\Utility\RandomString;

$drawerID = $this->get('drawerID') ?? RandomString::generateString(32, 'mixedalpha');
?>
<drawer
    id="<?= $drawerID ?>"
    class="drawer bottom-drawer border shadow-lg"
    data-auto-close="false"
    data-role="<?= $drawerRole ?? 'action-drawer' ?>">
    <div class="border-bottom d-flex justify-content-between p-4 drawer-header">
        <div class="drawer-title"></div>
        <div class="ml-auto">
            <button class="btn btn-sm close-drawer lh-1 p-0 patuzxjv"
                    data-toggle="drawer"
                    data-target="#<?= $drawerID ?>">
                <i class="mdi mdi-close mdi-24px"></i>
            </button>
        </div>
    </div>
    <div class="drawer-body view-port pos-r h-100"></div>
</drawer>
