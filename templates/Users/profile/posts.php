<?php

/**
 *
 */
use Cake\Utility\Security;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use App\Utility\RandomString;
use Cake\Routing\Router;

//$counter = $this->cell('Counter::posts', ['byAuthor', $this->get('account')->get('refid')]);
$postsCount = (int) $this->cell('Counter::count', [
    'posts', ['byAuthor', $account->get('refid')]
])->render();

$this->extend('common');
?>
<?php
if (
    !isset($feedLayout) ||
    !$this->elementExists('App/widgets/timeline-layouts/' . $feedLayout)
) {
    $feedLayout = 'stack';
}
?>
<div class="py-3 mx-n3">
    <?php if ($this->get('user')): ?>
        <!--<div class="y4QfaxPv">
            <div class="card">
                <div class="card-body">
                    <?php /*$this->element('App/widgets/content_creator', [
                        'publisherType' => 'publisher-large db-basic-publisher'
                    ]); */?>
                </div>
            </div>
        </div>-->
    <?php endif; ?>
    <?php if ($postsCount > 0): ?>
        <div id="posts" class="_RrFC43">
            <?php
            $params = json_encode([
                'resource_handle' => 'posts', // The name of the variable
                // containing the data to be passed to the view

                'resource_path' => 'profile/posts' // The path to the template use in rendering the data
            ]);
            $token = base64_encode(serialize($params));
            $dataSrc = '/posts_by_user?token=' . $token . '&tbuid='
                . $account->get('refid');
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
    <?php else: ?>

        <?php
//                $suggestedReading = $this->cell('Suggestions::suggestedPosts');
//                echo $suggestedReading->render();
        ?>
    <?php endif; ?>
</div>
<!--<script>-->
<?php $this->Html->scriptStart(['block' => 'scriptBottom']); ?>

<?php $this->Html->scriptEnd(); ?>
