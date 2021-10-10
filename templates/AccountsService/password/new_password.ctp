<?php

/* 
 * Password Manager
 */
?>
<?php ?>
<div class="container">
    <div class="row">
        <div class="col-md-5 col-lg-5 mx-auto">
            <div class="bg-white border">
                <?php if (!empty($message)): ?>
                <div class="alert-box"><?= $message ?></div>
                <?php endif; ?>
            <?= $this->Form->create(); ?>

                <div class="card-header bg-transparent">
                    <h3 class="card-title">Create new password</h3>
                </div>
                <div class="fieldset card-body">
                    <div class="form-group">
                    <?= $this->Form->input('new_password', ['type' => 'password', 'class' => 'form-control']) ?>
                    </div>
                    <div class="form-group">
                    <?= $this->Form->input('confirm_new_password', ['type' => 'password', 'class' => 'form-control']) ?>
                    </div>
                    <div class="form-group">
                    <?= $this->Form->button(__('Save'), ['class' => 'btn btn-block btn-success']) ?>
                    </div>
                </div>
            <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

