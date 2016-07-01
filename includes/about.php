<style>
	.block {
		width: 200px;
		display: inline-block;
	}
</style>
<b>Hopper</b> A tool for channel hopping.
<br><br>
<b>Author</b>: xtr4nge [_AT_] gmail.com - @xtr4nge

<br><br>

<br><b>[OPTIONS]</b>
<br>
<br><b>Delay</b>: time between hops.
<br><b>Channel</b>: list for channel hopping. (If Channel is disabled, the default list is applied [1 to 12])

<br><br><br>

<div style="font-family: courier, monospace;">
Command line usage: ./channel-hopping.py -i INTERFACE {options}
<br>
<br>Options:
<br><div class="block">-i [i], --interface=[i]</div> 		set interface (default: mon0)"
<br><div class="block">-t [time], --time=[time]</div> 		scan time"
<br><div class="block">-d [seconds] --delay=[seconds]</div> seconds between alerts (default: 1)"
<br><div class="block">-c [values] --channel=[values]</div> list of channels (default: 1,2,3,4,5,6,7,8,9,10,11,12)"
<br><div class="block">-h</div> 							Print this help message."

</div>
