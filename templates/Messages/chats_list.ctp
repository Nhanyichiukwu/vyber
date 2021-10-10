<?php

use Cake\Utility\Text;
use Cake\Routing\Router;
use App\Utility\RandomString;
/**
 * 
 */
?>
<?php if (count($connections)): ?>
<ul class="list-unstyled list-separated border-bottom">
    <?php if (count($chats)): ?>
        <?php foreach ($chats as $chat): ?>
        <?php
            $chatTitle = null;
            $chatParticipants = (array) $chat->get('chatparticipants');
            if ($chat->has('title')) {
                $chatTitle = $chat->get('title');
            } 
            // If the chat between just 2 persons, having no defined title
            // We use the name of the second party as the chat title
            else if($chat->get('chattype') === 'private' && count($chatParticipants) === 2) {
                $coParticipant = null;
                foreach ($chatParticipants as $chatParticipant) {
                    if (! $chatParticipant->correspondent->isSameAs($activeUser)) {
                        $coParticipant = $chatParticipant->correspondent;
                        break;
                    }
                }
                $chatTitle = $coParticipant->getFullname();
            } 
            // Perhaps the chat has no defined title, but is a group chat,
            // in this case we will use the first names of the first 3 participants
            // aside from the user
            else if ($chat->get('chattype') === 'group') {
                $firstNames = [];
                for ($i = 0; $i < 3; $i++) {
                    $chatParticipant = $chatParticipants[$i];
                    $firstNames[] = $chatParticipant->correspondent->getFirstName();
                }
                $chatTitle = implode(', ', $firstNames);
            }
        ?>
        <li class="list-separated-item px-2">
            <div class="align-items-center flex-nowrap gutters-sm justify-content-between row py-2 bgcH-grey-200">
                <div class="col-auto">
                    <span class="avatar avatar-lg d-block" style="background-image: url(demo/faces/female/12.jpg)">
                        <span class="avatar-status bg-green"></span>
                    </span>
                </div>
                <a class="col K1oMs4" 
                   href="javascript:void(0)" 
                   data-chat-title="<?= h($chatTitle); ?>" 
                   data-uri="<?= Router::url('messages/t/' . h($chat->get('refid')), true) ?>"
                   data-chat-type="<?= h($chat->chattype) ?>"
                   >
                    <div>
                        <span class="text-inherit"><?= Text::truncate(h($chatTitle), 30, ['ellipsis' => '...']); ?></span>
                    </div>
                    <small class="d-block item-except text-sm text-muted h-1x"><?= Text::truncate(h($chat->mostRecentMessage->get('text')), 30, ['ellipsis' => '...']); ?></small>
                </a>
                <div class="col-auto">
                    <div class="item-action dropdown">
                        <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="mdi mdi-18px mdi-chevron-down"></i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                            <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> Another action </a>
                            <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-message-square"></i> Something else here</a>
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-link"></i> Separated link</a>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php foreach ($connections as $connection): ?>
    <li class="list-separated-item py-0 px-2">
        <div class="align-items-center flex-nowrap gutters-sm justify-content-between row py-3 bgcH-grey-200">
            <div class="col-auto">
                <span class="avatar avatar-lg d-block" style="background-image: url(demo/faces/female/12.jpg)">
                    <span class="avatar-status bg-green"></span>
                </span>
            </div>
            <a class="col K1oMs4" 
               href="javascript:void(0)" 
               data-chat-title="<?= h($connection->correspondent->getFullname()); ?>" 
               data-uri="<?= Router::url('messages/t/' . RandomString::generateString(20, 'mixed'), true) ?>"
               data-chat-type="interpersonal" 
               data-correspondent="<?= h($connection->correspondent->refid) ?>"
               >
                <div>
                    <span class="text-inherit"><?= Text::truncate(h($connection->correspondent->getFullname()), 20, ['ellipsis' => '...']); ?></span>
                </div>
                <!--<small class="d-block item-except text-sm text-muted h-1x">{{replace_with_value}}</small>-->
            </a>
            <div class="col-auto">
                <div class="item-action dropdown">
                    <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="mdi mdi-18px mdi-chevron-down"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                        <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> Another action </a>
                        <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-message-square"></i> Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-link"></i> Separated link</a>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <?php endforeach; ?>
</ul>
<?php else: ?>
<div class="no-chats no-record px-3 text-center">
    There are no connections to chat with...
</div>
<?php endif; ?>


