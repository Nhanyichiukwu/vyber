<?php

use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\Routing\Router;
use App\Utility\RandomString;
use Cake\Utility\Text;
?>
<div class="col-12">
    <div id="connections"  
         class="ajaxify"
         data-name="connections"
         data-src="<?= '/profile/connections?user=' . $account->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed');  ?>"
         data-conditions='{"remove_if_no_content":"no","check_for_update":"no","auto_update":"no","use_data_prospect":"yes"}'
         >
    </div>
</div>