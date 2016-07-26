<?php

namespace Wame\MenuModule\Models;

use Wame\MenuModule\Models\Item;
use Wame\MenuModule\Repositories\MenuRepository;
use Wame\MenuModule\Models\MenuManager;

class MenuItemProcessor
{	
	/** @var string */
	private $lang;
	
	/** @var array */
	private $menuManager;
	
	
	public function __construct(MenuRepository $menuRepository, MenuManager $menuManager) 
	{
		$this->lang = $menuRepository->lang;
		$this->menuManager = $menuManager->menuItemTypes;
	}
	
	
	public function process($databaseItems)
	{
		$items = [];
		
		foreach ($databaseItems as $item) {
			$items[0][] = $this->addItem($item);
		}
		
		return $items;
	}
	
	
	private function addItem($item) 
	{
		$menuItem = new Item();
		$menuItem->setName('item_' . $item->id);
		$menuItem->setTitle($item->langs[$this->lang]->getItemTitle());
		$menuItem->setLink($this->menuManager[$item->type]->getLink($item));
        $menuItem->setOpen($item->getParameter('open'));
		$menuItem->setIcon($item->getParameter('icon'));
		
		if ($item->getParameter('class')) {
			$menuItem->addAttributes(['class' => $item->getParameter('class')]);
		}
		
		return $menuItem->getItem();
	}

}
