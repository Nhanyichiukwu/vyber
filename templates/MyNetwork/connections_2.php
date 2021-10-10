<?php
/**
 *
 */
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\Routing\Router;
use Cake\Utility\Text;
use Cake\Utility\Inflector;
use Cake\Utility\Security;
?>


<?php $this->extend('/Common/connections'); ?>
<!-- Counters -->
<div class="row gutters-sm">
    <div class="col-lg-4 col-6">
        <div class="card bg-azure-dark">
            <div class="card-body text-white">
                <div class="align-items-center d-flex justify-content-start">
                    <span class="icon lh_Ut7">
                        <i class="mdi mdi-48px mdi-account-group text-white"></i>
                    </span>
                    <div class="_jhNc11 ml-3">
                        <h3 class="fsz-28 mb-3">
                            <?= $this->Number->format(
                            $this->Cell('Counter::count',
                                ['connections', [$user->refid]])->render()
                            ); ?>
                        </h3>
                        <p class="mb-0"><?= __('Connections'); ?></p>
                    </div>
                </div>
            </div>
            <div class="card-footer px-2 py-1 text-right">
                <?= $this->Html->link(__('<span class="link-text">More</span> <span class="link-icon text-inherit"><i class="mdi mdi-chevron-right"></i></span>'), [
                    'action' => 'connections'
                ], [
                    'class' => 'btn btn-link btn-sm text-white',
                    'escapeTitle' => false
                ]); ?>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="card bg-yellow">
            <div class="card-body text-dark">
                <div class="align-items-center d-flex justify-content-start">
                    <span class="icon lh_Ut7">
                        <i class="mdi mdi-48px mdi-account-question text-dark"></i>
                    </span>
                    <div class="_jhNc11 ml-3">
                        <h3 class="fsz-28 mb-3"><?= $this->Number->format($this->Cell('Counter::count',
                                ['pending_connections', [$user->refid]])->render()); ?></h3>
                        <p class="mb-0"><?= __('Pending Connections'); ?></p>
                    </div>
                </div>
            </div>
            <div class="card-footer px-2 py-1 text-right">
                <?= $this->Html->link(__('<span class="link-text">More</span> <span class="link-icon text-inherit"><i class="mdi mdi-chevron-right"></i></span>'), [
                    'action' => 'connections',
                    'pending'
                ], [
                    'class' => 'btn btn-link btn-sm text-white',
                    'escapeTitle' => false
                ]); ?>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="card bg-red">
            <div class="card-body text-white">
                <div class="align-items-center d-flex justify-content-start">
                    <span class="icon lh_Ut7">
                        <i class="mdi mdi-48px mdi-account-arrow-right text-white"></i>
                    </span>
                    <div class="_jhNc11 ml-3">
                        <h3 class="fsz-28 mb-3">
                            <?= $this->Number->format(
                                $this->Cell('Counter::count',
                                    [
                                        'sent_requests',
                                        [
                                            $user->refid,
                                            'connection'
                                        ]
                                    ]
                                )->render()
                            ); ?>
                        </h3>
                        <p class="mb-0"><?= __('Sent Requests'); ?></p>
                    </div>
                </div>
            </div>
            <div class="card-footer px-2 py-1 text-right">
                <?= $this->Html->link(__('<span class="link-text">More</span> <span class="link-icon text-inherit"><i class="mdi mdi-chevron-right"></i></span>'), [
                    'action' => 'connections',
                    'sent-requests'
                ], [
                    'class' => 'btn btn-link btn-sm text-white',
                    'escapeTitle' => false
                ]); ?>
            </div>
        </div>
    </div>
</div>
<!-- Counters /-->
<?php if (isset($connections) && is_array($connections)): ?>
    <div class="card">
    <div class="card-body">
        <h6 class="card-title"><?= __('Connections'); ?></h6>
        <div class="connections profile-cards profile-grid">
            <div class="row gutters-sm">
            <?php foreach ($connections as $connection): ?>
                <div class="col-md-4 col-lg-3">
                    <?php
                        $dataSrc = 'connection/'.$connection->get('refid') . '?token=' . base64_encode(Security::randomString() . '_'. time());
                        $randID = Security::randomString(6);
                    ?>
                    <div class="_kG2vdB _Hc0qB9" data-load-type="r" data-src="<?= $dataSrc ?>" data-rfc="connection<?= $randID ?>" data-su="false" data-limit="1" data-r-ind="false" id="connection<?= $randID ?>"></div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
    <footer class="card-footer bgc-grey-100">
        <div class="_Um7tMZ text-center">
            <?= $this->Html->link(__('See More'), [
                '?' => ['more', 'page' => '2']
            ], [
                'class' => 'link btn btn-sm btn-link'
            ]); ?>
        </div>
    </footer>
</div>
<?php endif; ?>

