<?php
$spinnerSize = $size ?? 'spinner-border-sm';
?>
<div class="loading d-flex justify-content-center align-items-center <?= $modifier ?? '' ?>">
    <div class="spinner spinner-border <?= $spinnerSize ?> text-azure"></div>
</div>
