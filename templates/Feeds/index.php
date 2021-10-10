<?php
/**
 * @var App\View\AppView $this
 */

use Cake\Utility\Security as Security;
use Cake\Routing\Router;
use App\Utility\RandomString;
?>
<div class="feed">
    <?php $this->element('Widgets/post_editor', ['postEndPoint' => Router::url(['controller' => 'posts','action' => 'new_post'], true)]); ?>
    <div class="position-relative">
        <div class="h-auto">
            <?php
            $params = json_encode([
                'resource_handle' => 'timeline',
                'resource_path' => 'timeline'
            ]);
            $token = base64_encode(serialize($params));
            $dataSrc = '/timeline?token=' . $token . '&tbuid=' . $user->get('refid');
            ?>
            <div class="_Hc0qB9"
                 data-load-type="r"
                 data-src="<?= $dataSrc ?>"
                 data-rfc="timeline"
                 data-su="true"
                 data-limit="24" data-r-ind="false">
                <?= $this->element('App/loading', ['size' => 'spinner-md']); ?>
            </div>
        </div>
    </div>
</div>

<?php $this->end(); ?>

