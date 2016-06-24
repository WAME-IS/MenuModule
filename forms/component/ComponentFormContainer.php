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
    protected function configure() 
	{		
		$form = $this->getForm();

        $form->addText('class', _('CSS class'));
    }


	public function setDefaultValues($object)
	{
		$form = $this->getForm();
		
		//Todo: doriešiť default hodnotu
	}

}