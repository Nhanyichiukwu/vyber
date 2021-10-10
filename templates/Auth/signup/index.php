<?php

use Cake\Core\Configure;
use Cake\Routing\Router;

?>
<div class="sign-up-form py-6 col-md-5 col-lg-4 mx-auto">
    <div class="text-center text-white">
        <h3 class="fsz-32">Sign Up</h3>
        <p>Want to take your entertainment art to a higher level? <strong>Go Vibely</strong>...
        </p>
    </div>
    <?= $this->element('Auth/signup'); ?>
</div>

