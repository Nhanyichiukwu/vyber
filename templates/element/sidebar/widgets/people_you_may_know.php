<?php

/*
 * Widget for People You May know
 */
use App\Utility\RandomString;
use Cake\Routing\Router;
?>
<!--<div class="card">
    <div class="card-body">
        <h6 class="card-title"><?/*= __('People You May Know') */?></h6>
        <div class="ajaxify"
             data-name="familiar_users"
             data-src="<?/*= '/suggestions/familiar_users?actor=' . $activeUser->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed');  */?>"
             data-conditions='{"remove_if_no_content":"no","check_for_update":"yes","auto_update":"yes","use_data_prospect":"yes"}'
            >
        </div>
    </div>
</div>-->

<?php if ((int) $this->cell('Counter::count', [
        'people_you_may_know', [$appUser]
    ])->render() > 0): ?>
    <div id="peopleYouMayKnow" class="card mwp7f1ov">
        <div class="card-body p-3">
            <h6 class="card-title">People You May Know</h6>
            <?php
            $params = json_encode([
                'resource_handle' => 'suggestions',
                'resource_path' => '/Suggestions/people_you_may_know'
            ]);
            $token = base64_encode(serialize($params));
            $pymk = json_encode([
                'content' => 'possible_acquaintances',
                'src' => '/suggestion?what=people&type=people_you_may_know&token='
                    . $token .'&_referer='
                    . urlencode($this->getRequest()->getAttribute('here'))
                    . '&_accessKey=' . RandomString::generateString(16, 'mixed'),
                'remove_if_no_content' => 'no',
                'check_for_update' => 'yes',
                'auto_update' => 'yes',
                'use_data_prospect' => 'yes',
                'load_type' => 'overwrite',
            ]);
            ?>
            <div data-load-type="async"
                 class="ajaxify"
                 data-category="widget"
                 data-config='<?= $pymk ?>'></div>
        </div>
    </div>
<?php endif; ?>
