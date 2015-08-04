<?php if(!defined('APPLICATION')) exit();


class PeregrineReactionsModel extends Gdn_Model {

    public function __construct($Name = '') {
        parent::__construct('PeregrineReactions');
    }


    public function GetReactions($PostType, $PostID) {

        if ($PostType == "Discussion") {
            $Reactions = $this->GetWhere(Array('DiscussionID' => $PostID, 'CommentID' => null))->ResultArray();
        } else {
            $Reactions = $this->GetWhere(Array('CommentID' => $PostID, 'DiscussionID' => null))->ResultArray();
        }

        return $Reactions;
    }

    public function UpdateReactions($recordtype, $recordid, $reactionid) {


        if (!Gdn::Session()->CheckPermission('Plugins.PeregrineReactions.AllowReact')) {
            $message = T("You must have permission to React");
            echo $message;
            return;
        }
        $InsertUserID = Gdn::Session()->UserID;
        $RecordColumn = $recordtype . "ID";
        $message = array();
        $UserID = Gdn::SQL()
                ->Select('InsertUserID')
                ->From($recordtype)
                ->Where($RecordColumn, $recordid)
                ->Get()
                ->Value('InsertUserID');

        if ($UserID == $InsertUserID) {
            $message = T("You Can't Click on yourself");
            echo $message;
            return;
        }


        $Honored = Gdn::UserModel()->GetID($UserID);

        switch ($reactionid) {
            case "1":
                $AddColumn = "PeregrineReactOne";
                break;
            case "2":
                $AddColumn = "PeregrineReactTwo";
                break;
            case "3":
                $AddColumn = "PeregrineReactThree";
                break;
# Removed by digitalscream 2013-12-15
#            case "4":
#                $AddColumn = "PeregrineReactFour";
#                break;
        }



        $Result = Gdn::SQL()
                ->Select('ReactionType')
                ->From('PeregrineReactions')
                ->Where('InsertUserID', Gdn::Session()->UserID)
                ->Where($RecordColumn, $recordid)
                ->Get()
                ->Value('ReactionType');


        switch ($Result) {
            case "1":
                $RemColumn = "PeregrineReactOne";
                break;
            case "2":
                $RemColumn = "PeregrineReactTwo";
                break;
            case "3":
                $RemColumn = "PeregrineReactThree";
                break;
# Removed by digitalscream 2013-12-15
#            case "4":
#                $RemColumn = "PeregrineReactFour";
#                break;
        }

        if (!$Result) {
            $message = array("off" => "0", "on" => $reactionid);
            Gdn::SQL()
                    ->Update('User')
                    ->Set($AddColumn, "$AddColumn + 1", FALSE)
                    ->Where(array('UserID' => $UserID))
                    ->Put();
            $this->InsertReactions($InsertUserID, $UserID, $recordtype, $recordid, $reactionid);
        } elseif ($Result == $reactionid) {
            Gdn::SQL()
                    ->Update('User')
                    ->Set($AddColumn, "$AddColumn - 1", FALSE)
                    ->Where(array('UserID' => $UserID))
                    ->Put();


            Gdn::SQL()->Delete('PeregrineReactions', array('InsertUserID' => $InsertUserID, $RecordColumn => $recordid));
            $message = array("off" => $reactionid, "on" => "0");
        } else {
            $message = array("off" => $Result, "on" => $reactionid);

            Gdn::SQL()
                    ->Update('User')
                    ->Set($AddColumn, "$AddColumn + 1", FALSE)
                    ->Set($RemColumn, "$RemColumn - 1", FALSE)
                    ->Where(array('UserID' => $UserID))
                    ->Put();

            $this->ReplaceReactions($InsertUserID, $UserID, $recordtype, $recordid, $reactionid);
        }

        return $message;
    }


public function TimeframePeregrineReactions($MaxRecords, $NumDays) {
          
                return $Result = Gdn::SQL()
                ->Select ('u.UserID,  u.Name, u.Photo, u.Email,count(pr.UserID) as CountUserID')
                ->From('PeregrineReactions pr')
                ->Join('User u', 'pr.UserID = u.UserID')
                ->Where('pr.DateInserted >=', Gdn_Format::ToDateTime(strtotime("-" . $NumDays . " days")))
                //Monquixote tweak - removes facepalms from leaderboard
                ->Where('pr.reactionType <>','4')
                ->GroupBy('pr.UserID')
                ->OrderBy('CountUserID', 'desc')
                ->Limit($MaxRecords) 
               ->Get()
               ->ResultArray();
                           
                
}



public function TotDiscPeregrineReactions($recordid) {
                return $Result = Gdn::SQL()
                ->Select ('Paterfamilias', 'count', 'CountPaterfamilias')
                ->From('PeregrineReactions')
                ->Where('Paterfamilias', $recordid)
                ->Get()
               ->FirstRow()
               ->CountPaterfamilias;
                }
                
          
public function WhatsHotPeregrineReactions($recordid) {
                $Result = Gdn::SQL()
                ->Select ('CommentID, count(CommentID) as CountCommentID')
                ->From('PeregrineReactions')
                ->Where('Paterfamilias', $recordid)
                ->GroupBy('CommentID')
                ->OrderBy('CountCommentID', 'desc')
                ->Get()
                ->FirstRow();
                if ($Result)
                    $Result = $Result->CommentID;
                    
                return $Result;
}

    public function InsertReactions($InsertUserID, $UserID, $recordtype, $recordid, $reactionid) {
       
       
          if ($recordtype != "Discussion") {
                 $discid = Gdn::SQL()
                 ->Select('*')
                 ->From('Comment c')
                 ->Where('c.CommentID', $recordid)
                 ->Get()
                 ->Value('DiscussionID');
                } else {
               $discid =  $recordid;
               }
       
    
       
        Gdn::SQL()
                ->Set('DateInserted', Gdn_Format::ToDateTime())
                ->Set($recordtype . "ID", $recordid)
                ->Set('InsertUserID', $InsertUserID)
                ->Set('UserID', $UserID)
                ->Set('ReactionType', $reactionid)
                ->Set('Paterfamilias', $discid)
                ->Insert('PeregrineReactions', array());
    }

    public function ReplaceReactions($InsertUserID, $UserID, $recordtype, $recordid, $reactionid) {
         
        
         
       
       
        Gdn::SQL()
                ->Put('PeregrineReactions', array('DateInserted' => Gdn_Format::ToDateTime(),
                    $recordtype . "ID" => $recordid,
                    'InsertUserID' => $InsertUserID,
                    'UserID' => $UserID,
                    'ReactionType' => $reactionid), array($recordtype . "ID" => $recordid, 'InsertUserID' => $InsertUserID, 'UserID' => $UserID), FALSE);
    }

}
  
 
