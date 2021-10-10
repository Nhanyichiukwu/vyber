<?php
/**
 * Profile page !@not-in-use
 */
?>
<div class="row">
    <main class="col-md-8 col-lg-8">
        <div class="career-info card">
            <div class="card-body">
                <div class="clearfix">
                    <div class="edit-widget fl-r">
                        <a class="link-site" title="Edit"><i class="mdi mdi-pencil"></i></a>
                    </div>
                    <h6 class="card-title">Career</h6>
                </div>
                <?php if ($account->has('niche')): ?>
                
                <?php else: ?>
                <p>You haven't given any information about your musical career. Add this information about your, so that people will understand who they're looking at.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="personal-info card">
            <div class="card-body">
                <div class="clearfix">
                    <div class="edit-widget fl-r">
                        <a class="link-site" title="Edit"><i class="mdi mdi-pencil"></i></a>
                    </div>
                    <h6 class="card-title">Profile</h6>
                </div>
                <div class="acnt-info">
                    <strong class="acnt-info__label fullname">Fullname:</strong>
                    <span class="acnt-info__text"><?= h($account->fullname); ?></span>
                </div>
                <div class="acnt-info">
                    <strong class="acnt-info__label gender">Fullname:</strong>
                    <span class="acnt-info__text"><?= h($account->fullname); ?></span>
                </div>
                <div class="acnt-info">
                    <strong class="acnt-info__label dob">Fullname:</strong>
                    <span class="acnt-info__text"><?= h($account->fullname); ?></span>
                </div>
                <div class="acnt-info">
                    <strong class="acnt-info__label origin">Fullname:</strong>
                    <span class="acnt-info__text"><?= h($account->fullname); ?></span>
                </div>
                <div class="acnt-info">
                    <strong class="acnt-info__label residence">Fullname:</strong>
                    <span class="acnt-info__text"><?= h($account->fullname); ?></span>
                </div>
                <div class="acnt-info">
                    <strong class="acnt-info__label current-location">Fullname:</strong>
                    <span class="acnt-info__text"><?= h($account->fullname); ?></span>
                </div>
                <div class="acnt-info">
                    <strong class="acnt-info__label account-name">Fullname:</strong>
                    <span class="acnt-info__text"><?= h($account->fullname); ?></span>
                </div>
            </div>
        </div>
        <div class="contact-info card">
            <div class="card-body">
                <div class="clearfix">
                    <div class="edit-widget fl-r">
                        <a class="link-site" title="Edit"><i class="mdi mdi-pencil"></i></a>
                    </div>
                    <h6 class="card-title">Contact Info</h6>
                </div>
                <div class="acnt-info">
                    <strong class="acnt-info__label phone">Phone
                        <?php if (isset($account->contacts->phone->phone_type))
                            echo '<i class="small">' 
                            . $account->contacts->phone->phone_type . '</i>'; ?>:</strong>
                    <span class="acnt-info__text"><?= h($account->fullname); ?></span>
                </div>
                <div class="acnt-info">
                    <strong class="acnt-info__label email">Email (Primary):</strong>
                    <span class="acnt-info__text"><?= h($account->email); ?></span>
                </div>
                <?php /*
                <div class="acnt-info">
                    <strong class="acnt-info__label dob">Fullname:</strong>
                    <span class="acnt-info__text"><?= h($account->fullname); ?></span>
                </div>
                <div class="acnt-info">
                    <strong class="acnt-info__label origin">Fullname:</strong>
                    <span class="acnt-info__text"><?= h($account->fullname); ?></span>
                </div>
                <div class="acnt-info">
                    <strong class="acnt-info__label residence">Fullname:</strong>
                    <span class="acnt-info__text"><?= h($account->fullname); ?></span>
                </div>
                <div class="acnt-info">
                    <strong class="acnt-info__label current-location">Fullname:</strong>
                    <span class="acnt-info__text"><?= h($account->fullname); ?></span>
                </div>
                <div class="acnt-info">
                    <strong class="acnt-info__label account-name">Fullname:</strong>
                    <span class="acnt-info__text"><?= h($account->fullname); ?></span>
                </div>
                 */ ?>
            </div>
        </div>
        <div class="photos card">
            <div class="card-body">
                <div class="clearfix">
                    <div class="edit-widget fl-r">
                        <a class="link-site" data-toggle="tooltip" data-placement="top" title data-original-title="Edit"><i class="mdi mdi-pencil"></i></a>
                    </div>
                    <h6 class="card-title">Photos</h6>
                </div>
                <?php if (isset($account->music_industry)): ?>
                
                <?php else: ?>
                <p>You haven't given any information about your musical career. Add this information about your, so that people will understand who they're looking at.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="songs card">
            <div class="card-body">
                <div class="clearfix">
                    <div class="edit-widget fl-r">
                        <a class="link-site" title="Edit"><i class="mdi mdi-pencil"></i></a>
                    </div>
                    <h6 class="card-title">Songs</h6>
                </div>
                <?php if (isset($account->music_industry)): ?>
                
                <?php else: ?>
                <p>You haven't given any information about your musical career. Add this information about your, so that people will understand who they're looking at.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="videos card">
            <div class="card-body">
                <div class="clearfix">
                    <div class="edit-widget fl-r">
                        <a class="link-site" title="Edit"><i class="mdi mdi-pencil"></i></a>
                    </div>
                    <h6 class="card-title">Videos</h6>
                </div>
                <?php //if ($account->has() == 'music'): ?>
                
                <?php //else: ?>
                <p>You haven't given any information about your musical career. Add this information about your, so that people will understand who they're looking at.</p>
                <?php //endif; ?>
            </div>
        </div>
    </main>
    <aside class="col-md-4 col-lg-4"></aside>
</div>

