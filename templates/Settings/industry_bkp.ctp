<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="col-sm-3">
                <div class="form-group">
            <?= $this->Form->input(
                    'number_of_songs', 
                    [
                        'type' => 'number', 
                        'class' => 'form-control', 
                        'default' => 0, 
                        'label' => ['class' => 'form-label']
                    ]); ?>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
            <?= $this->Form->control(
                    'number_of_videos', 
                    [
                        'type' => 'number', 
                        'class' => 'form-control', 
                        'default' => 0, 
                        'label' => ['class' => 'form-label']
                    ]); ?>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
            <?= $this->Form->control(
                    'number_of_albums', 
                    [
                        'type' => 'number', 
                        'class' => 'form-control', 
                        'default' => 0, 
                        'label' => ['class' => 'form-label']
                    ]); ?>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
            <?= $this->Form->control(
                    'number_of_features', 
                    [
                        'type' => 'number', 
                        'class' => 'form-control', 
                        'default' => 0, 
                        'label' => ['text' => 'Features', 'class' => 'form-label']
                    ]); ?>
                </div>
            </div>