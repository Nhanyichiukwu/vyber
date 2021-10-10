<?php

/**
 * @var \App\View\AppView $this
 */
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use App\Utility\RandomString;
use Cake\Utility\Security;
?>

<?php
$section = $this->Url->request->getQuery('section');
if (!$section) {
    $section = 'default';
}
?>
<?php $this->start('pagelet_to'); ?>
    <h3 class="page-title">
        <?php if ($this->get('activeUser') && $account->isSameAs($activeUser)): ?>
        <?= __('My Events'); ?>
        <?php else: ?>
        <?= __('{firstname}\'s Events', ['firstname' => $account->getFirstName()]); ?>
        <?php endif; ?>
    </h3>
<?php $this->end(); ?>
<div class="events">
    <div class="row gutters-sm">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-list-group">
                    <div class="list-group-item list-group-item-action">
                        <?= $this->Html->link(__('My Events'), '/' . $account->getUsername() . '/events', ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($section === 'default'? ' active':'')]) ?></div>
                    <div class="list-group-item list-group-item-action">
                        <?= $this->Html->link(__('Invites'), '/' . $account->getUsername() . '/events/invites', ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($section === 'sent_requests'? ' active':'')]) ?></div>
                    <div class="list-group-item list-group-item-action">
                        <?= $this->Html->link(__('Upcoming'), '/' . $account->getUsername() . '/events/upcoming', ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($section === 'pending'? ' active':'')]) ?></div>
                    <div class="list-group-item list-group-item-action">
                        <?= $this->Html->link(__('Recent'), '/' . $account->getUsername() . '/events/recent', ['class' => 'nav-link border-top-0 border-right-0 border-left-0' . ($section === 'pending'? ' active':'')]) ?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
        <?php if (isset($events)): ?>
            <div class="row">
            <?php foreach ($events as $event): ?>
                <div class="col-md-6 col-lg-6">
                    <?php
                        $dataSrc = 'event/'.$event->get('refid') . '?token=' . base64_encode(Security::randomString() . '_'. time());
                        $randID = Security::randomString(6);
                    ?>
                    <div class="_kG2vdB _Hc0qB9" data-load-type="r" data-src="<?= $dataSrc ?>" data-rfc="event<?= $randID ?>" data-su="false" data-limit="1" data-r-ind="false" id="event<?= $randID ?>"></div>
                </div>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
        </div>
    </div>
</div>

