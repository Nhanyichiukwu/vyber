<?php
/**
 * Basic Layout Top
 *
 * All Layouts except the auth screen, must include this file at the top and
 * the corresponding layout bottom at the bottom.
 * @var \App\View\AppView $this;
 */

use Cake\Core\Configure;
//use Cake\Routing\Router;
//use Cake\Utility\Text;
//use Cake\Utility\Inflector;
//use App\Utility\RandomString;

$appAccent = $this->getAppAccent();
?>
<?= $this->Html->charset('utf-8'); ?>
<?= $this->Html->meta('viewport', 'width=device-width, height=device-height, initial-scale=1 minimum-scale=1, maximum-scale=1, viewport-fit=cover, shrink-to-fit=yes'); ?>
<?= $this->Html->meta('apple-mobile-web-app-capable', 'yes'); ?>
<?= $this->Html->meta('apple-mobile-web-app-status-bar-style', '#fc7800'); ?>
<?= $this->Html->meta('theme-color', '#fc7800'); ?>
<title><?= $this->fetch('title'); ?> - <?= Configure::read('Site.name'); ?></title>
<?= $this->Html->meta('csrfToken', $this->getRequest()->getAttribute('csrfToken')); ?>
<?= $this->Html->meta('description', $this->fetch('meta_description',  Configure::read('Meta.description'))); ?>
<?= $this->Html->meta('keywords', $this->fetch('meta_keywords',  Configure::read('Meta.keywords'))); ?>
<link rel="icon" type="image/png"
      href="<?= $this->Url->assetUrl('media/static-img/favicon?type=icon&format=png&size=192x192')
      ?>" sizes="32x32">
<link rel="apple-touch-icon" sizes="180x180"
      href="<?= $this->Url->assetUrl('media/static-img/favicon?type=icon&format=png&size=192x192')
?>">
<?= $this->fetch('meta'); ?>

<!-- Bootstrap CSS -->
<?php // $this->Html->css('vendor/bootstrap/bootstrap-grid.min'); ?>
<?php // $this->Html->css('vendor/bootstrap/bootstrap-reboot.min'); ?>
<?= $this->Html->css('vendor/bootstrap/bootstrap.min'); ?>
<?= $this->Html->css('bootstrap-override'); ?>
<?= $this->Html->css('accents/' . $appAccent . '.accent'); ?>
<?= $this->Html->css('app'); ?>

<?= $this->fetch('css'); ?>
<?php
    if ($this->fetch('page_style')) {
        echo $this->fetch('page_style');
    }
?>

<?= $this->Html->script('vendor/jQuery/jquery.min'); ?>
<?= $this->Html->script('vendor/jQuery/jquery.cookie'); ?>
<?= $this->fetch('scriptTop'); ?>
<script>
    function resizeFrame(obj, forceFullHeight = false) {
        if (forceFullHeight) {
            obj.setAttribute('scrolling', 'no');
            obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
        } else {
            obj.style.height = '80hv';
        }
    }
</script>
