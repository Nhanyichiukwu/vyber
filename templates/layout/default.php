<?php
/**
 * @var Cake\TwigView\View\TwigView $twig
 * @var App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

use App\Utility\RandomString;

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
if ($userDevice === 'mobile') {
    $mobileControl = ' clearfix foa3ulpk d-block w-100 h-100 o-hidden';
}
?>
<!DOCTYPE html>
<html lang="en-US" data-app-theme="default" class="default">
<head>
    <?= $this->element('LayoutElements/head'); ?>
</head>
<body class="<?= $userDevice ?>-layout default n1ft4jmn ofjtagoh<?= $controlClasses ?>"
      data-app-theme="default"
      data-app-user=""
      data-base-uri="<?= $baseUri ?>">
<?php if ($this->get('user')): ?>
    <?= $this->element('App/app_header') ?>
<?php endif; ?>
<x-vibely-app-container
    id="app-container"
    class="_viG app-container container-lg">
    <?php if ($this->fetch('notice')): ?>
        <x-vibely-noticeboard>
            <?= $this->fetch('notice'); ?>
        </x-vibely-noticeboard>
    <?php endif; ?>
    <?php if ($this->fetch('overhead_ad')): ?>
        <x-vibely-ads>
            <?= $this->fetch('overhead_ad'); ?>
        </x-vibely-ads>
    <?php endif; ?>
    <div class="row flex-column flex-md-row flex-wrap gutters-sm :two-columns-on-tablet :three-columbs-on-desktop">
        <?php if ($userDevice === 'desktop'): ?>
<!--        Show sidebar-->
        <nav id="main-navbar" class="col-2 d-none d-lg-block">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Demo Content</h4>
                </div>
            </div>
        </nav>
        <?php endif; ?>
        <main id="pageContent"
              role="main"
              class="main col-lg-6 col-md-8 foa3ulpk h-100 ofjtagoh ofy-auto otgeu7ew py-4<?= $userDevice === 'mobile' ?
                  ' px-0' : '' ?>">

            <div class="<?= $mobileControl ?>">
                <?php if (true === $this->get('pageHeader')): ?>
                    <?= $this->element('App/page_header'); ?>
                <?php endif; ?>
                <?php if (isset($user) && !$user->isActivated()): ?>
                    <?php $this->element('App/activation_prompt'); ?>
                <?php endif; ?>

                <?= $this->Flash->render(); ?>
                <?= $this->fetch('content') ?>
                <?=
                mb_strtolower(
                    RandomString::generateString(8, 'mixed', 'alpha')
                );
                ?>
            </div>
        </main>
        <?php if ($userDevice !== 'mobile'): ?>
        <div class="col-lg-4 col-md-4 d-md-block d-none py-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Demo Content</h4>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?php if (isset($user)): ?>
        <?= $this->element('App/buttons/creator_button') ?>
        <?php if ($userDevice === 'mobile'): ?>
            <?= $this->element('App/nav_bottom') ?>
        <?php endif; ?>
    <?php endif; ?>
    <?= $this->element('App/splashscreen') ?>
</x-vibely-app-container>
<?= $this->element('LayoutElements/foot'); ?>
</body>
</html>
