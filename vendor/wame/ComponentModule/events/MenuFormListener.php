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
		$this->updateParameters($componentEntity, $values);
	}
	
	
	public function onUpdate($form, $values, $componentEntity)
	{
		$this->updateParameters($componentEntity, $values);
	}
	
	
	public function onDelete()
	{
		
	}
	
	
	private function updateParameters($componentEntity, $values)
	{
		$parameters = $componentEntity->parameters;

		$parameters['class'] = $values['class'];

		$componentEntity->parameters = $parameters;
		
		return $componentEntity;
	}

}
