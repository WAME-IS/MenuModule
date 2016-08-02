<?php

namespace Wame\MenuModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridColumn;

class DeleteGridAction extends BaseGridColumn
{
	public function addColumn($grid) {
		$grid->addAction('delete', '', ":{$grid->presenter->getName()}:deleteItem")
			->setIcon('trash')
			->setTitle(_('Delete'))
			->setClass('btn btn-xs btn-danger ajax-modal');
		
		return $grid;
	}
}