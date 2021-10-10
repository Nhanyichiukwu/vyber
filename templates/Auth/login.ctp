<?php
use Cake\Utility\Inflector;
use Cake\Core\Configure;
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
  */

  $requestAction = $this->Url->request->action;
  $this->assign('title', 'Login');
?>
<div class="row justify-content-center">
    <div class="col-md-8 py-lg-5">
        <div class="card-group">
            <div class="card p-4">
                <div class="card-body">
                <?php if (isset($element)): ?>
                    <?= $this->element('Auth/' . $element); ?>
                <?php else: ?>
                    <h1 class="fsz-32 _ah49Gn text-script text-center">Login</h1>
                    <div class="login-form-wrapper">
                        <p class="font-weight-lighter fsz-22 text-center">Sign in to your account</p>
                        <?= $this->Flash->render(); ?>
                        <?= $this->Form->create('User') ?>
                        <?= $this->element('Auth/login'); ?>
                        <?= $this->Form->end(); ?>
                    </div>
                <?php endif; ?>
                </div>
            </div>
            <div class="card text-white e_kjg py-5 d-md-down-none" style="width:44%">
                <div class="card-body text-center">
                    <div>
                        <h2 class="fsz-32 text-white text-script text-capitalize">Sign Up</h2>
                        <p>Join milions of other <?= Inflector::pluralize(Configure::read('Site.name')); ?> all over the world -- Connect, Communicate, Share, Make Deals...</p>
                        <p>It's totally free...</p>
                        <?= $this->Html->link(__('Register Now!'), ['controller' => '/', 'action' => 'signup'],['class' => 'btn btn-primary active shadow-sm mt-3 rounded-pill']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
