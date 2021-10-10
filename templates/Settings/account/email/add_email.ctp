<?php

/* 
 * Privacy Settings
 */
?>
<?php ?>
<div class="col-10 p-4">
    <?= $this->Form->create(
$user,
[
'url' => [
    'action' => 'account',
    'username',
    'um' => 'sectional',
    'section' => 'username',
    'redirect' => urlencode($this->getRequest()->getAttribute('here'))
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
        <div class="alert alert-icon alert-primary small" role="alert">
            <span class="mdi mdi-alert-circle mr-2" aria-hidden="true"></span> You may only use leters A-Z, a-z, numbers 0-9 and underscore (_).
        </div>
<?= $this->Form->end(); ?>
</div>

