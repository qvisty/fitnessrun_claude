<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $race->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $race->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Races'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="races form large-9 medium-8 columns content">
    <?= $this->Form->create($race) ?>
    <fieldset>
        <legend><?= __('Edit Race') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('starttime');
            echo $this->Form->input('active');
            echo $this->Form->input('endtime');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
