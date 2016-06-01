<?php 

namespace Wame\MenuModule\Models;

use Nette\Utils\Arrays;

class ItemSorter
{
	/**
	 * Create menu items
	 * 
	 * @var array $services
	 * @return array
	 */
	private function createItems($services)
	{
		$items = [];
		
		foreach ($services as $service) {
            $item = $service->addItem();
			
			if (isset($items[$item->name])) {
				$items[$item->name] = (object) Arrays::mergeTree((array) $items[$item->name], (array) $item);
			} else {
				$items[$item->name] = $item;
			}
        }
		
		return $items;
	}
	
	
	/**
	 * Sort menu items by priority
	 * 
	 * @var array $items
	 * @return array
	 */
	private function sortItems($items)
	{
		$return = [];
		
		foreach ($items as $item) {
			if (count($item->nodes) == 0) {
				$return[$item->priority][] = $item;
			} else {
				$item->nodes = $this->sortItems($item->nodes);
				
				$return[$item->priority][] = $item;
			}
		}

		krsort($return);

		return $return;
	}
	

    /**
     * Get items from services
     * 
     * @var array $services
     * @return array
     */
    public function sort($services)
    {
		$items = $this->createItems($services);

        return $this->sortItems($items);
    }

}