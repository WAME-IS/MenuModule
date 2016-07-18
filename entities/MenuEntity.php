<?php

namespace Wame\MenuModule\Entities;

use Doctrine\ORM\Mapping as ORM;
use Wame\Core\Entities\Columns;
use Wame\Core\Entities\TranslatableEntity;

/**
 * @ORM\Table(name="wame_menu")
 * @ORM\Entity
 */
class MenuEntity extends TranslatableEntity
{
	use Columns\Identifier;
	use Columns\CreateDate;
	use Columns\CreateUser;
	use Columns\Parameters;
	use Columns\Status;

	/**
     * @ORM\OneToMany(targetEntity="MenuLangEntity", mappedBy="item")
     */
    protected $langs;

	/**
     * @ORM\ManyToOne(targetEntity="Wame\ComponentModule\Entities\ComponentEntity", inversedBy="id")
     * @ORM\JoinColumn(name="component_id", referencedColumnName="id", nullable=false)
     */
    protected $component;
	
	/**
	 * @ORM\Column(name="showing", type="integer", nullable=true)
	 */
	protected $showing;

	/**
	 * @ORM\Column(name="sort", type="integer", nullable=false)
	 */
	protected $sort;

	/**
	 * @ORM\Column(name="type", type="string", nullable=true)
	 */
	protected $type;
	
	/**
	 * @ORM\Column(name="value_id", type="integer", nullable=true)
	 */
	protected $value;
	
	
	/** get ************************************************************/
	
	public function getComponent()
	{
		return $this->component;
	}
	
	public function getShowing()
	{
		return $this->showing;
	}
	
	public function getSort()
	{
		return $this->sort;
	}
	
	public function getType()
	{
		return $this->type;
	}
	
	public function getValue()
	{
		return $this->value;
	}
	
	
	/** set ************************************************************/
	
	public function setComponent($component)
	{
		$this->component = $component;
		
		return $this;
	}
	
	public function setShowing($showing)
	{
		$this->showing = $showing;
		
		return $this;
	}
	
	public function setSort($sort)
	{
		$this->sort = $sort;
		
		return $this;
	}
	
	public function setType($type)
	{
		$this->type = $type;
		
		return $this;
	}
	
	public function setValue($value)
	{
		$this->value = $value;
		
		return $this;
	}
	
}