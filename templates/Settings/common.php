<?php
/**
 * Base template for settings
 * All templates except the index must extend this template, as it provides the
 * controller-wide navigation menu.
 *
 * @var \App\View\AppView $this;
 * @var \App\Model\Entity\User $user;
 */

use Cake\Routing\Router;

$this->enablePageHeader();
?>
<!--<div class="card bg-transparent _4gUj0 _muZaE shadow-none xzg02mh0">

</div>-->
<div class="wq8NSz7 mx-n3">
    <div class="row gutters-0">
        <div class="col-md-3 border-right bg-white min-vh-100">
            <div class="settings-nav mb-3">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-action <?= $page === 'profile' ? ' active' : '' ?>">
                        <?= $this->Html->link(
                            __('<span class="has-icon has-label"><i class="me-2 mdi mdi-18px mdi-account-box"></i> Edit Profile</span>'),
                            ['action' => 'profile'],
                            [
                                'class' => 'a3jocrmt text-muted',
                                'escapeTitle' => false
                            ]
                        ); ?>
                    </li>
                    <li class="list-group-item list-group-item-action <?= $page === 'account' ? ' active' : '' ?>">
                        <?= $this->Html->link(
                            __('<span class="has-icon has-label"><i class="me-2 mdi mdi-18px mdi-account"></i> Account</span>'),
                            ['action' => 'account'],
                            [
                                'class' => 'a3jocrmt text-muted',
                                'escapeTitle' => false
                            ]
                        ); ?>
                    </li>
                    <li class="list-group-item list-group-item-action <?= $page === 'career' ? ' active' : '' ?>">
                        <?= $this->Html->link(
                            __('<span class="has-icon has-label"><i class="me-2 mdi mdi-18px mdi-domain"></i> Career Lines</span>'),
                            ['action' => 'career'],
                            [
                                'class' => 'a3jocrmt text-muted',
                                'escapeTitle' => false
                            ]
                        ); ?>
                    </li>
                    <li class="list-group-item list-group-item-action <?= $page === 'location' ? ' active' : '' ?>">
                        <?= $this->Html->link(
                            __('<span class="has-icon has-label"><i class="me-2 mdi mdi-18px mdi-map-marker"></i> Location</span>'),
                            ['action' => 'location'],
                            [
                                'class' => 'a3jocrmt text-muted',
                                'escapeTitle' => false
                            ]
                        ); ?>
                    </li>
                    <li class="list-group-item list-group-item-action <?= $page === 'language' ? ' active' : '' ?>">
                        <?= $this->Html->link(
                            __('<span class="has-icon has-label"><i class="me-2 mdi mdi-18px mdi-account-voice"></i> Language</span>'),
                            ['action' => 'location'],
                            [
                                'class' => 'a3jocrmt text-muted',
                                'escapeTitle' => false
                            ]
                        ); ?>
                    </li>
                    <li class="list-group-item list-group-item-action <?= $page === 'privacy' ? ' active' : '' ?>">
                        <?= $this->Html->link(
                            __('<span class="has-icon has-label"><i class="me-2 mdi mdi-18px mdi-key"></i> Privacy</span>'),
                            ['action' => 'privacy'],
                            [
                                'class' => 'a3jocrmt text-muted',
                                'escapeTitle' => false
                            ]
                        ); ?>
                    </li>
                    <li class="list-group-item list-group-item-action <?= $page === 'notification' ? ' active' : '' ?>">
                        <?= $this->Html->link(
                            __('<span class="has-icon has-label"><i class="me-2 mdi mdi-18px mdi-bell"></i> Notification</span>'),
                            ['action' => 'notification'],
                            [
                                'class' => 'a3jocrmt text-muted',
                                'escapeTitle' => false
                            ]
                        ); ?>
                    </li>
                    <li class="list-group-item list-group-item-action <?= $page === 'blocking' ? ' active' : '' ?>">
                        <?= $this->Html->link(
                            __('<span class="has-icon has-label"><i class="me-2 mdi mdi-18px mdi-account-cancel"></i> Blocking</span>'),
                            [
                                'action' => 'blocking'
                            ],
                            [
                                'class' => 'a3jocrmt text-muted',
                                'escapeTitle' => false
                            ]
                        ); ?>
                    </li>
                    <li class="list-group-item list-group-item-action <?= $page === 'apps' ? ' active' : '' ?>">
                        <?= $this->Html->link(
                            __('<span class="has-icon has-label"><i class="me-2 mdi mdi-18px mdi-apps"></i> Apps and Websites</span>'),
                            ['action' => 'apps'],
                            [
                                'class' => 'a3jocrmt text-muted',
                                'escapeTitle' => false
                            ]
                        ); ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="py-3">
                <?php if (isset($page) && $page !== 'display'): ?>
                    <div id="<?= $page ?>-update" class="_RrFC43">
                        <?php
//                        $dataSrc = Router::url('/settings/'.$path, true);
                        ?>
                        <!--<div class="_Hc0qB9"
                             data-load-type="r"
                             data-src="<?/*= $dataSrc */?>"
                             data-rfc="ajax_data"
                             data-su="true"
                             data-limit="24" data-r-ind="false">
                            <?/*= $this->element('App/loading', ['size' => 'spinner-md']); */?>
                        </div>-->
                        <?php
                        $dataSrc = Router::url('/settings/'.$path, true);
                        $fetchContent = json_encode([
                            'content' => 'main_content',
                            'src' => $dataSrc,
                            'remove_if_no_content' => 'no',
                            'check_for_update' => 'no',
                            'auto_update' => 'no',
                            'use_data_prospect' => 'yes',
                            'load_type' => 'overwrite',
                        ]);
                        ?>
                        <div data-load-type="async" class="ajaxify" data-category="main_content" data-config='<?= $fetchContent ?>'>
                            <?= $this->element('App/loading', ['size' => 'spinner-md']); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!--<script>-->
<?= $this->Html->scriptStart(['block' => 'scriptBottom']); ?>
    $(document).ready(function () {
        // $('#input-industries').selectize({
        //     delimiter: ',',
        //     persist: false,
        //     create: function (input) {
        //         return {
        //             value: input,
        //             text: input
        //         }
        //     }
        // });
        // const inputIndustries = new OvTagsInput('#input-industries');
        // inputIndustries.tagify();
    });
     // document.addEventListener('page:content:ajax_data:ready', function () {
         // const inputIndustries = new OvTagsInput('#input-industries');
         // inputIndustries.tagify();
    //
    //     // inputIndustries.setOptions({foo: "bar"});
            // window.alert('hi');
    // });
<?= $this->Html->scriptEnd(); ?>
