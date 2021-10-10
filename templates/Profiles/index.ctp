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
<script>
<?php $this->Html->scriptStart(['block' => 'scriptBottom']); ?>
    
    PageLoader.beforeContentReady('<?= $page ?>', function(e) {
        // Do some stuff
        return true;
    });
    PageLoader.ajaxify({
        name: '<?= $page ?>', 
        target: '#<?= $page ?>',
        conditions: '',
        uri: '<?= '/profile/' . $uri . '?user=' . $account->getUsername() . '&_referer=' . urlencode($this->getRequest()->getAttribute('here')) . '&_accessKey=' . RandomString::generateString(16, 'mixed') ?>', page_id: ''
    });

<?php $this->Html->scriptEnd(); ?>