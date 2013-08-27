<?php if (!defined('APPLICATION')) exit();



$PluginInfo['PeregrineReactions'] = array(
    'Name' => 'Peregrine Reactions - Monquixote Edition',
    'Description' => "Peregrine Reactions - Monquixote edition tweaked by the Cat with a Banjo ",
    'Version' => '2.3',
    'RequiredApplications' => array('Vanilla' => '2.1a'),
    'RequiredTheme' => FALSE,
    'RequiredPlugins' => FALSE,
    'HasLocale' => TRUE,
    'SettingsUrl' => '/dashboard/settings/peregrinereactions',
    'RegisterPermissions' => array('Plugins.PeregrineReactions.AllowReact'),
    'Author' => "Peregrine",
    'MobileFriendly' => TRUE,
);



include_once(PATH_PLUGINS . '/PeregrineReactions/peregrinereactionsmodel.php');

class PeregrineReactions extends Gdn_Plugin {
 
 
   public function SettingsController_PeregrineReactions_Create($Sender) { 
     $Session = Gdn::Session();
        $Sender->Title('Peregine Reactions');
        $Sender->AddSideMenu('plugin/peregrinereactions');
        $Sender->Permission('Garden.Settings.Manage');
        $Sender->Render($this->GetView('peregrinereactions-settings.php'));
    } 
 
 public function DiscussionController_AfterDiscussionTitle_Handler($Sender) {
      $DID= $Sender->EventArguments['Discussion']->DiscussionID;
      $PeregrineReactionsModel = new PeregrineReactionsModel();
      $HotPR = $PeregrineReactionsModel->WhatsHotPeregrineReactions($DID);
      if ($HotPR > 0)
      echo Wrap(Anchor(T("What's Hot"), "discussion/comment/$HotPR/#Comment_$HotPR", 'Button'),"span");
}
     
/*
 public function DiscussionsController_AfterDiscussionTitle_Handler($Sender) {
    $DID= $Sender->EventArguments['Discussion']->DiscussionID;
    $PeregrineReactionsModel = new PeregrineReactionsModel();
    $TotDiscPeregrineReactions = $PeregrineReactionsModel->TotDiscPeregrineReactions($DID);   
     if($TotDiscPeregrineReactions)
   		 echo  '<span class="PeregrineTotReaction">' . T("Frets:") . $TotDiscPeregrineReactions .'</span> ';
 }
*/



    public function DiscussionController_AuthorInfo_Handler($Sender) {
    $AuthorInfo = $Sender->EventArguments['Author'];
    $totalreactionpoints = $AuthorInfo->PeregrineReactOne + $AuthorInfo->PeregrineReactTwo + $AuthorInfo->PeregrineReactThree;
    echo sprintf(T('Frets: %1s'), $totalreactionpoints);
    }



    public function ProfileController_AfterAddSidemenu_Handler($Sender) {
        $this->PR_Attach_Resources($Sender);
    }

    public function DiscussionController_Render_Before($Sender) {
        $this->PR_Attach_Resources($Sender);
    }
     public function DiscussionsController_Render_Before($Sender) {
     if (!C('Plugins.PeregrineReactions.NoLeaderBoard')) {
      $PeregrineReactLeadModule = new PeregrineReactLeadModule($Sender);
      $Sender->AddModule($PeregrineReactLeadModule);
      }
        $this->PR_Attach_Resources($Sender);
    }
    
  public function CategoryController_Render_Before($Sender) {
      if (!C('Plugins.PeregrineReactions.NoLeaderBoard')) {
      $PeregrineReactLeadModule = new PeregrineReactLeadModule($Sender);
      $Sender->AddModule($PeregrineReactLeadModule);
      }
       
        $this->PR_Attach_Resources($Sender);
    }
    
    public function PR_Attach_Resources($Sender) {
        $Sender->AddCssFile('peregrinereactions.css', 'plugins/PeregrineReactions');
        $Sender->AddJsFile('peregrinereactions.js', 'plugins/PeregrineReactions');
    }

    public function DiscussionController_PeregrineReactions_Create($Sender, $Args) {

        $SessionUserID = Gdn::Session()->UserID;
        if (!$SessionUserID) {
            echo T("You need to log in to react to comments");
            return;
        }
        if (!($UserID = $SessionUserID))
            return;

        if (count($Args) != "3") {
            echo (T("invalid request"));
            throw new Exception('Too Few Args - Invalid.');

            return;
        }


        switch (strtolower(GetValue(0, $Args))) {
            case "comment":
                $recordtype = "Comment";
                break;
            case "discussion":
                $recordtype = "Discussion";
                break;
        }

        switch ((GetValue(1, $Args))) {
            case "1":
                $reactiontype = "A";
                $reactionid = "1";
                break;
            case "2":
                $reactiontype = "B";
                $reactionid = "2";
                break;
            case "3":
                $reactiontype = "C";
                $reactionid = "3";
                break;
            case "4":
                $reactiontype = "D";
                $reactionid = "4";
                break;
        }

        if (GetValue(2, $Args) > 0) {
            $recordid = GetValue(2, $Args);
        }

        $answer = "recordtype is $recordtype - ";
        $answer .= "reactiontype is $reactiontype - ";
        $answer .= "recordid is $recordid";

        $PeregrineReactionsModel = new PeregrineReactionsModel();
        $Reactions = $PeregrineReactionsModel->UpdateReactions($recordtype, $recordid, $reactionid);
 
        if (is_array($Reactions)) {
            echo json_encode($Reactions);
        }
    }

    public function ProfileController_AfterUserInfo_Handler($Sender) {

        $Userinfo = $Sender->User;

     echo '<div class="ProfilePReactionBox">';           
      echo '<p class="PRTitle">' . T("ReactionsTitle") . "</p>";     
             
         
               $URarray = array(
                 T("funny")=> $Userinfo->PeregrineReactOne,
                 T("wow")=>$Userinfo->PeregrineReactTwo,
                 T("scholarly")=>$Userinfo->PeregrineReactThree,
                 T("artistic")=> $Userinfo->PeregrineReactFour,
                 );

        $UserTotReact = array_sum($URarray); 
        $increment = (170 /$UserTotReact);
     
       
       echo "<table>";
          echo "<tr>";
          echo "<td>";
            echo "<table class= ProfilePRGraphTable>";

           foreach ($URarray as $k => $v) {
 
            $Percentage = round(($v / $UserTotReact) * 100, 1);
            $width = floor($v * $increment) . "px";
            echo "<tr class=\"answerblock\" >";
            echo "<td> $k </td>";
            echo "<td>";
            echo "<div class=\"reactbar\" style=\"width:$width\">-</div>";
            echo "</td><td class=\"reactpercentage\">";
            echo "<span class=\"reactpercentage\">$Percentage%</span>";
            echo "</td>";
            echo "</tr>";
            }

            echo "</table>";

         echo "</td>";
          echo "<td>";
         


        echo "<table class= ProfilePRTable>";
        echo "<tr><td>";


        echo Gdn_Format::BigNumber($Userinfo->PeregrineReactOne);
        echo "</td><td>";
        echo Gdn_Format::BigNumber($Userinfo->PeregrineReactTwo);
        echo "</td><td>";
        echo Gdn_Format::BigNumber($Userinfo->PeregrineReactThree);
        echo "</td><td>";
        echo Gdn_Format::BigNumber($Userinfo->PeregrineReactFour);


        echo "</td>";
        echo "</tr>";
        echo '<tr><th>';
        echo T("funny");
        echo "</th><th>";
        echo T("wow");
        echo "</th><th>";
        echo T("scholarly");
        echo "</th><th>";
        echo T("artistic");
        echo "</th>";
        echo "</tr>";
        echo "</table>";
     
      
      echo "</td>";
       echo "</tr>";
       echo "</table>";
      
        echo '</div>';
    }

    public function DiscussionController_BeforePeregrineReactions_Handler($Sender, $Args) {

        $CountValues = array();
        $this->ShowUserReactions($Sender);
    }

    public function DiscussionController_AfterReactions_Handler($Sender, $Args) {

        Gdn::Controller()->FireEvent('BeforePeregrineReactions');
        $CountValues = array();

        $CountValues = $Sender->MyReactionCountData;
        $React[1] = T("funny");
        $TitleReact[1] = "Click me if your sides are splitting";
        $React[2] = T("wow");
        $TitleReact[2] = "Click me if you are awed";
        $React[3] = T("scholarly");
        $TitleReact[3] = T("Click me if you learned something");
        $React[4] = T("artistic");
        $TitleReact[4] = T("Click me if your head is in your hands");

        $RecordType = $Args['RecordType'];
        $RecordID = $Args['RecordID'];

     //   echo '<div class="Reactions ReactionClass">';


        for ($x = 1; $x <= 4; $x++) {
            if (!isset($CountValues[$x]))
                $CountValues[$x] = 0;
            echo '<span class="ReactionCount';
            if ($CountValues[0] == $x) {
                echo " MyReactClick";
            }
            echo '">' . $CountValues[$x];

            echo '</span>';

            $Image = Img("plugins/PeregrineReactions/design/images/ClickReaction-" . $x . ".png", array('alt' => 'reaction image', 'class' => "ProfilePhotoSmall"));
//Monquixote changes
            echo '<span class="PeregrineClick React-' . $x . '"  <a href="index.php?p=/discussion/peregrinereactions/' . "$RecordType/$x/$RecordID" . '" title="' . "xx" . $TitleReact[$x] . '" rel="nofollow">' . $Image . " " . $React[$x] . ' </a></span>';
        }
        echo '<span class="afterperegrinereaction"> </span>';
    }

    public function ShowUserReactions($Sender) {
        $MeID = Gdn::Session()->UserID;
        $Reactions = array();
        if ($Sender->EventArguments['Type'] == 'Discussion') {

            $RecordID = $Sender->DiscussionID;
            $PostType = "Discussion";
        } elseif ($Sender->EventArguments['Type'] == 'Comment') {

            $RecordID = ($Sender->EventArguments['Comment']->CommentID);
            $PostType = "Comment";
        }

        $PeregrineReactionsModel = new PeregrineReactionsModel();
        $Result = $PeregrineReactionsModel->GetReactions($PostType, $RecordID);

        $React = array();
        $React[1] = T("funny");
        $React[2] = T("wow");
        $React[3] = T("scholarly");
        $React[4] = T("artistic");


        $Reactors = array();
        $Reactions = array();
        $ReactorDateArr = array();
        $ReactionTypeArr = array();
        if (is_array($Result)) {
            foreach ($Result as $Reaction) {
                $ReactorID = $Reactors[] = $Reaction['InsertUserID'];
                $ReactorDateArr[$ReactorID] = Gdn_Format::DateFull($Reaction['DateInserted']);
                $ReactionTypeArr[$ReactorID] = $Reaction['ReactionType'];
            }

            $myreaction = 0;
            if (isset($ReactionTypeArr[$MeID])) {
                $myreaction = $ReactionTypeArr[$MeID];
            }


            $CountValues = (array_count_values($ReactionTypeArr));
            $Sender->MyReactionCountData = array();
            $Sender->MyReactionCountData = $CountValues;
            $Sender->MyReactionCountData[0] = $myreaction;
            foreach ($Reactors as $val) {
                $Reactor = Gdn::UserModel()->GetID($val);
                $Reactorname = GetValue('Name', $Reactor);
                $ReactorDate = $ReactorDateArr[$val];
                $ReactionType = $ReactionTypeArr[$val];
/*
                $photo = UserPhoto($Reactor, array('ImageClass' => 'ProfilePhotoCircle', 'Title' => sprintf(T('%1$s reacted %2$s on %3$s'), $Reactorname, $React[$ReactionType], $ReactorDate)));
                echo '<span class="ReactantWrap">';
                if ($photo) {
                    echo $photo;
                    echo '</span>';
                    echo '<span class="RImage-' . $ReactionType . '"> </span>';
                } else {

                    echo Wrap(UserAnchor($Reactor), 'span', array('Title' => " \"$React[$ReactionType]\"  $Reactorname  ($ReactorDate)"));
                    echo '<span class="RImageName-' . $ReactionType . '"> </span>';
                }
                echo '</span>'; // end ReactantWrap span
*/
            }
        } // end if isarray
    }

    public function Setup() {

        $Construct = Gdn::Structure();


        $Construct->Table('PeregrineReactions')
                ->Column('UserID', 'int(11)', False, 'key')
                ->Column('InsertUserID', 'int(11)', False, 'key')
                ->Column('CommentID', 'int(11)', TRUE)
                ->Column('DiscussionID', 'int(11)', TRUE)
                ->Column('Paterfamilias', 'int(11)', TRUE)
                ->Column('DateInserted', 'datetime')
                ->Column('ReactionType', 'int(11)', FALSE)
                ->Set();

        $Construct->Table('User')
                ->Column('PeregrineReactOne', 'int(11)', 0)
                ->Column('PeregrineReactTwo', 'int(11)', 0)
                ->Column('PeregrineReactThree', 'int(11)', 0)
                ->Column('PeregrineReactFour', 'int(11)', 0)
                ->Set();
    }

}  
 
  
  

