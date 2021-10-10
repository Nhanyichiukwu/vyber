<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div>
    <div class="form-group">
        <div class="form-label">How do you wish to recieve recovery code</div>
        <div class="custom-controls-stacked">
            <?= $this->Form->input('gender', ['type' => 'hidden']); ?>
            <label for="contact-method-email" class="custom-control custom-radio">
                <?= $this->Form->radio('contact_method',
                [
                    [
                        'value' => 'email',
                        'text' => 'Email',
                        'class' => 'custom-control-input'
                    ]
                ],
                [
                    'hiddenField' => false,
                    'label' => false
                ]); ?>
                <div class="custom-control-label">Email</div>
            </label>
            <label for="contact-method-sms" class="custom-control custom-radio">
                <?= $this->Form->radio('contact_method',
                [
                    [
                        'value' => 'sms',
                        'text' => 'Text Messaging',
                        'class' => 'custom-control-input',
                        'checked' => true
                    ]
                ],
                [
                    'hiddenField' => false,
                    'label' => false
                ]); ?>
                <div class="custom-control-label">Text Messaging</div>
            </label>
            <label for="contact-method-call" class="custom-control custom-radio">
                <?= $this->Form->radio('contact_method',
                [
                    [
                        'value' => 'call',
                        'text' => 'Voice Call',
                        'class' => 'custom-control-input'
                    ]
                ],
                [
                    'hiddenField' => false,
                    'label' => false
                ]); ?>
                <div class="custom-control-label">Voice Call</div>
            </label>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-info rounded-pill btn-block">Send Code</button>
    </div>
</div>




