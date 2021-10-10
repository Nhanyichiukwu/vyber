<?php
/**
 * @var Cake\TwigView\View\TwigView $twig
 * @var App\View\AppView $this
 */

use App\Utility\RandomString;

$baseUri = $this->getRequest()->getAttribute('base');
$title = $this->fetch('title');
$hasHeader = $this->get('hasHeader') ?? true;
$hasFooter = $this->get('hasFooter') ?? true;
$controlClasses = '';
if ($hasHeader) {
    $controlClasses .= ' has-header';
}
if ($hasFooter) {
    $controlClasses .= ' has-footer';
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <?= $this->element('LayoutElements/head'); ?>
</head>
<body class="mobile-layout<?= $controlClasses ?>"
      data-app-user=""
      data-base-uri="<?= $baseUri ?>">
<x-vibely-app-container
    id="app-container"
    class="_viG app-container clearfix foa3ulpk d-block w-100 h-100 o-hidden">
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
    <!-- Main Content -->
    <main id="pageContent"
          role="main"
          class="foa3ulpk h-100 main n1ft4jmn ofjtagoh ofy-auto otgeu7ew px-3">
        <?php if ($this->get('user') && !$user->isActivated()): ?>
            <?php $this->element('App/activation_prompt'); ?>
        <?php endif; ?>
        <?php if ($this->fetch('page_header')): ?>
            <?= $this->fetch('page_header') ?>
        <?php endif; ?>
        <?= $this->fetch('content') ?>
        <?=
        mb_strtolower(
            RandomString::generateString(8,'mixed', 'alpha')
        );
        ?>
    </main>
    <!-- /Main Content -->
</x-vibely-app-container>
<?= $this->element('App/splashscreen') ?>
<?= $this->element('LayoutElements/foot'); ?>
</body>
</html>
