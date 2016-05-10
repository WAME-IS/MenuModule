<?php

namespace Wame\MenuModule\Vendor\Wame\ComponentModule;

interface IMenuComponentFactory
{
	/** @return MenuComponent */
	public function create();	
}


class MenuComponent implements \Wame\MenuModule\Models\IComponent
{	
	/** @var \Nette\Application\LinkGenerator */
	private $linkGenerator;

	
	public function __construct(
		\Nette\Application\LinkGenerator $linkGenerator
	) {
		$this->linkGenerator = $linkGenerator;
	}
	
	
	public function addItem()
	{
		$item = new \Wame\MenuModule\Models\Item();
		$item->setName('menu');
		$item->setTitle(_('Menu'));
		$item->setLink($this->linkGenerator->link('Admin:Menu:create'));
		$item->setIcon('fa fa-list');
		
		return $item->getItem();
	}
	
	
	public function getLink()
	{
		return $this->linkGenerator->link('Admin:Menu:view');
	}
	
}