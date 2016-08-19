<?php

namespace Wame\MenuModule\Vendor\Wame\AdminModule\Grids\Columns;

use Nette\Utils\Html;
use Wame\DataGridControl\BaseGridItem;
use Wame\MenuModule\Models\MenuManager;

class Type extends BaseGridItem
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
		$grid->addColumnText('type', _('Type'))
				->setRenderer(function($item) {
                    if($this->menuManager[$item->getType()]) {
                        return Html::el('span')
                            ->setClass($this->menuManager[$item->getType()]->getIcon())
                            ->setTitle($this->menuManager[$item->getType()]->getTitle());
                    } else {
                        return Html::el('span')
                                ->setClass('fa fa-question')
                                ->setTitle($item->getType());
                    }
				});
		
		return $grid;
	}
    
}