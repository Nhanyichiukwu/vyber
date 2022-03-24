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
$thisPageTitle = $this->get('page_title', $this->fetch('title'));
?>
<!--<div class="hCp h-100 row has-page-title flex-row gutters-sm">-->
<!--    -->
<!--</div>-->
    <div class="col-auto">
        <div class="n1ft4jmn align-items-center">
            <div class="page-back-btn me-3">
                <?php if ($request->is('ajax') || $request->getQuery('drawer')): ?>
                    <!--<button data-role="close-button"
                            class="bgcH-grey-300 btn btn-icon btn-link btn-sm
                                close-page h_16ro mmhtpn7c n1ft4jmn bzakvszf p-0 rmgay8tp _ah49Gn">
                        <i class="mdi mdi-arrow-left mdi-24px"></i>
                    </button>-->
                <?php else: ?>
                <?php endif; ?>
                <a href="javascript:void(0)"
                   data-role="close-button"
                   class="bgcH-grey-300 btn btn-icon btn-link btn-sm
                           close-page h_16ro mmhtpn7c n1ft4jmn bzakvszf p-0 rmgay8tp _ah49Gn">
                    <i class="mdi mdi-arrow-left mdi-24px"></i>
                </a>
            </div>
            <h4 class="page-title mb-0">
                <span class="_jUif"><?= __($thisPageTitle); ?></span>
            </h4>
        </div>
    </div>
<?php if ($this->fetch('header_widget')): ?>
    <div class="col-auto align-self-center">
        <?= $this->fetch('header_widget'); ?>
    </div>
<?php endif; ?>
