<?php if (!defined('APPLICATION')) exit();

$PluginInfo['ThemeChooser'] = array(
    'Name' => 'ThemeChooser',
    'Description' => 'Add the possibility to choose from predefined css-files (themes) in Edit Profile.',
    'Version' => '1.01',
    'RequiredApplications' => array('Vanilla' => '2.1.1'),
    'SettingsPermission' => 'Garden.Settings.Manage',
    'SettingsUrl' => '/settings/themechooser',
    'MobileFriendly' => true,
    'Author' => 'GhostX, exetico, KaZinQ',
    'AuthorUrl' => 'https://nordic-t.co',
    'License' => 'GNU GPL2'
);

class ThemeChooserPlugin extends Gdn_Plugin {
    public function AssetModel_StyleCss_Handler($Sender) {
        $Session = Gdn::Session();
        if (!$this->Enabled()) {
            return;
        }
        $cssFile = $this->EnabledValue();
        $Sender->AddCssFile($cssFile.'.css', 'plugins/ThemeChooser', array('Sort' => 9999));
    }

    // Check for mobile view and user preference
    private function Enabled() {
        $Session = Gdn::Session();
        return !(
            ($Session->IsValid() && !$this->GetUserMeta($Session->UserID, 'Theme', true, true)) ||
            (!C('ThemeChooser.Mobile', false) && IsMobile())
        );
    }

    private function EnabledValue(){
        $Session = Gdn::Session();
        if ($Session->IsValid() && $this->GetUserMeta($Session->UserID, 'Theme', true, true))
        {
            return $this->GetUserMeta($Session->UserID, 'Theme', true, true);
        }
        return C('ThemeChooser.DefaultThemeCSS', false);
    }


    // User preference dropdown for theme selection on "Edit Profile" page.
    // You're able to use whatever you like. Just remeber
    public function ProfileController_EditMyAccountAfter_Handler($Sender) {
        $Session = Gdn::Session();

        // Get the default theme from the configuration
        $DefaultTheme = array(C('ThemeChooser.DefaultThemeCSS', false) => C('ThemeChooser.DefaultThemeName', false));
        // Get the themefiles and themenames
        $ThemeFiles = explode(',',C('ThemeChooser.ThemeFiles', false));
        $ThemeNames = explode(',',C('ThemeChooser.ThemeNames', false));
        // Make them an array
        $ExtraThemes = $this->Combine_Array($ThemeFiles,$ThemeNames);
        // Merge the default theme and the extra themes
        $Options = $DefaultTheme+$ExtraThemes;

        $Selected = ($this->GetUserMeta($Session->UserID, 'Theme', true, true));
        $Fields = array('TextField' => 'Text', 'ValueField' => 'Code', 'Value' => $Selected);

        echo $Sender->Form->Label('Theme (this is an experimental feature, use at your own risk)');
        echo Wrap($Sender->Form->Dropdown('ThemeChooser', $Options, $Fields),'li',array('class' => 'ThemeChooser'));
    }

    public function UserModel_AfterSave_Handler($Sender) {
        $FormValues = $Sender->EventArguments['FormPostValues'];
        $UserID = val('UserID', $FormValues, 0);
        $ThemeChooser = val('ThemeChooser', $FormValues, false);

        $this->SetUserMeta($UserID, 'Theme', $ThemeChooser);
    }

    // Settings page
    public function SettingsController_ThemeChooser_Create($Sender){
        $Sender->Permission('Garden.Settings.Manage');
        $Sender->SetData('Title', T('ThemeChooser Settings'));
        $Sender->AddSideMenu('dashboard/settings/plugins');

        $Conf = new ConfigurationModule($Sender);
        $Conf->Initialize(array(
            'ThemeChooser.DefaultThemeCSS' => array(
                'Control' => 'textbox',
                'LabelCode' => 'Default theme CSS file',
                'Default' => 'custom'
            ),
            'ThemeChooser.DefaultThemeName' => array(
                'Control' => 'textbox',
                'LabelCode' => 'Default theme name',
                'Default' => 'Custom'
            ),
            'ThemeChooser.ThemeFiles' => array(
                'Control' => 'textbox',
                'LabelCode' => 'CSS Files separated by a comma without whitespace and without file ending',
                'Default' => 'custom,custom_dark,custom_light'
            ),
            'ThemeChooser.ThemeNames' => array(
                'Control' => 'textbox',
                'LabelCode' => 'Theme names, separated by a comma without whitespace. Must match list above',
                'Default' => 'Custom Theme,Dark theme,Light theme'
            ),
            'ThemeChooser.Mobile' => array(
                'Control' => 'CheckBox',
                'LabelCode' => 'Enable on mobile devices',
                'Default' => false
            )
        ));
        $Conf->RenderAll();
    }

    private function Combine_Array($a, $b) {
        $acount = count($a);
        $bcount = count($b);
        $size = ($acount > $bcount) ? $bcount : $acount;
        $a = array_slice($a, 0, $size);
        $b = array_slice($b, 0, $size);
        return array_combine($a, $b);
    }
}
