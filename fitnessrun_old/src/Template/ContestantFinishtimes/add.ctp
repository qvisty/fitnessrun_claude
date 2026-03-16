<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Contestant Finishtimes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Contestants'), ['controller' => 'Contestants', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contestant'), ['controller' => 'Contestants', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Races'), ['controller' => 'Races', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Race'), ['controller' => 'Races', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contestantFinishtimes form large-9 medium-8 columns content">
<p id="timerStoppedMsg"><b><?php echo __("NOTE:");?></b><?php echo __("The automatic timer has stopped due to manual intervention of the timestamp. To start timer again please reload this page."); ?></p>
<?= $this->Form->create(null,['type' => 'get','id'=>'raceForm']) ?>
<?php echo $this->Form->label('activerace',__('Races')); ?>
<?php echo $this->Form->input('activerace', ['id'=>'activerace','options' => $races,'label'=>false]); ?>
    <?= $this->Form->end() ?>
<?php
            echo $this->Form->input('barcode', ['id'=>'barcode','placeholder' => __("Barcode")]);
?>
    <?= $this->Form->create($contestantFinishtime,['id'=>'mainForm']) ?>
    <fieldset>
        <legend><?= __('Add Contestant Finishtime') ?></legend>
        <?php
            echo $this->Form->input('contestant_id', ['id'=>'contestant_id','options' => $contestants]);
            $session = $this->request->session();
            echo $this->Form->input('race_id',['id'=>'race_id','type'=>'hidden','value'=>1]);
            echo $this->Form->input('finishtime',['second'=>true]);
            echo $this->Form->label(__('Enter laps'));
            echo $this->Form->checkbox('addLaps',['label'=>true,'checked'=>$session->read('addLaps')]);
            echo "<br>".$this->Form->label(__('Laps Count'));
            echo $this->Form->text('laps',['type'=>'number','min'=>0,'max'=>10,'value'=>0,'label'=>'label']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<?php echo $this->Html->script('utils.js'); ?>

<script>
    var idUpdateTime;

    $( document ).ready(function() {
        idUpdateTime = setInterval(updateTime,1000);
        $("#timerStoppedMsg").hide(0);
        $("input[name='laps']").prop('disabled', true);
        if($("input[name='addLaps']").is(':checked'))
        {
           $("input[name='laps']").prop('disabled', false); 
        }

        $("input[name='addLaps']").change(function() {
            $("input[name='laps']").prop('disabled', false);
           if(!$(this).is(':checked'))
           {
               $("input[name='laps']").prop('disabled', true);
           }
        });
        
        findRace();
        
        $('#activerace').change(function(){
           $("#raceForm").submit(); 
        });
        
        $("#barcode").focus();
    });
   
    
    function findRace()
    {
        if(typeof getUrlParameter("activerace") == 'undefined')
        {
            $("#race_id").val($("#activerace option:first").val());
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

    $(document).keypress(function(e) {
        //Enterknappen er trykket
        if(e.which == 13) {
            var barcode = removeLeadingZeros($("#barcode").val());
            if(inSelect(barcode))
            {
                //Hvad skal der ske, hvis den findes i listen.
            }
            $("#barcode").val("");
            $("#barcode").focus(); 
        }
    });

    function inSelect(barcode)
    {
        barcode = removeLeadingZeros(barcode);
        console.log("Barcode: " + barcode);
        var found = false;

        $("#contestant_id > option").each(function() {
            var curBarcode = this.value;
            if(barcode == curBarcode)
            {
                console.log("isMatch: " + curBarcode + " " + this.text + " : true");
                $("#contestant_id").val(barcode);
                $("#contestant_id").change();

                found = true;
            }
            else 
            {
                console.log("isMatch: " + curBarcode + " " + this.text + " : false");
            }

        });
        return found;
    }

    $("select[name^='finishtime'").click(function(){
        clearInterval(idUpdateTime);
        $("#timerStoppedMsg").show(100);
    });
   

    function updateTime()
    {
        //Opdaterer tiden i SELECT felterne. Man kunne naturligvis undlade at opdatere dage, måned og år. 
        var mDateTime = new Date();
        $("select[name='finishtime[year]']").val(pad(mDateTime.getFullYear(),4));
        $("select[name='finishtime[month]']").val(pad(mDateTime.getMonth()+1,2));
        $("select[name='finishtime[day]']").val(pad(mDateTime.getUTCDate(),2));
        $("select[name='finishtime[hour]']").val(pad(mDateTime.getHours(),2));
        $("select[name='finishtime[minute]']").val(pad(mDateTime.getMinutes(),2));
        $("select[name='finishtime[second]']").val(pad(mDateTime.getSeconds(),2));
    }
    function pad(num, size) 
    {
        var s = num+"";
        while (s.length < size) s = "0" + s;
        return s;
    }
    
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