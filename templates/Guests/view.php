<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $guest
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Guest'), ['action' => 'edit', $guest->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Guest'), ['action' => 'delete', $guest->id], ['confirm' => __('Are you sure you want to delete # {0}?', $guest->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Guests'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Guest'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="guests view content">
            <h3><?= h($guest->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Browser') ?></th>
                    <td><?= h($guest->browser) ?></td>
                </tr>
                <tr>
                    <th><?= __('Continent') ?></th>
                    <td><?= h($guest->continent) ?></td>
                </tr>
                <tr>
                    <th><?= __('Continent Code') ?></th>
                    <td><?= h($guest->continent_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Country') ?></th>
                    <td><?= h($guest->country) ?></td>
                </tr>
                <tr>
                    <th><?= __('Country Code') ?></th>
                    <td><?= h($guest->country_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Currency Converter') ?></th>
                    <td><?= h($guest->currency_converter) ?></td>
                </tr>
                <tr>
                    <th><?= __('Currency Code') ?></th>
                    <td><?= h($guest->currency_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Currency Symbol') ?></th>
                    <td><?= h($guest->currency_symbol) ?></td>
                </tr>
                <tr>
                    <th><?= __('Device') ?></th>
                    <td><?= h($guest->device) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ip') ?></th>
                    <td><?= h($guest->ip) ?></td>
                </tr>
                <tr>
                    <th><?= __('Latitude') ?></th>
                    <td><?= h($guest->latitude) ?></td>
                </tr>
                <tr>
                    <th><?= __('Longitude') ?></th>
                    <td><?= h($guest->longitude) ?></td>
                </tr>
                <tr>
                    <th><?= __('Os') ?></th>
                    <td><?= h($guest->os) ?></td>
                </tr>
                <tr>
                    <th><?= __('Region') ?></th>
                    <td><?= h($guest->region) ?></td>
                </tr>
                <tr>
                    <th><?= __('Registered User Refid') ?></th>
                    <td><?= h($guest->registered_user_refid) ?></td>
                </tr>
                <tr>
                    <th><?= __('State') ?></th>
                    <td><?= h($guest->state) ?></td>
                </tr>
                <tr>
                    <th><?= __('Timezone') ?></th>
                    <td><?= h($guest->timezone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($guest->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Visit') ?></th>
                    <td><?= h($guest->last_visit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($guest->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($guest->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
