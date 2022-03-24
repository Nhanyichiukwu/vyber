<?php
/**
 * @var Cake\TwigView\View\TwigView $twig
 * @var App\View\AppView $this
 */

use App\Utility\RandomString;

$baseUri = $this->getRequest()->getAttribute('base');
$title = $this->fetch('title');
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <?= $this->element('LayoutElements/head'); ?>
</head>
<body data-base-uri="<?= $baseUri ?>">
<div id="app-container"
    class="_viG app-container clearfix foa3ulpk d-block w-100 h-100 o-hidden">
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
    <!-- Main Content -->
    <main id="pageContent"
          role="main"
          class="foa3ulpk h-100 main n1ft4jmn ofjtagoh ofy-auto otgeu7ew">
        <?php if ($this->get('user') && !$user->isActivated()): ?>
            <?php $this->element('App/activation_prompt'); ?>
        <?php endif; ?>
        <?php if ($this->fetch('page_header')): ?>
            <?= $this->fetch('page_header') ?>
        <?php endif; ?>
        <?= $this->fetch('content') ?>
    </main>
    <!-- /Main Content -->
</div>
<?= $this->element('App/splashscreen') ?>
<?= $this->element('LayoutElements/foot'); ?>
</body>
</html>
