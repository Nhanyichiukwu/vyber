<?php
/**
 * @var AppView $this
 */

use App\Utility\AjaxMaskedRoutes;
use App\View\AppView;
use Cake\Routing\Router;
?>
<div class="feed mx-n3 pt-2 pt-md-3 px-lg-5 px-md-3">
    <?php $this->element('App/widgets/Forms/plain_post_form', ['postEndPoint' => Router::url(['controller' =>
        'posts','action' =>
        'new_post'], true)]); ?>
    <div class="h-auto">
        <?php
        $params = json_encode([
            'resource_handle' => 'threads',
            'resource_path' => 'posts/threads'
        ]);
        $token = base64_encode(serialize($params));
        $routeMask = AjaxMaskedRoutes::getRouteMaskFor('Newsfeed');
        $dataSrc = '/' . $routeMask . '/posts?cw_fdr=basic_threads&cw_ftr=relevance&token=' 
                . $token . '&cw_uid=' . $appUser->get('refid');
        $fetchTimeline = json_encode([
            'content' => 'timeline',
            'src' => $dataSrc,
            'remove_if_no_content' => 'no',
            'check_for_update' => 'yes',
            'auto_update' => 'no',
            'use_data_prospect' => 'yes',
            'load_type' => 'overwrite',
        ]);
        ?>
        <div data-request-type="async"
             class="ajaxify"
             data-category="main_content"
             data-config='<?= $fetchTimeline ?>'>
            <?= $this->element('App/loading', ['size' => 'spinner-md']); ?>
        </div>
        <!--<div class="_Hc0qB9"
             data-load-type="r"
             data-src="<?/*= $dataSrc */?>"
             data-rfc="timeline"
             data-su="true"
             data-limit="24" data-r-ind="false">
            <?/*= $this->element('App/loading', ['size' => 'spinner-md']); */?>
        </div>-->
    </div>
</div>

<?php $this->start('sidebar'); ?>

<?php $this->end(); ?>
