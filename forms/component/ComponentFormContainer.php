<?php

namespace Wame\MenuModule\Forms;

use Wame\DynamicObject\Forms\BaseFormContainer;

interface IComponentFormContainerFactory
{
	/** @return ComponentFormContainer */
	function create();
}


class ComponentFormContainer extends BaseFormContainer
{
    public function render() 
	{
        $this->template->_form = $this->getForm();
        $this->template->render(__DIR__ . '/default.latte');
    }

	
    protected function configure() 
	{		
		$form = $this->getForm();

        $form->addText('class', _('CSS class'));
    }
	
	
//	public function setDefaultValues($object)
//	{
//		$form = $this->getForm();
//		
//		$address = $this->addressRepository->get(['user' => $object->id]);
//
//		if ($address) {
//			$form['street']->setDefaultValue($address->street);
//			$form['houseNumber']->setDefaultValue($address->houseNumber);
//			$form['zipCode']->setDefaultValue($address->zipCode);
//			$form['city']->setDefaultValue($address->city);
//		}
//	}
	
}