<?php ?>
<?php $this->assign('title', 'Account Settings'); ?>
    <div class="col p-4">
<?= $this->Form->create(
$user,
[
'url' => [
    'controller' => 'settings',
    'action' => 'account',
    'um' => 'sectional',
    'section' => 'username',
    'redirect' => urlencode($this->Url->request->getPath())
],
'method' => 'post'
]); ?>
        <div class="row">
            <div class="col-lg-12">
                <label class="form-label">Username</label>
            </div>
            <div class="col-sm-9">
                <div class="form-group">
<?= $this->Form->control('username', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Username']); ?>
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
<?= $this->Form->end(); ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-label">Gender</div>
                    <div class="custom-controls-stacked">
<?= $this->Form->input('gender', ['type' => 'hidden']); ?>
                        <label for="gender-male" class="custom-control custom-radio custom-control-inline">
<?= $this->Form->radio('gender',
[
    [
        'value' => 'male',
        'text' => 'Male',
        'class' => 'custom-control-input',
        'hiddenField' => false
    ]
],
[
    'hiddenField' => false,
    'label' => false
]); ?>
                            <div class="custom-control-label">Male</div>
                        </label>
                        <label for="gender-female" class="custom-control custom-radio custom-control-inline">
<?= $this->Form->radio('gender',
[
    [
        'value' => 'female',
        'text' => 'Female',
        'class' => 'custom-control-input'
    ]
],
[
    'hiddenField' => false,
    'label' => false
]); ?>
                            <div class="custom-control-label">Female</div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-md-12">
<?= $this->Form->control(
    'date_of_birth', 
    [
        'year' => [
            'start' => 1959,
            'class' => 'col-4 custom-select form-control mr-2'
            ],
        'month' => ['class' => 'col-4 custom-select form-control mr-2'],
        'day' => ['class' => 'col-2 custom-select form-control'],
        'label' => [
            'class' => 'd-b'
        ]
    ]); ?>
                    </div>

                </div>
            </div>
            <div class="col-sm-12">
                <h3 class="card-title border-bottom py-2 mb-3">Origin</h3>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="form-label">Address</label>
<?= $this->Form->control(
'address',
[
'name' => 'origin[address]',
'class' => 'form-control',
'placeholder' => 'Street Address',
'label' => false
]); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Hometown</label>
<?= $this->Form->control(
'hometown',
[
'name' => 'origin[hometown]',
'class' => 'form-control',
'placeholder' => 'Hometown',
'label' => false
]); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Local Government</label>
<?= $this->Form->control(
'lga_of_origin', 
[
'name' => 'origin[lga]',
'class' => 'form-control',
'label' => false,
'placeholder' => 'Local Governamet'
]); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Countries</label>
<?= $this->Form->select('country_of_origin', 
[
'Biafra' => 'Biafra',
'Israel' => 'Israel'
],
[
'name' => 'origin[country]',
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
'state_of_origin',
[
'Abia' => 'Abia',
'Rivers' => 'Rivers',
'Enugu' => 'Enugu'
],
[
'name' => 'origin[state]',
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
'name' => 'origin[city]',
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
'name' => 'origin[postcode]',
'class' => 'form-control',
'label' => false,
'placeholder' => 'Postcode'
]); ?>
                </div>
            </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>