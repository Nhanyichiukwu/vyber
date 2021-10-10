<?php

/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
*/
?>
<div class="row">
    <div class="col-sm-12 col-md-8 col-lg-8 mt-lg-5  pull-center text-center">
        <h4><?= ucfirst($media_type) ?> Saved.</h4>
        <p>Your link is <strong class="text-primary"><?= $short_url ?></strong></p>
        <div class="input-group m-b">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
            </span>
            <input type="text" class="form-control">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
            </span>
        </div>
        <p><a href="#" onclick="socialMediaShare()" data-url="<?= $short_url ?>">Share</a> the above link with your friends across your social media.</p>
    </div>
</div>