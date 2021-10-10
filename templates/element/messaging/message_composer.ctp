<?php

/**
 * 
 */
?>
<div class="col bg-white py-3">
    <div id="message-composer" class="input-icon">
        <div class="border rounded-pill pr-8">
            <div id="textbox" contenteditable="true" spellcheck="true" class="bdrs-bl-20 bdrs-tl-20 form-control form-control-lg form-control-plaintext no-focus ofy-auto px-4 rounded-0 h_I4Py lh_Ut7" data-placeholder="Say Hello..." data-sender="<?= $activeUser->get('refid'); ?>"></div>
        </div>
        <span class="input-icon-addon p-e_All">
            <button type="button" class="btn btn-azure rounded-circle w_yHVB h_yHVB" type="button"><i class="mdi mdi-send"></i></button>
        </span>
    </div>
</div>

