<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $contestantFinishtime->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $contestantFinishtime->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Contestant Finishtimes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Contestants'), ['controller' => 'Contestants', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contestant'), ['controller' => 'Contestants', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Races'), ['controller' => 'Races', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Race'), ['controller' => 'Races', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contestantFinishtimes form large-9 medium-8 columns content">
    <?= $this->Form->create($contestantFinishtime) ?>
    <fieldset>
        <legend><?= __('Edit Contestant Finishtime') ?></legend>
        <?php
            echo $this->Form->input('contestant_id', ['options' => $contestants]);
            echo $this->Form->input('race_id', ['options' => $races]);
            echo $this->Form->input('finishtime');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
