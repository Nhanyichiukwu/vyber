<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Group $group
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Group'), ['action' => 'edit', $group->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Group'), ['action' => 'delete', $group->id], ['confirm' => __('Are you sure you want to delete # {0}?', $group->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Groups'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Group'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="groups view content">
            <h3><?= h($group->refid) ?></h3>
            <table>
                <tr>
                    <th><?= __('Refid') ?></th>
                    <td><?= h($group->refid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($group->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Slug') ?></th>
                    <td><?= h($group->slug) ?></td>
                </tr>
                <tr>
                    <th><?= __('Group Image') ?></th>
                    <td><?= h($group->group_image) ?></td>
                </tr>
                <tr>
                    <th><?= __('Author') ?></th>
                    <td><?= h($group->author) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($group->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($group->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($group->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($group->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Group Invites') ?></h4>
                <?php if (!empty($group->group_invites)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Group Id') ?></th>
                            <th><?= __('Sender Refid') ?></th>
                            <th><?= __('Invitee Refid') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($group->group_invites as $groupInvites) : ?>
                        <tr>
                            <td><?= h($groupInvites->id) ?></td>
                            <td><?= h($groupInvites->group_id) ?></td>
                            <td><?= h($groupInvites->sender_refid) ?></td>
                            <td><?= h($groupInvites->invitee_refid) ?></td>
                            <td><?= h($groupInvites->status) ?></td>
                            <td><?= h($groupInvites->created) ?></td>
                            <td><?= h($groupInvites->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'GroupInvites', 'action' => 'view', $groupInvites->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'GroupInvites', 'action' => 'edit', $groupInvites->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'GroupInvites', 'action' => 'delete', $groupInvites->id], ['confirm' => __('Are you sure you want to delete # {0}?', $groupInvites->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Group Join Requests') ?></h4>
                <?php if (!empty($group->group_join_requests)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Group Id') ?></th>
                            <th><?= __('User Refid') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Message') ?></th>
                            <th><?= __('Appeal') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Approved By') ?></th>
                            <th><?= __('Approved At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($group->group_join_requests as $groupJoinRequests) : ?>
                        <tr>
                            <td><?= h($groupJoinRequests->id) ?></td>
                            <td><?= h($groupJoinRequests->group_id) ?></td>
                            <td><?= h($groupJoinRequests->user_refid) ?></td>
                            <td><?= h($groupJoinRequests->status) ?></td>
                            <td><?= h($groupJoinRequests->message) ?></td>
                            <td><?= h($groupJoinRequests->appeal) ?></td>
                            <td><?= h($groupJoinRequests->created) ?></td>
                            <td><?= h($groupJoinRequests->modified) ?></td>
                            <td><?= h($groupJoinRequests->approved_by) ?></td>
                            <td><?= h($groupJoinRequests->approved_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'GroupJoinRequests', 'action' => 'view', $groupJoinRequests->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'GroupJoinRequests', 'action' => 'edit', $groupJoinRequests->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'GroupJoinRequests', 'action' => 'delete', $groupJoinRequests->id], ['confirm' => __('Are you sure you want to delete # {0}?', $groupJoinRequests->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Group Medias') ?></h4>
                <?php if (!empty($group->group_medias)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Group Id') ?></th>
                            <th><?= __('User Refid') ?></th>
                            <th><?= __('Media Path') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($group->group_medias as $groupMedias) : ?>
                        <tr>
                            <td><?= h($groupMedias->id) ?></td>
                            <td><?= h($groupMedias->group_id) ?></td>
                            <td><?= h($groupMedias->user_refid) ?></td>
                            <td><?= h($groupMedias->media_path) ?></td>
                            <td><?= h($groupMedias->created) ?></td>
                            <td><?= h($groupMedias->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'GroupMedias', 'action' => 'view', $groupMedias->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'GroupMedias', 'action' => 'edit', $groupMedias->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'GroupMedias', 'action' => 'delete', $groupMedias->id], ['confirm' => __('Are you sure you want to delete # {0}?', $groupMedias->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Group Members') ?></h4>
                <?php if (!empty($group->group_members)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Group Id') ?></th>
                            <th><?= __('User Refid') ?></th>
                            <th><?= __('Invited By') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Invited At') ?></th>
                            <th><?= __('Approved By') ?></th>
                            <th><?= __('Approved At') ?></th>
                            <th><?= __('Is Admin') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($group->group_members as $groupMembers) : ?>
                        <tr>
                            <td><?= h($groupMembers->group_id) ?></td>
                            <td><?= h($groupMembers->user_refid) ?></td>
                            <td><?= h($groupMembers->invited_by) ?></td>
                            <td><?= h($groupMembers->created) ?></td>
                            <td><?= h($groupMembers->modified) ?></td>
                            <td><?= h($groupMembers->status) ?></td>
                            <td><?= h($groupMembers->invited_at) ?></td>
                            <td><?= h($groupMembers->approved_by) ?></td>
                            <td><?= h($groupMembers->approved_at) ?></td>
                            <td><?= h($groupMembers->is_admin) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'GroupMembers', 'action' => 'view', $groupMembers->]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'GroupMembers', 'action' => 'edit', $groupMembers->]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'GroupMembers', 'action' => 'delete', $groupMembers->], ['confirm' => __('Are you sure you want to delete # {0}?', $groupMembers->)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Group Posts') ?></h4>
                <?php if (!empty($group->group_posts)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Group Id') ?></th>
                            <th><?= __('Post Refid') ?></th>
                            <th><?= __('Post Type') ?></th>
                            <th><?= __('User Refid') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($group->group_posts as $groupPosts) : ?>
                        <tr>
                            <td><?= h($groupPosts->id) ?></td>
                            <td><?= h($groupPosts->group_id) ?></td>
                            <td><?= h($groupPosts->post_refid) ?></td>
                            <td><?= h($groupPosts->post_type) ?></td>
                            <td><?= h($groupPosts->user_refid) ?></td>
                            <td><?= h($groupPosts->created) ?></td>
                            <td><?= h($groupPosts->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'GroupPosts', 'action' => 'view', $groupPosts->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'GroupPosts', 'action' => 'edit', $groupPosts->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'GroupPosts', 'action' => 'delete', $groupPosts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $groupPosts->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
