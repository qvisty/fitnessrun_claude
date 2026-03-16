<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Race Contestant'), ['action' => 'edit', $raceContestant->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Race Contestant'), ['action' => 'delete', $raceContestant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $raceContestant->id)]) ?> </li>
        <li><?= $this->Html->link(__('View all {0}',[__('race contestants')]), ['action' => 'index']) ?> </li>
    </ul>
</nav>
<div class="raceContestants view large-9 medium-8 columns content">
    <h3><?= h($raceContestant->id) ?></h3>
    <div id="TimeLabel">
        
    </div>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Race') ?></th>
            <td><?= $raceContestant->has('race') ? $this->Html->link($raceContestant->race->name, ['controller' => 'Races', 'action' => 'view', $raceContestant->race->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Contestant') ?></th>
            <td><?= $raceContestant->has('contestant') ? $this->Html->link($raceContestant->contestant->name, ['controller' => 'Contestants', 'action' => 'view', $raceContestant->contestant->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($raceContestant->id) ?></td>
        </tr>
    </table>
</div>

