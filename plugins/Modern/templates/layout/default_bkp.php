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
<body class="<?= $userDevice ?>-layout default n1ft4jmn ofjtagoh fixed-header"
      data-app-theme="default"
      data-app-user=""
      data-base-uri="<?= $baseUri ?>">

<x-vibely-app-container
    id="app-container"
    class="_viG app-container container-fluid d-block w-100">
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
    <div class=":three-columbs-on-desktop :two-columns-on-tablet flex-column flex-md-row row">
        <nav id="main-navbar" class="col-3 d-none d-lg-block">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Demo Content</h4>
                </div>
            </div>
        </nav>
        <main id="pageContent" role="main" class=":only-when-on-mobile col-lg-9 main">
            <?php if ($this->get('user')): ?>
                <?= $this->element('App/app_header', ['control' => null]) ?>
            <?php endif; ?>
            <div class="row">
                <div class="col-lg-7 col-md-9 h-100 ofy-auto py-4">
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
                </div>
                <div class="col-lg-5 col-md-3 d-md-block d-none px-0 py-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Demo Content</h4>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php if (isset($user)): ?>
        <?= $this->element('App/buttons/creator_button') ?>
        <?= $this->element('App/nav_bottom') ?>
    <?php endif; ?>
    <?= $this->element('App/splashscreen') ?>
</x-vibely-app-container>
<?= $this->element('LayoutElements/foot'); ?>
</body>
</html>
