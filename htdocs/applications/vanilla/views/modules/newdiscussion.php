<?php if (!defined('APPLICATION')) exit();
echo '<div class="BoxButtons BoxNewDiscussion">';

$Css = 'Button Primary Action NewDiscussion';
$Css .= strpos($this->CssClass, 'Big') !== FALSE ? ' BigButton' : '';

echo anchor(t('Recent Discussions'), '/discussions', 'Button Primary Action BigButton RecentDiscussions');

echo ButtonGroup($this->Buttons, $Css, $this->DefaultButton);
Gdn::controller()->fireEvent('AfterNewDiscussionButton');

echo '</div>';
