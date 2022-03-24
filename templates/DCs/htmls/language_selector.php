<?php

/**
 * Language Selector
 *
 * @var \App\View\AppView $this;
 */


$request = $this->getRequest();
$fieldName = $request->getQuery('fn');
if (empty($fieldName)) {
    $fieldName = 'language';
}
if (strpos($fieldName, '.')) {

}
$css = isset($css) ? ' ' . $css : '';

echo $this->element('App/widgets/language_selector', [
    'fieldName' => $fieldName,
    'css' => $css
]);
