<?php

namespace Wame\MenuModule\Models\DatabaseMenuProvider;

interface IMenuItem
{
	/**
	 * Create item to menu
	 */
	public function addItem();
	
	/**
	 * Menu item type
	 */
	public function getName();
	
	/**
	 * Menu item title
	 */
	public function getTitle();
	
	/**
	 * Menu item description
	 */
	public function getDescription();
	
	/**
	 * Menu item icon
	 */
	public function getIcon();
	
	/**
	 * Link to create menu item [admin]
	 */
	public function getLinkCreate();
	
	/**
	 * Link to edit menu item [admin]
	 */
	public function getLinkUpdate($menuEntity);
	
	/**
	 * Link to menu item [frontend]
	 */
	public function getLink($menuEntity);
	
}