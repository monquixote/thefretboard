<?php if (!defined('APPLICATION')) exit();


class PeregrineBadgesModule extends Gdn_Module {

    public function AssetTarget() {
          return "Panel";   
    }

    public function ToString() {




        $UserID = $this->_Sender->User->UserID;

        echo "<div id=\"PeregrineBadges\" class=\"Box PeregrineBadgesBox\">";

        echo "<ul class=\"PanelInfo PanelPeregrineBadges\">";

        echo "<h4>";
        echo T('My Badges');
        echo "</h4>";
      
        $Result = PeregrineBadgesModel::GetTotals($UserID);
        $CountAB = $Result[0]['AnniversaryBadge'];
        $CountCB = $Result[0]['CommentBadge'];
        $CountTB = $Result[0]['ThankfulBadge'];
        $CountLB = $Result[0]['LikedBadge'];
        $CountPRB1 = $Result[0]['PRBadgeOne'];
        $CountPRB2 = $Result[0]['PRBadgeTwo'];
        $CountPRB3 = $Result[0]['PRBadgeThree'];
        $CountPRB4 = $Result[0]['PRBadgeFour'];
        $Points = $Result[0]['Points'];
        if ($Points < 1) $Points = 0;
       
        
       
        echo "<strong>" . T('Total Points: ') . $Points . "</strong><br />";

        $prelink = "plugins/PeregrineBadges/design/images/";
        $badgepage = '/badges/index.php?badgetype=';
        $self = $_SERVER['PHP_SELF'];
       $badgepage = str_replace("/index.php",$badgepage,$self);
     
            
      
       
         // add a charter badge
         if ($UserID < 101) {
        //  echo Img($prelink . $counter . "charter.png", array('alt' => 'Charter', 'title' => sprintf(T('Charter Badge'), $counter), 'class' => "PeregrineBadgesSmall"));
       echo '<a href="' . $badgepage . "CharterBadge" . '">' .  Img($prelink . "charter.png", array('alt' => 'Charter', 'title' => sprintf(T('Charter')), 'class' => "PeregrineBadgesSmall")) . '</a>';
        }
       
       
        for ($counter = 1; $counter <= $CountAB; $counter++) {
       //   echo '<a href="' . $badgepage . "AnniversaryBadge" . '">' . Img($prelink . $counter . "av.png", array('alt' => 'Anniversary', 'title' => sprintf(T('Anniversary Number %s'), $counter), 'class' => "PeregrineBadgesSmall")) .'</a>';
       
   //    echo  Img($prelink . $counter . "av.png", array('alt' => 'Anniversary', 'title' => sprintf(T('Anniversary Number %s'), $counter), 'class' => "PeregrineBadgesSmall"));
      
         echo '<a href="' . $badgepage . "AnniversaryBadge" . '">' .  Img($prelink . $counter . "av.png", array('alt' => 'Anniversary', 'title' => sprintf(T('%s year Anniversary'), $counter), 'class' => "PeregrineBadgesSmall")) . '</a>';
        }
      
      
        $ComArray = Array(0, 1, 10, 100, 500, 1000, 2500, 5000, 10000);
        for ($counter = 1; $counter <= $CountCB; $counter++) {

           echo '<a href="' . $badgepage . "CommentBadge" . '">' .  Img($prelink . $counter . "comment.png", array('alt' => 'Comments', 'title' => sprintf(T('Comment %s'), $ComArray[$counter]), 'class' => "PeregrineBadgesSmall")) . '</a>';
        }
        if (C('EnabledPlugins.ThankfulPeople') == TRUE) {
            $HBArray = Array(0, 1, 10, 100, 500, 1000, 2500, 5000, 10000);
            for ($counter = 1; $counter <= $CountTB; $counter++) {

              echo '<a href="' . $badgepage . "ThankfulBadge" . '">' . Img($prelink . $counter . "hb.png", array('alt' => 'Likes', 'title' => sprintf(T('Likes %s'), $HBArray[$counter]), 'class' => "PeregrineBadgesSmall")) . '</a>';
         
         
            }
        }

        if (C('EnabledPlugins.LikeThis') == TRUE) {
            $HBArray = Array(0, 1, 10, 100, 500, 1000, 2500, 5000, 10000);
            for ($counter = 1; $counter <= $CountLB; $counter++) {

               echo '<a href="' . $badgepage . "LikedBadge" . '">' . Img($prelink . $counter . "hb.png", array('alt' => 'Likes', 'title' => sprintf(T('Likes %s'), $HBArray[$counter]), 'class' => "PeregrineBadgesSmall")) . '</a>';
            }
        }

        if (C('EnabledPlugins.PeregrineReactions') == TRUE) {
            $PRB1Array = Array(0, 1, 10, 100, 500, 1000, 2500, 5000, 10000);           
            for ($counter = 1; $counter <= $CountPRB1; $counter++) {
               echo '<a href="' . $badgepage . "PRBadgeOne" . '">' . Img($prelink . $counter . "prbone.png", array('alt' => 'PRB1', 'title' => sprintf(T('Peregrine Reaction One %s'), $PRB1Array[$counter]), 'class' => "PeregrineBadgesSmall")) . '</a>';
            }
        
        $PRB2Array = Array(0, 1, 10, 100, 500, 1000, 2500, 5000, 10000);
           
            for ($counter = 1; $counter <= $CountPRB2; $counter++) {
               echo '<a href="' . $badgepage . "PRBadgeTwo" . '">' . Img($prelink . $counter . "prbtwo.png", array('alt' => 'PRB2', 'title' => sprintf(T('Peregrine Reaction Two %s'), $PRB2Array[$counter]), 'class' => "PeregrineBadgesSmall")) . '</a>';
            }
        
         $PRB3Array = Array(0, 1, 10, 100, 500, 1000, 2500, 5000, 10000);
          for ($counter = 1; $counter <= $CountPRB3; $counter++) {
               echo '<a href="' . $badgepage . "PRBadgeThree" . '">' . Img($prelink . $counter . "prbthree.png", array('alt' => 'PRB3', 'title' => sprintf(T('Peregrine Reaction Three %s'), $PRB3Array[$counter]), 'class' => "PeregrineBadgesSmall")) . '</a>';
            }
        
           $PRB4Array = Array(0, 1, 10, 100, 500, 1000, 2500, 5000, 10000);         
          for ($counter = 1; $counter <= $CountPRB4; $counter++) {
            echo '<a href="' . $badgepage . "PRBadgeFour" . '">' . Img($prelink . $counter . "prbfour.png", array('alt' => 'PRB4', 'title' => sprintf(T('Peregrine Reaction Four %s'), $PRB4Array[$counter]), 'class' => "PeregrineBadgesSmall")) . '</a>';
            }
        
     
        } 

     $SpecialBadgeA = C('Plugins.PeregrineBadges.SpecialBadgeA') ;
     if($SpecialBadgeA) {
     $title = $SpecialBadgeA[0];
     for ($x=1; $x < count( $SpecialBadgeA);$x++) {
            $id =  $SpecialBadgeA[$x];
            if ($id == $UserID) {
            $image = Img($prelink ."sba.png", array('alt' => 'Special Badge', 'title' => sprintf(T('%s'), $SpecialBadgeA[0]), 'class' => "PeregrineBadgesSmall"));
           echo '<a href="' . $badgepage . "SpecialBadgeA" . '">' . $image . '</a>';
            }
           
         }
     }

  $SpecialBadgeB = C('Plugins.PeregrineBadges.SpecialBadgeB') ;
     if($SpecialBadgeB) {
     $title = $SpecialBadgeB[0];
     for ($x=1; $x < count( $SpecialBadgeB);$x++) {
            $id =  $SpecialBadgeB[$x];
            if ($id == $UserID) {
            $image = Img($prelink ."sbb.png", array('alt' => 'Special Badge', 'title' => sprintf(T('%s'), $SpecialBadgeB[0]), 'class' => "PeregrineBadgesSmall"));
           echo '<a href="' . $badgepage . "SpecialBadgeB" . '">' . $image . '</a>';
            }
           
         }
     }

$SpecialBadgeC = C('Plugins.PeregrineBadges.SpecialBadgeC') ;
     if($SpecialBadgeC) {
     $title = $SpecialBadgeC[0];
     for ($x=1; $x < count( $SpecialBadgeC);$x++) {
            $id =  $SpecialBadgeC[$x];
            if ($id == $UserID) {
            $image = Img($prelink ."sbc.png", array('alt' => 'Special Badge', 'title' => sprintf(T('%s'), $SpecialBadgeC[0]), 'class' => "PeregrineBadgesSmall"));
           echo '<a href="' . $badgepage . "SpecialBadgeC" . '">' . $image . '</a>';
            }
           
         }
     }
     
$SpecialBadgeD = C('Plugins.PeregrineBadges.SpecialBadgeD') ;
     if($SpecialBadgeD) {
     $title = $SpecialBadgeD[0];
     for ($x=1; $x < count( $SpecialBadgeD);$x++) {
            $id =  $SpecialBadgeD[$x];
            if ($id == $UserID) {
            $image = Img($prelink ."sbd.png", array('alt' => 'Special Badge', 'title' => sprintf(T('%s'), $SpecialBadgeD[0]), 'class' => "PeregrineBadgesSmall"));
           echo '<a href="' . $badgepage . "SpecialBadgeD" . '">' . $image . '</a>';
            }
           
         }
     } 
     
 $SpecialBadgeE = C('Plugins.PeregrineBadges.SpecialBadgeE') ;
     if($SpecialBadgeE) {
     $title = $SpecialBadgeE[0];
     for ($x=1; $x < count( $SpecialBadgeE);$x++) {
            $id =  $SpecialBadgeE[$x];
            if ($id == $UserID) {
            $image = Img($prelink ."sbe.png", array('alt' => 'Special Badge', 'title' => sprintf(T('%s'), $SpecialBadgeE[0]), 'class' => "PeregrineBadgesSmall"));
           echo '<a href="' . $badgepage . "SpecialBadgeE" . '">' . $image . '</a>';
            }
           
         }
     }  
     


        echo "</ul></div>";
    }

}
