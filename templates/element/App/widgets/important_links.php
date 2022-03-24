<?php
/**
 *
 *
 */

use Cake\Core\Configure; ?>
<ul class="d-flex flex-wrap list-unstyled fsz-14">
    <li class="list-item px-2">
        <?= $this->Html->link('About', [
            'controller' => 'about',
            'action' => 'index'
        ], [
            'class' => 'text-muted-dark u1owkvqx small'
        ]); ?>
    </li>
    <li class="list-item px-2">
        <?= $this->Html->link('Help Center', [
            'controller' => 'help-center',
            'action' => 'index'
        ], [
            'class' => 'text-muted-dark u1owkvqx small'
        ]); ?>
    </li>
    <li class="list-item px-2">
        <?= $this->Html->link('Privacy Policy', [
            'controller' => 'about',
            'action' => 'policies',
            'privacy-policy'
        ], [
            'class' => 'text-muted-dark u1owkvqx small'
        ]); ?>
    </li>
    <li class="list-item px-2">
        <?= $this->Html->link('Cookies Policy', [
            'controller' => 'about',
            'action' => 'policies',
            'cookie-policy'
        ], [
            'class' => 'text-muted-dark u1owkvqx small'
        ]); ?>
    </li>
    <li class="list-item px-2">
        <?= $this->Html->link('Community Guidelines', [
            'controller' => 'community',
            'action' => 'guidelines'
        ], [
            'class' => 'text-muted-dark u1owkvqx small'
        ]); ?>
    </li>
    <li class="list-item px-2">
        <?= $this->Html->link('Career', [
            'controller' => 'career',
            'action' => 'index'
        ], [
            'class' => 'text-muted-dark u1owkvqx small'
        ]); ?>
    </li>
    <li class="list-item px-2">
        <?= $this->Html->link('Language', [
            'controller' => 'options',
            'action' => 'language'
        ], [
            'class' => 'text-muted-dark u1owkvqx small'
        ]); ?>
    </li>
</ul>
<span class="fsz-12 text-muted-dark">&copy; <?= date('Y') . ' '
    . Configure::read('Site.name'); ?> | Alrights Reserved</span>
