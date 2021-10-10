<?php

/**
 * HorseSpeed - The PHP Web Application Framework for
 * 
 * @package HorseSpeed
 * @link https://www.horsespeed.org/ The HorseSpeed official website
 * @copyright (c) 2019, Scaling Horse Software, LLC
 * @author Nhanyichiukwu Hopeson Otuosorochiukwu
 * @license https://opensource.org/licenses/mit-license.php MIT License
 */

$this->extend('index');

?>
<?php $this->start('sidebar'); ?>
<div class="">
    <ul class="nav navbar-nav">
        <li class="nav-item">
            <?= $this->Html->link(__('Sent'),
                [
                    'sent'
                ],
                [
                    'class' => 'nav-link'
                ]); ?>
        </li>
        <li class="nav-item">
            <?= $this->Html->link(__('Received'),
                [
                    'received'
                ],
                [
                    'class' => 'nav-link'
                ]); ?>
        </li>
    </ul>
</div>
<?php $this->end(); ?>