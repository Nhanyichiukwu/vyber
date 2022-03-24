<?php

use App\Utility\RandomString;

/**
 * @var \App\View\AppView $this
 */
$id = $id ?? 'venue_' . RandomString::generateString(16, 'mixedalpha');
$class = $class ?? 'venue';
$index = $index ?? 0;
?>
<div id="<?= $id ?>" class="<?= $class ?> mb-3">
    <div class="row gutters-sm">
        <div class="col-12">
            <div class="form-group">
                <?= $this->Form->control('venues.' . $index . '.title',
                    [
                        'class' => 'form-control',
                        'required' => 'required',
                        'label' => [
                            'text' => 'Title',
                            'class' => 'form-label',
                        ]
                    ]
                ); ?>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <?= $this->Form->control('venues.' . $index . '.description',
                    [
                        'class' => 'form-control',
                        'required' => 'required',
                        'rows' => 2,
                        'label' => [
                            'text' => 'Description',
                            'class' => 'form-label',
                        ]
                    ]
                ); ?>
            </div>
        </div>
        <div class="col-sm-5 col-lg-6">
            <div class="form-group">
                <div class="h-100">
                    <label class="form-label">Venue Specific Poster</label>
                    <div class="_SHzJez bd-dotted mwp7f1ov bgc-grey-100 bgcH-grey-200 _IaEFbn _ragKBI
                        _yjxZKz _7SLuII _M8Lwqn border-dotted image-preview">
                        <?= $this->Form->control('venues.' . $index . '.media', [
                            'class' => 'form-control custom-file-input d-none',
                            'label' => [
                                'text' => '',
                                'class' => 'd-block bg-transparent gzgyw7j7 w-100 mb-0 landscape'
                            ],
                            'type' => 'file',
                            'accept' => "image/jpg,image/jpeg,image/png,image/gif,video/mp4,video/mpeg4,video/ogg",
                            'data-haspreview' => 'true',
                            'aria-hidden' => 'true',
                            'multiple' => 'false',
                            'templates' => [
                                'inputContainer' => '{{content}}'
                            ]
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="row gutters-sm">
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="input select required">
                            <label for="default-country" class="form-label">Country</label>
                            <?= $this->Form->select('venues.' . $index . '.country_region',
                                [
                                    'Biafra' => 'Biafra',
                                    'United Kingdom' => 'United Kingdom',
                                ],
                                [
                                    'id' => 'default-country',
                                    'class' => 'form-select',
                                    'required' => 'required',
                                    'templates' => [
                                        'inputContainer' => '{{content}}'
                                    ]
                                ]
                            ); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="input select required">
                            <label for="default-state" class="form-label">State</label>
                            <?= $this->Form->select('venues.' . $index . '.state_province',
                                [
                                    'Abia' => 'Abia',
                                    'Rivers' => 'Rivers',
                                ],
                                [
                                    'id' => 'default-state',
                                    'class' => 'form-select',
                                    'required' => 'required',
                                    'templates' => [
                                        'inputContainer' => '{{content}}'
                                    ]
                                ]
                            ); ?>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <div class="input text required">
                            <label for="default-city" class="form-label">City</label>
                            <?= $this->Form->control('venues.' . $index . '.city',
                                [
                                    'id' => 'default-city',
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'templates' => [
                                        'inputContainer' => '{{content}}'
                                    ],
                                    'label' => false,
                                ]
                            ); ?>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <?= $this->Form->control('venues.' . $index . '.address',
                            [
                                'id' => 'default-address',
                                'class' => 'form-control',
                                'required' => 'required',
                                'label' => [
                                    'text' => 'Street Address',
                                    'class' => 'form-label',
                                ]
                            ]
                        ); ?>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <div class="input text required">
                            <label class="form-label">Day 1</label>
                            <?= $this->Form->date('venues.' . $index . '.dates.0.day',
                                [
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'templates' => [
                                        'inputContainer' => '{{content}}'
                                    ]
                                ]
                            ); ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-8">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <div class="input text required">
                                    <label class="form-label">Starts at:</label>
                                    <?= $this->Form->time('venues.' . $index . '.dates.0.starts_at',
                                        [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'templates' => [
                                                'inputContainer' => '{{content}}'
                                            ]
                                        ]
                                    ); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <div class="input text required">
                                    <label class="form-label">Ends at:</label>
                                    <?= $this->Form->time('venues.' . $index . '.dates.0.ends_at',
                                        [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'templates' => [
                                                'inputContainer' => '{{content}}'
                                            ]
                                        ]
                                    ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
