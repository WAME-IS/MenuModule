<?php

namespace Wame\MenuModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridColumn;
use Wame\MenuModule\Models\MenuManager;

class EditGridAction extends BaseGridColumn
{
    private $menuManager;
    
    
    public function __construct(MenuManager $menuManager)
    {
        $this->menuManager = $menuManager->menuItemTypes;
    }
    
    
	public function addColumn($grid)
	{
		$grid->addAction('edit', '')
            ->setRenderer(function($item) {
                return $this->menuManager[$item->type]->getLinkUpdate($item);
            })
			->setIcon('pencil')
			->setTitle(_('Edit'))
			->setClass('btn btn-xs btn-info');
		
		return $grid;
	}
}