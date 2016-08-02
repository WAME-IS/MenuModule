<?php

namespace Wame\MenuModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridColumn;
use Wame\MenuModule\Models\MenuManager;
use Nette\Utils\Html;

class TitleLinkGridColumn extends BaseGridColumn
{
    private $menuManager;
    
    
    public function __construct(MenuManager $menuManager)
    {
        $this->menuManager = $menuManager->menuItemTypes;
    }
    
    
	public function addColumn($grid) {
		$grid->addColumnLink('title', _('Title'))
				->setRenderer(function($item) {
                    return Html::el('a')
                                ->addAttributes(['href' => $this->menuManager[$item->type]->getLinkUpdate($item)])
                                ->setText($item->title);
				})
                ->setSortable('l0.title')
				->setFilterText(['l0.title']);
		
		return $grid;
	}
}