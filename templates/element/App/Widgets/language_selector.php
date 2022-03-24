<?php

/**
 * Language Selector
 * @var \App\View\AppView $this;
 */

if (!isset($fieldName)) {
    $fieldName = 'language';
}
if (stripos($fieldName, '_')) {
    $fieldName = str_replace('_', '.', $fieldName);
}
$languageField = $fieldName . '.language';
$proficiencyField = $fieldName . '.proficiency';
$css = isset($css) ? ' ' . $css : '';
$removable = isset($removable) ? $removable : true;
$languages = [
    '' => 'Language',
    'chinese' => 'Chinese',
    'english' => 'English',
    'french' => 'French',
    'igbo' => 'Igbo',
    'japanese' => 'Japanese',
];
$languageProficiencies = [
    '' => 'Proficiency',
    'native-speaker' => 'Native Speaker',
];
$defaultLang = $this->get('defaultLang');
?>
<div class="language-selector mb-2<?= $css ?>">
    <div class="row align-items-center">
        <div class="col">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-2 mb-md-0">
                        <?= $this->Form
                            ->select($languageField,
                                $languages,
                                [
                                    'label' => false,
                                    'class' => 'form-select form-select-sm neh5467l',
                                    'required' => 'required',
                                ]); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-2 mb-md-0">
                        <?= $this->Form
                            ->select($proficiencyField,
                                $languageProficiencies,
                                [
                                    'label' => false,
                                    'class' => 'form-select form-select-sm neh5467l',
                                    'required' => 'required',
                                ]); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($removable): ?>
        <div class="col-auto">
            <button class="btn btn-icon btn-sm" type="button"
                    data-action="remove-object"
                    aria-controls=".language-selector">
                <span class="icofont-2x icofont-close-line"></span>
            </button>
        </div>
        <?php endif; ?>
    </div>
</div>
