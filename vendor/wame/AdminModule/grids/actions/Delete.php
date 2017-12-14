<?php

namespace Wame\MenuModule\Vendor\Wame\AdminModule\Grids\Actions;

use Wame\AdminModule\Vendor\Wame\DataGridControl\Actions\BaseGridAction;
use Wame\MenuModule\Models\MenuManager;


class Delete extends BaseGridAction
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
        $grid->addAction('delete', '', $this->getLink($grid))
                ->setIcon('delete')
                ->addAttributes(['data-position' => 'left', 'data-tooltip' => _('Delete')])
                ->setClass('btn btn-xs btn-icon btn-hover-danger tooltipped ajax-modal');

        return $grid;
    }


    /** {@inheritDoc} */
    protected function getLinkAction()
    {
        return 'deleteItem';
    }
    
}
