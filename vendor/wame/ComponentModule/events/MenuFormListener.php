<?php

namespace Wame\MenuModule\Vendor\Wame\ComponentModule\Events;

use Nette\Object;
use Wame\ComponentModule\Repositories\ComponentRepository;

class MenuFormListener extends Object 
{
	/** @var ComponentRepository */
	private $componentRepository;
	
	public function __construct(
		ComponentRepository $componentRepository
	) {
		$this->componentRepository = $componentRepository;
		
		$componentRepository->onCreate[] = [$this, 'onCreate'];
		$componentRepository->onUpdate[] = [$this, 'onUpdate'];
		$componentRepository->onDelete[] = [$this, 'onDelete'];
	}

	
	public function onCreate($form, $values, $componentEntity) 
	{
		$this->updateSettings($componentEntity, $values);
	}
	
	
	public function onUpdate($form, $values, $componentEntity)
	{
		$this->updateSettings($componentEntity, $values);
	}
	
	
	public function onDelete()
	{
		
	}
	
	
	private function updateSettings($componentEntity, $values)
	{
		$settings = $componentEntity->settings;

		$settings['class'] = $values['class'];

		$componentEntity->settings = $settings;
		
		return $componentEntity;
	}

}
