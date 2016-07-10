<?php if(!defined('APPLICATION')) exit();

class PeregrineBadgesModel extends VanillaModel {

 public function InitBadge($UserId) {
       $this->SQL->Insert('PeregrineBadges', array(
             'UserId' => $UserId,
             'AnniversaryBadge' => "0",
             'CommentBadge' => "0",
             'ThankfulBadge' => "0",
             'LikedBadge'=> "0",
             'PrBadgeOne'=> "0",
             'PrBadgeTwo'=> "0",
             'PrBadgeThree'=> "0",
             'PrBadgeFour'=> "0",
                )
        );
      
  }      
      
      
public function GetRecipientsBadge($BadgeType,$BadgeNumber,$limit) {  
        $Selection =  'pb.' . $BadgeType . ',pb.UserID, u.Name, u.Email, u.Photo';
        $BadgesModel = new Gdn_Model('User');
        $BadgesData = $BadgesModel->SQL
                        ->Select($Selection )
                        ->From('PeregrineBadges pb')
                        ->Where("$BadgeType >", ($BadgeNumber-1))
                        ->Join('User u', "u.UserID = pb.UserID") 
                         ->Limit("$limit") 
                        ->Get()
                        ->ResultArray();
         return $BadgesData;
    }     
      
      
      
      
      
 
        
public function GetBadge($UserId) {  
         $BadgesModel = new Gdn_Model('User');
         $ResultArray  = $BadgesModel->SQL
                        ->Select('*')
                        ->From('PeregrineBadges')
                        ->Where('UserId', $UserId)
                        ->Get()
                        ->ResultArray();
         return $ResultArray;
    }
          
   
public function GetPoints($UserId) {
        return $this->SQL
                        ->Select('Points')
                        ->From('PeregrineBadges')
                        ->Where('UserId', $UserId)
                        ->Get()
                        ->FirstRow('', DATASET_TYPE_ARRAY)
                ->Points;
    }


// anniversary

    public function GetCountAnniversaryBadge($UserId) {
        $BadgesModel = new Gdn_Model('User');
        $BadgesData = $BadgesModel->SQL
                        ->Select('AnniversaryBadge')
                        ->From('PeregrineBadges')
                        ->Where('UserId', $UserId)
                        ->Get()
                        ->FirstRow('', DATASET_TYPE_ARRAY)
                ->AnniversaryBadge;
        return $BadgesData;
    }

    public function UpdateAnniversaryBadge($UserId, $AnniversaryBadgeCount) {
        $this->SQL->Update('PeregrineBadges')->Set('AnniversaryBadge', $AnniversaryBadgeCount)->Where('UserId', $UserId)->Put();
    }


// comment

    public function GetCountCommentBadge($UserId) {
        $BadgesModel = new Gdn_Model('User');
        $BadgesData = $BadgesModel->SQL
                        ->Select('CommentBadge')
                        ->From('PeregrineBadges')
                        ->Where('UserId', $UserId)
                        ->Get()
                        ->FirstRow('', DATASET_TYPE_ARRAY)
                ->CommentBadge;
        return $BadgesData;
    }

    public function UpdateCommentBadge($UserId, $CommentBadgeCount) {
        $this->SQL->Update('PeregrineBadges')->Set('CommentBadge', $CommentBadgeCount)->Where('UserId', $UserId)->Put();
    }

//  thanked

    public function GetCountThankfulBadge($UserId) {
        $BadgesModel = new Gdn_Model('User');
        $BadgesData = $BadgesModel->SQL
                        ->Select('ThankfulBadge')
                        ->From('PeregrineBadges')
                        ->Where('UserId', $UserId)
                        ->Get()
                        ->FirstRow('', DATASET_TYPE_ARRAY)
                ->ThankfulBadge;
        return $BadgesData;
    }

    public function UpdateThankfulBadge($UserId, $HBadgeCount) {
        $this->SQL->Update('PeregrineBadges')->Set('ThankfulBadge', $HBadgeCount)->Where('UserId', $UserId)->Put();
    }

// liked
 
    public function GetCountLikedBadge($UserId) {
        $BadgesModel = new Gdn_Model('User');
        $BadgesData = $BadgesModel->SQL
                        ->Select('LikedBadge')
                        ->From('PeregrineBadges')
                        ->Where('UserId', $UserId)
                        ->Get()
                        ->FirstRow('', DATASET_TYPE_ARRAY)
                ->LikedBadge;
        return $BadgesData;
    }

    public function UpdateLikedBadge($UserId, $HBadgeCount) {
        $this->SQL->Update('PeregrineBadges')->Set('LikedBadge', $HBadgeCount)->Where('UserId', $UserId)->Put();
    }
    
    
   public function GetCountPRBadgeOne($UserId) {
        $BadgesModel = new Gdn_Model('User');
        $BadgesData = $BadgesModel->SQL
                        ->Select('PRBadgeOne')
                        ->From('PeregrineBadges')
                        ->Where('UserId', $UserId)
                        ->Get()
                        ->FirstRow('', DATASET_TYPE_ARRAY)
                ->PRBadgeOne;
    return $BadgesData;
    }

    public function UpdatePRBadgeOne($UserId, $PRBadgeCount) {
        $this->SQL->Update('PeregrineBadges')->Set('PRBadgeOne', $PRBadgeCount)->Where('UserId', $UserId)->Put();
    } 
    
    
    public function GetCountPRBadgeTwo($UserId) {
        $BadgesModel = new Gdn_Model('User');
        $BadgesData = $BadgesModel->SQL
                        ->Select('PRBadgeTwo')
                        ->From('PeregrineBadges')
                        ->Where('UserId', $UserId)
                        ->Get()
                        ->FirstRow('', DATASET_TYPE_ARRAY)
                ->PRBadgeTwo;
        return $BadgesData;
    }

    public function UpdatePRBadgeTwo($UserId, $PRBadgeCount) {
        $this->SQL->Update('PeregrineBadges')->Set('PRBadgeTwo', $PRBadgeCount)->Where('UserId', $UserId)->Put();
    }  
    
    
     public function GetCountPRBadgeThree($UserId) {
        $BadgesModel = new Gdn_Model('User');
        $BadgesData = $BadgesModel->SQL
                        ->Select('PRBadgeThree')
                        ->From('PeregrineBadges')
                        ->Where('UserId', $UserId)
                        ->Get()
                        ->FirstRow('', DATASET_TYPE_ARRAY)
                ->PRBadgeThree;
        return $BadgesData;
    }

    public function UpdatePRBadgeThree($UserId, $PRBadgeCount) {
        $this->SQL->Update('PeregrineBadges')->Set('PRBadgeThree', $PRBadgeCount)->Where('UserId', $UserId)->Put();
    }    
    
       public function GetCountPRBadgeFour($UserId) {
        $BadgesModel = new Gdn_Model('User');
        $BadgesData = $BadgesModel->SQL
                        ->Select('PRBadgeFour')
                        ->From('PeregrineBadges')
                        ->Where('UserId', $UserId)
                        ->Get()
                        ->FirstRow('', DATASET_TYPE_ARRAY)
                ->PRBadgeFour;
        return $BadgesData;
    }

    public function UpdatePRBadgeFour($UserId, $PRBadgeCount) {
        $this->SQL->Update('PeregrineBadges')->Set('PRBadgeFour', $PRBadgeCount)->Where('UserId', $UserId)->Put();
    }     
    
    


    public function GetTotals($UserId) {
        $BadgesModel = new Gdn_Model('User');
        $BadgesData = $BadgesModel->SQL
                        ->Select('*')
                        ->From('PeregrineBadges')
                        ->Where('UserId', $UserId)
                        ->Get()
                        ->ResultArray();
        return $BadgesData;
    }




    public function UpdatePoints($UserId, $Points) {

        $this->SQL->Update('PeregrineBadges')->Set('Points', $Points)->Where('UserId', $UserId)->Put();
    }

}

