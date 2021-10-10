<?php
/**
 * @var \App\View\AppView $this ;
 */

use App\Utility\RandomString;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\Routing\Router;
use Cake\Utility\Text;
use Cake\Utility\Inflector;
use Cake\Utility\Security;

?>

<header class="page-header bg-white border-top px-3 py-2 my-0 mgriukcz">
    <h3 class="page-title mb-0"><?= __('My Networks') ?></h3>
</header>
<section class="mb-2 mgriukcz bg-white">
    <div class="section-body p-3">
        <div class="dulmx5k4 flex-nowrap flex-row foa3ulpk mgriukcz n1ft4jmn ofx-auto pl-3 tvdg2pcc compact">
            <div class="col-4 col-lg-1 col-sm-2 muilk3da">
                <div class="card bg-azure-dark mmhtpn7c">
                    <div class="card-header p-2 text-white">
                        <span class="icon lh_Ut7">
                            <i class="mdi mdi-24px mdi-account-group text-white"></i>
                        </span>
                        <span class="_jhNc11 ml-auto">
                            <span class="">1</span>
                        </span>
                    </div>
                    <div class="card-footer px-2 py-1 text-center">
                        <?= $this->Html->link(__('<span class="link-text small">Connections</span>'), [
                            'controller' => 'MyNetwork',
                            'action' => 'connections'
                        ], [
                            'class' => 'fsz-12 text-white',
                            'escapeTitle' => false,
                            'data-toggle' => 'page',
                            'data-page-id' => RandomString::generateString(32, 'mixed', 'alpha'),
                            'fullBase' => true
                        ]); ?>
                    </div>
                </div>
            </div>
            <div class="col-4 col-lg-1 col-sm-2 muilk3da">
                <div class="card bg-azure-dark mmhtpn7c">
                    <div class="card-header p-2 text-white">
                        <span class="icon lh_Ut7">
                            <i class="mdi mdi-24px mdi-account-group text-white"></i>
                        </span>
                        <span class="_jhNc11 ml-auto">
                            <span class="">1</span>
                        </span>
                    </div>
                    <div class="card-footer px-2 py-1 text-center">
                        <?= $this->Html->link(__('<span class="link-text small">Followers</span>'), [
                            'controller' => 'MyNetwork',
                            'action' => 'followers'
                        ], [
                            'class' => 'fsz-12 text-white',
                            'escapeTitle' => false,
                            'data-toggle' => 'page',
                            'data-page-id' => RandomString::generateString(32, 'mixed', 'alpha'),
                            'fullBase' => true
                        ]); ?>
                    </div>
                </div>
            </div>
            <div class="col-4 col-lg-1 col-sm-2 muilk3da">
                <div class="card bg-azure-dark mmhtpn7c">
                    <div class="card-header p-2 text-white">
                        <div class="d-flex">
                            <span class="icon lh_Ut7">
                                <i class="mdi mdi-24px mdi-account-group text-white"></i>
                            </span>
                            <span class="_jhNc11 ml-auto">
                                <span class="">1</span>
                            </span>
                        </div>
                    </div>
                    <div class="card-footer px-2 py-1 text-center">
                        <?= $this->Html->link(__('<span class="link-text small">Followings</span>'), [
                            'controller' => 'MyNetwork',
                            'action' => 'followings'
                        ], [
                            'class' => 'fsz-12 text-white',
                            'escapeTitle' => false,
                            'data-toggle' => 'page',
                            'data-page-id' => RandomString::generateString(32, 'mixed', 'alpha'),
                            'fullBase' => true
                        ]); ?>
                    </div>
                </div>
            </div>
            <div class="col-4 col-lg-1 col-sm-2 muilk3da">
                <div class="card bg-azure-dark mmhtpn7c">
                    <div class="card-header p-2 text-white">
                        <span class="icon lh_Ut7">
                            <i class="mdi mdi-24px mdi-account-group text-white"></i>
                        </span>
                        <span class="_jhNc11 ml-auto">
                            <span class="">1</span>
                        </span>
                    </div>
                    <div class="card-footer px-2 py-1 text-center">
                        <?= $this->Html->link(__('<span class="link-text small">My Groups</span>'), [
                            'controller' => 'MyNetwork',
                            'action' => 'myGroups'
                        ], [
                            'class' => 'fsz-12 text-white',
                            'escapeTitle' => false,
                            'data-toggle' => 'page',
                            'data-page-id' => RandomString::generateString(32, 'mixed', 'alpha'),
                            'header-widget' => '<a href="/groups/new-group" ' .
                                'class="btn btn-secondary btn-sm float-right ' .
                                'yy63sy1k" data-toggle="page" ' .
                                'data-page-id="group-creator">New Group</a>',
                            'fullBase' => true
                        ]); ?>
                    </div>
                </div>
            </div>
            <div class="col-4 col-lg-1 col-sm-2 muilk3da">
                <div class="card bg-azure-dark mmhtpn7c">
                    <div class="card-header p-2 text-white">
                        <span class="icon lh_Ut7">
                            <i class="mdi mdi-24px mdi-account-group text-white"></i>
                        </span>
                        <span class="_jhNc11 ml-auto">
                            <span class="">1</span>
                        </span>
                    </div>
                    <div class="card-footer px-2 py-1 text-center">
                        <?= $this->Html->link(__('<span class="link-text small">Events</span>'), [
                            'controller' => 'MyNetwork',
                            'action' => 'events'
                        ], [
                            'class' => 'fsz-12 text-white',
                            'escapeTitle' => false,
                            'data-toggle' => 'page',
                            'data-page-id' => RandomString::generateString(32, 'mixed', 'alpha'),
                            'fullBase' => true
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="border-top p-2 section-footer text-center">
        <?php
        $trackingCode = [
            'ref' => 'my_network',
            'ref_url' => urlencode(
                $this->getRequest()->getRequestTarget()
            )
        ];
        ?>
        <?= $this->Html->link(__('Manage Network'), [
            'controller' => 'MyNetwork',
            'action' => 'manage',
            '?' => $trackingCode
        ], [
            "data-toggle" => "page",
            "data-page-id" => 'networkManager',
            'class' => '_ah49Gn',
            'fullBase' => true
        ]); ?>
    </div>
</section>
<!-- Counters /-->
<section class="section mgriukcz bg-white mb-2">
    <?php
    $sectionOutput = RandomString::generateString(6, 'mixed', 'alpha');
    ?>
    <nav class="toolbar bg-white d-flex border-bottom p-0" id="headerMenuCollapse">
        <div class="align-items-center page-nav px-3 toolbar w-100">
            <ul class="border-0 flex-nowrap flex-row foa3ulpk nav nav-tabs nav-tabs-sm ofy-h row-cols-auto">
                <li class="nav-item">
                    <a href="<?= Router::url('/my-network/invitations') ?>"
                       vibely-id="v4fU0H5"
                       data-target='#<?= $sectionOutput ?>'
                       data-loading="true"
                       data-type="fragment"
                       data-default="There currently no pending invitations. See
                       <a href='/my-network/invitations' class='_ah49Gn'>all
                       invitations</a>"
                       class="nav-link active">Invitations</a>
                </li>
                <li class="nav-item">
                    <a href="<?= Router::url('/my-network/meeting') ?>"
                       vibely-id="v4fU0H5"
                       data-target='#<?= $sectionOutput ?>'
                       data-loading="true"
                       data-type="fragment"
                       class="nav-link">Meeting</a>
                </li>
                <li class="nav-item">
                    <a href="<?= Router::url('/my-network/introductions') ?>"
                       vibely-id="v4fU0H5"
                       data-target='#<?= $sectionOutput ?>'
                       data-loading="true"
                       data-type="fragment"
                       class="nav-link">Introductions</a>
                </li>
            </ul>
        </div>
    </nav>
    <?php
    $params = json_encode([
        'resource_handle' => 'invitations',
        'resource_path' => 'Notifications/invitations'
    ]);
    $strParams = serialize($params);
    $strParams = base64_encode($strParams);
    ?>
    <div id="<?= $sectionOutput ?>" class="dynamic-data uf78udb5 _Hc0qB9 py-3"
         data-load-type="ow"
         data-src="/requests?type=connection&box=received&token=<?= $strParams ?>"
         data-rfc="users"
         data-su="true"
         data-limit="12"
         data-r-ind="false">
        <?= $this->element('App/loading'); ?>
    </div>
</section>
<section class="section mgriukcz bg-white mb-2">
    <div class="section-header p-3">
        <h6 class="section-title mb-0">People You May Know
            <span class="section-hint form-help"
                  data-toggle="popover"
                  data-html="true"
                  data-placement="top"
                  data-content="<p>This suggestions are based on your recent connections. Also, when your
                  connections make new connections, we will bring them to you to see if you also know and would
                  like to connect with them.</p>"
                  data-original-title=""
                  title="Suggestion Hint">?</span>
        </h6>
    </div>
    <div class="section-body p-3">
        <?php
        $params = json_encode([
            "resource_handle" => "users",
            "resource_path" => "Users/index"
        ]);
        $token = base64_encode(
            serialize($params)
        );
        $options = [
            "type" => "people_you_may_know",
            'ref' => 'my_network',
            'ref_url' => urlencode(
                $this->getRequest()->getRequestTarget()
            )
        ];
        $dataSrc = '/suggestion?' . http_build_query($options) . '&token=' . $token;
        ?>
        <div class="_Hc0qB9"
             data-load-type="r"
             data-src="<?= $dataSrc ?>"
             data-rfc="people_you_may_know"
             data-su="false"
             data-r-ind="false">
            <?= $this->element('App/loading'); ?>
        </div>
    </div>
    <div class="qYakgu-footer p-2 text-center">
        <?= $this->Html->link(__('See More'), [
            'controller' => 'Discover',
            'action' => 'people',
            'people-you-may-know',
            '?' => [
                'ref' => 'my-network',
                'ref_url' => urlencode(
                    $this->getRequest()->getRequestTarget()
                )
            ]
        ], [
            'data-toggle' => 'page',
            'data-page-id' => RandomString::generateString(32, 'mixed', 'alpha'),
            'data-page-title' => 'People You May Know',
            'class' => '_ah49Gn',
            'fullBase' => true,
        ]); ?>
    </div>
</section>
<section class="section mgriukcz bg-white mb-2">
    <div class="section-header p-3">
        <h6 class="section-title mb-0">People You May Be Interested In
            <span class="section-hint form-help"
                  data-toggle="popover"
                  data-html="true"
                  data-placement="top"
                  data-content="<p>This suggestion is randomly generated based
              people who are in the same industry as you.</p>"
                  data-original-title=""
                  title="Suggestion Hint">?</span></h6>
    </div>
    <div class="section-body p-3">
        <?php
        $params = [
            "what" => "users",
            "type" => "who_to_follow",
            "layout" => "flex_row",
            "data_limit" => "24"
        ];
        $token = base64_encode(
            serialize($params)
        );
        $trackingCode = [
            'ref' => 'my_network',
            'ref_url' => urlencode(
                $this->getRequest()->getRequestTarget()
            )
        ];
        $dataSrc = '/suggestion/' . $token . '?' . http_build_query($trackingCode)
        ?>
        <div class="_Hc0qB9"
             data-load-type="r"
             data-src="<?= $dataSrc ?>"
             data-rfc="who_to_follow"
             data-su="false"
             data-r-ind="false">
            <?= $this->element('App/loading'); ?>
        </div>
    </div>
    <div class="qYakgu-footer p-2 text-center">
        <?= $this->Html->link(__('See More'), [
            'controller' => 'Discover',
            'action' => 'people',
            'who-to-follow',
            '?' => [
                'ref' => 'discover',
                'ref_url' => urlencode(
                    $this->getRequest()->getRequestTarget()
                )
            ]
        ], [
            "data-toggle" => "page",
            "data-page-id" => RandomString::generateString(32, 'mixed', 'alpha'),
            'data-page-title' => 'People Of Interest',
            'class' => '_ah49Gn',
            'fullBase' => true
        ]); ?>
    </div>
</section>
<?php if (isset($connections) && is_array($connections)): ?>
    <div class="card">
        <div class="card-body">
            <h6 class="card-title"><?= __('Connections'); ?></h6>
            <div class="connections profile-cards profile-grid">
                <div class="row gutters-sm">
                    <?php foreach ($connections as $connection): ?>
                        <div class="col-md-4 col-lg-3">
                            <?php
                            $dataSrc = 'connection/' . $connection->get('refid') . '?token=' . base64_encode(Security::randomString() . '_' . time());
                            $randID = Security::randomString(6);
                            ?>
                            <div id="connection<?= $randID ?>"
                                 class="_kG2vdB _Hc0qB9"
                                 data-load-type="r"
                                 data-src="<?= $dataSrc ?>"
                                 data-rfc="connection<?= $randID ?>"
                                 data-su="false" data-limit="1"
                                 data-r-ind="false"></div>
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
