<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MusicIndustry $musicIndustry
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $musicIndustry->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $musicIndustry->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Music Industry'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="musicIndustry form large-9 medium-8 columns content">
    <?= $this->Form->create($musicIndustry) ?>
    <fieldset>
        <legend><?= __('Edit Music Industry') ?></legend>
        <?php
            echo $this->Form->control('user_refid');
            echo $this->Form->control('role_refid');
            echo $this->Form->control('stagename');
            echo $this->Form->control('user_entity_refid');
            echo $this->Form->control('genre_refid');
            echo $this->Form->control('music_category_refid');
            echo $this->Form->control('debute_year', ['empty' => true]);
            echo $this->Form->control('debute_album');
            echo $this->Form->control('debute_song');
            echo $this->Form->control('number_of_songs');
            echo $this->Form->control('number_of_videos');
            echo $this->Form->control('number_of_albums');
            echo $this->Form->control('number_of_features');
            echo $this->Form->control('skills');
            echo $this->Form->control('instruments_known');
            echo $this->Form->control('story');
            echo $this->Form->control('manager');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
