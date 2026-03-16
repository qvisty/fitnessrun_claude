<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Race'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="races index large-9 medium-8 columns content">
    <h3><?= __('Races') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('starttime') ?></th>
                <th scope="col"><?= $this->Paginator->sort('active') ?></th>
                <th scope="col"><?= $this->Paginator->sort('endtime') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($races as $race): ?>
            <tr>
                <td><?= $this->Number->format($race->id) ?></td>
                <td><?= h($race->name) ?></td>
                <td><?= h($race->starttime) ?></td>
                <td><?= h($race->active) ?></td>
                <td><?= h($race->endtime) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $race->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $race->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $race->id], ['confirm' => __('Are you sure you want to delete # {0}?', $race->id)]) ?>
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
