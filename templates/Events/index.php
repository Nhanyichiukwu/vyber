<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Routing\Router;
use Cake\Utility\Inflector;

?>
<?php if (isset($events) && count($events) > 0): ?>
    <div class="bg-white p-3 mb-2">
        <div class="row flex-wrap mb-3">
            <?php foreach ($events as $event): ?>
                <div class="col-md-4">
                    <div class="event">
                        <div class="card mwp7f1ov shadow-sm">
                            <div class="card-img card-img-top">
                                <?php
                                $imageSrc = 'static-bg/8rfjvIKstaOFCn?type=photo&role=event_poster&format=png&size=100x100';
                                if (!is_null($event->image)) {
                                    $imageSplit = explode('/', ltrim($event->image, '/'));

                                    $imageName = array_pop($imageSplit);
                                    $fileType = Inflector::singularize($imageSplit[0]);
                                    $imageName = substr($imageName, 0, strrpos($imageName, '.'));
                                    $imageName = str_replace(DS, '/', $imageName);
                                    $ext = substr($event->image, strrpos($event->image, '.') + 1);
                                    $imageSrc = $imageName . '?type=' . $fileType . '&role=event_poster&format=' . $ext . '&size=small';
                                }
                                ?>
                                <?= $this->Html->image(Router::url('/media/' . $imageSrc, true), []); ?>
                            </div>
                            <div class="card-body">
                                <div class="event-description"><?= h($event->description) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('first'), ['class' => 'bar']) ?>
                <?= $this->Paginator->prev('< ' . __('previous'), ['class' => 'barz']) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >', ['class' => 'foo']) ?>
                <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
        </div>
    </div>
<?php endif; ?>
<?php $this->extend('common'); ?>
