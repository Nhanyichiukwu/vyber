<?php
/**
 * 
 */
?>
<?php
if (! isset($feedLayout) || ! $this->elementExists('Widgets/TimelineLayouts/' . $feedLayout)):
    $feedLayout = 'grid';
endif;

$this->set('timeline', $posts);
?>
<?= $this->element('Widgets/TimelineLayouts/' . $feedLayout); ?>