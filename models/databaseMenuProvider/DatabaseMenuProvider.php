<?php

namespace Wame\MenuModule\Models;

use Nette\Security\User;
use Wame\MenuModule\Models\IMenuProvider;
use Wame\ComponentModule\Repositories\ComponentRepository;
use Wame\MenuModule\Repositories\MenuRepository;
use Wame\MenuModule\Models\MenuItemProcessor;

class DatabaseMenuProvider implements IMenuProvider
{	
	/** @var User */
	private $user;
	
	/** @var ComponentRepository */
	private $componentRepository;
	
	/** @var MenuRepository */
	private $menuRepository;
	
	/** @var MenuItemProcessor */
	private $menuItemProcessor;
	
	/** @var string */
	private $name;
	
	
	public function __construct(
		User $user, 
		ComponentRepository $componentRepository,
		MenuRepository $menuRepository,
		MenuItemProcessor $menuItemProcessor
	) {
		$this->user = $user;
		$this->componentRepository = $componentRepository;
		$this->menuRepository = $menuRepository;
		$this->menuItemProcessor = $menuItemProcessor;
	}
	
	
	/**
	 * Set component name
	 * 
	 * @param string $name
	 * @return \Wame\MenuModule\Models\DatabaseMenuProvider
	 */
	public function setName($name)
	{
		$this->name = $name;
		
		return $this;
	}
	

    /**
     * Get menu items from database
     * 
     * @return array
     */
    public function getItems()
    {
		$component = $this->componentRepository->get(['name' => $this->name]);
		
		if ($this->user->isLoggedIn()) {
			$showing = 1;
		} else {
			$showing = null;
		}
		
		$items = $this->menuRepository->getItems($component, $showing);
		
        return $this->menuItemProcessor->process($items);
    }

}
