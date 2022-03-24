<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;
use Cake\Routing\Router;

?>

<div class="col-lg-4 col-md-6 login-form mx-md-auto px-0 py-5">
    <div class="text-center text-white">
        <h3 class="fsz-32">Login</h3>
        <p>Want to take your entertainment art to a higher level? <strong>Go Vibely</strong>...
        </p>
    </div>
    <?= $this->element('Auth/login'); ?>
</div>
