<?php

namespace Wame\MenuModule\Forms;

use Nette\Application\Application;
use Nette\Http\Request;
use Wame\DynamicObject\Forms\BaseFormContainer;
use Wame\ComponentModule\Entities\ComponentEntity;
use Wame\ComponentModule\Repositories\ComponentRepository;
use Wame\MenuModule\Repositories\MenuRepository;


interface IBasicFormContainerFactory
{
	/** @return BasicFormContainer */
	function create();
}


class BasicFormContainer extends BaseFormContainer
{
	/** @var ComponentEntity */
	private $menu;
	
	/** @var array */
	private $items = [];


	public function __construct(
		Application $application, 
		Request $httpRequest,
		ComponentRepository $componentRepository, 
		MenuRepository $menuRepository
	) {
		parent::__construct();
		
		$id = $application->router->match($httpRequest)->getParameter('id');
		$this->menu = $componentRepository->get(['id' => $id]);
		$this->items = $menuRepository->getItemList($this->menu);
	}


    protected function configure() 
	{		
		$form = $this->getForm();
		
		$form->addGroup(_('Basic'));

		$form->addSelect('parent', _('Parent'), $this->items)
				->setPrompt('- ' . _('Highest level') . ' -');
    }


	public function setDefaultValues($object)
	{
		$form = $this->getForm();

//		$form['parent']->setDefaultValue($object->menuEntity->parent);
	}

}