<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label class="form-label">First Name</label>
                <?= $this->Form->control('firstname', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Firstname']); ?>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label class="form-label">Last Name</label>
                <?= $this->Form->control('lastname', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Lastname']); ?>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Other Names</label>
                <?= $this->Form->control('othernames', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Othernames']); ?>
            </div>
        </div>
    </div>