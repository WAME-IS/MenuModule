<?php

namespace Wame\MenuModule\Models;

use Nette\Utils\Html;

class MenuBuilder
{
    /** @var array */
    private $providers = [];
    
    /** @var Html */
    public $container;
    
    /** @var Html */
    public $list;

    /** @var Html */
    public $item;

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
	 * Get control prototype
	 * 
	 * @return Html
	 */
	public function getContainerPrototype()
	{
		return $this->container;
	}
	
	
	/**
	 * Get list prototype
	 * 
	 * @return Html
	 */
	public function getListPrototype()
	{
		return $this->list;
	}
	
	
	/**
	 * Get item prototype
	 * 
	 * @return Html
	 */
	public function getItemPrototype()
	{
		return $this->item;
	}
	
	
	/**
	 * Get items
	 * 
	 * @return array
	 */
    private function getItems()
    {
        $items = [];

        foreach ($this->providers as $name => $provider) {
			if (is_numeric($name)) {
				$name = null;
			}
			
            $items = array_merge($provider->getItems($name), $items);
        }

        $itemPrototype = new \Wame\MenuModule\Models\Prototype\ItemPrototype();

        return $itemPrototype->process($this->getItemPrototype(), $items, $this->itemTemplate);
    }

	
    /**
     * Create menu object
     * 
     * @return \stdClass
     */
    public function create()
    {
        $menu = new \stdClass();
        $menu->container = $this->getContainerPrototype();
        $menu->list = $this->getListPrototype();
        $menu->items = $this->getItems();

        return $menu;
    }
    
}
