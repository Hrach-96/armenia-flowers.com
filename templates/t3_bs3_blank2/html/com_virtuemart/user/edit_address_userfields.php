<?php

/**
 *
 * Modify user form view, User info
 *
 * @package	VirtueMart
 * @subpackage User
 * @author Oscar van Eijk, Eugen Stranz
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: edit_address_userfields.php 8763 2015-02-27 09:06:01Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Status Of Delimiter
$closeDelimiter = false;
$openTable = true;
$hiddenFields = '';

// Output: Userfields
foreach($this->userFields['fields'] as $field) {

	if($field['type'] == 'delimiter') {

		// For Every New Delimiter
		// We need to close the previous
		// table and delimiter
		if($closeDelimiter) { ?>
			</table>
		</fieldset>
		<?php
			$closeDelimiter = false;
		} //else {
			?>
			<fieldset>
			<span class="userfields_info"><?php echo $field['title'] ?></span>

			<?php
			$closeDelimiter = true;
			$openTable = true;
		//}

	} elseif ($field['hidden'] == true) {

		// We collect all hidden fields
		// and output them at the end
		$hiddenFields .= $field['formcode'] . "\n";

	} else {

		// If we have a new delimiter
		// we have to start a new table
		if($openTable) {
			$openTable = false;
			?>

			<table class="adminForm user-details">

		<?php
		}
		$descr = empty($field['description'])? $field['title']:$field['description'];
		// Output: Userfields
		?>
				<tr title="<?php echo $descr ?>">
					<td class="key">
						<label class="<?php echo $field['name'] ?>" for="<?php echo $field['name'] ?>_field">
							<?php echo $field['title'] . ($field['required'] ? ' *' : '') ?>
						</label>
					</td>
					<td class="key2">
						<?php echo $field['formcode'] ?>
					</td>
				</tr>
	<?php
	}

}

// At the end we have to close the current
// table and delimiter ?>

			</table>
		</fieldset>

<?php // Output: Hidden Fields
echo $hiddenFields
?>