<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Modify Race Contestant'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="raceContestants index large-9 medium-8 columns content">
    <h3><?= __('Race Contestants') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('race_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('contestant_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($raceContestants as $raceContestant): ?>
            <tr>
                <td><?= $this->Number->format($raceContestant->id) ?></td>
                <td><?= $raceContestant->has('race') ? $this->Html->link($raceContestant->race->name, ['controller' => 'Races', 'action' => 'view', $raceContestant->race->id]) : '' ?></td>
                <td><?= $raceContestant->has('contestant') ? $this->Html->link($raceContestant->contestant->name, ['controller' => 'Contestants', 'action' => 'view', $raceContestant->contestant->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $raceContestant->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $raceContestant->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $raceContestant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $raceContestant->id)]) ?>
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
