<?php

/* 
 * Password Manager
 */
?>
<?php ?>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-lg-4 mx-auto">
            <div class="bg-white border">
                <?php if (!empty($message)): ?>
                <div class="alert-box"><?= $message ?></div>
                <?php endif; ?>
            <?= $this->Form->create(); ?>

                <div class="card-header bg-transparent">
                    <h3 class="card-title">Password Recovery</h3>
                </div>
                <div class="fieldset card-body">
                    <?= $this->element('AccountsService' . DS . 'PasswordRecovery' . DS . $step); ?>
                </div>
            <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

