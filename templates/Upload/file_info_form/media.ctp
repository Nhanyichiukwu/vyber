<?php ?>
<div class="audio-file file-info-form px-5">
    <?= $this->Form->create(null, ['type' => 'file', 'id' => 'file-detail-form']); ?>
    <div class="row">
        <div class="col-8">
            <div class="section-header">
                <h3 class="section-title">Details</h3>
            </div>
            <div class="form-group">
                <?= $this->Form->input('title', [
                    'class' => 'form-control form-control-lg',
                    'label' => false,
                    'placeholder' => 'Title'
                ]); ?>
                <p><small class="text-muted">What is the title of the song/video?</small></p>
            </div>
            <div class="form-group">
                <?= $this->Form->input('description', [
                    'type' => 'textarea',
                    'class' => 'form-control',
                    'label' => false,
                    'placeholder' => 'Description'
                ]); ?>
                <p><small class="text-muted">Tell your viewers about this song or video</small></p>
            </div>
            <div class="form-group pos-r">
                <label class="form-label" for="thumbnail">Set Thumbnail</label>
                <p class="small text-muted">Thumbnails sends a clear message to your viewers with a clue of what your <?= $fileType ?> is about, and also help persuade people to view/listen to it.</p>
                <div class="form-row">
                    <div class="col-3">
                        <label for="custom-thumbnail" class="bgcH-grey-100 border h-100 image-picker rounded mb-0 bd-dotted bdsz-2">
                            <input type="file" name="custom_thumbnail" id="custom-thumbnail" class="custom-file-input">
                        </label>
                    </div>
                    <div class="col-3">
                        <label class="imagecheck">
                            <input name="thumbnail" type="radio" value="3" class="imagecheck-input">
                            <figure class="imagecheck-figure">
                                <img src="/img/nicolas-picard-208276-500.jpg" alt="}" class="imagecheck-image">
                            </figure>
                        </label>
                    </div>
                    <div class="col-3">
                        <label class="imagecheck">
                            <input name="thumbnail" type="radio" value="3" class="imagecheck-input">
                            <figure class="imagecheck-figure">
                                <img src="/img/nicolas-picard-208276-500.jpg" alt="}" class="imagecheck-image">
                            </figure>
                        </label>
                    </div>
                    <div class="col-3">
                        <label class="imagecheck">
                            <input name="thumbnail" type="radio" value="3" class="imagecheck-input">
                            <figure class="imagecheck-figure">
                                <img src="/img/nicolas-picard-208276-500.jpg" alt="}" class="imagecheck-image">
                            </figure>
                        </label>
                    </div>
                </div>
                
            </div>
            <div class="form-group">
                <label class="form-label" for="artist">Artist</label>
                <input name="artist" type="text" id="artist" class="form-control" placeholder="Artist">
                <p class="small text-muted">What is the name of the artist? Enter the name which the artist is popularly known with. Leave it blank if you are the artist...</p>
            </div>
            <div class="form-group">
                <label class="form-label" for="featured-artists">Featured Artists</label>
                <input type="text" id="featured-artists" name="featured_artists" class="form-control input-tags" placeholder="Featured Artists">
                <p class="small text-muted">Which artists were featured in this song/video? Seperate different names with comma.</p>
            </div>
        </div>
        <div class="sidebar sidebar-md pl-4 col-4">
                <?= $this->element('sidebar/upload/file_detail_sidebar'); ?>
        </div>
    </div>
    <hr class="border-bottom my-3">
    <div class="row mb-2">
        <div class="col-12">
            <div class="section-header">
                <h3 class="section-title">Content Distribution</h3>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label class="form-label" class="form-label" for="album">Counterpart (Optional)</label>
                <div class="input-with-ajax-search">
                    <input type="text" name="counterpart" placeholder="Start typing..." class="form-control">
                    <div class="ajax-search-result"></div>
                </div>
                <p class="small text-muted">The audio/video version of this video/audio</p>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label class="form-label" class="form-label" for="album">Album (Optional)</label>
                <div class="input-with-ajax-search">
                    <input type="text" name="album" placeholder="Start typing..." class="form-control">
                    <div class="ajax-search-result"></div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label class="form-label" for="playlists">Playlists (Optional)</label>
                <div class="input-with-ajax-search">
                    <input type="text" name="playlists" id="playlists" placeholder="Start typing..." class="form-control">
                    <div class="ajax-search-result"></div>
                </div>
                <p class="small text-muted">Would you like to add this song/video to a playlist?</p>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label class="form-label" for="tags">Tags (13 Tags Remaining)</label>
                <input type="text" name="tags" placeholder="Start typing..." id="tags" class="form-control input-tags" value="" data-role="tagsinput">
                <p><small class="text-muted">Tags make it easy for your song/video to appear in search result when people search for similar songs/videos or artist</small></p>
            </div>
        </div>
        <div class="col-5">
            <div class="form-group">
                <label class="form-label" for="cast">Cast (Optional)</label>
                <textarea type="text" placeholder="Michael Johnson,Jack Robbinson,Joles" id="cast" name="cast" class="form-control"></textarea>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="form-label" for="content-classification">Content Classification</label>
                <?= $this->Form->select('content_classification',
                        $contentClassification,
                        [
                            'class' => 'form-control custom-select',
                            'label' => false
                        ]
                    ); ?>
            </div>
        </div>
    </div>
    <div class="row category-checkbox mb-4">
        <div class="col-12">
            <div class="main-title">
                <h6>Genre</h6>
            </div>
        </div>
        <!-- checkbox 1col -->
        <input type="hidden" name="genre" value="">
        <?php if (count($genres)): ?>
            <?php foreach ($genres as $genreGroup): ?>
        <div class="col-4">

            <!--                        <div class="selectgroup selectgroup-pills">
            <?php foreach ($genreGroup as $genre): ?>
                      <label class="selectgroup-item">
                        <input type="radio" name="genre" value="<?= h($genre->get('refid')); ?>" class="selectgroup-input">
                        <span class="selectgroup-button selectgroup-button-icon"><?= h($genre->get('name')); ?></span>
                      </label>
            <?php endforeach; ?>
                                    </div>-->

            <div class="custom-controls-stacked">
            <?php foreach ($genreGroup as $genre): ?>
                <label class="custom-control custom-radio no-before no-after">
                    <input type="radio" name="genre" value="<?= h($genre->get('refid')); ?>" class="custom-control-input">
                    <div class="custom-control-label"><?= h($genre->get('name')); ?></div>
                </label>
            <?php endforeach; ?>
            </div>
        </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="row category-checkbox mb-4">
        <div class="col-12">
            <div class="main-title">
                <h6>Category ( you can select upto 6 categories )</h6>
            </div>
        </div>

        <input type="hidden" name="categories" value="">
    <?php if (count($categories)): ?>
        <?php foreach ($categories as $categoriesGroup): ?>
        <div class="col-4">
            <div class="custom-controls-stacked">
                <?php foreach ($categoriesGroup as $category): ?>
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" name="categories[]" class="custom-control-input" value="<?= h($category->get('slug')); ?>">
                    <span class="custom-control-label"><?= ucfirst(h($category->get('name'))); ?></span>
                </label>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
    </div>
    <hr class="border-bottom my-4">
    <div class="row">
        <div class="col-12">
            <div class="section-header">
                <h3 class="section-title">Audience <span class="small text-muted">Control who sees your media</span></h3>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="form-label" for="target-audience">Who is this <?= $fileType ?> made for?</label>
                <?php foreach (['Kids','Adults','Both'] as $index => $value): ?>
                <label class="custom-control custom-radio custom-control-inline no-before no-after">
                    <input type="radio" name="target_audience" value="<?= strtolower(h($value)); ?>" class="custom-control-input">
                    <div class="custom-control-label"><?= h($value); ?></div>
                </label>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label class="form-label" for="age-restriction">Age Restriction</label>
                <?= $this->Form->select('age_restriction',
                    $ageRanges,
                    [
                        'class' => 'form-control custom-select',
                        'label' => false
                    ]
                ); ?>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="form-label" for="privacy">Privacy Settings</label>
                <select id="privacy" name="privacy" class="custom-select">
                    <?php if (isset($userSettings) && $userSettings->content_privacy): ?>
                    <option value="<?= strtolower(h($userSettings->content_privacy)); ?>" selected><?= ucfirst(h($userSettings->content_privacy)); ?></option>
                    <?php endif; ?>
                    <?php if (count($privacyOptions)): ?>
                        <?php foreach ($privacyOptions as $privacyOption): ?>
                            <?php /* Skip the option if it is already defined in the user settings option*/ ?>
                            <?php  if (isset($userSettings) && $privacyOption === $userSettings->content_privacy) continue; ?>
                            <option value="<?= h($privacyOption); ?>"><?= ucfirst(h($privacyOption)); ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <p class="small text-muted">Control who sees your contents</p>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="form-label" for="geotargetting">Geotargetting</label>
                <select id="geotargetting" name="geotargetting" class="custom-select">
                    <?php if (isset($userSettings) && $userSettings->content_privacy): ?>
                    <option value="<?= strtolower(h($userSettings->content_privacy)); ?>" selected><?= ucfirst(h($userSettings->content_privacy)); ?></option>
                    <?php endif; ?>
                    <?php if (count($privacyOptions)): ?>
                        <?php foreach ($privacyOptions as $privacyOption): ?>
                            <?php /* Skip the option if it is already defined in the user settings option*/ ?>
                            <?php  if (isset($userSettings) && $privacyOption === $userSettings->content_privacy) continue; ?>
                            <option value="<?= h($privacyOption); ?>"><?= ucfirst(h($privacyOption)); ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <p class="small text-muted">Control who sees your contents</p>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="form-label" for="language">Language (Optional)</label>
                <?= $this->Form->select(
                    'language',
                    $languages,
                    [
                        'type' => 'select',
                        'class' => 'custom-select'
                    ]
                ); ?>
            </div>
        </div>
    </div>
    <div class="section-header">
        <h3 class="section-title" data-toggle="collapse" data-target="#more-options">
            More Options <i class="icon mdi mdi-chevron-down mdi-24px"></i>
        </h3>
    </div>
    <div id="more-options" class="row mb-4 collapse collapsable">
        <div class="col-6">
            <div class="form-group">
                <label class="form-label" for="recording-date">Recording Date</label>
                <?= $this->Form->control('recording_date', 
                    [
                        'type' => 'date', 
                        'label' => false,
                        'year' => ['class' => 'custom-select col-sm-5 mr-3'],
                        'month' => ['class' => 'custom-select col-sm-4 mr-3'],
                        'day' => ['class' => 'custom-select col-sm-2']
                    ]
                ); ?>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="form-label" for="release-date">Release Date</label>
                <?= $this->Form->control('release_date', 
                    [
                        'type' => 'date', 
                        'label' => false,
                        'year' => ['class' => 'custom-select col-sm-5 mr-3'],
                        'month' => ['class' => 'custom-select col-sm-4 mr-3'],
                        'day' => ['class' => 'custom-select col-sm-2']
                    ]
                ); ?>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="form-label" class="form-label" for="orientation">Orientation</label>
                <?= $this->Form->select(
                    'orientation',
                    $validOrientations,
                    [
                        'label' => false,
                        'class' => 'custom-select'
                    ]
                ); ?>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <input type="hidden" name="monetize" value="0">
                <label class="form-label" for="monetize">Monetize</label>
                <?php if (count($monetizationOptions)): ?>
                    <?php foreach ($monetizationOptions as $index => $value): ?>
                    <label class="custom-control custom-radio custom-control-inline no-before no-after">
                        <input type="radio" name="monetize" value="<?= h($index); ?>" class="custom-control-input">
                        <div class="custom-control-label"><?= h($value); ?></div>
                    </label>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="form-label" for="license">License</label>
                <select id="license" name="license" class="custom-select">
                    <option>Choose a license</option>
                        <?php if (count($licenseOptions)): ?>
                            <?php foreach ($licenseOptions as $licenseOption): ?>
                    <option value="<?= h($licenseOption); ?>"><?= ucfirst(h($licenseOption)); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                </select>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="form-label" for="age-restriction">Status</label>
                <?= $this->Form->select(
                    'status',
                    $statusList,
                    [
                        'label' => false,
                        'class' => 'custom-select'
                    ]
                ); ?>
            </div>
        </div>
    </div>
    <div class="osahan-area text-center mt-3">
        <button type="submit" name="save_media" class="btn btn-outline-primary">Save Changes</button>
    </div>
    <?= $this->Form->end(['Upload']); ?>
</div>

