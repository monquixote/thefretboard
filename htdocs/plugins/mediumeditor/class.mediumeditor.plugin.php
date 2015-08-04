<?php if (!defined('APPLICATION')) exit;

$PluginInfo['mediumeditor'] = array(
    'Name'        => "MediumEditor",
    'Description' => "HTML5 Content Editable makes its way to Vanilla through the MediumEditor Javascript plugin by Davi Ferreira. It offers an entirely new editing experience that is sure to please both you and your users alike.",
    'Version'     => '1.0.2',
    'PluginUrl'   => 'https://github.com/kasperisager/vanilla-mediumeditor',
    'Author'      => "Kasper Kronborg Isager",
    'AuthorEmail' => 'kasperisager@gmail.com',
    'AuthorUrl'   => 'https://github.com/kasperisager',
    'License'     => 'MIT',
    'RequiredApplications' => array('Vanilla' => '2.1.x')
);

/**
 * MediumEditor Plugin
 *
 * @author    Kasper Kronborg Isager <kasperisager@gmail.com>
 * @copyright 2014 (c) Kasper Kronborg Isager
 * @license   MIT
 * @package   MediumEditor
 * @since     1.0.0
 */
class MediumEditorPlugin extends Gdn_Plugin
{
    /**
     * Initialize MediumEditor
     *
     * @since  1.0.0
     * @access public
     * @param  Gdn_Form $sender
     */
    public function Gdn_Form_beforeBodyBox_handler($sender)
    {
        // Make sure that WYSIWYG is used
        $sender->setValue('Format', 'Wysiwyg');

        // Remove jQuery Autogrow as it interferes with the editor
        Gdn::controller()->removeJsFile('jquery.autogrow.js');

        // Add the assets we need for the editor
        Gdn::controller()->addCssFile($this->getResource('design/editor.min.css', false, false));
        Gdn::controller()->addJsFile($this->getResource('js/editor.min.js', false, false));
    }
}
