<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Event $event
 */
?>
<?php $this->start('left_sidebar'); ?>
<div class="">

</div>
<?php $this->end(); ?>
<?php $this->start('page_top'); ?>
<div class="page-header">
    <h3 class="page-title "><?= __('New Event') ?></h3>
    <!--        <nav class="col-md-3" id="actions-sidebar">
                    <ul class="side-nav">
                        <li class="heading"><?= __('Actions') ?></li>
                        <li><?= $this->Html->link(__('List Events'), ['action' => 'index']) ?></li>
                    </ul>
                </nav>-->
</div>
<?php $this->end(); ?>
<div class="row gutters-sm">
    <?php /* Start the main Column */ ?>
    <div class="col-lg-8 col-md-6">
        <div class="_rtacSK">
            <div class="_nJRzoh">

                <div class="events form card">
                    <div class="card-body">
                        <h3 class="page-title "><?= __('Event Details') ?></h3>
                        <?= $this->Form->create($event, ['type' => 'file']) ?>
                        <div class="form-group _Ad53 _179">
                            <?= $this->Form->control('user_refid', [
                                'type' => 'hidden',
                                'class' => 'hidden',
                                'value' => h($activeUser->refid)
                            ]); ?>
                            <?= $this->Form->control('host_name', [
                               'type' => 'hidden',
                               'class' => 'hidden',
                               'value' => h($activeUser->getFullname())
                           ]); ?>
                        </div>
                        <div class="form-group">
                            <div class="">
                                <div id="eventThumb" class="_SHzJez bd-dotted bdrs-10 bgc-grey-100 bgcH-grey-200 _IaEFbn _ragKBI _yjxZKz _7SLuII border-dotted h_bP23 image-preview">
                                    <label class="d-block bg-transparent h-100 w-100" for="image"></label>
                                </div>
                                <div class="_179 _Ad53">
                                <?= $this->Form->input('image', [
                                    'type' => 'file', 
                                    'class' => 'form-control custom-file-input', 
                                    'label' => ['class' => 'custom-file-label'],
                                    'accept' => "image/jpg,image/jpeg,image/png,image/gif",
                                    'data-haspreview' => 'true',
                                    'aria-hidden' => 'true',
                                    'multiple' => 'false',
                                    'templates' => [
                                        'inputContainer' => '<div class="{{type}} pos-r">{{content}}</div>'
                                    ]
                                ]); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->control('event_title', [
                                'class' => 'form-control',
                                'label' => 'Title',
                                'required' => 'required'
                            ]); ?>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->control('description', [
                                'class' => 'form-control',
                                'required' => 'required'
                            ]); ?>
                            <p class="text-small text-muted">What is this event all about?</p>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->select('event_type', 
                                $eventTypes,
                                [
                                    'class' => 'form-control',
                                    'required' => 'require'
                                ]
                                ); ?>
                            <p class="text-small text-muted">What type of event is it? Eg: Tv Show, Comedy Show, Seminar, Rally</p>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->select('privacy', 
                                [
                                    'public' => 'Public',
                                    'private' => 'Private'
                                ],
                                [
                                    'class' => 'form-control'

                                ]
                                ); ?>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->button(__('Create Event'), [
                                'class' => 'btn btn-info btn-block'
                            ]) ?>
                        </div>
                        <?= $this->Form->end(['Upload']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php /* Start Right Sidebar */ ?>
    <div class="col-lg-4 col-md-6"></div>
</div>

<!--<main class="center col w_n4AQnm">
    <div id="m5r1Oq" class="wv">
        
    </div>
</main>
<aside class="col sidebar sidebar-lg w_rk2ARF">
    <div class="d7bA">
        <?= $this->fetch('right_sidebar'); ?>
        <?= $this->element('Widgets/important_links'); ?>
    </div>
</aside>-->