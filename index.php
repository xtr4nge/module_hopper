<? 
/*
    Copyright (C) 2013-2016 xtr4nge [_AT_] gmail.com

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/ 
?>
<?
include "../../login_check.php";
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>FruityWiFi</title>
<script src="../js/jquery.js"></script>
<script src="../js/jquery-ui.js"></script>
<link rel="stylesheet" href="../css/jquery-ui.css" />
<link rel="stylesheet" href="../css/style.css" />
<link rel="stylesheet" href="../../../style.css" />

<script src="includes/scripts.js"></script>

<script>
$(function() {
    $( "#action" ).tabs();
    $( "#result" ).tabs();
});

</script>

</head>
<body>

<? include "../menu.php"; ?>

<br>

<?
include "../../config/config.php";
include "_info_.php";
include "../../functions.php";


// Checking POST & GET variables...
if ($regex == 1) {
    regex_standard($_POST["newdata"], "msg.php", $regex_extra);
    regex_standard($_GET["logfile"], "msg.php", $regex_extra);
    regex_standard($_GET["action"], "msg.php", $regex_extra);
    regex_standard($_POST["service"], "msg.php", $regex_extra);
    //regex_standard($_GET["tempname"], "msg.php", $regex_extra);
}

$newdata = $_POST['newdata'];
$logfile = $_GET["logfile"];
$action = $_GET["action"];
//$tempname = $_GET["tempname"];
$service = $_POST["service"];


// DELETE LOG
if ($logfile != "" and $action == "delete") {
    $exec = "rm ".$mod_logs_history.$logfile.".log";
    exec_fruitywifi($exec);
}

// SET MODE
if ($_POST["change_mode"] == "1") {
    $ss_mode = $service;
    $exec = "/bin/sed -i 's/ss_mode.*/ss_mode = \\\"".$ss_mode."\\\";/g' includes/options_config.php";
    exec_fruitywifi($exec);
}

?>

<div class="rounded-top" align="left"> &nbsp;&nbsp; <b><?=$mod_alias?></b> </div>
<div class="rounded-bottom">

    &nbsp; version <?=$mod_version?><br>
    
    <?
    $ismoduleup = exec($mod_isup);
    if ($ismoduleup != "") {
        echo "&nbsp;&nbsp; $mod_alias  <font color='lime'><b>enabled</b></font>.&nbsp; | <a href='includes/module_action.php?service=$mod_name&action=stop&page=module'><b>stop</b></a>";
    } else { 
        echo "&nbsp;&nbsp; $mod_alias  <font color='red'><b>disabled</b></font>. | <a href='includes/module_action.php?service=$mod_name&action=start&page=module'><b>start</b></a>"; 
    }
    ?>
    
</div>

<br>

<div id="msg" style="font-size: larger;">
Loading, please wait...
</div>

<div id="body" style="display:none;">

    <div id="result" class="module">
        <ul>
            <li><a href="#tab-options">Options</a></li>
            <li><a href="#tab-about">About</a></li>
        </ul>
        
        <!-- OPTIONS -->
        <div id="tab-options" class="history">
            <h4>
                HOPPING
            </h4>
            <h5>
                Delay (seconds)
                <br>
                <input id="hopper_delay" class="form-control input-sm" placeholder="Delay" value="<?=$mod_hopper_delay?>" style="width: 180px; display: inline-block; " type="text" />
                <input class="btn btn-default btn-sm" type="button" value="save" onclick="setOption('hopper_delay', 'mod_hopper_delay');">
            </h5>
            <hr>
            <h4>
                <input id="hopper_jump" type="checkbox" name="my-checkbox" <? if ($mod_hopper_jump == "1") echo "checked"; ?> onclick="setCheckbox(this, 'mod_hopper_jump')" >
                CHANNEL
            </h4>
                <div id="channel">
                    <!--<label></label>
                    <br>-->
                    <? $a_channel = explode(",", $mod_hopper_channel); ?>
                    <input type="checkbox" name="channel" value="1" onclick="setOptionCheckbox('channel')" <? if (in_array("1", $a_channel)) echo "checked"; ?> > 1
                    <input type="checkbox" name="channel" value="2" onclick="setOptionCheckbox('channel')" <? if (in_array("2", $a_channel)) echo "checked"; ?> > 2
                    <input type="checkbox" name="channel" value="3" onclick="setOptionCheckbox('channel')" <? if (in_array("3", $a_channel)) echo "checked"; ?> > 3
                    <input type="checkbox" name="channel" value="4" onclick="setOptionCheckbox('channel')" <? if (in_array("4", $a_channel)) echo "checked"; ?> > 4
                    <input type="checkbox" name="channel" value="5" onclick="setOptionCheckbox('channel')" <? if (in_array("5", $a_channel)) echo "checked"; ?> > 5
                    <input type="checkbox" name="channel" value="6" onclick="setOptionCheckbox('channel')" <? if (in_array("6", $a_channel)) echo "checked"; ?> > 6
                    <input type="checkbox" name="channel" value="7" onclick="setOptionCheckbox('channel')" <? if (in_array("7", $a_channel)) echo "checked"; ?> > 7
                    <input type="checkbox" name="channel" value="8" onclick="setOptionCheckbox('channel')" <? if (in_array("8", $a_channel)) echo "checked"; ?> > 8
                    <input type="checkbox" name="channel" value="9" onclick="setOptionCheckbox('channel')" <? if (in_array("9", $a_channel)) echo "checked"; ?> > 9
                    <input type="checkbox" name="channel" value="10" onclick="setOptionCheckbox('channel')" <? if (in_array("10", $a_channel)) echo "checked"; ?> > 10
                    <input type="checkbox" name="channel" value="11" onclick="setOptionCheckbox('channel')" <? if (in_array("11", $a_channel)) echo "checked"; ?> > 11
                    <input type="checkbox" name="channel" value="12" onclick="setOptionCheckbox('channel')" <? if (in_array("12", $a_channel)) echo "checked"; ?> > 12
                    <input type="checkbox" name="channel" value="13" onclick="setOptionCheckbox('channel')" <? if (in_array("13", $a_channel)) echo "checked"; ?> > 13
                    <br>
                    <input type="checkbox" name="channel" value="36" onclick="setOptionCheckbox('channel')" <? if (in_array("36", $a_channel)) echo "checked"; ?> > 36
                    <input type="checkbox" name="channel" value="40" onclick="setOptionCheckbox('channel')" <? if (in_array("40", $a_channel)) echo "checked"; ?> > 40
                    <input type="checkbox" name="channel" value="44" onclick="setOptionCheckbox('channel')" <? if (in_array("44", $a_channel)) echo "checked"; ?> > 44
                    <input type="checkbox" name="channel" value="48" onclick="setOptionCheckbox('channel')" <? if (in_array("48", $a_channel)) echo "checked"; ?> > 48
                    <input type="checkbox" name="channel" value="52" onclick="setOptionCheckbox('channel')" <? if (in_array("52", $a_channel)) echo "checked"; ?> > 52
                    <input type="checkbox" name="channel" value="56" onclick="setOptionCheckbox('channel')" <? if (in_array("56", $a_channel)) echo "checked"; ?> > 56
                    <input type="checkbox" name="channel" value="60" onclick="setOptionCheckbox('channel')" <? if (in_array("60", $a_channel)) echo "checked"; ?> > 60
                    <input type="checkbox" name="channel" value="64" onclick="setOptionCheckbox('channel')" <? if (in_array("64", $a_channel)) echo "checked"; ?> > 64
                </div>
        </div>
        <!-- END OPTIONS -->
        
        <!-- ABOUT -->

        <div id="tab-about" class="history">
            <? include "includes/about.php"; ?>
        </div>

        <!-- END ABOUT -->
        
    </div>

    <div id="loading" class="ui-widget" style="width:100%;background-color:#000; padding-top:4px; padding-bottom:4px;color:#FFF">
        Loading...
    </div>

    <?
    if ($_GET["tab"] == 1) {
        echo "<script>";
        echo "$( '#result' ).tabs({ active: 1 });";
        echo "</script>";
    } else if ($_GET["tab"] == 2) {
        echo "<script>";
        echo "$( '#result' ).tabs({ active: 2 });";
        echo "</script>";
    } else if ($_GET["tab"] == 3) {
        echo "<script>";
        echo "$( '#result' ).tabs({ active: 3 });";
        echo "</script>";
    } else if ($_GET["tab"] == 4) {
        echo "<script>";
        echo "$( '#result' ).tabs({ active: 4 });";
        echo "</script>";
    } else if ($_GET["tab"] == 5) {
        echo "<script>";
        echo "$( '#result' ).tabs({ active: 5 });";
        echo "</script>";
    } 
    ?>

</div>

<script type="text/javascript">
    $('#loading').hide();
    $(document).ready(function() {
        $('#body').show();
        $('#msg').hide();
    });
</script>

<script>
    $('.btn-default').on('click', function(){
        $(this).addClass('active').siblings('.btn').removeClass('active');
        param = ($(this).find('input').attr('name'));
        value = ($(this).find('input').attr('id'));
        $.getJSON('../api/includes/ws_action.php?api=/config/module/hopper/'+param+'/'+value, function(data) {});
    }); 
</script>

</body>
</html>
