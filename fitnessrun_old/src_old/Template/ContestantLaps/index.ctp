<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Contestant Lap'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contestantLaps index large-9 medium-8 columns content">
    <h3><?= __('Contestant Laps') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('contestant_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('race_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contestantLaps as $contestantLap): ?>
            <tr>
                <td><?= $this->Number->format($contestantLap->id) ?></td>
                <td><?= $contestantLap->has('contestant') ? $this->Html->link($contestantLap->contestant->name, ['controller' => 'Contestants', 'action' => 'view', $contestantLap->contestant->id]) : '' ?></td>
                <td><?= $contestantLap->has('race') ? $this->Html->link($contestantLap->race->name, ['controller' => 'Races', 'action' => 'view', $contestantLap->race->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $contestantLap->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contestantLap->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contestantLap->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contestantLap->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
