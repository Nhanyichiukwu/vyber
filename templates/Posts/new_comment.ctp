<?php

/**
 * This is a template for a new comment, rendered instantly upon successful 
 * comment creation
 * This template is only useful when the requested response type set in the
 * HTTP Header accept is not defined or is set to 'text/html'
 * But where the response type is json, the empty version in the /json directory
 * will be used instead
 */

?>
<?php if (isset($comment, $rootThread)): ?>
    <li class="_cxXFxo _aQtRd7eh"><?= $this->PostHtml->beautifyComment($comment, $rootThread); ?></li>
<?php endif; ?>