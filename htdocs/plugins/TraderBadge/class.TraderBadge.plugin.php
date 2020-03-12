<?php if (!defined('APPLICATION')) exit();

$PluginInfo['TraderBadge'] = array(
   'Name' => 'TraderBadge',
   'Description' => "Adds trader badges to those with the right tFB role.",
   'Version' => '0.11',
   'RequiredApplications' => array('Vanilla' => '2.0.18'),
   'RequiredTheme' => FALSE,
   'RequiredPlugins' => FALSE,
   'HasLocale' => FALSE,
   'SettingsUrl' => 'dashboard/plugin/TraderBadge',
   'SettingsPermission' => 'Garden.AdminUser.Only',
   'RegisterPermissions' => FALSE,
   'Author' => "Thomas Mashek",
   'AuthorEmail' => 'admin@thefretboard.co.uk',
   'AuthorUrl' => 'http://thefretboard.co.uk'
);

class TraderBadgePlugin extends Gdn_Plugin {

    public function PluginController_TraderBadge_Create( $Sender ) {
        $Sender->Title( 'Trader Badges' );
        $Sender->AddSideMenu( $this->GetPluginKey( 'SettingsUrl' ) );
        $Sender->Form = new Gdn_Form();
        $this->Dispatch( $Sender, $Sender->RequestArgs );
    }
    
    public function Controller_Index( $Sender ) {
        $Sender->Permission( 'Vanilla.Settings.Manage' );
        $Sender->SetData( 'PluginDescription', $this->GetPluginKey( 'Description' ) );
        $Validation = new Gdn_Validation();
        $ConfigurationModel = new Gdn_ConfigurationModel( $Validation );
        $ConfigurationModel->SetField( 'Plugins.TraderBadge.BadgeLocation', '1' );
        $Sender->Form->SetModel( $ConfigurationModel );
        
        if( $Sender->Form->AuthenticatedPostBack() === FALSE ) {
            $Sender->Form->SetData( $ConfigurationModel->Data );
        } else {
            $ConfigurationModel->Validation->ApplyRule('Plugins.TraderBadge.BadgeLocation', 'Required' );
            $Saved = $Sender->Form->Save();
            
            if( $Saved ) $Sender->StatusMessage = T( 'Huzzah! The changes have been saved!' );
        }
        
        $Sender->Render( $this->GetView( 'TraderBadge.php' ) );
    }

    public function Setup() {
        SaveToConfig( 'Plugins.TraderBadge.BadgeLocation', '1' );
    }
    
    public function OnDisable() {
        RemoveFromConfig( 'Plugins.TraderBadge.BadgeLocation' );
    }

    public function Base_GetAppSettingsMenuItems_Handler( $Sender ) {
        $Menu = &$Sender->EventArguments['SideMenu'];
        $Menu->AddLink( 'Add-ons', 'Role Badges', $this->GetPluginKey( 'SettingsUrl' ), 'Garden.AdminUser.Only' );
    }
    
    public function Base_Render_Before( $Sender ) {
        $Sender->AddCssFile( $this->GetResource( 'design/TraderBadge.css', FALSE, FALSE ) );
    }

    
    public function DiscussionController_AfterDiscussionMeta_Handler($Sender) {
        if( $this->badgeLocation() == 1 ) $this->attachBadge( $Sender );
    }
    
    public function DiscussionsController_DiscussionInfo_Handler($Sender) {
        if( $this->badgeLocation() == 1 ) $this->attachBadge( $Sender );
    }
    
    public function DiscussionController_CommentInfo_Handler( $Sender ) {
        if( $this->badgeLocation() == 1 ) $this->attachBadge( $Sender );
    }

    public function PostController_CommentInfo_Handler( $Sender ) {
        if( $this->badgeLocation() == 1 ) $this->attachBadge( $Sender );
    }
    
    // This seems only to works in 2.1+
    public function DiscussionController_AuthorPhoto_Handler( $Sender ) {
        if( $this->badgeLocation() == 2 ) $this->attachBadge( $Sender );
    }
    
    protected function badgeLocation() {
        return Gdn::Config( 'Plugins.TraderBadge.BadgeLocation' );
    }
    
    protected function attachBadge( $Sender ) {
        $roles = array();
        $userModel = new UserModel();
        if($Sender->EventArguments['Type'] == 'Discussion') {
          $authorID = $Sender->EventArguments['Discussion']->InsertUserID;
        } else {
          $authorID = $Sender->EventArguments['Author']->UserID;
        };
        $roleData = $userModel->GetRoles( $authorID );
        if( $roleData !== FALSE && $roleData->NumRows(DATASET_TYPE_ARRAY) > 0 )
        $roles = ConsolidateArrayValuesByKey( $roleData->Result(), 'Name' );
        foreach( $roles as $role ) {
            if( $role == "Traders Only" ) {
              echo '<span title="Trusted tFB Business Partner" class="trader-badge">tFB Trader</span>';
            };
        }
    }
}
