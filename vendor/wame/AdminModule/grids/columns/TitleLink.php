<?php

namespace Wame\MenuModule\Vendor\Wame\AdminModule\Grids\Columns;

use Nette\Utils\Html;
use Wame\DataGridControl\BaseGridItem;
use Wame\MenuModule\Models\MenuManager;

class TitleLink extends BaseGridItem
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