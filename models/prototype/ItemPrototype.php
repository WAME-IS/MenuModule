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
     * @param string $itemTemplate
     * @return array
     */
    public function process($element, $items, $itemTemplate = null)
    {
        $this->element = $element;

        if (is_array(current($items))) {
            foreach ($items as $priority) {
                $this->getItems($element, $priority, $itemTemplate);
            }
        } else {
            $this->getItems($element, $items, $itemTemplate);
        }

        return $this->items;
    }
    
    
    /**
     * Get items
     * 
     * @param Html $element
     * @param array $items
     * @param string $itemTemplate
     */
    private function getItems($element, $items, $itemTemplate)
    {
        foreach ($items as $item) {
            if ($itemTemplate) {
                $this->items[] = clone $itemTemplate->createItem($element, $item);
            } else {
                $this->items[] = clone $this->getItem($item);
            }
        }
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
            $return = Html::el('a')->href($item->link);
            
            $this->getOpenLink($item, $return);
            
            $return->setHtml($html);
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
    public function setIcon($item)
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
    public function setTitle($item)
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
    public function setDescription($item)
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
    public function getNodes($item, $level)
    {
        $html = '';

        foreach ($item->nodes as $item) {
            $html .= $this->getItem($item, $level);
        }

        return $html;
    }

    
    /**
     * Get link open
     * 
     * @param \stdClass $item
     * @param Html $element
     * @return Html
     */
    private function getOpenLink($item, $element)
    {
        if ($item->open == 'new_window') {
            $element->setTarget('_blank');
        } elseif ($item->open == 'small_modal') {
            $element->setClass('ajax-modal ajax-modal-sm');
        } elseif ($item->open == 'medium_modal') {
            $element->setClass('ajax-modal');
        } elseif ($item->open == 'large_modal') {
            $element->setClass('ajax-modal ajax-modal-lg');
        }
        
        return $element;
    }
}
