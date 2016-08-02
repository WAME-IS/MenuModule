<?php

namespace Wame\MenuModule\Vendor\Wame\AdminModule\Grids\Columns;

class AddGridToolbarButton extends \Wame\DataGridControl\BaseGridColumn
{
	public function addColumn($grid)
    {
        $grid->addToolbarButton(':Admin:Menu:addItem', _('Add item'), ['id' => $grid->presenter->id])
                ->setIcon('fa fa-plus')
                ->setClass('btn btn-success');
                
		return $grid;
	}
}