<?php if (!defined('APPLICATION')) exit();



$PluginInfo['PeregrineBadges'] = array(
    'Name' => 'Peregrine Badges',
    'Description' => "Badges for Charter member (first 100 members),Anniversaries, Comments, Thankful and/or Like Count shown in user profile and Badge Summary Page with addition of badges used in the Peregrine Reactions plugin.  ",
    'Version' => '4.1',
    'RequiredApplications' => array('Dashboard' => '>=2.0.18.1'),
    'MobileFriendly' => TRUE,
    'Requires' => FALSE,
    'HasLocale' => FALSE,
    'Author' => "Peregrine",
    'SettingsUrl' => '/dashboard/settings/peregrinebadges',
);

class PeregrineBadgesPlugin extends Gdn_Plugin {

    public function Base_Render_Before($Sender) {
        $Controller = $Sender->ControllerName;
        $ShowOnController = array(
            'profilecontroller',
        );
        if (!InArrayI($Controller, $ShowOnController))
            return;


        include_once(PATH_PLUGINS . DS . 'PeregrineBadges' . DS . 'class.peregrinebadgesmodule.php');
        $Sender->AddCssFile('peregrinebadges.css', 'plugins/PeregrineBadges');

        $PeregrineBadgesModule = new PeregrineBadgesModule($Sender);
        $Sender->AddModule($PeregrineBadgesModule);
    }
 
 
 
 public function PluginController_PeregrineBadges_Create($Sender,$Args) {
   
        $Session = Gdn::Session();

        if ($Sender->Menu)  {
            $Sender->ClearCssFiles();
            $Sender->AddCssFile('style.css');
            $Sender->AddCssFile('peregrinebadges.css', 'plugins/PeregrineBadges');
            $Sender->MasterView = 'default';
      
          
            $Sender->Render('PeregrineBadgesAll', '', 'plugins/PeregrineBadges');
           
        }
    
   
    }
 
 public function SettingsController_PeregrineBadges_Create($Sender) {
        $Session = Gdn::Session();
        $Sender->Title('Peregrine Badges');
        $Sender->AddSideMenu('plugin/peregrinebadges');
        $Sender->Permission('Garden.Settings.Manage');
        $Sender->Form = new Gdn_Form();
        $Validation = new Gdn_Validation();
        $ConfigurationModel = new Gdn_ConfigurationModel($Validation);
        $ConfigurationModel->SetField(array(
            'Plugins.PeregrineBadges.Limit'
        ));
        $Sender->Form->SetModel($ConfigurationModel);


        if ($Sender->Form->AuthenticatedPostBack() === FALSE) {
            $Sender->Form->SetData($ConfigurationModel->Data);
        } else {
            $Data = $Sender->Form->FormValues();

            if ($Sender->Form->Save() !== FALSE)
                $Sender->StatusMessage = T("Your settings have been saved.");
        }
        $Sender->Render($this->GetView('pbadges-settings.php'));
 

  }
  
  
  public function ProfileController_AddProfileTabs_handler($Sender) {
		// if(Gdn::Session()->UserID < 1) return;
	$IsMobile = (IsMobile()); 
          if ($IsMobile) {  
	    $Sender->AddProfileTab('PeregrineBadges', "/profile/peregrinebadges/".$Sender->User->UserID."/".Gdn_Format::Url($Sender->User->Name), 'PeregrineBadgesClass', T('Badges Tab'));	     
	      }
}
	
public function ProfileController_PeregrineBadges_Create($Sender, $Args) {    
        $Sender->AddCssFile('peregrinebadges.css', 'plugins/PeregrineBadges');
        $Sender->UserID = ArrayValue(0, $Sender->RequestArgs, '');
        $Sender->UserName = ArrayValue(1, $Sender->RequestArgs, '');
        $Sender->GetUserInfo($Sender->UserID, $Sender->UserName);
        $Sender->SetTabView('peregrinebadges', dirname(__FILE__).DS.'views'.DS.'peregrinebadgestabview.php', 'Profile');
        $Sender->Render();
}
	
public function ProfileController_BeforeRenderAsset_Handler($Sender) {
        $AssetName = GetValueR('EventArguments.AssetName', $Sender);

        if ($AssetName != "Content")
            return;

       $UserArgs = $Sender->User;
 
       
       $Sender->BData['UserID'] = $UserArgs->UserID;
       $Sender->BData['ThankfulCount'] = $UserArgs->ReceivedThankCount;
       $Sender->BData['LikeCount'] = $UserArgs->Liked;
       $Sender->BData['CommentCount'] = $UserArgs->CountComments;
       $Sender->BData['DateFirstVisit'] = $UserArgs->DateFirstVisit;
       $Sender->BData['PReactionOneCount'] = $UserArgs->PeregrineReactOne;
       $Sender->BData['PReactionTwoCount'] = $UserArgs->PeregrineReactTwo;
       $Sender->BData['PReactionThreeCount'] = $UserArgs->PeregrineReactThree;
       $Sender->BData['PReactionFourCount'] = $UserArgs->PeregrineReactFour;
 
    
       $this->BadgePointUpDate($Sender);
}


public function PostController_AfterCommentSave_Handler($Sender) {
        $Session = Gdn::Session();
       
       $UserArgs = $Session->User;
    
       $Sender->BData['UserID'] = $Session->UserID;
       $Sender->BData['ThankfulCount'] = $UserArgs->ReceivedThankCount;
       $Sender->BData['LikeCount'] = $UserArgs->Liked;
       $Sender->BData['CommentCount'] = $UserArgs->CountComments;
       $Sender->BData['DateFirstVisit'] = $UserArgs->DateFirstVisit;
       $Sender->BData['PReactionOneCount'] = $UserArgs->PeregrineReactOne;
       $Sender->BData['PReactionTwoCount'] = $UserArgs->PeregrineReactTwo;
       $Sender->BData['PReactionThreeCount'] = $UserArgs->PeregrineReactThree;
       $Sender->BData['PReactionFourCount'] = $UserArgs->PeregrineReactFour;
       $this->BadgePointUpDate($Sender);     
}

public function Base_AfterSignIn_Handler($Sender) {
       $Session = Gdn::Session();
      
       $UserArgs = $Session->User;
       $Sender->BData['UserID'] = $Session->UserID;
       $Sender->BData['ThankfulCount'] = $UserArgs->ReceivedThankCount;
       $Sender->BData['LikeCount'] = $UserArgs->Liked;
       $Sender->BData['CommentCount'] = $UserArgs->CountComments;
       $Sender->BData['DateFirstVisit'] = $UserArgs->DateFirstVisit;
       $Sender->BData['PReactionOneCount'] = $UserArgs->PeregrineReactOne;
       $Sender->BData['PReactionTwoCount'] = $UserArgs->PeregrineReactTwo;
       $Sender->BData['PReactionThreeCount'] = $UserArgs->PeregrineReactThree;
       $Sender->BData['PReactionFourCount'] = $UserArgs->PeregrineReactFour;
       $this->BadgePointUpDate($Sender);  
}

public function  BadgePointUpDate($Sender) {

       $UserID = $Sender->BData['UserID'];
     
        $PeregrineBadgesModel = new PeregrineBadgesModel();
 
 
        $Result = $PeregrineBadgesModel->GetBadge($UserID);
       
        if (!$Result) {
        $PeregrineBadgesModel->InitBadge($UserID);
        }
        
        // anniversaries
      
         $DateFirstVisit = $Sender->BData['DateFirstVisit'];
        $DFVtime = strtotime($DateFirstVisit);
        $ndate = Now();
        $offsetformat = T('|| F-j-Y');
        $Dtime = date($offsetformat, $DFVtime);
        $Ntime = date($offsetformat, $ndate);
        $Anniversaries = floor(($ndate - $DFVtime) / (24 * 3600 * 365));
        $CountAb = $PeregrineBadgesModel->GetCountAnniversaryBadge($UserID);
        if ($DateFirstVisit == "0000-00-00 00:00:00") $Anniversaries = 0;
        if ($Anniversaries > $CountAb) {
               $PeregrineBadgesModel->UpdateAnniversaryBadge($UserID, $Anniversaries);
               Gdn::Controller()->InformMessage(T('You received an Anniversary Badge.')); 
        }
        // comments  1, 10,100.500.1000,2500,5000,10000

        $ComArray = Array(0, 1, 10, 100, 500, 1000, 2500, 5000, 10000);

         
          $CommentCount = $Sender->BData['CommentCount'];
        
        if ($CommentCount >= $ComArray[8]) {
            $CountCom = 8;
        } elseif ($CommentCount >= $ComArray[7]) {
            $CountCom = 7;
        } elseif ($CommentCount >= $ComArray[6]) {
            $CountCom = 6;
        } elseif ($CommentCount >= $ComArray[5]) {
            $CountCom = 5;
        } elseif ($CommentCount >= $ComArray[4]) {
            $CountCom = 4;
        } elseif ($CommentCount >= $ComArray[3]) {
            $CountCom = 3;
        } elseif ($CommentCount >= $ComArray[2]) {
            $CountCom = 2;
        } elseif ($CommentCount >= $ComArray[1]) {
            $CountCom = 1;
        }

        $CountCb = $PeregrineBadgesModel->GetCountCommentBadge($UserID);
        if ($CountCom > $CountCb) {     
            $PeregrineBadgesModel->UpdateCommentBadge($UserID, $CountCom);
            Gdn::Controller()->InformMessage(T('You received a Comment Badge.'));
        }
        // thankful
        // thankful 1, 10,100.500.1000,2500,5000,10000
        if (C('EnabledPlugins.ThankfulPeople') == TRUE) {
            $HBArray = Array(0, 1, 10, 100, 500, 1000, 2500, 5000, 10000);
            
             $HBCount =  $Sender->BData['ThankfulCount'];

            if ($HBCount >= $HBArray[8]) {
                $CountH = 8;
            } elseif ($HBCount >= $HBArray[7]) {
                $CountH = 7;
            } elseif ($HBCount >= $HBArray[6]) {
                $CountH = 6;
            } elseif ($HBCount >= $HBArray[5]) {
                $CountH = 5;
            } elseif ($HBCount >= $HBArray[4]) {
                $CountH = 4;
            } elseif ($HBCount >= $HBArray[3]) {
                $CountH = 3;
            } elseif ($HBCount >= $HBArray[2]) {
                $CountH = 2;
            } elseif ($HBCount >= $HBArray[1]) {
                $CountH = 1;
            }

            $CountHB = $PeregrineBadgesModel->GetCountThankfulBadge($UserID);
            if ($CountH > $CountHB) {
                 $PeregrineBadgesModel->UpdateThankfulBadge($UserID, $CountH);
                 Gdn::Controller()->InformMessage(T('You received a Thankful Badge.')); 
            }
        }
      
        //liked
        if (C('EnabledPlugins.LikeThis') == TRUE) {
            $HBArray = Array(0, 1, 10, 100, 500, 1000, 2500, 5000, 10000);

            $HBCount =   $Sender->BData['LikeCount'];

            if ($HBCount >= $HBArray[8]) {
                $CountH = 8;
            } elseif ($HBCount >= $HBArray[7]) {
                $CountH = 7;
            } elseif ($HBCount >= $HBArray[6]) {
                $CountH = 6;
            } elseif ($HBCount >= $HBArray[5]) {
                $CountH = 5;
            } elseif ($HBCount >= $HBArray[4]) {
                $CountH = 4;
            } elseif ($HBCount >= $HBArray[3]) {
                $CountH = 3;
            } elseif ($HBCount >= $HBArray[2]) {
                $CountH = 2;
            } elseif ($HBCount >= $HBArray[1]) {
                $CountH = 1;
            }

            $CountHB = $PeregrineBadgesModel->GetCountLikedBadge($UserID);
            if ($CountH > $CountHB) {       
              $PeregrineBadgesModel->UpdateLikedBadge($UserID, $CountH);
              Gdn::Controller()->InformMessage(T('You received a Like Badge.'));  
            }
        }
       
         if (C('EnabledPlugins.PeregrineReactions') == TRUE) {
           
            
            $PR1Array = Array(0, 1, 10, 100, 500, 1000, 2500, 5000, 10000);

            $PR1Count =   $Sender->BData['PReactionOneCount'];


            if ($PR1Count >= $PR1Array[8]) {
                $CountPR1 = 8;
            } elseif ($PR1Count >= $PR1Array[7]) {
                $CountPR1 = 7;
            } elseif ($PR1Count >= $PR1Array[6]) {
                $CountPR1 = 6;
            } elseif ($PR1Count >= $PR1Array[5]) {
                $CountPR1 = 5;
            } elseif ($PR1Count >= $PR1Array[4]) {
                $CountPR1 = 4;
            } elseif ($PR1Count >= $PR1Array[3]) {
                $CountPR1 = 3;
            } elseif ($PR1Count >= $PR1Array[2]) {
                $CountPR1 = 2;
            } elseif ($PR1Count >= $PR1Array[1]) {
                $CountPR1 = 1;
            }

            $CountPRBOne = $PeregrineBadgesModel->GetCountPRBadgeOne($UserID);
       
            if ($CountPR1 > $CountPRBOne) {       
              $PeregrineBadgesModel->UpdatePRBadgeOne($UserID,$CountPR1 );
              Gdn::Controller()->InformMessage(T('You received a Reaction One Badge.'));  
            }
        }
        
          if (C('EnabledPlugins.PeregrineReactions') == TRUE) {
            $PR2Array = Array(0, 1, 10, 100, 500, 1000, 2500, 5000, 10000);

            $PR2Count =   $Sender->BData['PReactionTwoCount'];

            if ($PR2Count >= $PR2Array[8]) {
                $CountPR2 = 8;
            } elseif ($PR2Count >= $PR2Array[7]) {
                $CountPR2 = 7;
            } elseif ($PR2Count >= $PR2Array[6]) {
                $CountPR2 = 6;
            } elseif ($PR2Count >= $PR2Array[5]) {
                $CountPR2 = 5;
            } elseif ($PR2Count >= $PR2Array[4]) {
                $CountPR2 = 4;
            } elseif ($PR2Count >= $PR2Array[3]) {
                $CountPR2 = 3;
            } elseif ($PR2Count >= $PR2Array[2]) {
                $CountPR2 = 2;
            } elseif ($PR2Count >= $PR2Array[1]) {
                $CountPR2 = 1;
            }

            $CountPRBTwo = $PeregrineBadgesModel->GetCountPRBadgeTwo($UserID);
            if ($CountPR2 > $CountPRBTwo) {       
              $PeregrineBadgesModel->UpdatePRBadgeTwo($UserID, $CountPR2);
              Gdn::Controller()->InformMessage(T('You received a Reaction Two Badge.'));  
            }
        }
        
       if (C('EnabledPlugins.PeregrineReactions') == TRUE) {
            $PR3Array = Array(0, 1, 10, 100, 500, 1000, 2500, 5000, 10000);
         
            
            $PR3Count =   $Sender->BData['PReactionThreeCount'];

            if ($PR3Count >= $PR3Array[8]) {
                $CountPR3 = 8;
            } elseif ($PR3Count >= $PR3Array[7]) {
                $CountPR3 = 7;
            } elseif ($PR3Count >= $PR3Array[6]) {
                $CountPR3 = 6;
            } elseif ($PR3Count >= $PR3Array[5]) {
                $CountPR3 = 5;
            } elseif ($PR3Count >= $PR3Array[4]) {
                $CountPR3 = 4;
            } elseif ($PR3Count >= $PR3Array[3]) {
                $CountPR3 = 3;
            } elseif ($PR3Count >= $PR3Array[2]) {
                $CountPR3 = 2;
            } elseif ($PR3Count >= $PR3Array[1]) {
                $CountPR3 = 1;
            }

            $CountPRBThree = $PeregrineBadgesModel->GetCountPRBadgeThree($UserID);
            if ($CountPR3 > $CountPRBThree) {       
              $PeregrineBadgesModel->UpdatePRBadgeThree($UserID, $CountPR3);
              Gdn::Controller()->InformMessage(T('You received a Reaction Three Badge.'));  
            }
        }   
        
       if (C('EnabledPlugins.PeregrineReactions') == TRUE) {
            $PR4Array = Array(0, 1, 10, 100, 500, 1000, 2500, 5000, 10000);

            $PR4Count =   $Sender->BData['PReactionFourCount'];

            if ($PR4Count >= $PR4Array[8]) {
                $CountPR4 = 8;
            } elseif ($PR4Count >= $PR4Array[7]) {
                $CountPR4 = 7;
            } elseif ($PR4Count >= $PR4Array[6]) {
                $CountPR4 = 6;
            } elseif ($PR4Count >= $PR4Array[5]) {
                $CountPR4 = 5;
            } elseif ($PR4Count >= $PR4Array[4]) {
                $CountPR4 = 4;
            } elseif ($PR4Count >= $PR4Array[3]) {
                $CountPR4 = 3;
            } elseif ($PR4Count >= $PR4Array[2]) {
                $CountPR4 = 2;
            } elseif ($PR4Count >= $PR4Array[1]) {
                $CountPR4 = 1;
            }

            $CountPRBFour = $PeregrineBadgesModel->GetCountPRBadgeFour($UserID);
            if ($CountPR4 > $CountPRBFour) {       
              $PeregrineBadgesModel->UpdatePRBadgeFour($UserID, $CountPR4);
              Gdn::Controller()->InformMessage(T('You received a Reaction Four Badge.'));  
            }
        }     
        
     
        $this->AddPoints($Sender);
    }

    public function AddPoints($Sender) {
        $UserID = $Sender->BData['UserID'];
        
        $CountAb = $CountCb = $CountT = $CountL = 0;
        $CountPRBOne = $CountPRBTwo = $CountPRBThree = $CountPRBFour = 0;
        $PeregrineBadgesModel = new PeregrineBadgesModel();
        
        $Result = $PeregrineBadgesModel->GetBadge($UserID);
        
        $CountAB = $Result[0]['AnniversaryBadge'];
        $CountCB = $Result[0]['CommentBadge'];

        if (C('EnabledPlugins.ThankfulPeople') == TRUE) {
            $CountTB = $Result[0]['ThankfulBadge'];
            $ThankfulCount =   $Sender->BData['ThankfulCount'];
        }
      
        if (C('EnabledPlugins.LikeThis') == TRUE) {
            $CountLB = $Result[0]['LikedBadge'];
            $LikedCount =  $Sender->BData['LikeCount'] ;
        }
        
        
         if (C('EnabledPlugins.PeregrineReactions') == TRUE) {
            $CountPRBOne= $Result[0]['PRBadgeOne'];
            $PBOneCount =  $Sender->BData['PReactionOneCount'] ;
          
            $CountPRBTwo= $Result[0]['PRBadgeTwo'];
            $PBTwoCount =  $Sender->BData['PReactionTwoCount'] ;
         
            $CountPRBThree= $Result[0]['PRBadgeThree'];
            $PBThreeCount =  $Sender->BData['PReactionThreeCount'] ;
        
            $CountPRBFour= $Result[0]['PRBadgeFour'];
            $PBFourCount =  $Sender->BData['PReactionFourCount'] ;
        
         }
        
        
        
      
        // 5 points per badge
        $CountAB = $CountAB * 5;
        $CountCB = $CountCB * 5;
        $CountTB = $CountTB * 5;
        $CountLB = $CountLB * 5;
        $CountPRBOne = $CountPRBOne * 5;
        $CountPRBTwo = $CountPRBTwo * 5;
        $CountPRBThree = $CountPRBThree * 5;
        $CountPRBFour = $CountPRBFour * 5;
        
   
        $BadgePoints = $CountAB + $CountCB + $CountTB + $CountLB;
        $BadgePoints = $BadgePoints + $CountPRBOne + $CountPRBTwo + $CountPRBThree + $CountPRBFour;
        
        
         $CharterPoints = 0;
         if ($UserID < 101) {
           $CharterPoints = 10;
           }

        $OtherPoints = $ThankfulCount + $LikedCount;
        $OtherPoints = $OtherPoints + $PBOneCount + $PBTwoCount + $PBThreeCount + $PBFourCount;
        $TotalPoints = $BadgePoints + $OtherPoints + $CharterPoints;
        
        $PeregrineBadgesModel->UpdatePoints($UserID, $TotalPoints);
       
    }
   
    public function OnDisable() {
	          $matchroute = '^badges(/.*)?$';
             
	           Gdn::Router()-> DeleteRoute($matchroute); 
	
	}
    public function Setup() {
      
 
             $matchroute = '^badges(/.*)?$';
             $target = 'plugin/PeregrineBadges$1';
        
             if(!Gdn::Router()->MatchRoute($matchroute))
                  Gdn::Router()->SetRoute($matchroute,$target,'Internal'); 

      
        $Construct = Gdn::Structure();

        $Construct->Table('PeregrineBadges')
                ->PrimaryKey('id')
                ->Column('UserId', 'int(11)')
                ->Column('Points', 'int(11)')
                ->Column('AnniversaryBadge', 'tinyint(4)')
                ->Column('CommentBadge', 'tinyint(4)')
                ->Column('ThankfulBadge', 'tinyint(4)')
                ->Column('LikedBadge', 'tinyint(4)')
                ->Column('PRBadgeOne', 'tinyint(4)')
                ->Column('PRBadgeTwo', 'tinyint(4)')
                ->Column('PRBadgeThree', 'tinyint(4)')
                ->Column('PRBadgeFour', 'tinyint(4)')
                ->Set(FALSE, FALSE);
    }

}
