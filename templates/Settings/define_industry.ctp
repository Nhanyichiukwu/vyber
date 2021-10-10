<?php ?>
<?php $this->assign('title', 'Define Your Career'); ?>
    <div class="col p-4">
<?= $this->Form->create($user); ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-label">Choose Industry</div>
                    <div class="selectgroup selectgroup-pills">
                        <?php // $this->Form->setTemplates(['radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}>', 'append' => '<span>Hello</span>']); ?>
                        <label for="industry-music" class="selectgroup-item">
                            <?= 
                            $this->Form->radio('industry',
                            [
                                [
                                    'value' => 'music',
                                    'text' => 'Music'
                                ]
                            ],
                            [
                                'hiddenField' => false,
                                'label' => false,
                                'class' => 'selectgroup-input'
                            ]); 
                            ?>
                            <span class="selectgroup-button selectgroup-button-icon"><i class="mdi mdi-music"></i> Music</span>
                        </label>
                        <label for="industry-movie" class="selectgroup-item">
                            <?= 
                            $this->Form->radio('industry',
                            [
                                [
                                    'value' => 'movie',
                                    'text' => 'Movie'
                                ]
                            ],
                            [
                                'hiddenField' => false,
                                'label' => false,
                                'class' => 'selectgroup-input'
                            ]); 
                            ?>
                            <span class="selectgroup-button selectgroup-button-icon"><i class="mdi mdi-movie"></i> Movie</span>
                        </label>
                            <?php
//                        $this->Form->radio('industry',
//                            [
//                                [
//                                    'value' => 'music',
//                                    'text' => 'Music',
//                                    'checked'
//                                ],
//                                [
//                                    'value' => 'foo',
//                                    'text' => 'Foo',
//                                ]
//                            ],
//                            [
//                                'class' => 'selectgroup-input',
//                                'label' => [
//                                    'class' => 'selectgroup-item'
//                                ]
//                            ]
//                                    ); 
                        ?>
                    </div>
                    <p class="small text-muted">Which part of the entertainment industry do you belong?</p>
                </div>
            </div>
            <div class="col-sm-12">
                <button class="btn btn-outline-info">Save Changes</button>
            </div>
        </div>
<?= $this->Form->end(); ?>
    </div>
<!--<label for="industry-movie" class="selectgroup-item">
        <?php 
//        $this->Form->radio('industry',
//        [
//            [
//                'value' => 'movie',
//                'text' => 'Movie',
//                'class' => 'selectgroup-input'
//            ]
//        ],
//        [
//            'hiddenField' => false,
//            'label' => false
//        ]); 
        ?>
        <span class="selectgroup-button selectgroup-button-icon"><i class="mdi mdi-movie"></i> Movie</span>
    </label>-->