<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Video $video
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Videos'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="videos form large-9 medium-8 columns content">
    <?= $this->Form->create($video) ?>
    <fieldset>
        <legend><?= __('Add Video') ?></legend>
        <?php
            echo $this->Form->control('refid');
            echo $this->Form->control('title');
            echo $this->Form->control('slug');
            echo $this->Form->control('description');
            echo $this->Form->control('cast');
            echo $this->Form->control('tags');
            echo $this->Form->control('privacy');
            echo $this->Form->control('author_location');
            echo $this->Form->control('url');
            echo $this->Form->control('media_type');
            echo $this->Form->control('author_refid');
            echo $this->Form->control('song_refid');
            echo $this->Form->control('album_refid');
            echo $this->Form->control('genre_refid');
            echo $this->Form->control('category_refid');
            echo $this->Form->control('release_date', ['empty' => true]);
            echo $this->Form->control('is_debute');
            echo $this->Form->control('monetize');
            echo $this->Form->control('total_plays');
            echo $this->Form->control('number_of_people_played');
            echo $this->Form->control('number_of_downloads');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
