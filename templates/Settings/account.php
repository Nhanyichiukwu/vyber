<?php

use App\Utility\RandomString;
use Cake\Routing\Router;

$this->assign('title', 'Account Settings');

if (!$this->getRequest()->is('ajax')) {
    $this->extend('common');
}
?>
<div class="row">
    <div class="col">
        <div class="list-group list-group-flush">
            <?= $this->Html->link(
                __('Change Username'),
                ['action' => 'account', 'username'],
                [
                    'data-ov-toggle' => "modal",
                    'data-ov-target' => "#" . RandomString::generateString(
                        32,
                        'mixed',
                        'alpha'
                    ),
                    'data-title' => 'Change username',
                    'data-uri' => Router::url([
                        'action' => 'account',
                        'username'
                    ], true),
                    'data-modal-control' => '{
                    "class":"d-flex flex-column flex-column-reverse"
                    }',
                    'data-dialog-control' => '{"css":{"maxHeight":"90%"},
                    "class":"align-self-end m-md-auto mx-0 my-0 my-md-5 w-100"}',
                    'class' => 'list-group-item list-group-item-action ',
                    'escapeTitle' => false,
                    'title' => 'Change Username',
                    'fullBase' => true
                ]); ?>
            <?= $this->Html->link(
                __('Change Password'),
                ['action' => 'account', 'password'],
                [
                    'data-ov-toggle' => "modal",
                    'data-ov-target' => "#" . RandomString::generateString(
                        32,
                        'mixed',
                        'alpha'
                    ),
                    'data-title' => 'Change password',
                    'data-uri' => Router::url([
                        'action' => 'account',
                        'password'
                    ], true),
                    'data-modal-control' => '{
                    "class":"d-flex flex-column flex-column-reverse"
                    }',
                    'data-dialog-control' => '{"css":{"maxHeight":"90%"},
                    "class":"align-self-end m-md-auto mx-0 my-0 my-md-5 w-100"}',
                    'class' => 'list-group-item list-group-item-action ',
                    'escapeTitle' => false,
                    'title' => 'Change Username',
                    'fullBase' => true
                ]); ?>
            <?= $this->Html->link(
                __('Login Options'),
                ['action' => 'account', 'login-options'],
                [
                    'data-ov-toggle' => "modal",
                    'data-ov-target' => "#" . RandomString::generateString(
                        32,
                        'mixed',
                        'alpha'
                    ),
                    'data-title' => 'Login options',
                    'data-uri' => Router::url([
                        'action' => 'account',
                        'login-options'
                    ], true),
                    'data-modal-control' => '{
                    "class":"d-flex flex-column flex-column-reverse"
                    }',
                    'data-dialog-control' => '{"css":{"maxHeight":"90%"},
                    "class":"align-self-end m-md-auto mx-0 my-0 my-md-5 w-100"}',
                    'class' => 'list-group-item list-group-item-action ',
                    'escapeTitle' => false,
                    'title' => 'Login options',
                    'fullBase' => true
                ]); ?>
            <?= $this->Html->link(
                __('Account Security'),
                ['action' => 'account', 'account-security'],
                [
                    'data-ov-toggle' => "modal",
                    'data-ov-target' => "#" . RandomString::generateString(
                        32,
                        'mixed',
                        'alpha'
                    ),
                    'data-title' => 'Login options',
                    'data-uri' => Router::url([
                        'action' => 'account',
                        'account-security'
                    ], true),
                    'data-modal-control' => '{
                    "class":"d-flex flex-column flex-column-reverse"
                    }',
                    'data-dialog-control' => '{"css":{"maxHeight":"90%"},
                    "class":"align-self-end m-md-auto mx-0 my-0 my-md-5 w-100"}',
                    'class' => 'list-group-item list-group-item-action ',
                    'escapeTitle' => false,
                    'title' => 'Account security',
                    'fullBase' => true
                ]); ?>
            <?= $this->Html->link(
                __('Delete Account'),
                ['action' => 'account', 'password'],
                [
                    'data-ov-toggle' => "modal",
                    'data-ov-target' => "#" . RandomString::generateString(
                        32,
                        'mixed',
                        'alpha'
                    ),
                    'data-title' => 'Delete Account',
                    'data-uri' => Router::url([
                        'action' => 'account',
                        'delete'
                    ], true),
                    'data-modal-control' => '{
                    "class":"d-flex flex-column flex-column-reverse"
                    }',
                    'data-dialog-control' => '{"css":{"maxHeight":"90%"},
                    "class":"align-self-end m-md-auto mx-0 my-0 my-md-5 w-100"}',
                    'class' => 'list-group-item list-group-item-action text-red',
                    'escapeTitle' => false,
                    'title' => 'Change Username',
                    'fullBase' => true
                ]); ?>
        </div>
    </div>

</div>
