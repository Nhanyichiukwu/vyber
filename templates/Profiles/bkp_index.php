<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var \App\Model\Entity\User $account
 */
use Cake\Routing\Router;
use App\Utility\RandomString;
use Cake\Utility\Text;
use Cake\Utility\Inflector;

$this->extend('common');
?>
<div class="mx-0 mx-lg-n3 row">
    <div class="col-lg-6">
        <div class="d7bA">
            <?= $this->fetch('profile_sidedock'); ?>
            <div class="card ">
                <div class="card-body">
                    <h6 class="card-title"><?= __('Interests'); ?></h6>
                    <div id="userInterests"
                         class="ajaxify"
                         data-name="interests"
                         data-src="<?= '/profile/interests?user=' . $account->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed'); ?>"
                         data-conditions='{"remove_if_no_content":"no","check_for_update":"yes","auto_update":"no","use_data_prospect":"yes"}'></div>
                </div>
            </div>
            <div id="profileRelatedArticles"
                 class="ajaxify"
                 data-name="related_articles"
                 data-src="<?= '/profile/related_articles?user=' . $account->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed'); ?>"
                 data-conditions='{"remove_if_no_content":"no","check_for_update":"yes","auto_update":"no","use_data_prospect":"yes"}'>
            </div>
            <?php
            echo RandomString::generateString(20);
            echo '<br>';
            echo RandomString::generateString(8, 'mixed', 'alpha');
            echo '<br>';
            echo RandomString::generateString(4, 'mixed');
            echo '<br>';
            echo RandomString::generateString(3, 'mixed');
            ?>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="d7bA">
            <?= $this->fetch('profile_sidedock'); ?>
            <div class="card ">
                <div class="card-body">
                    <h6 class="card-title"><?= __('Interests'); ?></h6>
                    <div id="userInterests"
                         class="ajaxify"
                         data-name="interests"
                         data-src="<?= '/profile/interests?user=' . $account->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed'); ?>"
                         data-conditions='{"remove_if_no_content":"no","check_for_update":"yes","auto_update":"no","use_data_prospect":"yes"}'></div>
                </div>
            </div>
            <div id="profileRelatedArticles"
                 class="ajaxify"
                 data-name="related_articles"
                 data-src="<?= '/profile/related_articles?user=' . $account->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed'); ?>"
                 data-conditions='{"remove_if_no_content":"no","check_for_update":"yes","auto_update":"no","use_data_prospect":"yes"}'>
            </div>
            <?php
            echo RandomString::generateString(20);
            echo '<br>';
            echo RandomString::generateString(8, 'mixed', 'alpha');
            echo '<br>';
            echo RandomString::generateString(4, 'mixed');
            echo '<br>';
            echo RandomString::generateString(3, 'mixed');
            ?>
        </div>
    </div>
    <!--<div class="PUkr">
        <div class="Vo6f">
            <?php /*if ($this->fetch('pagelet_top')): */?>
                <div class="over-head mb-4">
                    <?/*= $this->fetch('pagelet_top'); */?>
                </div>
            <?php /*endif; */?>
            <?php /** Main Content Area **/?>
            <div class="_dzYJed">
                <div class="feed">
                    <?php /*if (isset($user)): */?>
                        <?php /*$this->element('App/widgets/content_creator',
                            [
                                'postEndPoint' => Router::url([
                                    'controller' => 'posts',
                                    'action' => 'new_post'
                                ], true)
                            ]); */?>
                    <?php /*endif; */?>
                    <div class="position-relative">
                        <div id="posts" class="_RrFC43">
                            <?php
    /*                            $params = json_encode([
                                    'resource_handle' => 'posts', // The name of the variable
                                    // containing the data to be passed to the view

                                    'resource_path' => 'profile/posts' // The path to the template use in rendering the data
                                ]);
                                $token = base64_encode(serialize($params));
                                $dataSrc = '/posts_by_user?token=' . $token . '&tbuid=' . $account->get('refid');
                                */?>
                            <div class="_Hc0qB9"
                                 data-load-type="r"
                                 data-src="<?/*= $dataSrc */?>"
                                 data-rfc="timeline"
                                 data-su="true"
                                 data-limit="24" data-r-ind="false">
                                <?/*= $this->element('App/loading', ['size' => 'spinner-md']); */?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php /** End Main Content Area **/?>
        </div>
    </div>-->
</div>
<section id="recently-published" class="card-variant mx-lg-n3 py-3 section">
    <div class="section-header px-3">
        <h4 class="section-title mb-0">Recent Posts</h4>
    </div>
    <div class="section-body p-3">
        <?php
        $params = json_encode([
            'resource_handle' => 'posts', // The name of the variable
            // containing the data to be passed to the view

            'resource_path' => 'profile/posts' // The path to the template use in rendering the data
        ]);
        $token = base64_encode(serialize($params));
        $dataSrc = '/posts_by_user?token=' . $token . '&tbuid='
            . $account->get('refid') . '&layout=linear';
        ?>
        <div class="_Hc0qB9"
             data-load-type="r"
             data-src="<?= $dataSrc ?>"
             data-rfc="timeline"
             data-su="true"
             data-limit="24" data-r-ind="false">
            <?= $this->element('App/loading', ['size' => 'spinner-md']); ?>
        </div>
    </div>
</section>
<!--<div class="row">
    <div class="profile-minor col-lg-4 border-right"></div>
    <div class="profile-main col-lg-8">
        <?php /*$this->cell('Counter::count', ['posts', ['actor' => $account->refid]]); */?>
    </div>
</div>-->
