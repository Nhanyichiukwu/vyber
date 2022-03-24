<?php

/*
 * Media Details Template
 *
 * Uses Element/Media/media_details.ctp
 */
use App\Utility\Calculator;


$tmpFileType = ($tmpFile['filetype'] === 'audio' ? 'song' : $tmpFile['filetype']);
?>

<div class="row">
    <div class="col-lg-12">
        <div class="main-title mb-3">
            <h2>Media Details</h2>
        </div>
    </div>
</div>
<div class="card shadow">
    <div class="card-body px-7">
        <div class="row">
            <div class="col-lg-3">
                <div id="media-preview">
            <?= $this->Html->media([
                    '/public-files/tmp/'.$activeUser->get('refid') . '/' .$tmpFile['name'],
                    [
                        'src' => '/public-files/tmp/'.$activeUser->get('refid') . '/' .substr($tmpFile['name'], 0, (strlen($tmpFile['name']) - 4) ) . '.ogg',
                        'type' => $tmpFile['filetype'] . "/ogg; codecs='theora, vorbis'"
                    ]],
                [
                    'controls' => 'controls',
                    'class' => 'w-100 rounded',
                    'text' => 'Unable to preview ' . $tmpFile['filetype'] . '!'
                ]
            ); ?>
                </div>
            </div>
            <div class="col-lg-9">
                <h4 id="media-title" class="osahan-title"><?= h($tmpFile['title']) ?></h4>
                <div class="osahan-size">Media Size: <?= Calculator::byteToMegabyte($tmpFile['size']); ?></div>
                <div id="upload-status" class="small text-muted">
                    <div class="float-right pull-right">
                <?= $this->Html->link(
                    __('<span class="mdi mdi-cancel"></span> Abort'),
                    ['action' => 'abort'],
                    [
                        'escapeTitle' => false,
                        'title' => 'Abort',
                        'class' => 'btn btn-outline-danger btn-sm rounded',
                        'confirm' => __('Are you sure you want to abort process?')
                    ]
                ); ?>
                    </div>
                    One more step, your <?= $tmpFileType ?> is not saved yet. Complete the form below to save it. Click 'Abort' to abort the process.</div>
            </div>
        </div>
    </div>
</div>
<div class="card shadow">
    <div class="card-body px-7">
        <div class="row">
            <div class="col-lg-12">
                <div class="osahan-form">
                <?= $this->Form->create($media, ['id' => 'media-detail-form', 'type' => 'file']); ?>
                <?= $this->Form->unlockField('media_details') ?>
                <?= $this->Form->unlockField('thumbnail') ?>
                <?= $this->Form->unlockField('title') ?>
                <?= $this->Form->unlockField('description') ?>
                <?= $this->Form->unlockField('release_date') ?>
                <?= $this->Form->unlockField('album') ?>
                <?= $this->Form->unlockField('playlist') ?>
                <?= $this->Form->unlockField('genre') ?>
                <?= $this->Form->unlockField('categories') ?>
                <?= $this->Form->unlockField('artist') ?>
                <?= $this->Form->unlockField('featured_artists') ?>
                <?= $this->Form->unlockField('privacy') ?>
                <?= $this->Form->unlockField('orientation') ?>
                <?= $this->Form->unlockField('monetize') ?>
                <?= $this->Form->unlockField('license') ?>
                <?= $this->Form->unlockField('tags') ?>
                <?= $this->Form->unlockField('cast') ?>
                <?= $this->Form->unlockField('language') ?>
                <?= $this->Form->unlockField('data-referrer') ?>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="title">Title</label>
                                <input type="text" name="title" placeholder="Title" id="title" class="form-control">
                                <p><small class="text-muted">What is the title of the song/video?</small></p>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="description">About</label>
                                <textarea rows="3" id="description" name="description" class="form-control"></textarea>
                                <p><small class="text-muted">Tell your viewers about this song or video</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2 mx-0">
                        <div class="d-none">
                            <input type="hidden" name="media_details" value="1">
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input type="file" name="thumbnail" id="thumbnail" class="custom-file-input">
                                <label for="thumbnail" class="custom-file-label">Cover Image</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="artist">Artist</label>
                                <input name="artist" type="text" id="artist" class="form-control" placeholder="Artist">
                                <p class="small text-muted">What is the name of the artist? Enter the name which the artist is popularly known with. Leave it blank if you are the artist...</p>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <label class="form-label" for="featured-artists">Featured Artists</label>
                                <input type="text" id="featured-artists" name="featured_artists" class="form-control input-tags" placeholder="Featured Artists">
                                <p class="small text-muted">Which artists were featured in this song/video? Seperate different names with comma.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" class="form-label" for="album">Counterpart (Optional)</label>
                                <input type="hidden" name="counterpart" value="">
                                <p class="small text-muted">The audio/video version of this video or audio</p>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" class="form-label" for="album">Album (Optional)</label>
                                <input type="hidden" name="album" value="">
                                <select id="album" name="album" class="custom-select">
                                    <option>Choose Album</option>
                        <?php if (count($albums)): ?>
                            <?php foreach ($albums as $album): ?>
                                    <option value="<?= h($album->ref_id); ?>"><?= h($album->title); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="playlist">Playlist (Optional)</label>
                                <select id="playlist" name="playlist" class="custom-select">
                                    <option>Add to playlist</option>
                        <?php if (count($playlists)): ?>
                            <?php foreach ($playlists as $playlist): ?>
                                    <option value="<?= h($playlist->ref_id); ?>"><?= h($playlist->title); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                                </select>
                            <p class="small text-muted">Would you like to add this song/video to a playlist?</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-lg-3">
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
                        <div class="col-lg-3">
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
                        <div class="col-lg-3">
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
                        <div class="col-lg-3">
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
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label" for="tags">Tags (13 Tags Remaining)</label>
                                <input type="text" name="tags" placeholder="Start typing..." id="tags" class="form-control input-tags" value="" data-role="tagsinput">
                                <p><small class="text-muted">Tags make it easy for your song/video to appear in search result when people search for similar songs/videos or artist</small></p>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label" for="cast">Cast (Optional)</label>
                                <input type="text" placeholder="Michael Johnson,Jack Robbinson,Joles" id="cast" name="cast" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
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

                    <div class="row mb-2">
                        <div class="col-lg-6">
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
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="content-definition">Content Definition</label>
                            <?= $this->Form->select('content_definition',
                                    $contentDefinitions,
                                    [
                                        'class' => 'form-control custom-select',
                                        'label' => false
                                    ]
                                ); ?>
                            </div>
                        </div>
                        <div class="col-lg-3">
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
                    </div>
                    <div class="row category-checkbox">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h6>Genre</h6>
                            </div>
                        </div>
                        <!-- checkbox 1col -->
                        <input type="hidden" name="genre" value="">
                <?php if (count($genres)): ?>
                    <?php foreach ($genres as $genreGroup): ?>
                        <div class="col-lg-2 col-xs-6 col-4">

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
                                    <input type="radio" name="genre" value="<?= h($genre->refid); ?>" class="custom-control-input">
                                    <div class="custom-control-label"><?= h($genre->name); ?></div>
                                </label>
                        <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                    </div>
                    <hr>
                    <div class="row category-checkbox">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h6>Category ( you can select upto 6 categories )</h6>
                            </div>
                        </div>

                        <input type="hidden" name="categories" value="">
                        <?php if (count($categories)): ?>
                            <?php foreach ($categories as $categoriesGroup): ?>
                                <div class="col-lg-2 col-xs-6 col-4">
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
                    <div class="row">
                        <div class="col-md-3 col-lg-3">
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
            <?= $this->Form->end(['upload']); ?>
                </div>
            </div>
        </div>
    </div>
    <footer class="card-footer bgc-grey-200">
        <div class="terms text-center">
            <p class="mb-0">To learn about our <a href="#">Terms of Service</a> and <a href="#">Community Guidelines</a>.</p>
            <p class="hidden-xs mb-0">Ipsum is therefore always free from repetition, injected humour, or non</p>
        </div>
    </footer>
</div>
