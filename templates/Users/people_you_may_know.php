<?php
/**
 * @var \App\View\AppView $this ;
 */

use Cake\ORM\ResultSet;
use Cake\Routing\Router;
use Cake\Utility\Text;
?>

<?php if (!isset($users) || empty($users)): ?>
    <?= $this->contentUnavailable($content); ?>
<?php elseif ($users instanceOf ResultSet && $users->count() > 0): ?>
    <div class="flex-nowrap flex-row foa3ulpk mgriukcz n1ft4jmn ofx-auto pl-3 row tvdg2pcc">
    <?php foreach ($users as $user): ?>
        <div class="col-5 col-md-2 col-sm-3 col-xxl-1 muilk3da">
            <?= $this->element('Users/users_circles', ['user' => $user]); ?>
        </div>
    <?php endforeach; ?>
    </div>
<?php elseif (is_string($users)): ?>
    <?= $users; ?>
<?php endif; ?>
