<?php if (!defined('APPLICATION'))exit();
echo $this->Form->Open();
echo $this->Form->Errors();
?>


<h1><?php echo Gdn::Translate('Peregrine Badges | by: Peregrine'); ?></h1>

<div class="Info"><?php echo Gdn::Translate("You know, you can make a donation, if you use this plugin.  Believe it on not, plugins don't grow on trees.  This is how YOU can contribute to the community, by paying back."); ?></div>

<table class="AltRows">
    <thead>
        <tr>
            <th class="Alt"><?php echo Gdn::Translate('Description'); ?></th>
            <th><?php echo Gdn::Translate('Option'); ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="Alt">
             <?php echo Gdn::Translate('Enter the maximum number of Users to list in the Peregrine Badge Summary Page'); ?>
            </td>
  
            <td>

                <?php
                $Options = array('20' => '20' , '30' => '30' ,'40' => '40' ,'40' => '40' ,'50' => '50' ,'60' => '60', '70' => '70', '80' => '80', '90' => '90', '100' => '100', '150' => '150', '200' => '200','300' => '300','400' => '400','500' => '500');
                $Fields = array('TextField' => 'Code', 'ValueField' => 'Code');
                echo $this->Form->DropDown('Plugins.PeregrineBadges.Limit', $Options, $Fields);
                ?>

            </td>
          
        </tr>
  </tbody> 
</table>
<br />
<br />

<?php echo $this->Form->Close();?>


<br />
<br />

<table>
<tr><td>
<h3><strong>Please make a small <i>donation of $10 or more</i> to Peregrine by clicking on the <i>donate</i> button </strong> </h3>
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


