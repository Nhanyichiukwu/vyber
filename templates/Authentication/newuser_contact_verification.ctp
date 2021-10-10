<?php
use Cake\Core\Configure;
?>
<div class="page">
    <div class="page-single">
        <div class="container">
            <div class="row">
                <div class="col col-login mx-auto">
                    <div class="text-center mb-6">
                        <img src="./demo/brand/tabler.svg" class="h-6" alt="">
                    </div>
                        <?= $this->Form->create('User', ['class' => 'card']) ?>
                        <?= $this->Form->unlockField('verification_code') ?>
                    <div class="card-body p-6">
                        <h6 class="card-title">Verify your <?= $contactMethod ?></h6>
                        <?= $this->Flash->render(); ?>
                        <div class="form-group">
                            <label class="form-label">Verification Code [<?= $code ?>]</label>
                            <input name="verification_code" type="text" class="form-control" placeholder="Verification Code">
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                        <div class="text-muted-dark mt-2">Hurry, it will expire very soon</div>
                        <div class="text-muted-dark">
                            Didn't recieve the code? 
                            <?php
                                $url = $this->Url->request->getRequestTarget();
                                $url .= stripos($url, '?') ? '&resend_code=1' : '?task=contact_verification&resend_code=1';
                            ?>
                            <a href="<?= $this->Url->webroot($url) ?>">Resend it</a>
                        </div>
                    </div>
                        <?= $this->Form->end() ?>
                    <div class="text-center text-muted">
                        Already have account? <a href="./login">Sign in</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>