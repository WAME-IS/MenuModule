<?php

namespace Wame\MenuModule\Vendor\Wame\AdminModule\Grids\ToolbarButtons;

use Wame\AdminModule\Vendor\Wame\DataGridControl\ToolbarButtons\Add as AdminAdd;


class Add extends AdminAdd
{
    public function __construct() 
    {
        $this->setTitle(_('Add item'));
        $this->setLink(':Admin:Menu:addItem');
    }

}