<?php

namespace Wame\MenuModule\Forms;

use Wame\DynamicObject\Forms\BaseFormContainer;
use Wame\MenuModule\Repositories\MenuRepository;

interface IAdvancedFormContainerFactory
{
	/** @return AdvancedFormContainer */
	function create();
}


class AdvancedFormContainer extends BaseFormContainer
{
	/** @var MenuRepository */
	private $menuRepository;
	
	public function __construct(MenuRepository $menuRepository) {
		parent::__construct();
		
		$this->menuRepository = $menuRepository;
	}
	
    public function render() 
	{
        $this->template->_form = $this->getForm();
        $this->template->render(__DIR__ . '/default.latte');
    }

	
    protected function configure() 
	{		
		$form = $this->getForm();
		
		$form->addGroup(_('Advanced'));

        $form->addRadioList('showing', _('Showing'), $this->menuRepository->getShowingList())
				->setDefaultValue(MenuRepository::SHOWING_EVERYONE)
				->getSeparatorPrototype()->setName(null);

		$form->addText('class', _('CSS class'));

        $form->addText('icon', _('Icon'));
		
        $form->addRadioList('only_icon', _('Only icon'), $this->yesOrNo)
				->setDefaultValue(BaseFormContainer::SWITCH_NO)
				->getSeparatorPrototype()->setName(null);
    }
	
	
	public function setDefaultValues($object)
	{
		$form = $this->getForm();

		$form['showing']->setDefaultValue($object->menuEntity->showing);
		
		$parameters = $object->menuEntity->parameters;
		
		if (isset($parameters['class'])) {
			$form['class']->setDefaultValue($parameters['class']);
		}
		
		if (isset($parameters['icon'])) {
			$form['icon']->setDefaultValue($parameters['icon']);
		}
		
		if (isset($parameters['only_icon'])) {
			$form['only_icon']->setDefaultValue($parameters['only_icon']);
		}
	}
	
}