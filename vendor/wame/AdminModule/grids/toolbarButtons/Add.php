<?php

namespace Wame\MenuModule\Vendor\Wame\AdminModule\Grids\ToolbarButtons;

use Wame\DataGridControl\BaseGridItem;

class Add extends BaseGridItem
{
	/** {@inheritDoc} */
	public function render($grid)
    {
        $grid->addToolbarButton(':Admin:Menu:addItem', _('Add item'), ['id' => $grid->presenter->id])
                ->setIcon('fa fa-plus')
                ->setClass('btn btn-success');
                
		return $grid;
	}
    
}