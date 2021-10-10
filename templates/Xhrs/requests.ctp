<?php
//print_r($requests);
?>
<?php foreach ($requests as $request): ?>
<div class="list-group-item list-group-item-action request post-r">
    <e-action-menu class="action-menu e-custom-dropdown dropdown pos-a-r">
        <a href="javascript:void(0)" data-toggle="dropdown" class="box-square-2 btn-white dropdown-toggle no-after rounded-circle sQrBx text-center text-muted-dark" aria-haspopup="true" aria-expanded="true">
            <i class="mdi mdi-24px mdi-dots-vertical"></i></a>

        <e-dropmenu class="dropdown-menu keep-open dropdown-menu-right dropdown-menu-arrow fsz-sm shadow-lg" data-auto-close="true">
            <ul class="unstyled m-0 p-0">
                <li>
                    <a href="/musicsound/settings" class="d-b td-n pY-5 px-3 bgcH-grey-100 c-grey-700 text-nowrap">
                        <icon class="mR-10 d-inline-block va-t"><i class="icon mdi mdi-floppy mdi-24px"></i></icon>
                        <div class="d-inline-block">
                            <span class="d-b fs16 fsz-def">Save this post to my collections</span>
                            <span class="text-muted small">Saving a post let's you retain a copy even if the <br>original owner deletes it</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/musicsound/settings" class="d-b td-n pY-5 px-3 bgcH-grey-100 c-grey-700 text-nowrap">
                        <icon class="mR-10 d-inline-block va-m"><i class="icon mdi mdi-link-variant mdi-24px"></i></icon>
                        <div class="d-inline-block">
                            <span class="d-b fs16 fsz-def">Copy link to post</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/musicsound/settings" class="d-b td-n pY-5 px-3 bgcH-grey-100 c-grey-700 text-nowrap">
                        <icon class="mR-10 d-inline-block va-m"><i class="icon mdi mdi-xml mdi-24px"></i></icon>
                        <div class="d-inline-block">
                            <span class="d-b fs16 fsz-def">Embed this post</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/musicsound/settings" class="d-b td-n pY-5 px-3 bgcH-grey-100 c-grey-700 text-nowrap">
                        <icon class="mR-10 d-inline-block va-m"><i class="icon mdi mdi-account-star mdi-24px"></i></icon>
                        <div class="d-inline-block">
                            <span class="d-b fs16 fsz-def">Recommend to a friend</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/musicsound/settings" class="d-b td-n pY-5 px-3 bgcH-grey-100 c-grey-700 text-nowrap">
                        <icon class="mR-10 d-inline-block va-t"><i class="icon mdi mdi-flag-outline mdi-24px"></i></icon>
                        <div class="d-inline-block">
                            <span class="d-b fs16 fsz-def">Report this post</span>
                            <span class="text-muted small">Report this post if you think it is inappropriate<br>violates the community standards</span>
                        </div>
                    </a>
                </li>
                <li role="separator" class="dropdown-divider"></li>
                <li>
                    <a href="/musicsound/settings" class="d-b td-n pY-5 px-3 bgcH-grey-100 c-grey-700 text-nowrap">
                        <icon class="mR-10 d-inline-block va-m"><i class="icon mdi mdi-pencil mdi-24px"></i></icon>
                        <div class="d-inline-block">
                            <span class="d-b fs16 fsz-def">Edit post</span>
                        </div>
                    </a>
                </li>
                <li class="dropdown d-b">
                    <a href="javascript:void(1)" class="d-b td-n pY-5 px-3 bgcH-grey-100 c-grey-700 text-nowrap" data-toggle="dropdown">
                        <icon class="mR-10 d-inline-block va-m"><i class="icon mdi mdi-delete-forever mdi-24px"></i></icon>
                        <div class="d-inline-block">
                            <span class="d-b fs16 fsz-def">Delete post</span>
                        </div>
                    </a>
                    <e-dropmenu id="1-delete-sub-drop" class="dropdown-menu dropdown-menu-right dropdown-menu-arrow fsz-sm shadow-lg">
                        <ul class="unstyled m-0 p-0">
                            <li>
                                <a href="/musicsound/settings" class="d-b td-n pY-5 px-3 bgcH-grey-100 c-grey-700 text-nowrap">
                                    <icon class="mR-10 d-inline-block va-t"><i class="icon mdi mdi-floppy mdi-24px"></i></icon>
                                    <div class="d-inline-block">
                                        <span class="d-b fs16 fsz-def">Send to recycle bin?</span>
                                        <span class="text-muted small">Send items to recycle bin if you wish to recover <br>
                                                them later, or if you are unsure what you want to <br>
                                                do with it. However, objects in the recycle bin <br>are automatically delete after 30 days</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="/musicsound/settings" class="d-b td-n pY-5 px-3 bgcH-grey-100 c-grey-700 text-nowrap">
                                    <icon class="mR-10 d-inline-block va-t"><i class="icon mdi mdi-floppy mdi-24px"></i></icon>
                                    <div class="d-inline-block">
                                        <span class="d-b fs16 fsz-def">Delete Permanently?</span>
                                        <span class="text-muted small">Deleted items cannot be recovered. If you're <br>
                                                not sure what to do with this post, send it to recycle bin</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </e-dropmenu>
                </li>
            </ul>
        </e-dropmenu>
    </e-action-menu>
    <div class="d-flex gutters-xs mx-n3">
        <div class="col-auto">
            <div class="">
                <a href="#">
                    <span class="avatar avatar-md"><?= $request->getInitiator()->getNameAccronym() ?></span>
                </a>
            </div>
        </div>
        <div class="col">
            <div class="d-flex">
                <div class="req-b">
                    <div class="text small"><?= $request->getMessage(); ?></div>
                </div>
                <div class="btn-group btn-group-vertical commit-btns cta ml-auto">
                    <div
                        role="button"
                        class="align-items-center btn btn-control-small btn-outline-primary btn-sm commit-btn d-inline-flex i_H4n"
                        data-commit="connection"
                        data-intent="accept"
                        aria-committed="false"
                        data="<?= h($request->getCorrespondent()->getUsername()); ?>/<?= h($request->getInitiator()->getUsername()) ?>"
                    >
                        <span class="btn-text" aria-alt-text="Disconnect">Accept</span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
