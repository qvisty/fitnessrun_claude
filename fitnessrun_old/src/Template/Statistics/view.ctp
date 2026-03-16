<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('View all {0}',[__('statistics')]), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="raceContestants index large-9 medium-8 columns content">
    <div id="TimeLabel">
    </div>
    
    <h3><?= __('Team') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('laps') ?></th>
                <th scope="col"><?= $this->Paginator->sort('time') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($teamStats as $teamStat): ?>
            <tr>
                <td><?= $teamStat['name']; ?></td>
                <td><?= $teamStat['lapscount']; ?></td>
                
                <?php 
                    //Laver timestamp´et
                $seconds = $teamStat['time'];
                $hours = floor($seconds / 3600);
                $mins = floor($seconds / 60 % 60);
                $secs = floor($seconds % 60);
                $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                
                ?>
                
                <td><?= $timeFormat; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <h3><?= __('Contestants') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('team') ?></th>
                <th scope="col"><?= $this->Paginator->sort('laps') ?></th>
                <th scope="col"><?= $this->Paginator->sort('time') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contestants as $contestant): ?>
            <tr>
                <td><?= $contestant['id']; ?></td>
                <td><?= $contestant['name']; ?></td>
                <td><?= $contestant['team']; ?></td>
                <td><?= $contestant['lapscount']; ?></td>
                
                <?php 
                    //Laver timestamp´et
                $seconds = $contestant['time'];
                $hours = floor($seconds / 3600);
                $mins = floor($seconds / 60 % 60);
                $secs = floor($seconds % 60);
                $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
                
                ?>
                
                <td><?= $timeFormat; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
setInterval(updateTimeLabel,1000);
var countDown = 60;

function updateTimeLabel()
{
    
    $("#TimeLabel").text( "<?= __('Automatic refreshing page in: '); ?>" + countDown);
    if(countDown-- <= 2)
    {
        $("#TimeLabel").text( "<?= __('Refreshing page - please hang tight!'); ?>");
        location.reload();
    }
}

</script>