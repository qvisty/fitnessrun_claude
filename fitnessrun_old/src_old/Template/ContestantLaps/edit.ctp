<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $contestantLap->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $contestantLap->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Contestant Laps'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="contestantLaps form large-9 medium-8 columns content">
    <?= $this->Form->create($contestantLap) ?>
    <fieldset>
        <legend><?= __('Edit Contestant Lap') ?></legend>
        <?php
            echo $this->Form->input('contestant_id', ['options' => $contestants]);
            echo $this->Form->input('race_id', ['options' => $races]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
