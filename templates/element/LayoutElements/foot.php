<?php
/**
 * Basic Layout Bottom
 *
 * All Layouts except the auth screen, must include this file at the bottom and
 * the corresponding layout top at the top.
 */
?>
<?= $this->Html->script('vendor/bootstrap/bootstrap.bundle.min'); ?>
<?= $this->Html->script('vendor/jQuery/jquery.form'); ?>
<?= $this->Html->script('utils.js?token='. date('Ymdhis')); ?>
<script>
//            let META_DATA;
//            META_DATA = $.parseJSON($('metadata').text());

   $(function(){
        // Enables popover, tooltip
       $('[data-toggle="popover"]').popover();
       $('[data-toggle="tooltip"]').tooltip();

       // enableDisplayToggle();
   });
</script>
<?= $this->Html->script('app'); ?>
<?= $this->Html->script('script'); ?>
<?= $this->Html->script('vibely'); ?>
<?= $this->Html->script('commit'); ?>
<?= $this->Html->script('AsyncAccountService'); ?>
<?php
if ($this->fetch('page_script')) {
    echo $this->fetch('page_script');
}
?>
<?= $this->fetch('scriptBottom'); ?>
