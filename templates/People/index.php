<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Routing\Router;
use Cake\Utility\Inflector;

$options = [
    'layout' => 'users_grid',
    'colSize' => 6
];
$this->set('options', $options);
$this->pageTitle('People');
?>
<?php if (!$this->getRequest()->is('ajax')): ?>
<?php $this->enablePageHeader(); ?>
<?php endif; ?>

<?php if ($this->getRequest()->is('ajax')): ?>
    <?php if (isset($categories)): ?>
        <div class="content bg-light py-3">
            <div class="users-list">
                <?php foreach ($categories as $category => $people): ?>
                    <?php if (count($people)): ?>
                        <header class="section-header mt-5 mb-3">
                            <h4 class="section-title mb-0"><?= ucwords(Inflector::delimit($category, ' ')) ?></h4>
                        </header>
                        <?= $this->element( 'Users/flex_row', ['users' => $people]); ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="">No suggestions right now.</div>
    <?php endif; ?>
<?php
else:
    $params = json_encode([
        'resource_handle' => 'categories',
        'resource_path' => 'Explore/people',
    ]);
    $token = base64_encode(
        serialize($params)
    );
    $dataSrces = '/suggestion?token=' . $token;
?>
<div class="_Hc0qB9"
     data-load-type="r"
     data-src="<?= $dataSrces ?>"
     data-rfc="people"
     data-su="true"
     data-limit="24"
     data-r-ind="false">
    <?= $this->element('App/loading'); ?>
</div>
<?php endif; ?>
