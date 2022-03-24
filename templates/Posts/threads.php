<?php

/**
 * @var App\View\AppView $this
 */

$feedLayout = $this->getRequest()->getCookie('timeline_layout') ?? 'stack';
echo $this->element('App/widgets/timeline-layouts/' . $feedLayout);
