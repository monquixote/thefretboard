<?php if (!defined('APPLICATION'))  exit();


// Define the plugin:
$PluginInfo['DiscussionToolTip'] = array(
    'Name' => 'DiscussionToolTip',
    'Description' => 'This plugin provides a discussion excerpt tooltip popup. Hovering the mouse over Tooltip icon  brings up a tooltip that contains approximately 220 characters of the Discussion contents and what is more it does not work!',
    'Version' => '1.3',
//    'SettingsUrl' => '/dashboard/settings/discussiontooltip',
    'Author' => "Peregrine"
);

class DiscussionToolTipPlugin extends Gdn_Plugin {

   
    public function DiscussionsController_BeforeDiscussionContent_Handler($Sender) {      
		echo "potato";
       $prelink = "plugins/DiscussionToolTip/design/images/";
        $CssItem = $Sender->EventArguments['CssClass'];
        $CssItem = str_replace("Bookmarked"," ",$CssItem);
        $this->DiscussionToolTipResources($Sender);
        $bodyLine = $Sender->EventArguments['Discussion']->Body;    
        $formline = strip_tags(str_replace(array('[',']'), array('<','>'), $bodyLine));   
       $sline = substr($formline, 0, 220) . "..." ;
       $oldName = $Sender->EventArguments['Discussion']->Name;
       $oldUrl = $Sender->EventArguments['Discussion']->Url;

      
        $newTitleAnchor  = '<a href="' . $Sender->EventArguments['Discussion']->Url  . '">' .  Img($prelink . "dt.png", array('alt' => 'Tooltip', 'title' => $sline, 'class' => "Dtooltip")) . '</a>';
       
    
    
       echo $newTitleAnchor;
  
}
   
/*   
   public function SettingsController_DiscussionToolTip_Create($Sender) { 
     $Session = Gdn::Session();
        $Sender->Title('Discussion Tool Tip');
        $Sender->AddSideMenu('plugin/discussiontooltip');
        $Sender->Permission('Garden.Settings.Manage');
       
        $Sender->Render($this->GetView('dt-settings.php'));
    } 
  */  

    public function CategoriesController_BeforeDiscussionContent_Handler($Sender) {
       $this->DiscussionsController_BeforeDiscussionContent_Handler($Sender);
    }
  
  
    protected function DiscussionToolTipResources($Sender) {
       $Sender->AddCssFile('disctip.css', 'plugins/DiscussionToolTip');
    }

    public function Setup() {
        
    }


}

