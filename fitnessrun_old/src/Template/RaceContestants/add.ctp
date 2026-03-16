<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('View all {0}',[__('race contestants')]), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="raceContestants form large-9 medium-8 columns content">
<?= $this->Form->create(null,['type' => 'get','id'=>'raceForm']) ?>
<?php echo $this->Form->input('activerace', ['id'=>'activerace','options' => $races]); ?>
    <?php echo $this->Form->input('team', ['id'=>'team','options' => $teams]); ?>
    <?= $this->Form->end() ?>
    
    <?= $this->Form->create($raceContestant) ?>
        <?php 
            //Sikre, at knappen kun vises, hvis der er gyldigt input.
            if(!empty($contestants->toArray())){
                echo $this->Form->button(__('Submit'),['id'=>'submit']);
            }  
        ?>
    <fieldset>
        <legend><?= __('Add Race Contestant') ?></legend>
        <?php
            echo $this->Form->input('race_id',['id'=>'race_id','type'=>'hidden','value'=>1]);
            echo $this->Form->input('contestants', ['id'=>'contestants','options' => $contestants,'multiple' => true]);
            echo $this->Form->button(__('Add'),['type'=>'button','id'=>'addButton','name'=>'addButton'])." ";
            echo $this->Form->button(__('Remove'),['type'=>'button','id'=>'removeButton','name'=>'removeButton'])."<br>"; 
            echo $this->Form->input('raceContestants', ['id'=>'raceContestants','options'=>$raceContestants,'multiple' => true]);
        ?>
    </fieldset>
    <?php 
        //Sikre, at knappen kun vises, hvis der er gyldigt input.
        if(!empty($contestants->toArray())){
            echo $this->Form->button(__('Submit'),['id'=>'submit']);
        }  
    ?>
    <?= $this->Form->end() ?>
</div>

<?php echo $this->Html->script('utils.js'); ?>
<script>
    $(document).ready()
    {
        updateActiveRace();
        updateTeams();
        updateContestants();
    }

    $( "#raceContestants" ).dblclick(function() {
        $("#removeButton").click();
    });
    
    $( "#contestants" ).dblclick(function() {
        $("#addButton").click();
    });
    $('#addButton').click(function()
    {
    $('#contestants option:selected').remove().appendTo('#raceContestants');
    });
    $('#removeButton').click(function()
    {
    $('#raceContestants option:selected').remove().appendTo('#contestants');
    });
    
    $('#activerace').change(function()
    {
       $("#raceForm").submit();
    });
    
    $('#team').change(function()
    {
       $("#raceForm").submit();
    });
    
    $('#submit').click(function()
    {
        $('#raceContestants option').prop('selected', true);
    });
    
    function updateActiveRace()
    {
        //Hvis der ikke er valgt et løb, da vælges det første i listen over mulige løb.
        if(typeof getUrlParameter("activerace") == 'undefined')
        {
            $("#race_id").val($("#activerace option:first").val());
            $("#raceForm").submit();
            return;
        }
        
        //Sætter den valgte værdi.
        var activeRace = getUrlParameter("activerace");
        $("#activerace").val(activeRace);
        $("#activerace").change();
        
        var selectedValue = $("#activerace option:selected").val();
        if(selectedValue == activeRace)
        {
            $("#race_id").val(activeRace);
        }
        else 
        {
            $("#race_id").val(null);
        }
    }

    function updateContestants()
    {
        var selectedContestants = $('#raceContestants option');
        
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
                    x.remove(j);       
                }
            }            
        }  
    }

    function updateTeams()
    {
        //Hvis der ikke er valgt et løb, da vælges det første i listen over mulige løb.
        if(typeof getUrlParameter("team") == 'undefined')
        {
            $("#team").val($("#team option:first").val());
            $("#raceForm").submit();
            return;
        }
        
        //Sætter den valgte værdi.
        var activeRace = getUrlParameter("team");
        $("#team").val(activeRace);
        $("#team").change();
        
        var selectedValue = $("#team option:selected").val();
        if(selectedValue == activeRace)
        {
            $("#team").val(activeRace);
        }
        else 
        {
            $("#team").val(null);
        }
    }
</script>
