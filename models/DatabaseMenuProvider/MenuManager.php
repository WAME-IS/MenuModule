<?php

namespace Wame\MenuModule\Models;

use Wame\MenuModule\Models\IMenuProvider;
use Wame\MenuModule\Models\ItemSorter;

class MenuManager implements IMenuProvider
{	
	/** @var array */
	public $menuItemTypes = [];
	
	/** @var array */
	private $removeMenuItemType = [];
	
	/** @var ItemSorter */
	private $itemSorter;
	
	
	public function __construct(ItemSorter $itemSorter) 
	{
		$this->itemSorter = $itemSorter;
	}
	
	
	/**
	 * Add menu item type
	 * 
	 * @param object $menuItemType
	 * @param string $name
	 * @return \Wame\MenuModule\Models\MenuManager
	 */
	public function addMenuItemType($menuItemType, $name = null)
	{
		if (!$name) {
			$name = $this->getClassName($menuItemType);
		}
		
		$this->menuItemTypes[$name] = $menuItemType;
		
		return $this;
	}
	
	
	/**
	 * Add menu item type to remove list
	 * 
	 * @param mixed $menuItemType
	 * @return \Wame\MenuModule\Models\MenuManager
	 */
	public function removeMenuItemType($menuItemType)
	{
		if (is_object($menuItemType)) {
			$name = $this->getClassName($menuItemType);
		} else {
			$name = $menuItemType;
		}
		
		$this->removeMenuItemType[$name] = $name;
		
		return $this;
	}
	
	
	/**
	 * Remove menu item types
	 * 
	 * @return array
	 */
	private function removeMenuItemTypes()
	{
		$menuItemTypes = $this->menuItemTypes;
		
		foreach ($this->removeMenuItemType as $menuItemType) {
			if (array_key_exists($menuItemType, $menuItemTypes)) {
				unset($menuItemTypes[$menuItemType]);
			}
		}
		
		return $menuItemTypes;
	}
	

    /**
     * Get menu item types from services
     * 
     * @return array
     */
    public function getItems()
    {
		$menuItemTypes = $this->removeMenuItemTypes();
		
        return $this->itemSorter->sort($menuItemTypes);
    }
	
	
	/**
	 * Get class name from namespace
	 * 
	 * @param string $namespace
	 * @return string
	 */
	public function getClassName($namespace)
	{
		$reflect = new \ReflectionClass($namespace);
		
		return $reflect->getShortName();
	}

}
