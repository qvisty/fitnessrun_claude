<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $raceContestant->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $raceContestant->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Race Contestants'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Races'), ['controller' => 'Races', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Race'), ['controller' => 'Races', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Contestants'), ['controller' => 'Contestants', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contestant'), ['controller' => 'Contestants', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="raceContestants form large-9 medium-8 columns content">
    <?= $this->Form->create($raceContestant) ?>
    <fieldset>
        <legend><?= __('Edit Race Contestant') ?></legend>
        <?php
            echo $this->Form->input('race_id', ['options' => $races]);
            echo $this->Form->input('contestant_id', ['options' => $contestants]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
