<?php

/**
 * @var \App\View\AppView $this;
 */

use App\Utility\RandomString;
use Cake\Routing\Router;

?>
<div class="app-bottom-nav fixed-bottom d-md-none">
    <div class="d-flex flex-nowrap flex-row justify-content-between row-cols-5">
        <div>
            <a href="<?= Router::url('/feeds?ref=app_main_nav_home_tab',
                true)
            ?>"
               vibely-id="v4fU0H5"
               data-target='#pageContent'
               class="active item">
                <div class="_af4H">
                    <!--            <svg style="width:24px;height:24px" viewBox="0 0 24 24">-->
                    <!--                <path fill="currentColor" d="M12,3L2,12H5V20H19V12H22L12,3M12,8.75A2.25,2.25 0 0,1 14.25,11A2.25,2.25 0 0,1 12,13.25A2.25,2.25 0 0,1 9.75,11A2.25,2.25 0 0,1 12,8.75M12,15C13.5,15 16.5,15.75 16.5,17.25V18H7.5V17.25C7.5,15.75 10.5,15 12,15Z"></path>-->
                    <!--            </svg>-->
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M10,20V14H14V20H19V12H22L12,3L2,12H5V20H10Z"/>
                    </svg>
                    <span class="nav-item-label d-md-none d-lg-inline">Home</span>
                </div>
            </a>
        </div>
        <div>
            <a href="<?= Router::url('/discover?ref=app_main_nav_discover_tab',
                true)
            ?>"
               vibely-id="v4fU0H5"
               data-target='#pageContent'
               class="item">
                <div class="_af4H">
                    <!--            <svg style="width:24px;height:24px" viewBox="0 0 24 24">-->
                    <!--                <path fill="currentColor" d="M15,13H16.5V15.82L18.94,17.23L18.19,18.53L15,16.69V13M19,8H5V19H9.67C9.24,18.09 9,17.07 9,16A7,7 0 0,1 16,9C17.07,9 18.09,9.24 19,9.67V8M5,21C3.89,21 3,20.1 3,19V5C3,3.89 3.89,3 5,3H6V1H8V3H16V1H18V3H19A2,2 0 0,1 21,5V11.1C22.24,12.36 23,14.09 23,16A7,7 0 0,1 16,23C14.09,23 12.36,22.24 11.1,21H5M16,11.15A4.85,4.85 0 0,0 11.15,16C11.15,18.68 13.32,20.85 16,20.85A4.85,4.85 0 0,0 20.85,16C20.85,13.32 18.68,11.15 16,11.15Z"></path>-->
                    <!--            </svg>-->
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                              d="M11.19,2.25C10.93,2.25 10.67,2.31 10.42,2.4L3.06,5.45C2.04,5.87 1.55,7.04 1.97,8.05L6.93,20C7.24,20.77 7.97,21.23 8.74,21.25C9,21.25 9.27,21.22 9.53,21.1L16.9,18.05C17.65,17.74 18.11,17 18.13,16.25C18.14,16 18.09,15.71 18,15.45L13,3.5C12.71,2.73 11.97,2.26 11.19,2.25M14.67,2.25L18.12,10.6V4.25A2,2 0 0,0 16.12,2.25M20.13,3.79V12.82L22.56,6.96C22.97,5.94 22.5,4.78 21.47,4.36M11.19,4.22L16.17,16.24L8.78,19.3L3.8,7.29"/>
                    </svg>
                    <span class="nav-item-label d-md-none d-lg-inline">Discover</span>
                </div>
            </a>
        </div>
        <div class="_oFb7Hd">
            <div id="tap-to-post">
                <a href="javascript:void()"
                   data-bs-toggle="modal"
                   data-bs-target="#creatorTools"
                   class="btn btn-app btn-icon bzakvszf lzkw2xxp qrfe0hvl wh_opzWcA">
                    <span class="mdi mdi-shape-square-plus mdi-24px"></span>
                    <span class="btn-label sr-only">Share</span>
                </a>
            </div>
        </div>
        <div>
            <a href="<?= Router::url('/my-network?data_target=app_view', true) ?>"
               vibely-id="v4fU0H5"
               data-target='#pageContent'
               class="item">
                <div class="_af4H">
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                              d="M12,5.5A3.5,3.5 0 0,1 15.5,9A3.5,3.5 0 0,1 12,12.5A3.5,3.5 0 0,1 8.5,9A3.5,3.5 0 0,1 12,5.5M5,8C5.56,8 6.08,8.15 6.53,8.42C6.38,9.85 6.8,11.27 7.66,12.38C7.16,13.34 6.16,14 5,14A3,3 0 0,1 2,11A3,3 0 0,1 5,8M19,8A3,3 0 0,1 22,11A3,3 0 0,1 19,14C17.84,14 16.84,13.34 16.34,12.38C17.2,11.27 17.62,9.85 17.47,8.42C17.92,8.15 18.44,8 19,8M5.5,18.25C5.5,16.18 8.41,14.5 12,14.5C15.59,14.5 18.5,16.18 18.5,18.25V20H5.5V18.25M0,20V18.5C0,17.11 1.89,15.94 4.45,15.6C3.86,16.28 3.5,17.22 3.5,18.25V20H0M24,20H20.5V18.25C20.5,17.22 20.14,16.28 19.55,15.6C22.11,15.94 24,17.11 24,18.5V20Z"></path>
                    </svg>
                    <span class="nav-item-label d-md-none d-lg-inline">My Network</span>
                </div>
            </a>
        </div>
        <div>
            <a href="<?= Router::url('/hall-of-fame?data_target=app_view', true) ?>"
               vibely-id="v4fU0H5"
               data-target='#pageContent'
               class="item">
                <div class="_af4H">
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                              d="M10,2V4.26L12,5.59V4H22V19H17V21H24V2H10M7.5,5L0,10V21H15V10L7.5,5M14,6V6.93L15.61,8H16V6H14M18,6V8H20V6H18M7.5,7.5L13,11V19H10V13H5V19H2V11L7.5,7.5M18,10V12H20V10H18M18,14V16H20V14H18Z"/>
                    </svg>
                    <span class="nav-item-label d-md-none d-lg-inline">Hall of Fame</span>
                </div>
            </a>
        </div>
    </div>
</div>
<?php /**
<a href="<?= Router::url('/feeds?ref=app_main_nav_home_tab',
    true)
?>"
   vibely-id="v4fU0H5"
   data-target='#pageContent'
   class="active item">
    <div class="_af4H">
        <!--            <svg style="width:24px;height:24px" viewBox="0 0 24 24">-->
        <!--                <path fill="currentColor" d="M12,3L2,12H5V20H19V12H22L12,3M12,8.75A2.25,2.25 0 0,1 14.25,11A2.25,2.25 0 0,1 12,13.25A2.25,2.25 0 0,1 9.75,11A2.25,2.25 0 0,1 12,8.75M12,15C13.5,15 16.5,15.75 16.5,17.25V18H7.5V17.25C7.5,15.75 10.5,15 12,15Z"></path>-->
        <!--            </svg>-->
        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
            <path fill="currentColor" d="M10,20V14H14V20H19V12H22L12,3L2,12H5V20H10Z" />
        </svg>
        <span class="nav-item-label">Home</span>
    </div>
</a>

<a href="<?= Router::url('/discover?ref=app_main_nav_discover_tab',
    true)
?>"
   vibely-id="v4fU0H5"
   data-target='#pageContent'
   class="item">
    <div class="_af4H">
        <!--            <svg style="width:24px;height:24px" viewBox="0 0 24 24">-->
        <!--                <path fill="currentColor" d="M15,13H16.5V15.82L18.94,17.23L18.19,18.53L15,16.69V13M19,8H5V19H9.67C9.24,18.09 9,17.07 9,16A7,7 0 0,1 16,9C17.07,9 18.09,9.24 19,9.67V8M5,21C3.89,21 3,20.1 3,19V5C3,3.89 3.89,3 5,3H6V1H8V3H16V1H18V3H19A2,2 0 0,1 21,5V11.1C22.24,12.36 23,14.09 23,16A7,7 0 0,1 16,23C14.09,23 12.36,22.24 11.1,21H5M16,11.15A4.85,4.85 0 0,0 11.15,16C11.15,18.68 13.32,20.85 16,20.85A4.85,4.85 0 0,0 20.85,16C20.85,13.32 18.68,11.15 16,11.15Z"></path>-->
        <!--            </svg>-->
        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
            <path fill="currentColor" d="M11.19,2.25C10.93,2.25 10.67,2.31 10.42,2.4L3.06,5.45C2.04,5.87 1.55,7.04 1.97,8.05L6.93,20C7.24,20.77 7.97,21.23 8.74,21.25C9,21.25 9.27,21.22 9.53,21.1L16.9,18.05C17.65,17.74 18.11,17 18.13,16.25C18.14,16 18.09,15.71 18,15.45L13,3.5C12.71,2.73 11.97,2.26 11.19,2.25M14.67,2.25L18.12,10.6V4.25A2,2 0 0,0 16.12,2.25M20.13,3.79V12.82L22.56,6.96C22.97,5.94 22.5,4.78 21.47,4.36M11.19,4.22L16.17,16.24L8.78,19.3L3.8,7.29" />
        </svg>
        <span class="nav-item-label">Explore</span>
    </div>
</a>
<a href="<?= Router::url('/talent-hub?data_target=app_view', true) ?>"
   vibely-id="v4fU0H5"
   data-target='#pageContent'
   class="item">
    <div class="_af4H">
        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
            <path fill="currentColor" d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9Z" />
        </svg>
        <span class="nav-item-label">Talent Hub</span>
    </div>
</a>
<a href="<?= Router::url('/my-network?data_target=app_view', true) ?>"
   vibely-id="v4fU0H5"
   data-target='#pageContent'
   class="item">
    <div class="_af4H">
        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
            <path fill="currentColor" d="M12,5.5A3.5,3.5 0 0,1 15.5,9A3.5,3.5 0 0,1 12,12.5A3.5,3.5 0 0,1 8.5,9A3.5,3.5 0 0,1 12,5.5M5,8C5.56,8 6.08,8.15 6.53,8.42C6.38,9.85 6.8,11.27 7.66,12.38C7.16,13.34 6.16,14 5,14A3,3 0 0,1 2,11A3,3 0 0,1 5,8M19,8A3,3 0 0,1 22,11A3,3 0 0,1 19,14C17.84,14 16.84,13.34 16.34,12.38C17.2,11.27 17.62,9.85 17.47,8.42C17.92,8.15 18.44,8 19,8M5.5,18.25C5.5,16.18 8.41,14.5 12,14.5C15.59,14.5 18.5,16.18 18.5,18.25V20H5.5V18.25M0,20V18.5C0,17.11 1.89,15.94 4.45,15.6C3.86,16.28 3.5,17.22 3.5,18.25V20H0M24,20H20.5V18.25C20.5,17.22 20.14,16.28 19.55,15.6C22.11,15.94 24,17.11 24,18.5V20Z"></path>
        </svg>
        <span class="nav-item-label">My Network</span>
    </div>
</a>
<a href="<?= Router::url('/hall-of-fame?data_target=app_view', true) ?>"
   vibely-id="v4fU0H5"
   data-target='#pageContent'
   class="item">
    <div class="_af4H">
        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
            <path fill="currentColor" d="M10,2V4.26L12,5.59V4H22V19H17V21H24V2H10M7.5,5L0,10V21H15V10L7.5,5M14,6V6.93L15.61,8H16V6H14M18,6V8H20V6H18M7.5,7.5L13,11V19H10V13H5V19H2V11L7.5,7.5M18,10V12H20V10H18M18,14V16H20V14H18Z" />
        </svg>
        <span class="nav-item-label">Hall of Fame</span>
    </div>
</a>
 **/ ?>
