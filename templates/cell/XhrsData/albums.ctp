<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
use Cake\Routing\Router;
use App\Utility\RandomString;
use Cake\Utility\Text;
use Cake\Utility\Inflector;
?>

<?php $this->start('pagelet_top'); ?>
<div class="page-header">
    <h2 class="page-title text-muted-dark"><?= __('Albums') ?></h2>
</div>
<?php $this->end(); ?>

<div class="col-12">
    <div id="albums" class="ajaxify"
        data-name="albums"
        data-src="<?= '/profile/albums?user=' . $account->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed');  ?>"
        data-conditions='{"remove_if_no_content":"no","check_for_update":"no","auto_update":"no","use_data_prospect":"yes"}'
        >
    </div>
</div>
