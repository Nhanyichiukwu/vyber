<?php

/*
 * Widget for Due Events
 */
use App\Utility\RandomString;
use Cake\Routing\Router;
?>
<div class="card">
    <div class="card-body">
        <h6 class="card-title"><?= __('Trending Movies') ?></h6>
        <div class="segment sTn"
             data-name="trending_movies"
             data-src="<?= Router::url('/xhrs/fetch_segment/trending_movies?actor=' . $activeUser->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed'));  ?>"
             data-conditions='{"remove_if_no_content":"no","check_for_update":"yes","auto_update":"yes","use_data_prospect":"yes"}'
            >
        </div>
    </div>
</div>