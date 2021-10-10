<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Connection $connection
 */

use App\Utility\Calculator;
use App\Utility\RandomString;
use Cake\Routing\Router;
use Cake\Utility\Text;

?>
<?php
$params = [
'user' => $user->get('refid')
];
$dataSrc = '/requests/connection?_dh=invitations';
?>
<div class="_Hc0qB9"
     data-load-type="r"
     data-src="<?= $dataSrc ?>"
     data-rfc="invitations"
     data-su="true"
     data-limit="24" data-r-ind="false">
    <?= $this->element('App/loading', ['size' => 'spinner-md']); ?>
</div>
