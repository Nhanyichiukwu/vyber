<?php

/**
 * Page specific header: Includes the back button, the page title and page
 * specific context menu on the right
 *
 * @var \App\View\AppView $this
 */
use Cake\Routing\Router;
//$prevPage = $this->getRequest()->referer() ??
//    $this->getRequest()->getAttribute('base');
//if ($prevPage !== $this->getRequest()->getAttribute('base')) {
//    $prevPage = Router::url($prevPage);
//}
$request = $this->getRequest();
$thisPageTitle = $this->get('page_title') ?? $this->fetch('title');
?>
<header class="page-header bg-white mgriukcz border-bottom">
    <div class="hCp h-100 row has-page-title flex-row gutters-sm">
        <div class="col">
            <div class="n1ft4jmn align-items-center">
                <div class="page-back-btn mr-3">
                    <?php if ($request->is('ajax') || $request->getQuery('drawer')): ?>
                        <button data-toggle="drawer"
                                data-role="close-button"
                                class="bgcH-grey-300 btn btn-icon btn-link btn-sm
                                close-page h_16ro mmhtpn7c n1ft4jmn bzakvszf p-0 rmgay8tp _ah49Gn">
                            <i class="mdi mdi-arrow-left mdi-24px"></i>
                        </button>
                    <?php else: ?>
                        <a href=""
                           data-toggle="drawer"
                           data-role="close-button"
                           class="bgcH-grey-300 btn btn-icon btn-link btn-sm
                           close-page h_16ro mmhtpn7c n1ft4jmn bzakvszf p-0 rmgay8tp _ah49Gn">
                            <i class="mdi mdi-arrow-left mdi-24px"></i>
                        </a>
                    <?php endif; ?>
                </div>
                <h4 class="mb-0 mr-auto">
                    <span class="_jUif"><?= __($thisPageTitle); ?></span>
                </h4>
            </div>
        </div>
        <?php if ($this->fetch('header_widget')): ?>
        <div class="col-auto">
            <?php
            /*$vibelyData = json_encode(
                array(
                    'src' => '/dynamic-contents/menu/context-menu?for=current_page',
                    'output' => '.bottom-drawer',
                    'drawerTitle' => ''
                )
            );*/
            ?>
            <!--<a
                href="javascript:void(0)"
                data-processor="vibely"
                vibely-data='<?/*= $vibelyData */?>'
                class="n1ft4jmn text-center">
                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                    <path fill="currentColor"
                          d="M12,16A2,2 0 0,1 14,18A2,2 0 0,1 12,20A2,2 0 0,1 10,18A2,2 0 0,1 12,16M12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10M12,4A2,2 0 0,1 14,6A2,2 0 0,1 12,8A2,2 0 0,1 10,6A2,2 0 0,1 12,4Z"/>
                </svg>
            </a>-->
            <?= $this->fetch('header_widget'); ?>
        </div>
        <?php endif; ?>
    </div>
</header>
