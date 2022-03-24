<?php if ((int) $this->cell('Counter::count', ['trends', [$appUser]])->render() < 1): ?>
    <div class="_4gUj0 _UxaA _gGsso _jr card section vllbqapx" data-role="widget"
         data-config='<?= json_encode([
             'content' => 'trends',
             'limit' => 4
         ]) ?>'
         data-auto-update="true">
        <div class="card-body">
            <h6 class="card-title">Trends</h6>
            <?= $this->element('App/loading'); ?>
        </div>
    </div>
<?php endif; ?>
