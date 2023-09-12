<?php
/**
 * @package  JMS Multi Image Upload for Virtuemart
 * @version  1.0
 * @copyright Copyright (coffee) 2009 - 2013 Joommasters. All rights reserved.
 * @License  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @Website: http://www.joommasters.com
 **/
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

// Load the tooltip behavior.
JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
?>
<form action="<?php echo JRoute::_('index.php?option=com_virtuemart');?>" method="post" name="adminForm" id="adminForm">
	<table class="adminlist">
		<thead>
			<tr>
				<td>Please go to product detail page, and upload images as you want. This component only use for running ajax when upload images.<br>
				<input type="submit" value="Go to virtuemart">
				</td>
			</tr>
		</thead>
	</table>
</form>