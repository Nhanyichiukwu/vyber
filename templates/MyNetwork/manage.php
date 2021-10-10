<?php

/**
 * @var \App\View\AppView $this;
 */

use App\Utility\RandomString;
use Cake\Routing\Router;

$this->set('page_title', 'Manage Network');
?>
<?php $this->element('App/page_header'); ?>
<div class="bg-white content">
    <ul class="list-group list-group-flush cgihvj8k mgriukcz">
        <li class="list-group-item list-group-item-action">
            <div class="n1ft4jmn q3ywbqi8 bzakvszf">
                <?php
                $trackingCode = [
                    'ref' => 'my_network',
                    'ref_url' => urlencode(
                        $this->getRequest()->getRequestTarget()
                    )
                ];
                ?>
                <?= $this->Html->link(__('<span class="mr-2 _ah49Gn mdi mdi-24px lh-1 mdi-handshake"></span> Connections'), [
                    'controller' => 'MyNetwork',
                    'action' => 'connections',
                    '?' => $trackingCode
                ], [
                    "data-toggle" => "page",
                    "data-page-id" => RandomString::generateString(32, 'mixed','alpha'),
                    'class' => 'a3jocrmt bzakvszf jjx5ybac n1ft4jmn text-dark text-white-shadow',
                    'fullBase' => true,
                    'escapeTitle' => false
                ]); ?>
                <span class="counter"><?= $this->Number->format($connectionsCount); ?></span>
            </div>
        </li>
        <li class="list-group-item list-group-item-action">
            <div class="n1ft4jmn q3ywbqi8 bzakvszf">
                <?php
                $trackingCode = [
                    'ref' => 'my_network',
                    'ref_url' => urlencode(
                        $this->getRequest()->getRequestTarget()
                    )
                ];
                ?>
                <?= $this->Html->link(__('<span class="mr-2 _ah49Gn ' .
                    'mdi mdi-24px lh-1 mdi-account-multiple"></span> Followers'), [
                    'controller' => 'MyNetwork',
                    'action' => 'followers',
                    '?' => $trackingCode
                ], [
                    "data-toggle" => "page",
                    "data-page-id" => RandomString::generateString(32, 'mixed','alpha'),
                    'class' => 'a3jocrmt bzakvszf jjx5ybac n1ft4jmn text-dark text-white-shadow',
                    'fullBase' => true,
                    'escapeTitle' => false
                ]); ?>
                <span class="counter"><?= $this->Number->format($followersCount); ?></span>
            </div>
        </li>
        <li class="list-group-item list-group-item-action">
            <div class="n1ft4jmn q3ywbqi8 bzakvszf">
                <?php
                $trackingCode = [
                    'ref' => 'my_network',
                    'ref_url' => urlencode(
                        $this->getRequest()->getRequestTarget()
                    )
                ];
                ?>
                <?= $this->Html->link(__('<span class="mr-2 _ah49Gn ' .
                    'mdi mdi-24px lh-1 mdi-account-multiple-outline"></span> People I\'m Following'), [
                    'controller' => 'MyNetwork',
                    'action' => 'followings',
                    '?' => $trackingCode
                ], [
                    "data-toggle" => "page",
                    "data-page-id" => RandomString::generateString(32, 'mixed','alpha'),
                    'class' => 'a3jocrmt bzakvszf jjx5ybac n1ft4jmn text-dark text-white-shadow',
                    'fullBase' => true,
                    'escapeTitle' => false
                ]); ?>
                <span class="counter"><?= $this->Number->format($followingsCount); ?></span>
            </div>
        </li>
        <li class="list-group-item list-group-item-action">
            <div class="n1ft4jmn q3ywbqi8 bzakvszf">
                <?php
                $trackingCode = [
                    'ref' => 'my_network',
                    'ref_url' => urlencode(
                        $this->getRequest()->getRequestTarget()
                    )
                ];
                ?>
                <?= $this->Html->link(__('<span class="mr-2 _ah49Gn ' .
                    'mdi mdi-24px lh-1 mdi-account-group-outline"></span> My Groups'), [
                    'controller' => 'MyNetwork',
                    'action' => 'groups',
                    '?' => $trackingCode
                ], [
                    "data-toggle" => "page",
                    "data-page-id" => RandomString::generateString(32, 'mixed','alpha'),
                    'class' => 'a3jocrmt bzakvszf jjx5ybac n1ft4jmn text-dark text-white-shadow',
                    'fullBase' => true,
                    'escapeTitle' => false
                ]); ?>
                <span class="counter"><?= $this->Number->format($groupsCount); ?></span>
            </div>
        </li>
        <li class="list-group-item list-group-item-action">
            <div class="n1ft4jmn q3ywbqi8 bzakvszf">
                <?php
                $trackingCode = [
                    'ref' => 'my_network',
                    'ref_url' => urlencode(
                        $this->getRequest()->getRequestTarget()
                    )
                ];
                ?>
                <?= $this->Html->link(__('<span class="mr-2 _ah49Gn ' .
                    'mdi mdi-24px lh-1 mdi-calendar"></span> Events'), [
                    'controller' => 'MyNetwork',
                    'action' => 'events',
                    '?' => $trackingCode
                ], [
                    "data-toggle" => "page",
                    "data-page-id" => RandomString::generateString(32, 'mixed','alpha'),
                    'class' => 'a3jocrmt bzakvszf jjx5ybac n1ft4jmn text-dark text-white-shadow',
                    'fullBase' => true,
                    'escapeTitle' => false
                ]); ?>
                <span class="counter"><?= $this->Number->format($eventsCount); ?></span>
            </div>
        </li>
        <li class="list-group-item list-group-item-action">
            <div class="n1ft4jmn q3ywbqi8 bzakvszf">
                <?php
                $trackingCode = [
                    'ref' => 'my_network',
                    'ref_url' => urlencode(
                        $this->getRequest()->getRequestTarget()
                    )
                ];
                ?>
                <?= $this->Html->link(__('<span class="mr-2 _ah49Gn ' .
                    'mdi mdi-24px lh-1 mdi-pound"></span> Hashtags I Follow'), [
                    'controller' => 'MyNetwork',
                    'action' => 'hashtags',
                    '?' => $trackingCode
                ], [
                    "data-toggle" => "page",
                    "data-page-id" => RandomString::generateString(32, 'mixed','alpha'),
                    'class' => 'a3jocrmt bzakvszf jjx5ybac n1ft4jmn text-dark text-white-shadow',
                    'fullBase' => true,
                    'escapeTitle' => false
                ]); ?>
                <span class="counter"><?= $this->Number->format($hashtagsCount); ?></span>
            </div>
        </li>
    </ul>
</div>
