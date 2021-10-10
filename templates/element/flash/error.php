<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
    <?= $message ?>
    <button type="button" class="close btn btn-sm" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
