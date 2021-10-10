<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Media $media
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $media->refid],
                ['confirm' => __('Are you sure you want to delete # {0}?', $media->refid)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Medias'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="medias form large-9 medium-8 columns content">
    <?= $this->Form->create($media) ?>
    <fieldset>
        <legend><?= __('Edit Media') ?></legend>
        <?php
            echo $this->Form->control('id');
            echo $this->Form->control('title');
            echo $this->Form->control('slug');
            echo $this->Form->control('description');
            echo $this->Form->control('cast');
            echo $this->Form->control('tags');
            echo $this->Form->control('author_refid');
            echo $this->Form->control('genre_refid');
            echo $this->Form->control('album_refid');
            echo $this->Form->control('author_location');
            echo $this->Form->control('file_path');
            echo $this->Form->control('file_mime');
            echo $this->Form->control('media_type');
            echo $this->Form->control('classification');
            echo $this->Form->control('target_audience');
            echo $this->Form->control('audience_locations');
            echo $this->Form->control('age_restriction');
            echo $this->Form->control('audio_or_video_counterpart_refid');
            echo $this->Form->control('recording_date', ['empty' => true]);
            echo $this->Form->control('release_date', ['empty' => true]);
            echo $this->Form->control('privacy');
            echo $this->Form->control('status');
            echo $this->Form->control('is_debut');
            echo $this->Form->control('monetize');
            echo $this->Form->control('language');
            echo $this->Form->control('orientation');
            echo $this->Form->control('thumbnail');
            echo $this->Form->control('total_plays');
            echo $this->Form->control('number_of_people_played');
            echo $this->Form->control('number_of_downloads');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
