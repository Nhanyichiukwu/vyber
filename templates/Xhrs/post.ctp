<?php
if (!isset($feedLayout) || ! $this->elementExists('Widgets/TimelineLayouts/' . $feedLayout)):
    $feedLayout = 'grid';
endif;
?>
<?= $this->element('singletons/post/'. $feedLayout . '/post_singleton', ['post' => $post]); ?>

