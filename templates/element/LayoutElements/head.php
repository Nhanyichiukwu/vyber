<?php
/**
 * Basic Layout Top
 *
 * All Layouts except the auth screen, must include this file at the top and
 * the corresponding layout bottom at the bottom.
 */

use Cake\Core\Configure;
//use Cake\Routing\Router;
//use Cake\Utility\Text;
//use Cake\Utility\Inflector;
//use App\Utility\RandomString;
?>
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1,shrink-to-fit=yes">
<title><?= $this->fetch('title'); ?> - <?= Configure::read('Site.name'); ?></title>
<?= $this->fetch('meta'); ?>

<!-- Bootstrap CSS -->
<?= $this->Html->css('vendor/bootstrap/bootstrap-grid.min'); ?>
<?= $this->Html->css('vendor/bootstrap/bootstrap-reboot.min'); ?>
<?= $this->Html->css('vendor/bootstrap/bootstrap.min'); ?>
<?= $this->Html->css('bootstrap-override'); ?>
<?= $this->Html->css('themes/default.theme'); ?>
<?= $this->Html->css('themes/custom.theme'); ?>
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
