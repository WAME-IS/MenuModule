<?php 

namespace Wame\MenuModule\Components;

use Nette\Utils\Html;
use Wame\MenuModule\Models\MenuBuilder;

interface IMenuControlFactory
{
	/** @return MenuControl */
	public function create();	
}


class MenuControl extends \App\Core\Components\BaseControl
{	
	/** @var MenuBuilder */
    private $menuBuilder;
    
	/** @var array */
    private $providers;
        
	
    public function __construct(MenuBuilder $menuBuilder) 
    {
        parent::__construct();
        
        $this->menuBuilder = $menuBuilder;
    }
	
	
    /**
     * Add provider
     * 
     * @param class $provider
     */
	public function addProvider($provider)
	{
        $this->providers[] = $provider;
	}
    
    /**
     * Set Html container prototype
     * 
     * @param Html $container
     * @return \Wame\MenuModule\Models\MenuBuilder
     */
    public function setContainerPrototype(Html $container)
    {
        $this->menuBuilder->setContainerPrototype($container);
        
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
        $this->menuBuilder->setListPrototype($list);
        
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
        $this->menuBuilder->setItemPrototype($item);
        
        return $this;
    }
	
	
	/**
	 * Set Item template
	 * 
	 * @param object $namespace
	 * @return \Wame\MenuModule\Components\MenuControl
	 */
	public function setItemTemplate($namespace)
	{
		$this->menuBuilder->setItemTemplate($namespace);
		
		return $this;
	}
	
	
	public function render()
	{
        $this->menuBuilder->setProviders($this->providers);
        
		if ($this->templateFile) {
			$this->template->setFile($this->templateFile);
		} else {
			$this->template->setFile(__DIR__ . '/MenuControl.latte');
		}

		$this->template->menu = $this->menuBuilder->create();
		$this->template->render();
	}

}