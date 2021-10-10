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
<?php if (isset($invitations) && count($invitations)): ?>
    <div class="px-3">
        <ul class="invitations list-group list-group-flush mgcdl4bc mgriukcz">
            <?php foreach ($invitations as $invitation): ?>
                <?php
                // $this->element('Connections/singleton', $connection);

                    $status = ' unread';
                    if ((int) $invitation->is_read === 1) {
                        $status = ' read';
                    }
                ?>
                <li class="invitation list-group-item notification bgcH-grey-100
                 c-grey-800 cH-blue p-3 text-decoration-none<?= $status ?>">
                    <div class="gutters-xs row"
                         data-role="link"
                         data-action="linkify"
                         data-toggle="page"
                         data-page-id="<?= RandomString::generateString(32, 'mixed', 'alpha') ?>"
                         data-page-title="<?= $invitation->sender->getFirstname() ?>'s invitation"
                         data-url="<?= Router::url([
                             'controller' => 'MyNetwork',//$invitation->type,
                             'action' => 'invitations',
                             $invitation->refid
                         ], true) ?>">
                        <a href="<?= Router::url([
                            'controller' => 'MyNetwork',//$invitation->type,
                            'action' => 'invitations',
                            $invitation->refid
                        ]) ?>"
                           class="col-auto">
                            <img class="avatar avatar-md"
                                 src="<?= $this->Url->webroot(
                                     h($invitation->sender->profile->getImageUrl())
                                 ) ?>" alt="">
                        </a>
                        <div class="col">
                            <div class="jc-sb fxw-nw mB-5 fsz-14 mb-2">
                                <a href="<?= Router::url([
                                    'controller' => 'MyNetwork',//$invitation->type,
                                    'action' => 'invitations',
                                    $invitation->refid
                                ]) ?>"
                                   class="mB-0 text-bold"><?= Text::truncate(
                                        h($invitation->sender->getFullName()), 40
                                    )
                                    ?></a>
                                <span class="c-grey-600">is inviting you to join his network.</span>
                                <!--<span class="c-grey-600 fsz-sm"><? /*//= $invitation->getMessage()*/ ?></span>-->
                            </div>
                            <div class="row">
                                <div class="col fsz-12">
                                    <span class="small">
                                        <i class="icon mdi mdi-clock"></i> <?= (new Calculator())
                                            ->calculateTimePassedSince($invitation->created, 2) ?>
                                    </span>
                                </div>
                                <div class="col-auto ml-auto n1ft4jmn">
                                    <span><?= $this->element('App/buttons/connection_confirm_btn', ['account' =>
                                            $invitation->sender, 'full' => true]); ?></span>
                                    <span
                                        class="ml-3"><?= $this->element('App/buttons/connection_reject_btn', ['account' =>
                                            $invitation->sender, 'full' => true]); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php else: ?>
    <div class="no-data-msg text-center p-3">You have no new invitations</div>
<?php endif; ?>
