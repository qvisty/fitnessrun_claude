<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Contestant'), ['action' => 'edit', $contestant->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Contestant'), ['action' => 'delete', $contestant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contestant->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Contestants'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contestant'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="contestants view large-9 medium-8 columns content">
    <h3><?= h($contestant->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($contestant->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($contestant->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Team') ?></th>
            <td><?= h($contestant->team) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Active') ?></th>
            <td><?= $contestant->active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
