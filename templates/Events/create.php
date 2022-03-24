<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Event $event
 */

$this->enablePageHeader();
$this->pageTitle('Create Events');

$this->omitWidget('unread_notifications');

?>
<?php $this->start('header_widget'); ?>
<?= $this->Html->link(
    __('List Events'),
    ['action' => 'index'],
    [
        'class' => 'border btn btn-outline-light nav-link px-2 shadow-sm text-dark c-default',
    ]
) ?>
<?php $this->end(); ?>
<div class="_rtacSK">
    <div class="_nJRzoh">

        <div class="events form bg-white">
            <div class="p-3">
                <?= $this->Form->create($event, ['type' => 'file']) ?>
                <div class="form-group _Ad53 _179">
                    <?= $this->Form->control('user_refid', [
                        'type' => 'hidden',
                        'class' => 'hidden',
                        'value' => h($user->refid)
                    ]); ?>
                    <?= $this->Form->control('hostname', [
                        'type' => 'hidden',
                        'class' => 'hidden',
                        'value' => h($user->getFullname())
                    ]); ?>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <?= $this->Form->control('title', [
                                'class' => 'form-control',
                                'required' => 'required',
                                'label' => [
                                    'text' => 'Title',
                                    'class' => 'form-label',
                                ]
                            ]); ?>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <div class="">
                                <div id="eventThumb" class="_SHzJez bd-dotted mwp7f1ov bgc-grey-100 bgcH-grey-200 _IaEFbn _ragKBI
                        _yjxZKz _7SLuII _M8Lwqn border-dotted image-preview">
                                    <label class="d-block bg-transparent landscape w-100" for="media"></label>
                                    <?= $this->Form->file('media', [
                                        'id' => 'media',
                                        'class' => 'form-control custom-file-input d-none',
                                        'label' => false,
                                        'accept' => "image/jpg,image/jpeg,image/png,image/gif,video/mp4,video/mpeg4,video/ogg",
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
                    </div>
                    <div class="col-sm-7">
                        <div class="form-group input text required">
                            <?= $this->Form->control('description', [
                                'class' => 'form-control',
                                'required' => 'required',
                                'rows' => 3,
                                'label' => [
                                    'text' => 'Description',
                                    'class' => 'form-label',
                                ]
                            ]); ?>
                            <p class="text-muted-dark">
                                <span class="fsz-12">What is this event all about?</span>
                            </p>
                        </div>
                        <div class="form-group input select required">
                            <label for="event-type-id" class="form-label">Event Type</label>
                            <?= $this->Form->control('event_type_id',
                                [
                                    'options' => $eventTypes,
                                    'class' => 'form-select',
                                    'required' => 'required',
                                    'label' => false
                                ]
                            ); ?>
                            <p class="text-muted-dark">
                            <span
                                class="fsz-12">What type of event is it? Eg: Tv Show, Comedy Show, Seminar, Rally</span>
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="privacy" class="form-label">Privacy</label>
                            <?= $this->Form->select('privacy',
                                [
                                    'public' => 'Public',
                                    'private' => 'Private',
                                    'connections' => 'Connections',
                                    'mutual_connections' => 'Mutual Connections'
                                ],
                                [
                                    'default' => 'public',
                                    'id' => 'privacy',
                                    'class' => 'form-select',
                                ]
                            ); ?>
                            <p class="text-muted-dark">
                                <span class="fsz-12">Who can see or attend this event?</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="form-group text-md-end">
                    <?= $this->Form->button(__('Next <i class="mdi mdi-arrow-right"></i>'), [
                        'class' => 'btn btn-app',
                        'escapeTitle' => false
                    ]) ?>
                </div>
                <?= $this->Form->end(['Upload']) ?>
            </div>
        </div>
    </div>
</div>
