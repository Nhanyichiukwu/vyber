<?php
/**
 * @var App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

use App\Utility\RandomString;
use Cake\Core\Configure;

$baseUri = $this->getRequest()->getAttribute('base');

/**
 * Configuring page title
 */
$title = $this->fetch('title');
$titleArr = explode('/', $title);
$title = end($titleArr);
$this->start('title');
echo $title;
$this->end();

$hasHeader = $this->get('hasHeader') ?? true;
$hasFooter = $this->get('hasFooter') ?? true;
$controlClasses = '';
if ($hasHeader) {
    $controlClasses .= ' has-header';
}
if ($hasFooter) {
    $controlClasses .= ' has-footer';
}
$mobileControl = null;
$userDevice = $this->get('platform');
$appView = $userDevice . '-view';


$offcanvasState = $this->get('offcanvas_state');

if ($userDevice === 'mobile') {
    $mobileControl = ' clearfix foa3ulpk d-block w-100 h-100 o-hidden';
}

/**
 * Sidebar configuration
 *
 * By default the right sidebar is enabled but hidden on smaller devices.
 * Each page can be configured to disable it entirely if need be, by setting
 * `sidebar` view var to `false` either in the controller or in the template.
 */
$this->set('sidebar', $this->get('sidebar',true));

/**
 * On the other hand, each page can decide at what point the side bar should appear.
 * Where there's none configured, it will default to display a flex box at
 * tablet level using the bootstrap class (d-md-flex)
 */
$sidebarVisibility = $this->get('sidebar_visibility', 'tablet');
switch ($sidebarVisibility) {
    case 'tablet':
        $sidebarDisplayPoint = 'd-md-flex';
        break;
    case 'desktop':
        $sidebarDisplayPoint = 'd-lg-flex';
        break;
    case 'extra_large':
        $sidebarDisplayPoint = 'd-xl-flex';
        break;
    case false:
        $sidebarDisplayPoint = '';
        break;
    default:
        $sidebarDisplayPoint = 'd-md-flex';
}
if (!empty($sidebarDisplayPoint)) {
    $sidebarDisplayPoint = ' ' . $sidebarDisplayPoint;
}
$appAccent = $this->getAppAccent();
$this->set('appAccent', $appAccent);

/******* Default Sidebar Widgets ********/
if ($this->get('user')) {
    $widgets = [
        'unread_notifications',
//    'due_events',
        'people_you_may_know',
        'trends',
        'hall_of_fame'
    ];

    $omissionList = $this->getOmittedWidgets();
    foreach ($omissionList as $omittedWidget) {
        if (in_array($omittedWidget, $widgets)) {
            unset($widgets[array_keys($widgets, $omittedWidget)[0]]);
        }
    }
    $pageWidgets = $this->getPageWidgets();
    foreach ($pageWidgets as $widget) {
        if (!in_array($widget, $widgets)) {
            $widgets[] = $widget;
        }
    }
    $this->addWidget($widgets);
}
?>
<!DOCTYPE html>
<html lang="en-US" data-app-accent="<?= $appAccent ?>" class="<?= $appAccent ?>">
<!--suppress HtmlRequiredTitleElement -->
<head>
    <?= $this->element('LayoutElements/head'); ?>
    <?= $this->Html->css('off-canvas'); ?>
</head>
<body id="cw-app_consumer-interface" class="<?= $offcanvasState  . ' ' . $appView ?> <?= $appAccent ?> app-body
off-canvas
fixed-header
h-auto"
      data-app-accent="<?= $appAccent ?>"
      data-page-layout="off-canvas"
      <?php if (isset($user)): ?>
      data-app-user="@<?= $user->getUsername() ?>"
      <?php endif; ?>
      data-base-uri="<?= $baseUri ?>">
<?php if ($this->get('user')): ?>
<aside id="off-canvas" class="col-aside d-lg-block d-none">
    <div
        class="border-right col-inner fixed-bottom fixed-top ofy-auto u8aoy6la cw-app-light-theme-bg">
        <?= $this->element('Profile/sidebar/dashboard', ['user' => $user]) ?>
    </div>
</aside>
<?php endif; ?>
<div id="app-canvas" class="app-canvas d-block w-100">
    <?= $this->element('App/off_canvas_header', ['control' => null]) ?>
        <div class="pagelet pobaw2t1 q2AIuFY6">
        <?php if ($this->fetch('notice')): ?>
            <x-cw-noticeboard>
                <?= $this->fetch('notice'); ?>
            </x-cw-noticeboard>
        <?php endif; ?>
        <?php if ($this->fetch('overhead_ad')): ?>
            <x-cw-ads>
                <?= $this->fetch('overhead_ad'); ?>
            </x-cw-ads>
        <?php endif; ?>
        <main role="main" class="main container-fluid :only-when-on-mobile">
            <div class="row">
                <div id="pageContent" class="col-main col-md-8 flex-fill pb-5 pb-md-0 px-0 n1ft4jmn ofjtagoh">
                    <?php if (isset($user) && !$user->isActivated()): ?>
                        <?= $this->element('App/activation_prompt'); ?>
                    <?php endif; ?>
                    <div id="page-content-wrapper" class="_oFb7Hd h-100 px-3">
                        <?php if ($this->isPageHeaderEnabled()): ?>
                            <header class="bg-white border-bottom my-0 n1ft4jmn page-header py-2 py-md-3 mx-n3 q3ywbqi8">
                                <?= $this->element('App/page_header'); ?>
                            </header>
                        <?php endif; ?>
                        <?php if (true === $this->get('page_nav_top')): ?>
                            <?= $this->fetch('page_nav_top'); ?>
                        <?php endif; ?>
                        <?php if ($this->getRequest()->getSession()->read('Flash')): ?>
                            <?= $this->Flash->render(); ?>
                        <?php endif; ?>
                        <?= $this->fetch('content') ?>
                        <?= mb_strtolower(
                            RandomString::generateString(8, 'mixed', 'alpha')
                        ); ?>
                    </div>
                </div>
                <?php if ($this->isSidebarEnabled()): ?>
                <div class="border-left col-md-4 d-none flex-md-column
                min-vh-100 ms-auto px-3 py-3 sidebar-right
                zgmqvrj1<?= $sidebarDisplayPoint ?>">
                    <div class="col-inner uxnchls3">
                        <div class="_Y7wf _ycGkU4 affixed _uXY7 foa3ulpk ofy-auto">
                            <?php if ($this->fetch('sidebar')): ?>
                                <?= $this->fetch('sidebar'); ?>
                            <?php endif; ?>
                            <?php $this->loadWidgets(); ?>
                            <?= $this->element('App/widgets/important_links'); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
    <aside class="right-docker _Y7wf _ycGkU4 border-left _kkz9 _uXY7 _wf7p ofy-auto u8aoy6la z_Gtob"></aside>
    <?php if (isset($user)): ?>
        <?= $this->element('App/buttons/creator_button') ?>
        <?= $this->element('App/nav_bottom') ?>
    <?php endif; ?>
    <?= $this->element('App/widgets/common_modal') ?>
    <?= $this->element('App/splashscreen') ?>
</div>
<?= $this->element('LayoutElements/foot'); ?>
</body>
</html>
