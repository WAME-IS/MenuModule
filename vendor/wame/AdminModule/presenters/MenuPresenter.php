<?php

namespace App\AdminModule\Presenters;

use Nette\Utils\Html;
use Wame\ComponentModule\Forms\ComponentForm;
use Wame\ComponentModule\Repositories\ComponentRepository;
use Wame\MenuModule\Entities\MenuEntity;
use Wame\MenuModule\Repositories\MenuRepository;
use Wame\MenuModule\Models\MenuManager;
use Wame\MenuModule\Vendor\Wame\AdminModule\Components\AddMenuItem\ItemTemplate;
use Wame\PositionModule\Repositories\PositionRepository;

class MenuPresenter extends ComponentPresenter
{
	/** @var MenuEntity */
	private $item;
	
	/** @var array */
	private $items = [];
	
	/** @var ComponentForm @inject */
	public $componentForm;

	/** @var ComponentRepository @inject */
	public $componentRepository;

	/** @var MenuRepository @inject */
	public $menuRepository;

	/** @var MenuManager @inject */
	public $menuManager;

	/** @var ItemTemplate @inject */
	public $itemTemplate;

	/** @var PositionRepository @inject */
	public $positionRepository;

	
	public function actionDefault()
	{
		if (!$this->user->isAllowed('menu', 'view')) {
			$this->flashMessage(_('To enter this section you do not have have enough privileges.'), 'danger');
			$this->redirect(':Admin:Dashboard:', ['id' => null]);
		}
		
		if (!$this->id) {
			$this->flashMessage(_('Missing identifier.'), 'danger');
			$this->redirect(':Admin:Component:', ['id' => null]);
		}
		
		$this->component = $this->componentRepository->get(['id' => $this->id]);
		
		if (!$this->component) {
			$this->flashMessage(_('This component does not exist.'), 'danger');
			$this->redirect(':Admin:Component:', ['id' => null]);
		}
		
		if ($this->component->status == ComponentRepository::STATUS_REMOVE) {
			$this->flashMessage(_('This component is removed.'), 'danger');
			$this->redirect(':Admin:Component:', ['id' => null]);
		}		
	}
	
	
	public function actionCreate()
	{
		if (!$this->user->isAllowed('menu', 'create')) {
			$this->flashMessage(_('To enter this section you do not have have enough privileges.'), 'danger');
			$this->redirect(':Admin:Dashboard:', ['id' => null]);
		}
		
		if ($this->getParameter('p')) {
			$position = $this->positionRepository->get(['id' => $this->getParameter('p')]);
			
			if (!$position) {
				$this->flashMessage(_('This position does not exist.'), 'danger');
				$this->redirect(':Admin:Component:', ['id' => null]);
			}
			
			if ($position->status == PositionRepository::STATUS_REMOVE) {
				$this->flashMessage(_('This position is removed.'), 'danger');
				$this->redirect(':Admin:Component:', ['id' => null]);
			}
			
			if ($position->status == PositionRepository::STATUS_DISABLED) {
				$this->flashMessage(_('This position is disabled.'), 'warning');
			}
		}
	}
	
	
	public function actionEdit()
	{
		if (!$this->user->isAllowed('menu', 'edit')) {
			$this->flashMessage(_('To enter this section you do not have have enough privileges.'), 'danger');
			$this->redirect(':Admin:Dashboard:', ['id' => null]);
		}
		
		if (!$this->id) {
			$this->flashMessage(_('Missing identifier.'), 'danger');
			$this->redirect(':Admin:Component:', ['id' => null]);
		}
		
		$this->component = $this->componentRepository->get(['id' => $this->id]);
		
		if (!$this->component) {
			$this->flashMessage(_('This component does not exist.'), 'danger');
			$this->redirect(':Admin:Component:', ['id' => null]);
		}
		
		if ($this->component->status == ComponentRepository::STATUS_REMOVE) {
			$this->flashMessage(_('This component is removed.'), 'danger');
			$this->redirect(':Admin:Component:', ['id' => null]);
		}
	}
	
	
	public function actionDeleteItem()
	{
		if (!$this->user->isAllowed('menu', 'deleteItem')) {
			$this->flashMessage(_('To enter this section you do not have have enough privileges.'), 'danger');
			$this->redirect(':Admin:Dashboard:', ['id' => null]);
		}
		
		$this->item = $this->menuRepository->get(['id' => $this->id]);
		
		if (!$this->item) {
			$this->flashMessage(_('This menu item does not exist.'), 'danger');
			$this->redirect(':Admin:Component:', ['id' => null]);
		}

		if ($this->item->status == MenuRepository::STATUS_DELETED) {
			$this->flashMessage(_('This position is removed.'), 'danger');
			$this->redirect(':Admin:Component:', ['id' => null]);
		}
	}
	

	/**
	 * Menu component form
	 * 
	 * @return ComponentForm
	 */
	protected function createComponentMenuForm()
	{
		$form = $this->componentForm
						->setType('MenuComponent')
						->setId($this->id)
						->build();

		return $form;
	}
	
	
	/**
	 * Add menu item list
	 * 
	 * @return MenuControl
	 */
	protected function createComponentAddMenuItem()
	{
        $control = $this->IMenuControlFactory->create();
		$control->addProvider($this->menuManager);

		$control->setContainerPrototype(Html::el('div')->setClass('com-menu-item-types'));
		$control->setListPrototype(Html::el('div')->setClass('row'));
		$control->setItemPrototype(Html::el('div')->setClass('col-xs-6 col-sm-4 col-lg-3'));
		$control->setItemTemplate($this->itemTemplate);
        
		return $control;
	}
	
	
	public function renderDefault()
	{
		$showing = $this->getParameter('s');
		
		$this->template->siteTitle = $this->component->langs[$this->lang]->title;
		$this->template->menuManager = $this->menuManager->menuItemTypes;
		$this->template->component = $this->component;
		$this->template->items = $this->menuRepository->getItems($this->component, $showing);
		$this->template->showing = $showing;
		$this->template->showingList = $this->menuRepository->getShowingList();
	}
	
	
	public function renderCreate()
	{
		$this->template->siteTitle = _('Create menu');
	}
	
	
	public function renderEdit()
	{
		$this->template->siteTitle = _('Edit menu');
		$this->template->componentTitle = $this->component->langs[$this->lang]->title;
	}
	
	
	public function renderAddItem()
	{
		$this->template->siteTitle = _('Select the type of item');
	}
	
	
	public function renderDeleteItem()
	{
		$this->template->siteTitle = _('Deleting menu item');
		$this->template->menuId = $this->item->component->id;
	}
	
	
	/**
	 * Delete menu item
	 */
	public function handleDeleteItem()
	{
		if (!$this->user->isAllowed('menu', 'deleteItem')) {
			$this->flashMessage(_('For this action you do not have enough privileges.'), 'danger');
			$this->redirect(':Admin:Dashboard:', ['id' => null]);	
		}
		
		$this->menuRepository->delete(['id' => $this->id]);
		
		$this->flashMessage(_('Menu item has been successfully deleted.'), 'success');
		$this->redirect(':Admin:Menu:', ['id' => $this->item->component->id]);
	}
	
}
