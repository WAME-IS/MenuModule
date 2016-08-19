<?php

namespace Wame\MenuModule\Vendor\Wame\AdminModule\Grids\Actions;

use Wame\DataGridControl\BaseGridItem;
use Wame\MenuModule\Models\MenuManager;

class Edit extends BaseGridItem
{
    /** @var MenuManager */
    private $menuManager;
    
    
    public function __construct(MenuManager $menuManager)
    {
        $this->menuManager = $menuManager->menuItemTypes;
    }
    
    
	/** {@inheritDoc} */
	public function render($grid)
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