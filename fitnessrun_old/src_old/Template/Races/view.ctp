<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Race'), ['action' => 'edit', $race->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Race'), ['action' => 'delete', $race->id], ['confirm' => __('Are you sure you want to delete # {0}?', $race->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Races'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Race'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="races view large-9 medium-8 columns content">
    <h3><?= h($race->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($race->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($race->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Starttime') ?></th>
            <td><?= h($race->starttime) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Endtime') ?></th>
            <td><?= h($race->endtime) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Active') ?></th>
            <td><?= $race->active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Contestant Finishtimes') ?></h4>
        <?php if (!empty($race->contestant_finishtimes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Contestant Id') ?></th>
                <th scope="col"><?= __('Race Id') ?></th>
                <th scope="col"><?= __('Finishtime') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($race->contestant_finishtimes as $contestantFinishtimes): ?>
            <tr>
                <td><?= h($contestantFinishtimes->id) ?></td>
                <td><?= h($contestantFinishtimes->contestant_id) ?></td>
                <td><?= h($contestantFinishtimes->race_id) ?></td>
                <td><?= h($contestantFinishtimes->finishtime) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ContestantFinishtimes', 'action' => 'view', $contestantFinishtimes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ContestantFinishtimes', 'action' => 'edit', $contestantFinishtimes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ContestantFinishtimes', 'action' => 'delete', $contestantFinishtimes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contestantFinishtimes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Contestant Laps') ?></h4>
        <?php if (!empty($race->contestant_laps)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Contestant Id') ?></th>
                <th scope="col"><?= __('Race Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($race->contestant_laps as $contestantLaps): ?>
            <tr>
                <td><?= h($contestantLaps->id) ?></td>
                <td><?= h($contestantLaps->contestant_id) ?></td>
                <td><?= h($contestantLaps->race_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ContestantLaps', 'action' => 'view', $contestantLaps->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ContestantLaps', 'action' => 'edit', $contestantLaps->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ContestantLaps', 'action' => 'delete', $contestantLaps->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contestantLaps->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Race Contestants') ?></h4>
        <?php if (!empty($race->race_contestants)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Race Id') ?></th>
                <th scope="col"><?= __('Contestant Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($race->race_contestants as $raceContestants): ?>
            <tr>
                <td><?= h($raceContestants->id) ?></td>
                <td><?= h($raceContestants->race_id) ?></td>
                <td><?= h($raceContestants->contestant_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'RaceContestants', 'action' => 'view', $raceContestants->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'RaceContestants', 'action' => 'edit', $raceContestants->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'RaceContestants', 'action' => 'delete', $raceContestants->id], ['confirm' => __('Are you sure you want to delete # {0}?', $raceContestants->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
