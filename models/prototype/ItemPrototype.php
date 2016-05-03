<?php

namespace Wame\MenuModule\Models\Prototype;

use Nette\Utils\Html;

class ItemPrototype
{	
    /** @var array */
    private $items = [];

    /** @var Html */
    private $element;

	
    /**
     * Item process
     * 
     * @param Html $element
     * @param array $items
     * @return array
     */
	public function process($element, $items)
	{
        $this->element = $element;
        
        foreach ($items as $priority) {
			foreach ($priority as $item) {
				$this->items[] = clone $this->getItem($item);
			}
        }

		return $this->items;
	}
    
	
    /**
     * Generate Html item
     * 
     * @param \stdClass $item
     * @param int $level
     * @return Html
     */
    private function getItem($item, $level = 0)
    {      
        $html = $this->setIcon($item);
        $html .= $this->setTitle($item);
        $html .= $this->setDescription($item);
        
        if (empty($item->link)) {
            $return = $html;
        } else {
            $return = Html::el('a')
                            ->href($item->link)
                            ->setHtml($html);
        }
        
        if (count($item->nodes) > 0) {
            $level++;
            
            $return .= Html::el('ul')
                            ->setClass('nodes')
                            ->data('level', $level)
                            ->setHtml($this->getNodes($item, $level));
        }
        
        return $this->element->addAttributes($item->attributes)->data('name', $item->name)->setHtml($return);
    }
    
	
    /**
     * Set Html icon
     * 
     * @param \stdClass $item
     * @return Html
     */
    private function setIcon($item)
    {
        $html = null;
        
        if ($item->icon != '') {
            $html = Html::el('span')
                        ->setClass($item->icon);
        }
        
        return $html;
    }
    
	
    /**
     * Set Html title
     * 
     * @param \stdClass $item
     * @return Html
     */
    private function setTitle($item)
    {
        $html = null;
        
        if ($item->title != '') {
            $html = Html::el('span')
                        ->setClass('title')
                        ->setText($item->title);
        }
        
        return $html;
    }
    
	
    /**
     * Set Html description
     * 
     * @param \stdClass $item
     * @return Html
     */
    private function setDescription($item)
    {
        $html = null;
        
        if ($item->description != '') {
            $html = Html::el('p')
                        ->setClass('description')
                        ->setText($item->description);
        }
        
        return $html;
    }
    
	
    /**
     * Get item nodes
     * 
     * @param \stdClass $item
     * @param int $level
     * @return Html
     */
    private function getNodes($item, $level)
    {
        $html = '';
        
        foreach ($item->nodes as $priority) {
			foreach ($priority as $item) {
				$html .= $this->getItem($item, $level);
			}
        }
        
        return $html;
    }

}
