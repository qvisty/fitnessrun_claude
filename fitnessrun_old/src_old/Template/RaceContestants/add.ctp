<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Race Contestants'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="raceContestants form large-9 medium-8 columns content">
<?= $this->Form->create(null,['type' => 'get','id'=>'raceForm']) ?>
<?php echo $this->Form->input('activerace', ['id'=>'activerace','options' => $races]); ?>
    <?= $this->Form->end() ?>
    
    <?= $this->Form->create($raceContestant) ?>
    <fieldset>
        <legend><?= __('Add Race Contestant') ?></legend>
        <?php
            echo $this->Form->input('race_id',['id'=>'race_id','type'=>'hidden','value'=>1]);
            echo $this->Form->input('contestants', ['id'=>'contestants','options' => $contestants,'multiple' => true]);
            echo $this->Form->button(__('Add'),['type'=>'button','id'=>'addButton','name'=>'addButton'])." ";
            echo $this->Form->button(__('Remove'),['type'=>'button','id'=>'removeButton','name'=>'removeButton'])."<br>"; 
            echo $this->Form->input('contestant_id', ['id'=>'contestant_id','options'=>$contestantsInRace,'multiple' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),['id'=>'submit']) ?>
    <?= $this->Form->end() ?>
</div>

<script>
    var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};
    </script>

<script>
    $(document).ready()
    {
        var selectedContestants = $('#contestant_id option');
        
        for(i = 0;i<selectedContestants.length;i++)
        {
            var selectedContestant = selectedContestants[i].value;
            
            var allContestants = $('#contestants option');
            for(j = 0;j<allContestants.length;j++)
            {
                var contestant = allContestants[j].value;
                if(selectedContestant == contestant)
                {
                    var x = document.getElementById("contestants");
                    x.remove(j);                    //$('#contestants options').remove(j);
                }
            }            
        }
        
        findRace();
        
        $('#activerace').change(function(){
           $("#raceForm").submit(); 
        });
    }
    
    
    function findRace()
    {
        if(typeof getUrlParameter("activerace") == 'undefined')
        {
            $("#race_id").val($("#activerace option:first").val());
            $("#raceForm").submit();
            return;
        }
        hasFound = false;
        $("#activerace > option").each(function() {
            var activeRace = getUrlParameter("activerace");
            if(this.value == activeRace)
            {
                $("#activerace").val(this.value);
                $("#activerace").change();
                
                $("#race_id").val(this.value);
                hasFound = true;
            }
        });
        
        if(!hasFound)
        {
            $("#mainForm :input").prop("disabled", true);
            $("#mainForm :button").prop("disabled", true);
        }
    }
    
    $('#addButton').click(function()
    {
        $('#contestants option:selected').remove().appendTo('#contestant_id');
    });
    $('#removeButton').click(function()
    {
        $('#contestant_id option:selected').remove().appendTo('#contestants');
    });
    $('#submit').click(function()
    {
        $('#contestant_id option').prop('selected', true);
    });
    
</script>