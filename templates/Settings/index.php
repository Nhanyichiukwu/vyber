<?php
/**
 * Settings Index page
 *
 * @var \App\View\AppView $this;
 * @var \App\Model\Entity\User $user;
 */

use Cake\Routing\Router;

$this->enablePageHeader();
?>
<div class="mx-md-n3">
    <div class="list-group list-group-flush">
        <a href="<?= Router::url(['action' => 'profile']); ?>"
           class="list-group-item list-group-item-action">
            <span class="d-flex flex-wrap flex-md-nowrap">
                <span class="col-auto me-3"><span class="mdi mdi-account"></span></span>
                <span class="list-item-label me-4 fw-bold text-dark col-md-2">Profile</span>
                <span class="list-item-desc text-muted col-md-auto flex-fill fsz-14">
                    Let's you modify details such as your name,
                    description, biography, gender, date of birth and more.</span>
            </span>
        </a>
        <a href="<?= Router::url(['action' => 'account']); ?>"
           class="list-group-item list-group-item-action">
            <span class="d-flex flex-wrap flex-md-nowrap">
                <span class="col-auto me-3"><span class="mdi mdi-account"></span></span>
                <span class="list-item-label me-4 fw-bold text-dark col-md-2">Account</span>
                <span class="list-item-desc text-muted col-md-auto flex-fill fsz-14">Let's you modify details such as
                    your name,
                    description, biography, gender, date of birth and more.</span>
            </span>
        </a>
        <a href="<?= Router::url(['action' => 'privacy']); ?>"
           class="list-group-item list-group-item-action">
            <span class="d-flex flex-wrap flex-md-nowrap">
                <span class="col-auto me-3"><span class="mdi mdi-account"></span></span>
                <span class="list-item-label me-4 fw-bold text-dark col-md-2">Privacy</span>
                <span class="list-item-desc text-muted col-md-auto flex-fill fsz-14">Let's you modify details such as
                    your name,
                    description, biography, gender, date of birth and more.</span>
            </span>
        </a>
    </div>
</div>

