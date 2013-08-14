<?php if (!defined('APPLICATION')) exit();
echo $this->Form->Open();
echo $this->Form->Errors();
?>


<h1><?php echo Gdn::Translate('Discussion Tool Tip | by: Peregrine'); ?></h1>

<div class="Info"><?php echo Gdn::Translate('Discussion Tool Tip Options.  The only option you have is to donate :)'); ?></div>


<?php echo $this->Form->Close();?>


<br />
<br />

<table>
<tr><td>
<h3><strong>Please consider making a small <i>contribution</i> to Peregrine by clicking on the <i>donate</i> button </strong> </h3>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="R78ZA8B7MTFYW">
<p></p>
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
<h3><strong>Your donations helps support development</strong></h3>
</td></tr>

</table>
