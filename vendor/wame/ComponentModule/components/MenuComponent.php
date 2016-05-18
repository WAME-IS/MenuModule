<?php

namespace Wame\MenuModule\Vendor\Wame\ComponentModule;

use Nette\Application\LinkGenerator;
use Wame\MenuModule\Models\Item;
use Wame\MenuModule\Components\IMenuControlFactory;
use Wame\MenuModule\Models\DatabaseMenuProvider;

interface IMenuComponentFactory
{
	/** @return MenuComponent */
	public function create();	
}


class MenuComponent implements \Wame\ComponentModule\Models\IComponent
{	
	/** @var LinkGenerator */
	private $linkGenerator;

	/** @var IMenuControlFactory */
	private $IMenuControlFactory;

	/** @var DatabaseMenuProvider */
	private $databaseMenuProvider;

	
	public function __construct(
		LinkGenerator $linkGenerator,
		IMenuControlFactory $IMenuControlFactory,
		DatabaseMenuProvider $databaseMenuProvider
	) {
		$this->linkGenerator = $linkGenerator;
		$this->IMenuControlFactory = $IMenuControlFactory;
		$this->databaseMenuProvider = $databaseMenuProvider;
	}
	
	
	public function addItem()
	{
		$item = new Item();
		$item->setName('menu');
		$item->setTitle(_('Menu'));
		$item->setLink($this->linkGenerator->link('Admin:Menu:create'));
		$item->setIcon('fa fa-list');
		
		return $item->getItem();
	}
	
	
	public function getLink($componentEntity)
	{
		return $this->linkGenerator->link('Admin:Menu:', ['id' => $componentEntity->id]);
	}
	
	
	public function createComponent($componentInPosition)
	{
		$control = $this->IMenuControlFactory->create();
		$control->addProvider($this->databaseMenuProvider->setName($componentInPosition->component->name), $componentInPosition->component->name);
		$control->setComponentInPosition($componentInPosition);
		
		return $control;
	}
	
}