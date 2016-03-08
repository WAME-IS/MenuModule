<?php 

namespace Wame\MenuModule\Models;

class Item
{	
    /** @var array */
    private $attributes = [];
    
    /** @var string */
    private $description;
    
    /** @var string */
    private $icon;
    
    /** @var string */
    private $link;
    
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
        $this->nodes[] = $node;
        
        return $this;
    }
	
    /**
     * Add sseparator
     * 
     * @param string $title
     * @return \App\AdminModule\Components\AdminMenuControl\Item
     */
    public function addSeparator($title = null)
    {
        $return = new \stdClass();
        $return->attributes = ['class' => 'divider'];
        $return->description = null;
        $return->icon = null;
        $return->link = null;
        $return->title = $title;
        $return->nodes = null;
		
		$this->nodes[] = $return;

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
        $return->description = $this->description;
        $return->icon = $this->icon;
        $return->link = $this->link;
        $return->title = $this->title;
        $return->nodes = $this->nodes;
        
        return $return;
    }

}