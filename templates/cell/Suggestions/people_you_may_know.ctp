<?= $peopleYouMayKnow; ?>
<?php if (count($peopleYouMayKnow)): ?>
        <ul class="people-list unstyled row mx-n3">
    <?php foreach ($peopleYouMayKnow as $someoneYouMayKnow): ?>
            <li class="col-md-6 learfix py-3">
            <img class="avatar avatar-xl border-0 fl-l mr-3 no-o" src="assets/img/avatar-fat.jpg">
            <div class="offset-1 pl-3">
                <a class="mb-0"><strong><?= h($someoneYouMayKnow->fullname); ?></strong> <small class="text-muted-dark">@<?= h($someoneYouMayKnow->username); ?></small></a>
                <div class="about-content-block"><?= h($someoneYouMayKnow->about); ?></div>
                <div class="meta-data text-small text-muted-dark">
                    <span class="personality"><?= h($someoneYouMayKnow->personality); ?></span> |
                    <span class="location"><?= h($someoneYouMayKnow->location); ?></span> |
                    <span class="genre"><?= h($someoneYouMayKnow->genre); ?></span>
                </div>
                <div class="">
                    <button class="btn btn-outline-primary btn-sm"><span class="mdi mdi-account-plus"></span> Connect</button>
                    <button class="btn btn-danger btn-sm"><span class="mdi mdi-times"></span> Connect</button>
                </div>
            </div>
        </li>
        <li class="col-md-6 learfix py-3">
            <img class="avatar avatar-xl border-0 fl-l mr-3 no-o" src="assets/img/avatar-fat.jpg">
            <div class="offset-1 pl-3">
                <strong>Jacob Thornton</strong> @fat
                <div class="">
                    <button class="btn btn-outline-primary btn-sm">
                        <span class="mdi mdi-account-plus"></span> Connect</button>
                </div>
            </div>
        </li>
        <li class="col-md-6 learfix py-3">
            <img class="avatar avatar-xl border-0 fl-l mr-3 no-o" src="assets/img/avatar-fat.jpg">
            <div class="offset-1 pl-3">
                <strong>Jacob Thornton</strong> @fat
                <div class="">
                    <button class="btn btn-outline-primary btn-sm">
                        <span class="mdi mdi-account-plus"></span> Connect</button>
                </div>
            </div>
        </li>
        <li class="col-md-6 learfix py-3">
            <img class="avatar avatar-xl border-0 fl-l mr-3 no-o" src="assets/img/avatar-fat.jpg" style="
    outline: none !important;
    border: none !important;
">
            <div class="offset-1 pl-3">
                <strong>Jacob Thornton</strong> @fat
                <div class="">
                    <button class="btn btn-outline-primary btn-sm">
                        <span class="mdi mdi-account-plus"></span> Connect</button>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>

<!--<div class="suggestion-usd border-bottom">
        <img src="./WorkWise Html Template_files/s1.png" alt="">
        <div class="sgt-text">
            <h4>Jessica William</h4>
            <span>Graphic Designer</span>
        </div>
        <span><i class="mdi mdi-plus"></i></span>
    </div>
    <div class="border-bottom d-flex px-2 py-2 suggestion-usd">
        <img src="./WorkWise Html Template_files/s1.png" alt="" class="avatar avatar-xl mr-3">
        <div class="col-md-9 pl-0 sgt-text">
            <h4>Jessica William</h4>
            <span>Graphic Designer</span>
        </div>
        <span class="pull-right"><i class="mdi mdi-plus"></i> Connect</span>
    </div>-->