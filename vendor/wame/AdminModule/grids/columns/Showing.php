<?php

namespace Wame\MenuModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridItem;

class Showing extends BaseGridItem
{
	/** {@inheritDoc} */
	public function render($grid)
    {
		$grid->addColumnText('showing', _('Showing'))
                ->setRenderer(function($item) {
                    switch($item->showing) {
                        case 0: return _('Not logged');
                        case 1: return _('Logged');
                        case 2: return _('Everyone');
                    }
                })
                ->setSortable();
		
        $grid->addFilterSelect('showing', _('Showing'), [
            '' => _('All'),
            0 => _('Not logged'),
            1 => _('Logged'),
            2 => _('Everyone')
        ]);
                
		return $grid;
	}
    
}