<?php
// No direct access
defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

class CooltagsControllerXXX_UCFIRST_INTERNAL_NAME_XXX extends CooltagsController
{

	public function edit()
	{
		$app			= JFactory::getApplication();

		$previousId = (int) $app->getUserState('com_cooltags.edit.XXX_INTERNAL_NAME_FORCE_FORM_XXX.id');
		$editId	= (int) JRequest::getInt('id', null, '', 'array');

		$app->setUserState('com_cooltags.edit.XXX_INTERNAL_NAME_FORCE_FORM_XXX.id', $editId);

		$model = $this->getModel('XXX_UCFIRST_INTERNAL_NAME_XXX', 'CooltagsModel');

		if ($editId) {
            $model->checkout($editId);
		}

		if ($previousId) {
            $model->checkin($previousId);
		}

		$this->setRedirect(JRoute::_('index.php?option=com_cooltags&view=XXX_INTERNAL_NAME_FORCE_FORM_XXX&layout=edit', false));
	}

	public function save()
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		header("Content-Type: text/html; charset=utf-8");
		$app	= JFactory::getApplication();
		$model = $this->getModel('XXX_UCFIRST_INTERNAL_NAME_XXX', 'CooltagsModel');

		$data = JRequest::getVar('jform', array(), 'post', 'array');

		$form = $model->getForm();
		if (!$form) {
			JError::raiseError(500, $model->getError());
			return false;
		}

		$data = $model->validate($form, $data);

		if ($data === false) {
			$errors	= $model->getErrors();

			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if ($errors[$i] instanceof Exception) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				} else {
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			$app->setUserState('com_cooltags.edit.XXX_INTERNAL_NAME_FORCE_FORM_XXX.data', $data);

			$id = (int) $app->getUserState('com_cooltags.edit.XXX_INTERNAL_NAME_FORCE_FORM_XXX.id');
			$this->setRedirect(JRoute::_('index.php?option=com_cooltags&view=XXX_INTERNAL_NAME_FORCE_FORM_XXX&layout=edit&id='.$id, false));
			return false;
		}

		$return	= $model->save($data);

		if ($return === false) {
			$app->setUserState('com_cooltags.edit.XXX_INTERNAL_NAME_FORCE_FORM_XXX.data', $data);

			$id = (int)$app->getUserState('com_cooltags.edit.XXX_INTERNAL_NAME_FORCE_FORM_XXX.id');
			$this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_cooltags&view=XXX_INTERNAL_NAME_FORCE_FORM_XXX&layout=edit&id='.$id, false));
			return false;
		}

            
        if ($return) {
            $model->checkin($return);
        }
        
        $app->setUserState('com_cooltags.edit.XXX_INTERNAL_NAME_FORCE_FORM_XXX.id', null);

        $this->setMessage(JText::_('Item saved successfully'));
        $this->setRedirect(JRoute::_('index.php?option=com_cooltags&view=XXX_INTERNAL_NAME_FORCE_FORM_XXX&id='.$return, false));

		$app->setUserState('com_cooltags.edit.XXX_INTERNAL_NAME_FORCE_FORM_XXX.data', null);
	}
    
    
    function cancel() {
        
		$app			= JFactory::getApplication();

		$id = (int) $app->getUserState('com_cooltags.edit.XXX_INTERNAL_NAME_FORCE_FORM_XXX.id');
        if ($id) {
            $app->setUserState('com_cooltags.edit.XXX_INTERNAL_NAME_FORCE_FORM_XXX.id', null);
			$this->setRedirect(JRoute::_('index.php?option=com_cooltags&view=XXX_INTERNAL_NAME_FORCE_FORM_XXX&id='.$id, false));
        } else {
			$this->setRedirect(JRoute::_('index.php?option=com_cooltags&view=XXX_INTERNAL_NAME_FORCE_LIST_XXX', false));
        }
        
    }
    
    
}