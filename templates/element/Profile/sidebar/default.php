<?php

/**
 * 
 */
?>
<div class="card card-profile">
    <div class="card-header" style="background-image: url(demo/photos/eberhard-grossgasteiger-311213-500.jpg);"></div>
    <div class="card-body text-center">
        <img class="card-profile-img" src="demo/faces/male/16.jpg">
        <h3 class="mb-3"><?= h($profile->getFullname()) ?></h3>
        <?php if ($profile->profile->has('about')): ?>
        <p class="mb-4">
            <?= h($profile->profile->getBio()); ?>
        </p>
        <?php endif; ?>
        <button class="btn btn-outline-primary btn-sm">
            <span class="fa fa-twitter"></span> Follow
        </button>
    </div>
</div>

<div class="card">
    <div class="card-header with-border">
        <h4 class="box-title">About Me</h4>
    </div>
    <!-- /.box-header -->
    <div class="card-body">
        <strong><i class="fa fa-book margin-r-5"></i> Education</strong>

        <?php if ($profile->profile->has('about')): ?>
        <p class="text-muted">
            <?= h($profile->profile->getBio()); ?>
        </p>
        <?php endif; ?>
        <hr>
        <h4><i class="fa fa-map-marker margin-r-5"></i> Location</h4>
        <p class="text-muted">Malibu, California</p>
        <hr>
        <h4><i class="mdi mdi-pencil margin-r-5"></i> Skills</h4>
        <?php if ($profile->profile->has('skills')): ?>
        <p>
            <?php
            $skills = explode(',', h($profile->profile->skills));
            foreach ($skills as $skill):
            ?>
            <span class="label label-success"><?= ucwords($skill); ?></span>
            <?php endforeach; ?>
        </p>
        <?php endif; ?>
        <hr>
        <h4><i class="mdi mdi-file-document margin-r-5"></i> Notes</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
    </div>
    <!-- /.box-body -->
</div>
