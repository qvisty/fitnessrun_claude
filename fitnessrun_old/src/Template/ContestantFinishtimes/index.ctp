<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Contestant Finishtime'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Contestants'), ['controller' => 'Contestants', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contestant'), ['controller' => 'Contestants', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Races'), ['controller' => 'Races', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Race'), ['controller' => 'Races', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contestantFinishtimes index large-9 medium-8 columns content">
    <h3><?= __('Contestant Finishtimes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('contestant_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('race_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('finishtime') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contestantFinishtimes as $contestantFinishtime): ?>
            <tr>
                <td><?= $this->Number->format($contestantFinishtime->id) ?></td>
                <td><?= $contestantFinishtime->has('contestant') ? $this->Html->link($contestantFinishtime->contestant->name, ['controller' => 'Contestants', 'action' => 'view', $contestantFinishtime->contestant->id]) : '' ?></td>
                <td><?= $contestantFinishtime->has('race') ? $this->Html->link($contestantFinishtime->race->name, ['controller' => 'Races', 'action' => 'view', $contestantFinishtime->race->id]) : '' ?></td>
                <td><?= h($contestantFinishtime->finishtime) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $contestantFinishtime->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contestantFinishtime->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contestantFinishtime->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contestantFinishtime->id)]) ?>
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
