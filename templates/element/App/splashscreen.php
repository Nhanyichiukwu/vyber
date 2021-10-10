<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="splashscreen">
    <div class="splash">
        <?= $this->Html->image('splashicon.png', ['class' => 'splash-brand']); ?>
        <div class="app-loading py-3">
            <?= $this->element('App/loading') ?>
        </div>
    </div>
</div>
<?php $this->Html->scriptStart(['block' => 'script_bottom']); ?>
<!--<script>-->

<?php $this->Html->scriptEnd(); ?>
