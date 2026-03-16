<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Contestant Lap'), ['action' => 'edit', $contestantLap->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Contestant Lap'), ['action' => 'delete', $contestantLap->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contestantLap->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Contestant Laps'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contestant Lap'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="contestantLaps view large-9 medium-8 columns content">
    <h3><?= h($contestantLap->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Contestant') ?></th>
            <td><?= $contestantLap->has('contestant') ? $this->Html->link($contestantLap->contestant->name, ['controller' => 'Contestants', 'action' => 'view', $contestantLap->contestant->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Race') ?></th>
            <td><?= $contestantLap->has('race') ? $this->Html->link($contestantLap->race->name, ['controller' => 'Races', 'action' => 'view', $contestantLap->race->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($contestantLap->id) ?></td>
        </tr>
    </table>
</div>
