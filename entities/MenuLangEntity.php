<?php

namespace Wame\MenuModule\Entities;

use Doctrine\ORM\Mapping as ORM;
use Wame\Core\Entities\Columns;
use Wame\Core\Entities\BaseLangEntity;

/**
 * @ORM\Table(name="wame_menu_lang")
 * @ORM\Entity
 */
class MenuLangEntity extends BaseLangEntity
{
	use Columns\Identifier;
	use Columns\EditDate;
	use Columns\EditUser;
	use Columns\Lang;
	use Columns\Title;
	use Columns\Slug;
	use Columns\Parameters;

	/**
     * @ORM\ManyToOne(targetEntity="MenuEntity", inversedBy="langs")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id", nullable=false)
     */
	protected $item;
	
	/**
	 * @ORM\Column(name="alternative_title", type="string", nullable=true)
	 */
	protected $alternativeTitle;

	
	public function getAlternativeTitle()
	{
		return $this->alternativeTitle;
	}
	
	public function setAlternativeTitle($alternativeTitle)
	{
		$this->alternativeTitle = $alternativeTitle;
		
		return $this;
	}
	
	public function getItemTitle()
	{
		if ($this->getAlternativeTitle()) {
			return $this->getAlternativeTitle();
		} else {
			return $this->getTitle();
		}
	}
    
    
    /** {@inheritDoc} */
    public function setEntity($entity)
    {
        $this->item = $entity;
    }
	
}