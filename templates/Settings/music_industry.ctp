<?php
$userEntityOptions = $roleOptions = $musicCategoryOptions = $albumOptions = $genreOptions = $musicalInstrumentsOptions = $songsOptions = [];
if (count($userEntities)) {
    foreach ($userEntities as $userEntity) {
        $userEntityOptions[$userEntity->refid] = __($userEntity->name);
    }
}
if (count($userRoles)) {
    foreach ($userRoles as $userRole) {
        $roleOptions[$userRole->refid] = __($userRole->name);
    }
}
//if (count($musicCategories)) {
//    foreach ($musicCategories as $musicCategory) {
//        $musicCategoryOptions[$musicCategory->refid] = __($musicCategory->name);
//    }
//}
if (count($albums)) {
    foreach ($albums as $album) {
        $albumOptions[$album->refid] = __($album->name);
    }
}
if (count($genres)) {
    foreach ($genres as $genre) {
        $genreOptions[$genre->refid] = __($genre->name);
    }
}
if (count($songs)) {
    foreach ($songs as $song) {
        $songsOptions[$song->refid] = __($song->name);
    }
}
?>
<div class="card">
    <div class="card-header d-b">
        <span class="fl-r"><?= $this->Html->link('Change Industry', [
            'change_industry' => 1
        ], 
        [
            'class' => 'btn btn-sm btn-outline-primary'
        ]); ?></span>
        <h3 class="card-title">Music Industry</h3>
    </div>
    <div class="fieldset card-body">
<?= $this->Form->create($musicMakerData, ['type' => 'post']); ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="user-entity" class="form-label">Entity</label>
                    <?= $this->Form->input(
                    'user_entity_refid',
                    [
                        'type' => 'select',
                        'name' => 'user_entity',
                        'id' => 'user-entity',
                        'class' => 'form-control custom-select ',
                        'label' => false,
                        'options' => $userEntityOptions,
                        'empty' => '--Select Entity--'
                    ]); ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="role" class="form-label">Role</label>
                    <?= $this->Form->input(
                    'role_refid',
                    [
                        'type' => 'select',
                        'name' => 'role',
                        'id' => 'role',
                        'class' => 'form-control custom-select ',
                        'label' => false,
                        'options' => $roleOptions,
                        'empty' => '--Select Role--'
                    ]); ?>
                    <p class="small text-muted-dark">What's your role in the music industry?</p>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="form-group">
                    <label for="stagename" class="form-label">Stagename</label>
                    <?= $this->Form->control('stagename', ['class' => 'form-control', 'id' => 'stagename', 'placeholder' => 'Your Stagename', 'label' => false, 'default' => h($activeUser->username)]); ?>
                </div>
            </div>
            <div class="col-sm-5">
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
                        'options' => $genreOptions,
                        'empty' => '--Select Genre--'
                    ]); ?>
                </div>
            </div>
            <div class="col-sm-12">
                <label for="music-category" class="form-label">Music Category (<small class="small text-muted">What category of music do you do? Example: Gospel, Romance</small>)</label>
                <input type="hidden" name="music_categories" value="0">
                <div class="row">
                    <?php foreach ($musicCategories as $mCategoryGroup):?>
                    <div class="col-sm-3">
                        <div class="form-group">
                        <?php foreach ($mCategoryGroup as $category): ?>
                            <?php
                                    $checked = null;
                                    if (! empty($musicMakerData->music_categories)) {
                                        $userMusicCats = (array ) (is_array($musicMakerData->music_categories) ? 
                                            $musicMakerData->music_categories : explode(',', $musicMakerData->music_categories));
                                        foreach ($userMusicCats as $userMusicCat) {
                                            if ($category->slug === $userMusicCat) {
                                                $checked = 'checked';
                                            }
                                        }
                                    }
                                ?>
                            <div class="custom-control custom-checkbox">
                            <?= $this->Form->input(
                            'music_category_refid',
                            [
                                'type' => 'checkbox',
                                'name' => 'music_categories[]',
                                'value' => h($category->slug),
                                'class' => 'custom-control-input',
                                'id' => h($category->slug),
                                'label' => false,
                                'hiddenField' => false,
                                'templates' => [
                                    'inputContainer' => '{{content}}'
                                ],
                                $checked
                            ]); ?>
                                 <label class="custom-control-label" for="<?= h($category->slug); ?>"><?= h($category->name); ?></label>
                              </div>
                            
                        <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="form-group">
                    <label for="debut" class="form-label">Debut</label>
                <?= $this->Form->input(
                'debut', 
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
                        'options' =>  $albumOptions,
                        'empty' => '--Select Album--'
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
                        'options' =>  $songsOptions,
                        'empty' => '--Select Song--'
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
                            'type' => 'text',
                            'class' => 'form-control',
                            'label' => false,
                            'placeholder' => 'Add skill',
                            'data-role' => 'tagsinput'
                        ]); ?>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="form-label">Instruments you can play</label>
                    <div class="selectgroup selectgroup-pills">
                        <?php if (count($musicalInstruments)): ?>
                            <?php foreach ($musicalInstruments as $musicalInstrument): ?>
                                <?php
                                    $checked = null;
                                    if (! empty($musicMakerData->instruments_known)) {
                                        $userInstruments = (array ) (is_array($musicMakerData->instruments_known) ? 
                                            $musicMakerData->instruments_known : explode(',', $musicMakerData->instruments_known));
                                        foreach ($userInstruments as $instrument) {
                                            if ($musicalInstrument->slug === $instrument) {
                                                $checked = 'checked';
                                            }
                                        }
                                    }
                                ?>
                                <label for="instruments-known" class="selectgroup-item">
                                    <?= $this->Form->input(
                                            'instruments_known', 
                                            [
                                                'name' => 'instruments[]', 
                                                'type' => 'checkbox', 
                                                'value' => h($musicalInstrument->slug), 
                                                'class' => 'selectgroup-input', 
                                                'label' => false, 
                                                'hiddenField' => false, 
                                                'templates' => [
                                                    'inputContainer' => '{{content}}'
                                                ],
                                                $checked
                                            ]); ?>
                                    <span class="selectgroup-button"><?= h($musicalInstrument->name) ?></span>
                                </label>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
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