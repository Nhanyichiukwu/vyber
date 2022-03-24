<?php
/**
 *
 */
?>
<?php
$layout = $this->get('postsLayout');
if (empty($layout)) {
    $layout = $this->get('feedLayout');
}

if (!$this->elementExists('App/widgets/timeline-layouts/' . $layout)) {
    $layout = 'stack';
}

$this->set('timeline', $posts);
?>
<?= $this->element('App/widgets/timeline-layouts/' . $layout); ?>
