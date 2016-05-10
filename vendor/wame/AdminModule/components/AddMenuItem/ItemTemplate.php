<?php

namespace Wame\MenuModule\Vendor\Wame\AdminModule\Components\AddMenuItem;

use Nette\Application\IRouter;
use Nette\Http\Request;
use Nette\Utils\Html;
use Wame\MenuModule\Models\MenuManager;

class ItemTemplate extends \Nette\Object
{	
	/** @var integer */
	private $menuId;
	
	/** @var MenuManager */
	private $menuManager;
	
	
	public function __construct(IRouter $router, Request $httpRequest, MenuManager $menuManager) 
	{
		$this->menuId = $router->match($httpRequest)->getParameter('id');
		$this->menuManager = $menuManager->menuItemTypes;
	}
	
	
	public function createItem($element, $item) 
	{
		$icon = Html::el('div')->addClass('caption')->setHtml(Html::el('span')->addClass($item->icon . ' fa-4x text-primary'));
		
		$caption = $this->getCaption($item);
		
		$html = Html::el('div')->setClass('thumbnail text-center')->setHtml($icon . $caption);
		
		return $element->addAttributes($item->attributes)->data('name', $item->name)->setHtml($html);
	}
	
	
	private function getCaption($item)
	{
		$title = Html::el('div')->setClass('lead')->setText($item->title);
		
		if ($item->description) {
			$description = Html::el('p')->setText($item->description);
		} else {
			$description = '';
		}
		
		$button = Html::el('p')->setHtml(Html::el('a')->href($this->menuManager[$item->name]->getLinkCreate($this->menuId))->setClass('btn btn-success')->setHtml(
						Html::el('span')->setClass('fa fa-plus') . 
						Html::el()->setText(' ' . _('Add item'))
					));
		
		$html = Html::el('div')->setClass('caption')->setHtml($title . $description . $button);
		
		return $html;
	}
	
}
