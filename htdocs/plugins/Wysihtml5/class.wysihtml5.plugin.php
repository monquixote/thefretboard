<?php if (!defined('APPLICATION')) exit;

$PluginInfo['Wysihtml5'] = array(
    'Name'        => "Wysihtml5",
    'Description' => "Turns the default text area into an HTML5 editor that generates valid and semantic markup.",
    'Version'     => '2.1.0',
  	'MobileFriendly' => TRUE,
    'PluginUrl'   => 'https://github.com/kasperisager/vanilla-wysihtml5',
    'Author'      => "Kasper Kronborg Isager",
    'AuthorEmail' => 'kasperisager@gmail.com',
    'AuthorUrl'   => 'https://github.com/kasperisager',
    'License'     => 'MIT',
    'RequiredApplications' => array('Vanilla' => '2.1.x')
);

/**
 * Wysihtml5 Plugin
 *
 * @author    Kasper Kronborg Isager <kasperisager@gmail.com>
 * @copyright 2014 (c) Kasper Kronborg Isager
 * @license   MIT
 * @package   Wysihtml5
 * @since     2.0.0
 */
class Wysihtml5Plugin extends Gdn_Plugin
{
    /**
     * Initialize Wysihtml5
     *
     * @param Gdn_Form $sender
     */
    public function Gdn_Form_beforeBodyBox_handler($sender)
    {
        // Make sure that Wysiwyg is used
        $sender->setValue('Format', 'Wysiwyg');

        // Remove jQuery Autogrow as it interfeers with the editor
        Gdn::controller()->removeJsFile('jquery.autogrow.js');

        // Add the assets we need for the editor
        Gdn::controller()->addCssFile($this->getResource('design/editor.css', false, false));
        Gdn::controller()->addCssFile('resources/css/vanillicon.css');
        Gdn::controller()->addJsFile($this->getResource('js/editor.min.js', false, false));
        // Render the formatting toolbar
        echo Gdn::controller()->fetchView($this->getView('toolbar.tpl'));
    }
}
