<?php

namespace Wame\MenuModule\Models;

use Nette\Utils\Html;

class MenuBuilder
{
    /** @var array */
    private $providers = [];
    
    /** @var Html */
    private $container;
    
    /** @var Html */
    private $list;

    /** @var Html */
    private $item;

    /** @var string */
    private $itemTemplate;
    
	
    public function __construct() 
    {
        $this->container = Html::el('div');
        $this->list = Html::el('ul');
        $this->item = Html::el('li');
    }
    
	
    /**
     * Set providers
     * 
     * @param array $providers
     * @return \Wame\MenuModule\Models\MenuBuilder
     */
    public function setProviders($providers)
    {
        $this->providers = $providers;
        
        return $this;
    }
    
	
    /**
     * Set Html container prototype
     * 
     * @param Html $container
     * @return \Wame\MenuModule\Models\MenuBuilder
     */
    public function setContainerPrototype(Html $container)
    {
        $this->container = $container;
        
        return $this;
    }
    
	
    /**
     * Set Html list prototype
     * 
     * @param Html $list
     * @return \Wame\MenuModule\Models\MenuBuilder
     */
    public function setListPrototype(Html $list)
    {
        $this->list = $list;
        
        return $this;
    }
    
	
    /**
     * Set Html item prototype
     * 
     * @param Html $item
     * @return \Wame\MenuModule\Models\MenuBuilder
     */
    public function setItemPrototype(Html $item)
    {
        $this->item = $item;
        
        return $this;
    }
    
	
    /**
     * Set item template
     * 
     * @param object $namespace
     * @return \Wame\MenuModule\Models\MenuBuilder
     */
    public function setItemTemplate($namespace)
    {
        $this->itemTemplate = $namespace;
        
        return $this;
    }
    
	
	/**
	 * Get items
	 * 
	 * @return array
	 */
    private function getItems()
    {
        $items = [];

        foreach ($this->providers as $provider) {
            $items = array_merge($provider->getItems(), $items);
        }

        $itemPrototype = new \Wame\MenuModule\Models\Prototype\ItemPrototype();

        return $itemPrototype->process($this->item, $items, $this->itemTemplate);
    }

	
    /**
     * Create menu object
     * 
     * @return \stdClass
     */
    public function create()
    {
        $menu = new \stdClass();
        $menu->container = $this->container;
        $menu->list = $this->list;
        $menu->items = $this->getItems();

        return $menu;
    }
    
}
