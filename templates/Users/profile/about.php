<?php $this->extend('common'); ?>
<section class="card mb-4">
    <div class="card-body">
        <h2 class="section-title font-weight-light text-muted">
            <span class="link-site text-muted" title="Edit"><i class="mdi mdi-trophy-award"></i></span>
            <span>Career</span>
            <?php if (isset($activeUser) && $account->isSameAs($activeUser)): ?>
            <small class="edit-widget fl-r">
                <a href="#" class="link-site text-muted" title="Edit"><i class="mdi mdi-pencil mdi-18px"></i></a>
            </small>
            <?php endif; ?>
        </h2>
        <ul class="unstyled pl-0 ml-0">
                <?php if (isset($account->profile->stagename)): ?>
            <li class="d-flex peers">
                <span class="label">Celebrity Name</span>
                <span class="label"><?= h($account->profile->getStagename()); ?></span>
            </li>
                <?php endif; ?>
            <li class="d-flex">
                <span class="label">Role</span>
                <span class="peer-greed"><?= $account->profile->role; ?> Singer</span>
            </li>
            <li class="d-flex peers">
                <span class="label">Role</span>
                <span class="peer-greed"><?= $account->profile->role; ?> Singer</span>
            </li>
            <li class="d-flex peers">
                <span class="label">Role</span>
                <span class="peer-greed"><?= $account->profile->role; ?> Singer</span>
            </li>
            <li class="d-flex peers">
                <span class="label">Role</span>
                <span class="peer-greed"><?= $account->profile->role; ?> Singer</span>
            </li>
            <li class="d-flex peers">
                <span class="label">Role</span>
                <span class="peer-greed"><?= $account->profile->role; ?> Singer</span>
            </li>
            <li class="d-flex peers">
                <span class="label">Role</span>
                <span class="peer-greed"><?= $account->profile->role; ?> Singer</span>
            </li>
        </ul>
    </div>
</section>
<section class="card mb-4">
    <div class="card-body">
        <h2 class="section-title font-weight-light text-muted">
            <span>Personal Info</span>
            <?php if (isset($activeUser) && $account->isSameAs($activeUser)): ?>
            <small class="edit-widget fl-r">
                <a href="#" class="link-site text-muted" title="Edit"><i class="mdi mdi-pencil mdi-18px"></i></a>
            </small>
            <?php endif; ?>
        </h2>
        <ul class="unstyled pl-0 ml-0">
            <li class="d-flex peers">
                <span class="label">Gender</span>
                <span class="peer-greed"><?= $account->profile->getGender(); ?></span>
            </li>
            <li class="d-flex peers">
                <span class="label">Date Of Birth</span>
                <span class="peer-greed"><?= $account->getDOB(); ?></span>
            </li>
            <li class="d-flex peers">
                <span class="label">Hometown</span>
                <span class="peer-greed"><?= $account->profile->getHometown(); ?></span>
            </li>
            <li class="d-flex peers">
                <span class="label">State/Province</span>
                <span class="peer-greed"><?= $account->profile->getStateOfOrigin(); ?></span>
            </li>
            <li class="d-flex peers">
                <span class="label">Country Of Origin</span>
                <span class="peer-greed"><?= $account->profile->getCountryOfOrigin(); ?></span>
            </li>
            <li class="divider my-3 bdB">
                <span class="label">Residential Address</span>
            </li>
            <li class="divider">
                <span class="label">City</span>
                <span class="peer-greed"><?= $account->profile->getCityOfResidence(); ?></span>
            </li>
        </ul>
    </div>
</section>
<section class="card mb-4">
    <div class="card-body">
        <h2 class="section-title font-weight-light text-muted">
            <span>Achievements</span>
            <?php if (isset($activeUser) && $account->isSameAs($activeUser)): ?>
            <small class="edit-widget fl-r">
                <a href="#" class="link-site text-muted" title="Edit"><i class="mdi mdi-pencil mdi-18px"></i></a>
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
<section class="card mb-4">
    <div class="card-body">
        <h2 class="section-title font-weight-light text-muted">
            <span>Nominations</span>
            <?php if (isset($activeUser) && $account->isSameAs($activeUser)): ?>
            <small class="edit-widget fl-r">
                <a href="#" class="link-site text-muted" title="Edit"><i class="mdi mdi-pencil mdi-18px"></i></a>
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
<section class="card mb-4">
    <div class="card-body">
        <h2 class="section-title font-weight-light text-muted">
            <span class="link-site text-muted" title="Edit"><i class="mdi mdi-trophy-award"></i></span>
            <span>Awards</span>
            <?php if (isset($activeUser) && $account->isSameAs($activeUser)): ?>
            <small class="edit-widget fl-r">
                <a href="#" class="link-site text-muted" title="Edit"><i class="mdi mdi-pencil mdi-18px"></i></a>
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
