<?php

namespace Wame\MenuModule\Components;

use Nette\DI\Container;
use Nette\Utils\Html;
use Wame\Core\Components\BaseControl;
use Wame\MenuModule\Models\MenuBuilder;

interface IMenuControlFactory
{

    /** @return MenuControl */
    public function create();
}

class MenuControl extends BaseControl
{

    /** @var MenuBuilder */
    public $menuBuilder;

    /** @var array */
    private $providers;

    public function __construct(Container $container)
    {
        parent::__construct($container);

        $this->menuBuilder = new MenuBuilder();
    }

    /**
     * Add provider
     * 
     * @param class $provider
     */
    public function addProvider($provider, $name = null)
    {
        $this->providers[$name] = $provider;
    }

    /**
     * Get control prototype
     * 
     * @return Html
     */
    public function getContainerPrototype()
    {
        return $this->menuBuilder->getContainerPrototype();
    }

    /**
     * Get list prototype
     * 
     * @return Html
     */
    public function getListPrototype()
    {
        return $this->menuBuilder->getListPrototype();
    }

    /**
     * Get item prototype
     * 
     * @return Html
     */
    public function getItemPrototype()
    {
        return $this->menuBuilder->getItemPrototype();
    }

    /**
     * Set Html container prototype
     * 
     * @param Html $container
     * @return MenuBuilder
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
     * @return MenuBuilder
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
     * @return MenuBuilder
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
     * @return MenuControl
     */
    public function setItemTemplate($namespace)
    {
        $this->menuBuilder->setItemTemplate($namespace);

        return $this;
    }

    public function render()
    {
        $this->menuBuilder->setProviders($this->providers);

        if ($this->componentInPosition) {
            $this->template->component = $this->componentInPosition->component;
            $this->template->position = $this->componentInPosition->position;
        }
        $this->template->menu = $this->menuBuilder->create();

        $this->getTemplateFile();
        $this->template->render();
    }
}
