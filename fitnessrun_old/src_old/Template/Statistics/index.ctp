<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
    </ul>
</nav>
<div class="races index large-9 medium-8 columns content">
    <h3><?= __('Race statistics') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort(__('Starttime')) ?></th>
                <th scope="col"><?= $this->Paginator->sort(__('endtime')) ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($races as $race): ?>
            <tr>
                <td><?= $this->Number->format($race->id) ?></td>
                <td><?= h($race->name) ?></td>
                <td><?= h($race->starttime) ?></td>
                <td><?= h($race->endtime) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $race->id]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
