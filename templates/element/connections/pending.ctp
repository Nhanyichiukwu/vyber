<?php // foreach ($connections as $connection): ?>
<div class="col-sm-12 col-md-4 col-lg-3">
    <div class="card card-profile">
        <div class="card-header" style="background-image: url(file:///C:/Downloads/tabler-master/tabler-master/dist/demo/photos/eberhard-grossgasteiger-311213-500.jpg);"></div>
        <div class="card-body text-center">
            <img class="card-profile-img" src="file:///C:/Downloads/tabler-master/tabler-master/dist/demo/faces/male/16.jpg">
            <h4 class="mb-3"><?= h($connection->firstname) ?></h4>
            <p class="mb-4">Big belly rude boy, million dollar hustler. Unemployed.</p>
            <?= $this->Form->postLink(
                __('<span class="fa fa-twitter"></span> Remove Connection'),
                [
                    'controller' => 'commit',
                    'action' => 'index',
                    '?' => [
                        'intent' => 'disconnect',
                        'u' => h($connection->refid)
                    ]
                ],
                [
                    'class' => 'btn btn-outline-primary btn-sm',
                    'data-role' => 'cta',
                    'data-action' => 'disconnect',
                    'confirm' => __('Disconnect from {0}?', h($connection->firstname)),
                    'escapeTitle' => false
                ]
            ); ?>
        </div>
    </div>
</div>
<?php // endforeach; ?>