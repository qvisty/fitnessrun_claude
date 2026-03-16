<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Contestant Laps'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="contestantLaps form large-9 medium-8 columns content">
    <?php
        echo $this->Form->create(null,['id'=>'raceForm','type'=>'get']);
        echo $this->Form->input('activerace', ['id'=>'activerace','options' => $races]);
        echo $this->Form->end();
    ?>

    <?php
        echo $this->Form->input('barcode',['id'=>'barcode','type'=>"text"])
    ?>
    <?= $this->Form->create($contestantLap,['id'=>'mainForm']) ?>
    <fieldset>
        <legend><?= __('Add Contestant Lap') ?></legend>
        <?php
            echo $this->Form->input('contestant_id', ['id'=>'contestant_id','options' => $contestants]);
            echo $this->Form->input('race_id', ['id'=>'race_id','type'=>'hidden']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<?php echo $this->Html->script('utils.js'); ?>

<script>
    $( document ).ready(function() {
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