<?php
/**
 * Basic Layout Bottom
 *
 * All Layouts except the auth screen, must include this file at the bottom and
 * the corresponding layout top at the top.
 */
?>
<?= $this->Html->script('vendor/bootstrap/bootstrap.bundle.min'); ?>
<?php $this->Html->script('vendor/bootstrap/popper.min'); ?>
<?= $this->Html->script('vendor/jQuery/jquery.form'); ?>
<?= $this->Html->script('utils.js?token='. date('Ymdhis')); ?>
<?= $this->Html->script('app'); ?>
<?= $this->Html->script('misc/tags-input.jquery'); ?>
<?= $this->Html->script('script'); ?>
<?= $this->Html->script('vibely'); ?>
<?= $this->Html->script('commit'); ?>
<?= $this->Html->script('post-composer'); ?>
<?= $this->Html->script('AsyncAccountService'); ?>
<script>
    //            let META_DATA;
    //            META_DATA = $.parseJSON($('metadata').text());

    $(function(){
        // Enables popover, tooltip
        $('[data-toggle="popover"]').popover();
        $('[data-toggle="tooltip"]').tooltip();
    });

    APP.modal.handleBasicModal();
</script>
<?php
if ($this->fetch('page_script')) {
    echo $this->fetch('page_script');
}
?>
<?php if ($this->fetch('scriptBottom')): ?>
<script>
    <?= $this->fetch('scriptBottom'); ?>
</script>
<?php endif; ?>
<?= $this->Html->scriptBlock(sprintf(
    'const CSRF_TOKEN = %s;',
    json_encode($this->getRequest()->getAttribute('csrfToken'))
)); ?>
