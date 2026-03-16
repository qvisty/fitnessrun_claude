<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Contestant Finishtime'), ['action' => 'edit', $contestantFinishtime->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Contestant Finishtime'), ['action' => 'delete', $contestantFinishtime->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contestantFinishtime->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Contestant Finishtimes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contestant Finishtime'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Contestants'), ['controller' => 'Contestants', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contestant'), ['controller' => 'Contestants', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Races'), ['controller' => 'Races', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Race'), ['controller' => 'Races', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="contestantFinishtimes view large-9 medium-8 columns content">
    <h3><?= h($contestantFinishtime->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Contestant') ?></th>
            <td><?= $contestantFinishtime->has('contestant') ? $this->Html->link($contestantFinishtime->contestant->name, ['controller' => 'Contestants', 'action' => 'view', $contestantFinishtime->contestant->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Race') ?></th>
            <td><?= $contestantFinishtime->has('race') ? $this->Html->link($contestantFinishtime->race->name, ['controller' => 'Races', 'action' => 'view', $contestantFinishtime->race->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($contestantFinishtime->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Finishtime') ?></th>
            <td><?= h($contestantFinishtime->finishtime) ?></td>
        </tr>
    </table>
</div>
