<?php
/**
 *
 */
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\Routing\Router;
use Cake\Utility\Text;
use Cake\Utility\Inflector;
?>
<?php if ($this->get('activeUser') && $account->isSameAs($activeUser)): ?>
    <?php $this->start('pagelet_top'); ?>
    <div class="page-header">

    </div>
    <?php $this->end(); ?>
<?php endif; ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <?php if ($this->get('activeUser') && $account->isSameAs($activeUser)): ?>
            <?= __('My Connections'); ?>
            <?php else: ?>
            <?= __('{firstname}\'s Connections', ['firstname' => $account->getFirstName()]); ?>
            <?php endif; ?>
        </h3>
    </div>
    <div class="card-body">
        <div class="connections profile-cards profile-grid">
<?php if (isset($connections) && is_array($connections)): ?>
    <div class="row">
    <?php foreach ($connections as $connection): ?>
        <div class="col-md-6 col-lg-4">
            <?php /*
            <div class="card rounded-0">
                <div class="card-body p-1" style="background-image: url(../../img/profile/header-images/entertainer_profile_cover_image_915x240.jpg);">
                    <div class="media p-3 white-glass">
                        <div class="row card-row">
                            <div class="col-auto">
                                <span class="avatar avatar-xxl" style="background-image: url(../../img/profile/profile-photos/iohfh.jpg)"></span>
                            </div>
                            <div class="col">
                                <div class="media-body">
                                    <div class="account-identity">
                                    <h3 class="m-0 account-name text-white text-dark-shadow">
                                        <?= $this->Html->link(__('{fullname}', ['fullname' => h($connection->getFullname())]),
                                            Router::normalize('/e/' . $connection->getUsername()),
                                            [
                                                'class' => 'text-white text-dark-shadow',
                                                'escapeTitle' => false
                                            ]); ?>
                                    </h3>
                                    <p class="account-username mb-1">
                                        <?= $this->Html->link(__('@{username}', ['username' => h($connection->getUsername())]),
                                            Router::normalize('/e/' . $connection->getUsername()),
                                            [
                                                'class' => 'text-white text-dark-shadow',
                                                'escapeTitle' => false
                                            ]); ?>
                                    </p>
                                    </div>
                                <?php if ($connection->profile->getRoles()): ?>
                                    <p class="text-muted"><?= implode(' | ', $connection->profile->getRoles()); ?></p>
                                <?php endif; ?>
                                <?php if ($connection->profile->getBio()): ?>
                                    <p class="user-bio"><?= $this->Text->truncate($connection->profile->getBio(), 50, ['ellipsis' => '...']); ?></p>
                                <?php endif; ?>
                                    <ul class="ab border-top list-inline mb-0 mt-2 pt-3">
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="btn btn-azure bx bx-rnd bx30 bx-xpnd-on-hvr" title="" data-toggle="tooltip" data-original-title="Connect"><i class="mdi mdi-account-plus"></i> <span class="wd btn-text">Connect</span></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="btn btn-azure bx bx-rnd bx30 bx-xpnd-on-hvr" title="" data-toggle="tooltip" data-original-title="Send Message"><i class="mdi mdi-message"></i> <span class="wd btn-text">Send Message</span></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="btn btn-azure bx bx-rnd bx30 bx-xpnd-on-hvr" title="" data-toggle="tooltip" data-original-title="Meet"><i class="mdi mdi-human-male-female"></i> <span class="wd btn-text">Ask to meet</span></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="btn btn-azure bx bx-rnd bx30 bx-xpnd-on-hvr" title="" data-toggle="tooltip" data-original-title="Introduce"><i class="mdi mdi-account-switch"></i> <span class="wd btn-text">Intorduce</span></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="btn btn-azure bx bx-rnd bx30 bx-xpnd-on-hvr" title="" data-toggle="tooltip" data-original-title="Introduce"><i class="mdi mdi-chevron-down"></i> <span class="wd btn-text">More</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> **/ ?>


            <div class="TVo9Fi LkYB profile-card">
                <div class="SKgK LkA card card-profile">
                            <?php
                                $imgPath = WWW_ROOT . str_replace('/', DS, 'img/profile-headers/entertainer_profile_cover_image_915x240.jpg');
                                $file = new File($imgPath, false);
                                //pr(get_class_methods($file));
                                //$stream = $file->read();
                                //$encoded = base64_encode($stream);
                                $basename = $file->info()['basename'];
                                $filename = substr($basename, 0, strrpos($basename, '.'));
                                $dataUri = $this->Url->assetUrl('/media/' . $filename . '?type=photo&role=profile_header&format=' . $file->ext());

                                ?>
                    <div class="Cj1 card-img card-img-top h_aZ7">
                        <div class="_kx7 _poYC _3PpE border o-hidden _XZA1 _v6nr" style="background-image: url(<?= $dataUri ?>)">
                            <?= $this->Html->image($dataUri, ['class' => 'media _Aqj']); ?>
                        </div>
                    </div>
                    <div class="bQ3 card-body">
                        <img class="card-profile-img" src="../../img/profile/profile-photos/iohfh.jpg">
                        <h4 class="mb-3"><?= __('{fullname}', ['fullname' => h($connection->getFullname())]) ?></h4>
                    </div>
                </div>
            </div>
            <div class="account-box LkYB TVo9Fi">
                <div class="TVo9Fi-inner">
                    <div class="profile-card TVo9Fi-front">
                        <div class="SKgK card h-100 rounded-0 shadow-none border-0 card-profile">
                            <?php
                                $profileImgUrl = '';
                                $imagePath = '';
                                if (!empty($connection->profile->getProfileImageUrl())) {
                                    $profileImgUrl = $this->Url->assetUrl('uploads' . $connection->profile->getProfileImageUrl(), ['fullBase' => true]);
                                    $imagePath = WWW_ROOT . 'uploads' . $connection->profile->getProfileImageUrl();
                                }
                                $imageSrc = $profileImgUrl; // Fallback in case the encoding fails
                                if (file_exists($imagePath) && is_file($imagePath)) {
                                    $image = new File($imagePath);
                                    $encodedImage = base64_encode($image->read());
                                    $imageSrc = 'data:' . $image->mime() . ';base64,' . $encodedImage;
                                }

                                ?>
<!--                                <img class="e__profile-photo"
                                     alt="<?= h($connection->getFullname()); ?>"
                                     src="<?= $imageSrc; ?>"
                                     data-uri="<?= $imageSrc; ?>">-->

                            <div class="Cj1 card-header rounded-0" style="background-image: url(../../img/profile/header-images/entertainer_profile_cover_image_915x240.jpg);"></div>
                            <div class="bQ3 card-body rounded-0">
                                <img class="card-profile-img" src="../../img/profile/profile-photos/iohfh.jpg">
                                <h4 class="mb-3"><?= __('{fullname}', ['fullname' => h($connection->getFullname())]) ?></h4>
                            </div>
                        </div>
                    </div>

                    <div class="TVo9Fi-back flip-info">
                        <div class="card h-100 rounded-0 shadow-none border-0">
                            <div class="account-info text-center card-body rounded-0">
                                <div class="JtgT">
                                    <div class="QX1">
                                        <h3 class="mb-3"><?= __('{fullname}', ['fullname' => Text::truncate(h($connection->getFullname()), 25)]) ?></h3>
                                            <?php if ($connection->profile->getRoles()): ?>
                                        <p><?= implode(' | ', $connection->profile->getRoles()); ?></p>
                                            <?php endif; ?>
                                            <?php if ($connection->profile->getBio()): ?>
                                        <p class="user-bio"><?= $this->Text->truncate($connection->profile->getBio(), 50, ['ellipsis' => '...']); ?></p>
                                            <?php endif; ?>
                                    </div>
                                </div>
                                <div class="JtgT">
                                    <div class="QyS">
                                        <div class="btns d-flex justify-content-between">
                                            <button type="button" class="btn e_kjg rounded-pill" data-title="Disconnect" data-requires-login="true">
                                                <i class="mdi mdi-account-plus"></i> <span>Connect</span>
                                            </button>
                                            <button type="button" class="btn e_kjg rounded-circle" data-requires-login="true">
                                                <i class="mdi mdi-message"></i>
                                            </button>
                                            <button type="button" class="btn e_kjg rounded-circle" data-requires-login="true">
                                                <span class="mdi mdi-human-male-female"></span>
                                            </button>
                                            <button type="button" class="btn e_kjg rounded-circle" data-requires-login="true">
                                                <span class="mdi mdi-account-switch"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-4">
                                    <?php
                                    $url = [
                                        'controller' => 'profile',
                                        'action' => 'preview',
                                        h($connection->getUsername()),
                                        '?' => [
                                            '_vpt' => 'modal',
                                            '_lo' => 0
                                        ]
                                    ];
                                    $profileUrl = \Cake\Routing\Router::url($url);
                                    ?>

                                    <?= $this->Html->link(
                                            __('<span class="mdi mdi-eye"></span> View Profile'),
                                            $url,
                                            [
                                                'class' => 'btn btn-sm e_kjg',
                                                'escapeTitle' => false,
                                                'data-profile-url' => $profileUrl,
                                                'data-toggle' => 'modal',
                                                'data-target' => '#e__modal-'. h($connection->get('id')),
                                                'onclick' => "jQuery('#preview-". $this->Number->format($connection->get('id')) . "').attr('src','". $profileUrl . "')"
                                            ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
<?php endif; ?>
</div>
    </div>
</div>
<!--<script>-->
<?php $this->Html->scriptStart(['block' => 'scriptBottom']); ?>
//jQuery.ready(function() {
    lazyLoader.page.onContentReady('connections', function(e) {
        let b = $('.LkYB');
        $(b).css({height: ($(b).width() + ($(b).width() / 15)) + 'px'});
    });
//});().height()
<?php $this->Html->scriptEnd(); ?>
