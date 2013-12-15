<?php if(!defined('APPLICATION')) die();

// let the spaghetti western begin


// let the spaghetti western begin

$qs = $_SERVER['QUERY_STRING'];
preg_match('|badgetype=(.*)|', $qs, $matches);
$rawto = ($matches[1]);
$ThankfulBadge = $LikedBadge = $SpecialBadge = $CommentBadge = $AnniversaryBadge = $CharterBadge ="";
$PRBadgeOne = $PRBadgeTwo = $PRBadgeThree = $PRBadgeFour = "";
switch ($rawto) {

    // Anniversary not implemented nor is Charter, or Specials.

    case 'CharterBadge':
        $whereto = "CharterBadge";
        $CharterBadge = $BadgeName = T("Charter Member");
        $SingBadgeName = T("Charter");
        $ImageBaseName = "charter";
        break;
 case 'AnniversaryBadge':
        $whereto = "AnniversaryBadge";
        $AnniversaryBadge = $BadgeName = T("Anniversaries");
        $SingBadgeName = T("Anniversary");
        $ImageBaseName = "av";
        break;
    case 'CommentBadge':
        $whereto = "CommentBadge";
        $CommentBadge = $BadgeName = T("Comments");
        $SingBadgeName = T("Comment");
        $ImageBaseName = "comment";
        break;
    case 'PRBadgeOne':
        $whereto = "PRBadgeOne";
        $PRBadgeOne = $BadgeName = T("PRBadgeOne");
        $SingBadgeName = $BadgeName;
        $ImageBaseName = "prbone";
        break;
     case 'PRBadgeTwo':
         $whereto = "PRBadgeTwo";
        $PRBadgeTwo = $BadgeName = T("PRBadgeTwo");
        $SingBadgeName = $BadgeName;
        $ImageBaseName = "prbtwo";
        break;
    case 'PRBadgeThree':
         $whereto = "PRBadgeThree";
        $PRBadgeThree = $BadgeName = T("PRBadgeThree");
        $SingBadgeName = $BadgeName;
        $ImageBaseName = "prbthree";
        break;
    case 'PRBadgeFour':
        $whereto = "PRBadgeFour";
        $PRBadgeFour = $BadgeName = T("PRBadgeFour");
        $SingBadgeName = $BadgeName;
        $ImageBaseName = "prbfour";
        break;
    case 'ThankfulBadge':
        $whereto = "ThankfulBadge";
        $ThankfulBadge = $BadgeName = T("Thankful");
        $SingBadgeName = $BadgeName;
        $ImageBaseName = "hb";
        break;
    case 'LikedBadge':
        $whereto = "LikedBadge";
        $LikedBadge = $BadgeName = T("Liked");
        $SingBadgeName = $BadgeName;
        $ImageBaseName = "hb";
        break;
     case 'SpecialBadgeA':
        $whereto = "SpecialBadgeA";
        $SpecialBadge = "Y";
        break;
    case 'SpecialBadgeB':
        $whereto = "SpecialBadgeB";
        $SpecialBadge = "Y";
        break;
    case 'SpecialBadgeC':
        $whereto = "SpecialBadgeC";
        $SpecialBadge = "Y";
        break;
    case 'SpecialBadgeD':
        $whereto = "SpecialBadgeD";
        $SpecialBadge = "Y";
        break;
     case 'SpecialBadgeE':
        $whereto = "SpecialBadgeE";
        $SpecialBadge = "Y";
        break;


    default:
        $whereto = "CommentBadge";
        $CommentBadge = $BadgeName = T("Comments");
        $SingBadgeName = T("Comment");
        $ImageBaseName = "comment";
}



$limit = C('Plugins.PeregrineBadges.Limit');
$BadgeNumber = 1;

if ($whereto == "CharterBadge") {
    charterbadgedisplay($ImageBaseName);
}

if ($whereto == "SpecialBadgeA") {
    specialbadgedisplayA();
}

if ($whereto == "SpecialBadgeB") {
    specialbadgedisplayB();
}

if ($whereto == "SpecialBadgeC") {
    specialbadgedisplayC();
}

if ($whereto == "SpecialBadgeD") {
    specialbadgedisplayD();
}

if ($whereto == "SpecialBadgeE") {
    specialbadgedisplayE();
}


if (($whereto <> "CharterBadge") && ($SpecialBadge <> "Y")) {

    $User = $Session = Gdn::Session()->User->UserID;
    $PeregrineBadgesModel = new PeregrineBadgesModel();
    if ($User > 0) {
        $UserBadges = PeregrineBadgesModel::GetBadge($User);
    }

    $PBArray = PeregrineBadgesModel::GetRecipientsBadge($whereto, $BadgeNumber, $limit);

    echo '<h1 class="pbheading">';
    echo T('Badge Summary');
    echo "</h1>";

    $User = $Session = Gdn::Session()->User->UserID;
    $UserName = $Session = Gdn::Session()->User->Name;
    $maxcount = 0;
    $BadgeList = Array(0, 1, 10, 100, 500, 1000, 2500, 5000, 10000);

    for ($x = 0; $x < count($PBArray); $x++) {

        $index = $PBArray[$x][$whereto];

        if ($maxcount < $PBArray[$x][$whereto]) {
            $maxcount = $PBArray[$x][$whereto];
        }
    }

    $index = $UserBadges[0][$whereto];

    $Image = Img("plugins/PeregrineBadges/design/images/" . $index . $ImageBaseName . ".png", array('alt' => 'Badge', 'class' => "PeregrineBadgesSmall"));

    $BLevel = $BadgeList[$index];

    $NewBadgeName = $BadgeName;
    if ($index < 2)
        $NewBadgeName = $SingBadgeName;

    if ($BadgeName == $CommentBadge) {

       $message =  T("Comment Badges are awarded to members who participate in discussions");

        if ($index == 1)
            $message = T("Nice to see that you are getting involved!");
        if ($index == 2)
            $message = T("You are getting the hang of it - keep it up!");
        if ($index > 2)
            $message = T("Nice to see you are staying with us and are contributing!");
    }
    if ($BadgeName == $LikedBadge) {

        $message =  T("Liked Badges are awarded to members who have been Liked by other members");

        if ($index == 1)
            $message = T("First Like: You received your first like! It can be the beginning of something beautiful!");
        if ($index == 2)
            $message = T("People are starting to like the things you write - nice!");
        if ($index > 2)
            $message = T("Your posts are liked more and more - thanks for contributing awesome stuff!");
    }
    if ($BadgeName == $ThankfulBadge) {

        $message =  T("ThankfulBadges are awarded to members who have been thanked by other members");

        if ($index == 1)
            $message = T("First Thanks: You received your first thanks! It can be the beginning of something beautiful!");
        if ($index == 2)
            $message = T("People are starting to thank you for the things you write - nice!");
        if ($index > 2)
            $message = T("You are receiving more and more thanks - thank you for contributing awesome stuff!");
    }

     if ($BadgeName == $PRBadgeOne) {

        $message =  T("Peregrine Reactions Badge Type One are awarded to members who have been ... by other members");

        if ($index == 1)
            $message = T("First ReactionOne - You have ...");
        if ($index == 2)
            $message = T("People are starting to 10 REACTONE you for the things you write - nice!");
        if ($index > 2)
            $message = T("You are receiving 100 or more REACTONE");
    }

     if ($BadgeName == $PRBadgeTwo) {

        $message =  T("Peregrine Reactions Badge Type Two are awarded to members who have been ... by other members");

        if ($index == 1)
            $message = T("First ReactionTwo - You have ...");
        if ($index == 2)
            $message = T("People are starting to 10 REACTTWO you for the things you write - nice!");
        if ($index > 2)
            $message = T("You are receiving 100 or more REACTTWO");
    }

     if ($BadgeName == $PRBadgeThree) {

        $message =  T("Peregrine Reactions Badge Type Three are awarded to members who have been ... by other members");

        if ($index == 1)
            $message = T("First ReactionThree - You have ...");
        if ($index == 2)
            $message = T("People are starting to 10 REACTTHREE you for the things you write - nice!");
        if ($index > 2)
            $message = T("You are receiving 100 or more REACTTHREE");
    }


      if ($BadgeName == $PRBadgeFour) {

        $message =  T("Peregrine Reactions Badge Type Four are awarded to members who have been ... by other members");

        if ($index == 1)
            $message = T("First ReactionFour - You have ...");
        if ($index == 2)
            $message = T("People are starting to 10 REACTFOUR you for the things you write - nice!");
        if ($index > 2)
            $message = T("You are receiving 100 or more REACTFOUR");
    }


    if ($BadgeName == $AnniversaryBadge) {
        $NewBadgeName = $SingBadgeName;
        $BLevel = $index;
              $message =  T("Anniversary Badges are awarded every year");

        if ($index == 1) {
            $message = T("Congratulations! Nice to see you like it here!");
            $BLevel = T("First");
        }
        if ($index == 2) {
            $message = T("Congratulations - you are starting to be a fixture of the forum!");
            $BLevel = T("Second");
        }
        if ($index == 3) {
            $message = T("Congratulations - you are officially a fixture of the forum! ");
            $BLevel = T("Third");
        }
        if ($index == 4) {
            $message = T("Congratulations - you are officially a fixture of the forum! ");
            $BLevel = T("Fourth");
        }
        if ($index == 5) {
            $message = T("Congratulations - you are officially a fixture of the forum! ");
            $BLevel = T("Fifth");
        }
        if ($index > 5) {
            $message = T("Congratulations - you are officially a fixture of the forum! ");
        }
    }


 if ($index > 0) {
    echo '<p class="pbheading" >' . '<span class= "pbimagespan">' . $Image . '</span>' . $UserName . ", " . T("You are a recipient of the esteemed $BLevel $NewBadgeName badge ") . "</p>";
    }

    echo '<p class="pbmessage" >' . $message . "</p>";

    $AllBadgeArray = array("Comments",
    "Thankful",
    "Liked",
    $PRBadgeOne,
    $PRBadgeTwo,
    $PRBadgeThree,
    $PRBadgeFour,
    );


    if (InArrayI($BadgeName, $AllBadgeArray))  {
        $BadgeList = Array(0, 1, 10, 100, 500, 1000, 2500, 5000, 10000);


        if ($maxcount < 1)
            $maxcount = 1;
        for ($BadgeNo = 1; $BadgeNo <= $maxcount; $BadgeNo++) {
            echo '<div class="pbtitle">';
            $NewBadgeName = $BadgeName;
            if ($BadgeNo < 2)
                $NewBadgeName = $SingBadgeName;

            echo T("Recipients of the esteemed $BadgeList[$BadgeNo] $NewBadgeName Badge");

            echo "</div>";
            echo '<div class="pbtable">';
            $gotone = 0;
            for ($x = 0; $x <= count($PBArray)-1; $x++) {
                $UID = $PBArray[$x]['UserID'];
                $Name = $PBArray[$x]['Name'];
                $Photo = $PBArray[$x]['Photo'];
                $Email = $PBArray[$x]['Email'];
                $TheBadge = $PBArray[$x][$whereto];
                $Object->UserID = $UID;
                $Object->Name = $Name;
                $Object->Photo = $Photo;
                $Object->Email = $Email;
                $User = UserBuilder($Object);
                $photo = UserPhoto($User, array('LinkClass' => 'ProfilePhotoCategory', 'ImageClass' => 'ProfileSmall'));
                if ($BadgeNo <= $TheBadge) {
                    if ($gotone != 1) {
                        if (($UID) > 0)
                            $gotone = 1;
                    }

                    $Href = "/profile/$Name/$UID";
                    echo '<div class="pbcell">';

                    if ($photo) {

                        echo UserPhoto($User, array('LinkClass' => 'ProfilePhotoCategory', 'ImageClass' => 'ProfilePhotoSmall'));
                        echo "<br />";
                        echo UserAnchor($User);
                    } else {
                        echo UserAnchor($User);
                    }
                    echo "</div>"; // TO BE REPLACED BY END DIV //
                }
            }
            echo "</div>"; // TO BE REPLACED BY END DIV //
            if ($gotone < 1)
                echo T('No Awards Yet');
        }
    }
}

function charterbadgedisplay($ImageBaseName) {
// charter badge

    echo '<h1 class="pbheading">';
    echo T('Badge Summary');
    echo "</h1>";
    $User = $Session = Gdn::Session()->User->UserID;
    $UserName = $Session = Gdn::Session()->User->Name;
        $message = T("Thanks for being here from the beginning");
        $Image = Img("plugins/PeregrineBadges/design/images/" . $ImageBaseName . ".png", array('alt' => 'Badge', 'class' => "PeregrineBadgesSmall"));
    if (($User > 0) && ($User < 101)) {
        echo '<p class="pbheading" >' . '<span class= "pbimagespan">' . $Image . '</span>' . $UserName . ", " . T("You are a recipient of the esteemed Charter badge") . "</p>";
        echo '<p class="pbmessage" >' . $message . "</p>";
    }

    echo '<p class="pbmessage" >' . T("The Charter badge $Image is awarded to the first 100 members of the forum") . "</p>";
}

function specialbadgedisplayA() {


  $SpecialBadgeA = C('Plugins.PeregrineBadges.SpecialBadgeA') ;
     if($SpecialBadgeA) {
     $title = $SpecialBadgeA[0];
     echo '<h1 class="pbheading">';
     echo T('Badge Summary');
     echo "</h1>";
     $User = $Session = Gdn::Session()->User->UserID;
     $UserName = $Session = Gdn::Session()->User->Name;
     $message = T("You have received Special Badge A");
     $Image = Img("plugins/PeregrineBadges/design/images/" . "sba.png", array('alt' => 'Special Badge', 'title' => sprintf(T('%s'), $title) ,'class' => "PeregrineBadgesSmall"));


    for ($x=1; $x < count( $SpecialBadgeA);$x++) {
        $id =  $SpecialBadgeA[$x];
        if ($id == $User) {
        echo '<p class="pbheading" >' . '<span class= "pbimagespan">' . $Image . '</span>' . $UserName . ", " . sprintf(T('You are a recipient of the esteemed %s badge'),$title) . "</p>";
        echo '<p class="pbmessage" >' . $message . "</p>";
        }
    }

	echo '<p class="pbmessage" >' . T("The $title badge $Image is awarded to special A members of the forum") . "</p>";

  }

}

function specialbadgedisplayB() {


  $SpecialBadgeB = C('Plugins.PeregrineBadges.SpecialBadgeB') ;
     if($SpecialBadgeB) {
     $title = $SpecialBadgeB[0];
     echo '<h1 class="pbheading">';
     echo T('Badge Summary');
     echo "</h1>";
     $User = $Session = Gdn::Session()->User->UserID;
     $UserName = $Session = Gdn::Session()->User->Name;
     $message = T("You have received Special Badge B");
     $Image = Img("plugins/PeregrineBadges/design/images/" . "sbb.png", array('alt' => 'Special Badge', 'title' => sprintf(T('%s'), $title) ,'class' => "PeregrineBadgesSmall"));


    for ($x=1; $x < count( $SpecialBadgeB);$x++) {
        $id =  $SpecialBadgeB[$x];
        if ($id == $User) {
        echo '<p class="pbheading" >' . '<span class= "pbimagespan">' . $Image . '</span>' . $UserName . ", " . sprintf(T('You are a recipient of the esteemed %s badge'),$title) . "</p>";
        echo '<p class="pbmessage" >' . $message . "</p>";
        }
    }

     echo '<p class="pbmessage" >' . T("The $title badge $Image is awarded to special B members of the forum") . "</p>";

  }

}

function specialbadgedisplayC() {

  $SpecialBadgeC = C('Plugins.PeregrineBadges.SpecialBadgeC') ;
     if($SpecialBadgeC) {
     $title = $SpecialBadgeC[0];
     echo '<h1 class="pbheading">';
     echo T('Badge Summary');
     echo "</h1>";
     $User = $Session = Gdn::Session()->User->UserID;
     $UserName = $Session = Gdn::Session()->User->Name;
     $message = T("You have received Special Badge C");
     $Image = Img("plugins/PeregrineBadges/design/images/" . "sbc.png", array('alt' => 'Special Badge', 'title' => sprintf(T('%s'), $title) ,'class' => "PeregrineBadgesSmall"));

    for ($x=1; $x < count( $SpecialBadgeC);$x++) {
        $id =  $SpecialBadgeC[$x];
        if ($id == $User) {
        echo '<p class="pbheading" >' . '<span class= "pbimagespan">' . $Image . '</span>' . $UserName . ", " . sprintf(T('You are a recipient of the esteemed %s badge'),$title) . "</p>";
        echo '<p class="pbmessage" >' . $message . "</p>";
        }
    }

     echo '<p class="pbmessage" >' . T("The $title badge $Image is awarded to special C members of the forum") . "</p>";

  }

}


function specialbadgedisplayD() {

  $SpecialBadgeD = C('Plugins.PeregrineBadges.SpecialBadgeD') ;
     if($SpecialBadgeD) {
     $title = $SpecialBadgeD[0];
     echo '<h1 class="pbheading">';
     echo T('Badge Summary');
     echo "</h1>";
     $User = $Session = Gdn::Session()->User->UserID;
     $UserName = $Session = Gdn::Session()->User->Name;
     $message = T("You have received Special Badge D");
     $Image = Img("plugins/PeregrineBadges/design/images/" . "sbd.png", array('alt' => 'Special Badge', 'title' => sprintf(T('%s'), $title) ,'class' => "PeregrineBadgesSmall"));


    for ($x=1; $x < count( $SpecialBadgeD);$x++) {
        $id =  $SpecialBadgeD[$x];
        if ($id == $User) {
        echo '<p class="pbheading" >' . '<span class= "pbimagespan">' . $Image . '</span>' . $UserName . ", " . sprintf(T('You are a recipient of the esteemed %s badge'),$title) . "</p>";
        echo '<p class="pbmessage" >' . $message . "</p>";
        }
    }

     echo '<p class="pbmessage" >' . T("The $title badge $Image is awarded to special D members of the forum") . "</p>";

  }

}

function specialbadgedisplayE() {

  $SpecialBadgeE = C('Plugins.PeregrineBadges.SpecialBadgeE') ;
     if($SpecialBadgeE) {
     $title = $SpecialBadgeE[0];
     echo '<h1 class="pbheading">';
     echo T('Badge Summary');
     echo "</h1>";
     $User = $Session = Gdn::Session()->User->UserID;
     $UserName = $Session = Gdn::Session()->User->Name;
     $message = T("You have received Special Badge E");
     $Image = Img("plugins/PeregrineBadges/design/images/" . "sbe.png", array('alt' => 'Special Badge', 'title' => sprintf(T('%s'), $title) ,'class' => "PeregrineBadgesSmall"));


    for ($x=1; $x < count( $SpecialBadgeE);$x++) {
        $id =  $SpecialBadgeE[$x];
        if ($id == $User) {
        echo '<p class="pbheading" >' . '<span class= "pbimagespan">' . $Image . '</span>' . $UserName . ", " . sprintf(T('You are a recipient of the esteemed %s badge'),$title) . "</p>";
        echo '<p class="pbmessage" >' . $message . "</p>";
        }
    }

     echo '<p class="pbmessage" >' . T("The $title badge $Image is awarded to special E members of the forum") . "</p>";

  }

}