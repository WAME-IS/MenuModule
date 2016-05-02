<?php 

namespace Wame\MenuModule\Models;

use Nette\Utils\Strings;

class Item
{	
    /** @var array */
    private $attributes = [];
    
    /** @var int */
    private $priority = 0;
    
    /** @var string */
    private $description;
    
    /** @var string */
    private $icon;
    
    /** @var string */
    private $link;
    
    /** @var string */
    private $name;
    
    /** @var string */
    private $title;
    
    /** @var array */
    private $nodes = [];
    
	
    /**
     * Set item CSS class
     * 
     * @param array $attributes
     * @return \App\AdminModule\Components\AdminMenuControl\Item
     */
	public function addAttributes($attributes)
    {
        $this->attributes = $attributes;
        
        return $this;
    }
    
	
    /**
     * Set item priority
     * 
     * @param int $priority
     * @return \App\AdminModule\Components\AdminMenuControl\Item
     */
	public function setPriority($priority)
    {
        $this->priority = $priority;
        
        return $this;
    }
	
    
    /**
     * Set item description
     * 
     * @param string $description
     * @return \App\AdminModule\Components\AdminMenuControl\Item
     */
	public function setDescription($description)
    {
        $this->description = $description;
        
        return $this;
    }
    
	
    /**
     * Set item icon
     * 
     * @param string $icon
     * @return \App\AdminModule\Components\AdminMenuControl\Item
     */
	public function setIcon($icon)
    {
        $this->icon = $icon;
        
        return $this;
    }
	
    
    /**
     * Set item link
     * 
     * @param string $link
     * @return \App\AdminModule\Components\AdminMenuControl\Item
     */
	public function setLink($link)
    {
        $this->link = $link;
        
        return $this;
    }
    
	
    /**
     * Set item name
     * 
     * @param string $name
     * @return \App\AdminModule\Components\AdminMenuControl\Item
     */
	public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
	
    /**
     * Set item title
     * 
     * @param string $title
     * @return \App\AdminModule\Components\AdminMenuControl\Item
     */
	public function setTitle($title)
    {
        $this->title = $title;
        
        return $this;
    }
    
	
    /**
     * Add sub item
     * 
     * @param stdClass $node
     * @return \App\AdminModule\Components\AdminMenuControl\Item
     */
    public function addNode($node)
    {
        if ($node->name) {
            $this->nodes[$node->name] = $node;
        } else {
            $this->nodes[Strings::webalize($node->title)] = $node;
        }
        
        return $this;
    }
	
    
    /**
     * Return item object
     * 
     * @return \stdClass
     */
    public function getItem()
    {
        $return = new \stdClass();
        $return->attributes = $this->attributes;
        $return->priority = $this->priority;
        $return->description = $this->description;
        $return->icon = $this->icon;
        $return->link = $this->link;
        $return->name = $this->getName();
        $return->title = $this->title;
        $return->nodes = $this->nodes;
        
        return $return;
    }
    
    /**
     * Get item name
     * 
     * @return string
     */
    private function getName()
    {
        if ($this->name) {
            return $this->name;
        } else {
            throw new \Exception(_('The menu item must be given name. Please use setName() method.'));
        }
    }

}