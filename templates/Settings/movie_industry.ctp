<?php ?>
<div class="card">
    <div class="card-header bg-transparent d-b">
        <span class="fl-r"><?= $this->Html->link('Change Industry', [
            'change_industry' => 1
        ], 
        [
            'class' => 'btn btn-sm btn-outline-primary'
        ]); ?></span>
        <h3 class="card-title">Movie Industry</h3>
    </div>
    <div class="fieldset card-body">
<?= $this->Form->create(null, ['type' => 'post', 'url' => ['action' => 'music-industry']]); ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="entity" class="form-label">Entity</label>
            <?= $this->Form->control('user_entity_refid', ['class' => 'form-control', 'name' => 'entity', 'label' => false, 'id' => 'entity']); ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="role" class="form-label">Role</label>
                    <?= $this->Form->control('role_refid', ['class' => 'form-control', 'name' => 'role', 'label' => false, 'id' => 'role']); ?>
                    <p class="small text-muted-dark">What's your role in the music industry?</p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="stagename" class="form-label">Stagename</label>
                    <?= $this->Form->control('stagename', ['class' => 'form-control', 'id' => 'stagename', 'placeholder' => 'Your Stagename', 'label' => false]); ?>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                <label for="genre" class="form-label">Genre</label>
                    <?= $this->Form->input(
                    'genre_refid',
                    [
                        'type' => 'select',
                        'name' => 'genre',
                        'id' => 'genre',
                        'class' => 'form-control custom-select ',
                        'label' => false,
                        'options' => [
                            'afro-beat' => 'Afro Beat',
                            'hip-hop' => 'Hip-Hop',
                            'r&b' => 'R&B'
                        ]
                    ]); ?>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                <label for="music-category" class="form-label">Music Category</label>
                    <?= $this->Form->input(
                    'music_category_refid',
                    [
                        'type' => 'select',
                        'name' => 'music_category',
                        'class' => 'form-control custom-select ',
                        'id' => 'music-category',
                        'label' => false,
                        'options' => [
                            'afro-beat' => 'Afro Beat',
                            'hip-hop' => 'Hip-Hop',
                            'r&b' => 'R&B'
                        ]
                    ]); ?>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="form-group">
                    <label for="debut-year" class="form-label">Debut Year</label>
                <?= $this->Form->input(
                'debut_year', 
                [
                    'type' => 'date',
                    'label' => false,
                    'year' => [
                        'start' => 1939,
                        'class' => 'col-4 custom-select form-control mr-2'
                        ],
                    'month' => ['class' => 'col-4 custom-select form-control mr-2'],
                    'day' => ['class' => 'col-3 custom-select form-control']
                ]); ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <label for="debut-album" class="form-label">Debut Album</label>
                    <?= $this->Form->input(
                    'debut_album',
                    [
                        'type' => 'select',
                        'class' => 'form-control custom-select ',
                        'id' => 'debut-album',
                        'label' => false,
                        'options' =>  [
                            '88650850803503552355' => 'Up All Night',
                            '08358033003588030838' => 'Happy Moments',
                            '05605883585355325666' => 'Until When'
                        ]
                    ]); ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <label for="debut-song" class="form-label">Debut Song</label>
                    <?= $this->Form->input(
                    'debut_song',
                    [
                        'type' => 'select',
                        'class' => 'form-control custom-select ',
                        'id' => 'debut-song',
                        'label' => false,
                        'options' =>  [
                            '88650850803603552355' => 'Up All Night',
                            '08358033023588030838' => 'Happy Moments',
                            '05605883583355325666' => 'Until When'
                        ]
                    ]); ?>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
            <?= $this->Form->input(
                    'number_of_songs', 
                    [
                        'type' => 'number', 
                        'class' => 'form-control', 
                        'default' => 0, 
                        'label' => ['class' => 'form-label']
                    ]); ?>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
            <?= $this->Form->control(
                    'number_of_videos', 
                    [
                        'type' => 'number', 
                        'class' => 'form-control', 
                        'default' => 0, 
                        'label' => ['class' => 'form-label']
                    ]); ?>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
            <?= $this->Form->control(
                    'number_of_albums', 
                    [
                        'type' => 'number', 
                        'class' => 'form-control', 
                        'default' => 0, 
                        'label' => ['class' => 'form-label']
                    ]); ?>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
            <?= $this->Form->control(
                    'number_of_features', 
                    [
                        'type' => 'number', 
                        'class' => 'form-control', 
                        'default' => 0, 
                        'label' => ['text' => 'Features', 'class' => 'form-label']
                    ]); ?>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="manager" class="form-label">Manager</label>
                    <?= $this->Form->input(
                            'manager',
                            [
                                'class' => 'form-control',
                                'label' => false,
                                'placeholder' => 'Manager'
                            ]); ?>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="skills" class="form-label">Skills</label>
                    <?= $this->Form->input(
                        'skills',
                        [
                            'class' => 'form-control',
                            'label' => false,
                            'placeholder' => 'Skill'
                        ]); ?>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="instruments" class="form-label">Instruments you can play</label>
                    <?= $this->Form->control(
                        'instruments_known',
                        [
                            'class' => 'form-control',
                            'label' => false,
                            'placeholder' => 'Instruments'
                        ]); ?>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="story" class="form-label">Story</label>
                    <?= $this->Form->input(
                    'story',
                    [
                        'type' => 'textarea',
                        'placeholder' => 'Your Story',
                        'class' => 'form-control',
                        'label' => false
                    ]); ?>
                    <p class="small text-muted">Tell your career story with your fans</p>
                </div>
            </div>
            <div class="col-sm-12 text-right">
                <button class="btn btn-blue">Save Changes</button>
            </div>
        </div>
<?= $this->Form->end(); ?>
    </div>
</div>