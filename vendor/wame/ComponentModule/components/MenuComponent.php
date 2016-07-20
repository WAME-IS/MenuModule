<?php

namespace Wame\MenuModule\Vendor\Wame\ComponentModule;

use Nette\Application\LinkGenerator;
use Wame\ComponentModule\Registers\IComponent;
use Wame\MenuModule\Models\Item;
use Wame\MenuModule\Components\IMenuControlFactory;
use Wame\MenuModule\Models\DatabaseMenuProvider;

interface IMenuComponentFactory
{
	/** @return MenuComponent */
	public function create();	
}


class MenuComponent implements IComponent
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
		$item->setName($this->getName());
		$item->setTitle($this->getTitle());
		$item->setDescription($this->getDescription());
		$item->setLink($this->getLinkCreate());
		$item->setIcon($this->getIcon());
		
		return $item->getItem();
	}
	
	
	public function getName()
	{
		return 'menu';
	}
	
	
	public function getTitle()
	{
		return _('Menu');
	}
	
	
	public function getDescription()
	{
		return _('Create tree menu');
	}
	
	
	public function getIcon()
	{
		return 'fa fa-list';
	}
	
	
	public function getLinkCreate()
	{
		return $this->linkGenerator->link('Admin:Menu:create');
	}

	
	public function getLinkDetail($componentEntity)
	{
		return $this->linkGenerator->link('Admin:Menu:', ['id' => $componentEntity->id]);
	}
	
	
	public function createComponent($componentInPosition = null)
	{
		$control = $this->IMenuControlFactory->create();
        $control->addProvider($this->databaseMenuProvider->setName($componentInPosition->component->name), 'database');
		return $control;
	}
	
}