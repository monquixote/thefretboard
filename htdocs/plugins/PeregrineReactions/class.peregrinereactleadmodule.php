<?php if (!defined('APPLICATION')) exit();


class PeregrineReactLeadModule extends Gdn_Module {

    public function AssetTarget() {
        return 'Panel';
    }

    public function ToString() {


        echo "<div id=\"PeregrineReactLeaderBoard\" class=\"Box PeregrineReactLeaderBoardBox\">";


        echo '<h4 id ="WeekReactTitle">';
        echo T("frets Weekly Chart");
        echo "</h4>";


        echo '<ul class="PanelInfo PanelPeregrineReactLeader">';
       
        $Limit =   C('Plugins.PeregrineReactLeaderBoard.Limit');
        if ($Limit < 1)  $Limit = 5;
        $PRBArray = PeregrineReactionsModel::TimeframePeregrineReactions($Limit,date('w'));
           
      

        for ($x = 0; $x < $Limit; $x++) {
           
            $UID =     $PRBArray[$x]['UserID'];
            $Points = $PRBArray[$x]['CountUserID'];
            $Name =   $PRBArray[$x]['Name']; 
            $Photo = $PRBArray[$x]['Photo'];
            $Email = $PRBArray[$x]['Email'];
            $Object->UserID = $UID;
            $Object->Name = $Name;
            $Object->Photo = $Photo;
            $Object->Email = $Email;  
            
            $User = UserBuilder($Object);
            $photo = UserPhoto($User, array('LinkClass' => 'ProfilePhotoCategory', 'ImageClass' => 'ProfilePhotoLeader'));
            if ($Points > 0) {
                echo '<li class="plbanchor">';
              
                $Href = "/profile/$Name/$UID";
                if ($photo) {
                    echo UserPhoto($User, array('LinkClass' => 'ProfilePhotoCategory', 'ImageClass' => 'ProfilePhotoLeader'));
                    echo UserAnchor($User);
                } else {
                   
                  echo UserAnchor($User);
                }
              
               echo "<span class=\"Aside\"><span class=\"Count\">" . T('Points: ') . $Points . "</span></span>";
                echo '</li>';
                echo "<p></p>";
            }
        }
        echo "</ul>";
        echo "</div>";
    }

}
