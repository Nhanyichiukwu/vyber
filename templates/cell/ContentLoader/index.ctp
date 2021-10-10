<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<?= $this->element('Profile/header'); ?>
<div class=" container pt-3 px-3 pb-5">
    <div class="clearfix row ml-0">
        <div class="col-md-3 sidebar--md col-sm-3 pl-0">
            <div class="sidebar__inner">
                <div class="sidebuck card card-profile">
                    <div class="card-header" style="background-image: url(demo/photos/eberhard-grossgasteiger-311213-500.jpg);"></div>
                    <div class="card-body text-center">
                        <img class="card-profile-img" src="demo/faces/male/16.jpg">
                        <h4 class="mb-3"><?= h($account->fullname); ?></h4>
                        <?php if (!empty($account->bio)): ?>
                        <p class="mb-4"><?= h($account->bio); ?></p>
                        <?php endif; ?>
                        <button class="btn btn-outline-primary btn-sm">
                            <span class="mdi mdi-plus"></span> Connect
                        </button>
                    </div>
                </div>
                
<!--                <div class="user-data full-width card">
                    <div class="user-profile card-body p-0">
                        <div class="bg-dark cover-image pos-r px-3 py-3 rounded-top text-center username-dt">
                            <div class="avatar avatar-placeholder avatar-xxl pos-r t-50"></div>
                        </div>username-dt end
                        <div class="pb-3 pt-5 px-3 text-center user-specs">
                            <h3>John Doe</h3>
                            <span>Graphic Designer at Self Employed</span>
                        </div>
                    </div>user-profile end
                    
                </div>-->

                <div class="section card">
                    <div class="card-body pb-0">
                        <h6 class="text-small text-muted">Photos</h6>
                        <ul class="row gutters-sm unstyled p-0">
                            <li class="col-6 col-sm-4 px-1">
                              <div class="image-box">
                                <figure class="image-figure">
                                    <img src="../../webroot/img/nicolas-picard-208276-500.jpg" alt="" class="rounded-sm"/>
                                </figure>
                              </div>
                            </li>
                            <li class="col-6 col-sm-4 px-1">
                              <div class="image-box mb-1">
                                <figure class="image-figure">
                                    <img src="../../webroot/img/nicolas-picard-208276-500.jpg" alt="" class="rounded-sm"/>
                                </figure>
                              </div>
                            </li>
                            <li class="col-6 col-sm-4 px-1">
                              <div class="image-box mb-1">
                                <figure class="image-figure">
                                    <img src="../../webroot/img/nicolas-picard-208276-500.jpg" alt="" class="rounded-sm"/>
                                </figure>
                              </div>
                            </li>
                            <li class="col-6 col-sm-4 px-1">
                              <div class="image-box mb-1">
                                <figure class="image-figure">
                                    <img src="../../webroot/img/nicolas-picard-208276-500.jpg" alt="" class="rounded-sm"/>
                                </figure>
                              </div>
                            </li>
                            <li class="col-6 col-sm-4 px-1">
                              <div class="image-box mb-1">
                                <figure class="image-figure">
                                    <img src="../../webroot/img/nicolas-picard-208276-500.jpg" alt="" class="rounded-sm"/>
                                </figure>
                              </div>
                            </li>
                            <li class="col-6 col-sm-4 px-1">
                              <div class="image-box mb-1">
                                <figure class="image-figure">
                                    <img src="../../webroot/img/nicolas-picard-208276-500.jpg" alt="" class="rounded-sm"/>
                                </figure>
                              </div>
                            </li>
                            <li class="col-6 col-sm-4 px-1">
                              <div class="image-box mb-1">
                                <figure class="image-figure">
                                    <img src="../../webroot/img/nicolas-picard-208276-500.jpg" alt="" class="rounded-sm"/>
                                </figure>
                              </div>
                            </li>
                            <li class="col-6 col-sm-4 px-1">
                              <div class="image-box mb-1">
                                <figure class="image-figure">
                                    <img src="../../webroot/img/nicolas-picard-208276-500.jpg" alt="" class="rounded-sm"/>
                                </figure>
                              </div>
                            </li>
                            <li class="col-6 col-sm-4 px-1">
                              <div class="image-box mb-1">
                                <figure class="image-figure">
                                    <img src="../../webroot/img/nicolas-picard-208276-500.jpg" alt="" class="rounded-sm"/>
                                </figure>
                              </div>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <span class="fl-r"><a href="#" class="btn btn-link btn-sm">More</a></span>
                    </div>
                </div>
                
                
                <div class="card">
                    <div class="card-body">
                        <h6 class="afh">Likes <small>· <a href="#">View All</a></small></h6>
                        <ul class="bow box">
                            <li class="rv afa">
                                <img class="bos vb yb aff" src="assets/img/avatar-fat.jpg">
                                <div class="rw">
                                    <strong>Jacob Thornton</strong> @fat
                                    <div class="bpa">
                                        <button class="btn btn-outline-primary btn-sm">
                                            <span class="mdi mdi-account-plus"></span> Follow</button>
                                    </div>
                                </div>
                            </li>
                            <li class="rv">
                                <a class="bpu" href="#">
                                    <img class="bos vb yb aff" src="assets/img/avatar-mdo.png">
                                </a>
                                <div class="rw">
                                    <strong>Mark Otto</strong> @mdo
                                    <div class="bpa">
                                        <button class="btn btn-outline-primary btn-sm">
                                            <span class="mdi mdi-account-plus"></span> Follow</button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        Dave really likes these nerds, no one knows why though.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 float-left main-content-wrap col-sm-6 pl-0">
        <?= $this->element('Modules/publishing_tools'); ?>
            <div class="scrollbar-dynamic position-relative">
                <div class="feed-notification-bar">
                    Latest News
                </div>
                <div id="newsfeed" class="mb-5 newsfeed-home pb-5" role="newsfeed">
                <?php if (count($newsfeed)): ?>
                    <?php foreach ($newsfeed as $post): ?>
                        <?= $this->Template->addTemplate($post, 'post'); ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <h5 class="text-muted text-center text-light">Your newsfeed is empty...</h5>
                <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="sidebar--md col-md-3 col-sm-3 pl-0">
            <div class="sidebar__inner">
                <div class="section card">
                    <div class="card-body">
                        <h6 class="text-small text-muted">Suggested Connection</h6>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h6 class="afh">Likes <small>· <a href="#">View All</a></small></h6>
                        <ul class="bow box">
                            <li class="rv afa">
                                <img class="bos vb yb aff" src="assets/img/avatar-fat.jpg">
                                <div class="rw">
                                    <strong>Jacob Thornton</strong> @fat
                                    <div class="bpa">
                                        <button class="btn btn-outline-primary btn-sm">
                                            <span class="mdi mdi-account-plus"></span> Follow</button>
                                    </div>
                                </div>
                            </li>
                            <li class="rv">
                                <a class="bpu" href="#">
                                    <img class="bos vb yb aff" src="assets/img/avatar-mdo.png">
                                </a>
                                <div class="rw">
                                    <strong>Mark Otto</strong> @mdo
                                    <div class="bpa">
                                        <button class="btn btn-outline-primary btn-sm">
                                            <span class="mdi mdi-account-plus"></span> Follow</button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        Dave really likes these nerds, no one knows why though.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>