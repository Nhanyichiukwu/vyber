<?php
use App\Utility\DateTimeFormatter;
use Cake\I18n\Date;
use Cake\Utility\Text;

$this->extend('common');
?>
<div class="about">
    <section class="card r8upjl1q _4gUj0 _gGsso shadow-none _UxaA">
        <div class="card-header bzakvszf q3ywbqi8 py-2">
            <h2 class="card-title font-weight-light fs-3">
                <x-cw-flex-box class="bzakvszf link-site" title="Edit">
                    <?php
                    $icon = 'icofont-';
                    if ($account->profile->gender === 'male') {
                        $icon .= 'business-man';
                    } elseif ($account->profile->gender === 'female') {
                        $icon .= 'girl';
                    } else {
                        $icon .= 'user-alt-3';
                    }
                    ?>
                    <x-cw-icon class="<?= $icon ?> me-4"></x-cw-icon>
                    <x-cw-inline-span>Persona</x-cw-inline-span>
                </x-cw-flex-box>
            </h2>
            <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                <x-cw-flex-box class="edit-widget fl-r">
                    <a href="#" class="link-site text-muted" title="Edit">
                        <x-cw-icon class="mdi mdi-pencil mdi-18px"></x-cw-icon>
                    </a>
                </x-cw-flex-box>
            <?php endif; ?>
        </div>
        <ul class="card-list-group mb-3 list-group mb-3 borderless">
            <?php if (isset($account->profile->stagename)): ?>
            <li class="list-group-item list-group-item-action content-editable hover-btn">
                <div class="flex-column flex-md-row row">
                    <div class="col-auto col-md-3">
                        <div class="cw_info-label jjx5ybac zvzds1sq">Stage Name</div>
                    </div>
                    <div class="col cw_info-group">
                        <div class="cw_info-wrap _oFb7Hd">
                            <div class="cw_info-data"><?= h($account->profile->getStagename()); ?></div>
                            <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                                <div class="d-none edit-info px-1 _bHrk _p5kp _qRwCre bg-white border">
                                    <a href="#" class="link-site text-muted" title="Edit">
                                        <x-cw-icon class="mdi mdi-pencil mdi-18px"></x-cw-icon>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </li>
            <?php endif; ?>
            <li class="list-group-item list-group-item-action content-editable hover-btn">
                <div class="flex-column flex-md-row row">
                    <div class="col-auto col-md-3">
                        <div class="cw_info-label jjx5ybac zvzds1sq">Industries</div>
                    </div>
                    <div class="col cw_info-group">
                        <div class="cw_info-wrap _oFb7Hd">
                            <div class="cw_info-data text-capitalize">
                                <?= $account->profile->getIndustriesAsString(); ?>
                            </div>
                            <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                                <div class="d-none edit-info px-1 _bHrk _p5kp _qRwCre bg-white border">
                                    <a href="#" class="link-site text-muted" title="Edit">
                                        <x-cw-icon class="mdi mdi-pencil"></x-cw-icon>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item list-group-item-action content-editable hover-btn">
                <div class="flex-column flex-md-row row">
                    <div class="col-auto col-md-3">
                        <div class="cw_info-label jjx5ybac zvzds1sq">Roles</div>
                    </div>
                    <div class="col cw_info-group">
                        <div class="cw_info-wrap _oFb7Hd">
                            <div class="cw_info-data text-capitalize">
                                <?= $account->profile->getRolesAsString(); ?>
                            </div>
                            <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                                <div class="d-none edit-info px-1 _bHrk _p5kp _qRwCre bg-white border">
                                    <a href="#" class="link-site text-muted" title="Edit">
                                        <x-cw-icon class="mdi mdi-pencil"></x-cw-icon>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </li>
            <?php if ($account->profile->hasValue('description')): ?>
                <li class="list-group-item list-group-item-action content-editable hover-btn">
                    <div class="flex-column flex-md-row row">
                        <div class="col-auto col-md-3">
                            <div class="cw_info-label jjx5ybac zvzds1sq">Description</div>
                        </div>
                        <div class="col cw_info-group">
                            <div class="cw_info-wrap _oFb7Hd">
                                <div class="cqteavpn cw_info-data"><?= h($account->profile->getDescription()); ?></div>
                                <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                                    <div class="d-none edit-info px-1 _bHrk _p5kp _qRwCre bg-white border">
                                        <a href="#" class="link-site text-muted" title="Edit">
                                            <x-cw-icon class="mdi mdi-pencil"></x-cw-icon>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endif; ?>
            <?php if ($account->profile->hasValue('bio')): ?>
                <li class="list-group-item list-group-item-action content-editable hover-btn">
                    <div class="flex-column flex-md-row row">
                        <div class="col-auto col-md-3">
                            <div class="cw_info-label jjx5ybac zvzds1sq">Biography</div>
                        </div>
                        <div class="col cw_info-group">
                            <div class="cw_info-wrap _oFb7Hd">
                                <div class="cqteavpn cw_info-data"><?= h($account->profile->getBio()); ?></div>
                                <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                                    <div class="d-none edit-info px-1 _bHrk _p5kp _qRwCre bg-white border">
                                        <a href="#" class="link-site text-muted" title="Edit">
                                            <x-cw-icon class="mdi mdi-pencil"></x-cw-icon>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endif; ?>
            <?php if ($account->profile->hasValue('websites')): ?>
                <li class="list-group-item list-group-item-action content-editable hover-btn">
                    <div class="flex-column flex-md-row row">
                        <div class="col-auto col-md-3">
                            <div class="cw_info-label jjx5ybac zvzds1sq">Websites</div>
                        </div>
                        <div class="col cw_info-group">
                            <div class="cw_info-wrap _oFb7Hd">
                                <div class="cqteavpn cw_info-data"><?= h($account->profile->getBio()); ?></div>
                                <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                                    <div class="d-none edit-info px-1 _bHrk _p5kp _qRwCre bg-white border">
                                        <a href="#" class="link-site text-muted" title="Edit">
                                            <x-cw-icon class="mdi mdi-pencil"></x-cw-icon>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endif; ?>
            <?php if ($account->profile->hasValue('social_links')): ?>
                <li class="list-group-item list-group-item-action content-editable hover-btn">
                    <div class="flex-column flex-md-row row">
                        <div class="col-auto col-md-3">
                            <div class="cw_info-label jjx5ybac zvzds1sq">Social Links</div>
                        </div>
                        <div class="col cw_info-group">
                            <div class="cw_info-wrap _oFb7Hd">
                                <div class="cqteavpn cw_info-data"><?= h($account->profile->getSocialLinks()); ?></div>
                                <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                                    <div class="d-none edit-info px-1 _bHrk _p5kp _qRwCre bg-white border">
                                        <a href="#" class="link-site text-muted" title="Edit">
                                            <x-cw-icon class="mdi mdi-pencil"></x-cw-icon>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </section>
    <section class="card r8upjl1q _4gUj0 _gGsso shadow-none _UxaA">
        <div class="card-header bzakvszf q3ywbqi8 py-2">
            <h2 class="card-title font-weight-light fs-3">
                <x-cw-flex-box class="bzakvszf link-site" title="Edit">
                    <?php
                    $icon = 'icofont-';
                    if ($account->profile->gender === 'male') {
                        $icon .= 'business-man';
                    } elseif ($account->profile->gender === 'female') {
                        $icon .= 'girl';
                    } else {
                        $icon .= 'user-alt-3';
                    }
                    ?>
                    <x-cw-icon class="<?= $icon ?> me-4"></x-cw-icon>
                    <x-cw-inline-span>Personal Info</x-cw-inline-span>
                </x-cw-flex-box>
            </h2>
            <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                <x-cw-flex-box class="edit-widget fl-r">
                    <a href="#" class="link-site text-muted" title="Edit">
                        <x-cw-icon class="mdi mdi-pencil mdi-18px"></x-cw-icon>
                    </a>
                </x-cw-flex-box>
            <?php endif; ?>
        </div>
        <ul class="card-list-group mb-3 list-group mb-3 borderless">
            <li class="list-group-item list-group-item-action content-editable hover-btn">
                <div class="flex-column flex-md-row row">
                    <div class="col-auto col-md-3">
                        <div class="cw_info-label jjx5ybac zvzds1sq">Gender</div>
                    </div>
                    <div class="col cw_info-group">
                        <div class="cw_info-wrap _oFb7Hd">
                            <div class="cqteavpn cw_info-data"><?= $account->profile->getGender(); ?></div>
                            <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                                <div class="d-none edit-info px-1 _bHrk _p5kp _qRwCre bg-white border">
                                    <a href="#" class="link-site text-muted" title="Edit">
                                        <x-cw-icon class="mdi mdi-pencil"></x-cw-icon>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item list-group-item-action content-editable hover-btn">
                <div class="flex-column flex-md-row row">
                    <div class="col-auto col-md-3">
                        <div class="cw_info-label jjx5ybac zvzds1sq">Date of Birth</div>
                    </div>
                    <div class="col cw_info-group">
                        <div class="cw_info-wrap _oFb7Hd">
                            <div class="cqteavpn cw_info-data">
                                <?= date('F j, Y', (new DateTime($account->profile->getDOB()))->getTimestamp());
                                ?></div>
                            <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                                <div class="d-none edit-info px-1 _bHrk _p5kp _qRwCre bg-white border">
                                    <a href="#" class="link-site text-muted" title="Edit">
                                        <x-cw-icon class="mdi mdi-pencil"></x-cw-icon>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </section>
    <section class="card r8upjl1q _4gUj0 _gGsso shadow-none _UxaA">
        <div class="card-header bzakvszf q3ywbqi8 py-2">
            <h2 class="card-title font-weight-light fs-3">
                <x-cw-flex-box class="bzakvszf link-site" title="Edit">
                    <?php
                    $icon = 'icofont-';
                    if ($account->profile->gender === 'male') {
                        $icon .= 'business-man';
                    } elseif ($account->profile->gender === 'female') {
                        $icon .= 'girl';
                    } else {
                        $icon .= 'user-alt-3';
                    }
                    ?>
                    <x-cw-icon class="<?= $icon ?> me-4"></x-cw-icon>
                    <x-cw-inline-span>Background</x-cw-inline-span>
                </x-cw-flex-box>
            </h2>
            <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                <x-cw-flex-box class="edit-widget fl-r">
                    <a href="#" class="link-site text-muted" title="Edit">
                        <x-cw-icon class="mdi mdi-pencil mdi-18px"></x-cw-icon>
                    </a>
                </x-cw-flex-box>
            <?php endif; ?>
        </div>
        <ul class="card-list-group mb-3 list-group mb-3 borderless">
            <li class="list-group-item list-group-item-action content-editable hover-btn">
                <div class="flex-column flex-md-row row">
                    <div class="col-auto col-md-3">
                        <div class="cw_info-label jjx5ybac zvzds1sq">Hometown</div>
                    </div>
                    <div class="col cw_info-group">
                        <div class="cw_info-wrap _oFb7Hd">
                            <div class="cqteavpn cw_info-data"><?= $account->profile->getHometown(); ?></div>
                            <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                                <div class="d-none edit-info px-1 _bHrk _p5kp _qRwCre bg-white border">
                                    <a href="#" class="link-site text-muted" title="Edit">
                                        <x-cw-icon class="mdi mdi-pencil"></x-cw-icon>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item list-group-item-action content-editable hover-btn">
                <div class="flex-column flex-md-row row">
                    <div class="col-auto col-md-3">
                        <div class="cw_info-label jjx5ybac zvzds1sq">LGA/County</div>
                    </div>
                    <div class="col cw_info-group">
                        <div class="cw_info-wrap _oFb7Hd">
                            <div class="cqteavpn cw_info-data"><?= $account->profile->getLgaOfOrigin(); ?></div>
                            <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                                <div class="d-none edit-info px-1 _bHrk _p5kp _qRwCre bg-white border">
                                    <a href="#" class="link-site text-muted" title="Edit">
                                        <x-cw-icon class="mdi mdi-pencil"></x-cw-icon>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item list-group-item-action content-editable hover-btn">
                <div class="flex-column flex-md-row row">
                    <div class="col-auto col-md-3">
                        <div class="cw_info-label jjx5ybac zvzds1sq">State/Province</div>
                    </div>
                    <div class="col cw_info-group">
                        <div class="cw_info-wrap _oFb7Hd">
                            <div class="cqteavpn cw_info-data"><?= $account->profile->getStateOfOrigin(); ?></div>
                            <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                                <div class="d-none edit-info px-1 _bHrk _p5kp _qRwCre bg-white border">
                                    <a href="#" class="link-site text-muted" title="Edit">
                                        <x-cw-icon class="mdi mdi-pencil"></x-cw-icon>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item list-group-item-action content-editable hover-btn">
                <div class="flex-column flex-md-row row">
                    <div class="col-auto col-md-3">
                        <div class="cw_info-label jjx5ybac zvzds1sq">Nationality</div>
                    </div>
                    <div class="col cw_info-group">
                        <div class="cw_info-wrap _oFb7Hd">
                            <div class="cqteavpn cw_info-data"><?= $account->profile->getCountryOfOrigin(); ?></div>
                            <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                                <div class="d-none edit-info px-1 _bHrk _p5kp _qRwCre bg-white border">
                                    <a href="#" class="link-site text-muted" title="Edit">
                                        <x-cw-icon class="mdi mdi-pencil"></x-cw-icon>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item list-group-item-action content-editable hover-btn">
                <div class="flex-column flex-md-row row">
                    <div class="col-auto col-md-3">
                        <div class="cw_info-label jjx5ybac zvzds1sq">Residential Info</div>
                    </div>
                    <div class="col cw_info-group">
                        <div class="cw_info-wrap _oFb7Hd">
                            <div class="cqteavpn cw_info-data"><?= $account->profile->getAddress(); ?></div>
                            <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                                <div class="d-none edit-info px-1 _bHrk _p5kp _qRwCre bg-white border">
                                    <a href="#" class="link-site text-muted" title="Edit">
                                        <x-cw-icon class="mdi mdi-pencil"></x-cw-icon>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </section>
    <section class="card r8upjl1q _4gUj0 _gGsso shadow-none _UxaA">
        <div class="card-header bzakvszf q3ywbqi8 py-2">
            <h2 class="card-title font-weight-light fs-3">
                <x-cw-flex-box class="bzakvszf link-site" title="Edit">
                    <?php
                    $icon = 'icofont-';
                    if ($account->profile->gender === 'male') {
                        $icon .= 'business-man';
                    } elseif ($account->profile->gender === 'female') {
                        $icon .= 'girl';
                    } else {
                        $icon .= 'user-alt-3';
                    }
                    ?>
                    <x-cw-icon class="<?= $icon ?> me-4"></x-cw-icon>
                    <x-cw-inline-span>Residential Info</x-cw-inline-span>
                </x-cw-flex-box>
            </h2>
            <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                <x-cw-flex-box class="edit-widget fl-r">
                    <a href="#" class="link-site text-muted" title="Edit">
                        <x-cw-icon class="mdi mdi-pencil mdi-18px"></x-cw-icon>
                    </a>
                </x-cw-flex-box>
            <?php endif; ?>
        </div>
        <ul class="card-list-group mb-3 list-group mb-3 borderless">
            <li class="list-group-item list-group-item-action content-editable hover-btn">
                <div class="flex-column flex-md-row row">
                    <div class="col-auto col-md-3">
                        <div class="cw_info-label jjx5ybac zvzds1sq">City</div>
                    </div>
                    <div class="col cw_info-group">
                        <div class="cw_info-wrap _oFb7Hd">
                            <div class="cqteavpn cw_info-data"><?= $account->profile->getCityOfResidence(); ?></div>
                            <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                                <div class="d-none edit-info px-1 _bHrk _p5kp _qRwCre bg-white border">
                                    <a href="#" class="link-site text-muted" title="Edit">
                                        <x-cw-icon class="mdi mdi-pencil"></x-cw-icon>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item list-group-item-action content-editable hover-btn">
                <div class="flex-column flex-md-row row">
                    <div class="col-auto col-md-3">
                        <div class="cw_info-label jjx5ybac zvzds1sq">State/Province</div>
                    </div>
                    <div class="col cw_info-group">
                        <div class="cw_info-wrap _oFb7Hd">
                            <div class="cqteavpn cw_info-data"><?= $account->profile->getStateOfResidence(); ?></div>
                            <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                                <div class="d-none edit-info px-1 _bHrk _p5kp _qRwCre bg-white border">
                                    <a href="#" class="link-site text-muted" title="Edit">
                                        <x-cw-icon class="mdi mdi-pencil"></x-cw-icon>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item list-group-item-action content-editable hover-btn">
                <div class="flex-column flex-md-row row">
                    <div class="col-auto col-md-3">
                        <div class="cw_info-label jjx5ybac zvzds1sq">Country</div>
                    </div>
                    <div class="col cw_info-group">
                        <div class="cw_info-wrap _oFb7Hd">
                            <div class="cqteavpn cw_info-data"><?= $account->profile->getCountryOfResidence(); ?></div>
                            <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                                <div class="d-none edit-info px-1 _bHrk _p5kp _qRwCre bg-white border">
                                    <a href="#" class="link-site text-muted" title="Edit">
                                        <x-cw-icon class="mdi mdi-pencil"></x-cw-icon>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item list-group-item-action content-editable hover-btn">
                <div class="flex-column flex-md-row row">
                    <div class="col-auto col-md-3">
                        <div class="cw_info-label jjx5ybac zvzds1sq">Address</div>
                    </div>
                    <div class="col cw_info-group">
                        <div class="cw_info-wrap _oFb7Hd">
                            <div class="cqteavpn cw_info-data"><?= $account->profile->getAddress(); ?></div>
                            <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                                <div class="d-none edit-info px-1 _bHrk _p5kp _qRwCre bg-white border">
                                    <a href="#" class="link-site text-muted" title="Edit">
                                        <x-cw-icon class="mdi mdi-pencil"></x-cw-icon>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </section>
    <section class="card r8upjl1q _4gUj0 _gGsso shadow-none _UxaA">
        <div class="card-body">
            <h2 class="section-title font-weight-light text-muted">
                <span>Achievements</span>
                <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                    <small class="edit-widget fl-r">
                        <a href="#" class="link-site text-muted" title="Edit"><i
                                class="mdi mdi-pencil mdi-18px"></i></a>
                    </small>
                <?php endif; ?>
            </h2>
            <?php if (
                isset($achievements) &&
                !empty($achievements) &&
                is_array($achievements) &&
                is_countable($achievements)
            ): ?>
                <?php foreach ($achievements as $achievement): ?>

                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
    <section class="card r8upjl1q _4gUj0 _gGsso shadow-none">
        <div class="card-body">
            <h2 class="section-title font-weight-light text-muted">
                <span>Nominations</span>
                <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                    <small class="edit-widget fl-r">
                        <a href="#" class="link-site text-muted" title="Edit"><i
                                class="mdi mdi-pencil mdi-18px"></i></a>
                    </small>
                <?php endif; ?>
            </h2>
            <?php if (
                isset($nominations) &&
                !empty($nominations) &&
                is_array($nominations) &&
                is_countable($nominations)
            ): ?>
                <?php foreach ($nominations as $nomination): ?>

                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
    <section class="card r8upjl1q _4gUj0 _gGsso shadow-none">
        <div class="card-body">
            <h2 class="section-title font-weight-light text-muted">
                <span class="link-site text-muted" title="Edit"><i class="mdi mdi-trophy-award"></i></span>
                <span>Awards</span>
                <?php if (isset($appUser) && $account->isSameAs($appUser)): ?>
                    <small class="edit-widget fl-r">
                        <a href="#" class="link-site text-muted" title="Edit"><i
                                class="mdi mdi-pencil mdi-18px"></i></a>
                    </small>
                <?php endif; ?>
            </h2>
            <?php if (
                isset($awards) &&
                !empty($awards) &&
                is_array($awards) &&
                is_countable($awards)
            ): ?>
                <?php foreach ($awards as $award): ?>

                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</div>
