<?php

/* 
 * Location Editor
 */
?>


<div class="bg-white border">
    <?= $this->Form->create($user); ?>

    <div class="card-header bg-transparent">
        <h3 class="card-title">Location Settings</h3>
    </div>
    <div class="fieldset card-body">
        <div class="row">
            <div class="col-md-12">Manage your location settings</div>
        </div>
    </div>
    <div class="fieldset card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="form-label">Address</label>
    <?= $this->Form->control(
        'address',
        [
            'name' => 'location[address]',
            'class' => 'form-control',
            'placeholder' => 'Street Address',
            'label' => false
        ]); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Countries</label>
    <?= $this->Form->select('country_of_location', 
        [
            'Biafra' => 'Biafra',
            'Israel' => 'Israel'
        ],
        [
            'name' => 'location[country]',
            'class' => 'form-control custom-select',
            'id' => 'select-countries',
            'label' => false
        ]
    ); ?>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">State/Province</label>
    <?= $this->Form->select(
        'state_of_location',
        [
            'Abia' => 'Abia',
            'Rivers' => 'Rivers',
            'Enugu' => 'Enugu'
        ],
        [
            'name' => 'location[state]',
            'class' => 'form-control custom-select ',
            'label' => false,
            'placeholder' => 'State/Province'
        ]); ?>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="form-group">
                    <label class="form-label">City</label>
    <?= $this->Form->control(
        'city',
        [
            'name' => 'location[city]',
            'class' => 'form-control',
            'label' => false,
            'placeholder' => 'City'
        ]); ?>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group">
                    <label class="form-label">Postal Code</label>
    <?= $this->Form->control(
        'postcode',
        [
            'name' => 'location[postcode]',
            'class' => 'form-control',
            'label' => false,
            'placeholder' => 'Postcode'
        ]); ?>
                </div>
            </div>


        </div>
    </div>
    <?= $this->Form->end(); ?>
</div>