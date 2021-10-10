<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label">About Me</label>
            <textarea name="about" rows="5" class="form-control" placeholder="Here can be your description" value="Mike"><?= h($activeUser->about); ?></textarea>
        </div>
    </div>
</div>