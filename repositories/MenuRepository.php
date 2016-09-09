<?php

namespace Wame\MenuModule\Repositories;

use Wame\ComponentModule\Entities\ComponentEntity;
use Wame\Core\Exception\RepositoryException;
use Wame\LanguageModule\Repositories\TranslatableRepository;
use Wame\MenuModule\Entities\MenuEntity;
use Wame\MenuModule\Entities\MenuLangEntity;

class MenuRepository extends TranslatableRepository
{
	const STATUS_DELETED = 0;
	const STATUS_ACTIVE = 1;
	
	const SHOWING_NOT_LOGGED = 0;
	const SHOWING_LOGGED = 1;
	const SHOWING_EVERYONE = 2;
    
    const OPEN_NORMAL = 'normal';
    const OPEN_NEW_WINDOW = 'new_window';
    const OPEN_SMALL_MODAL = 'small_modal';
    const OPEN_MEDIUM_MODAL = 'medium_modal';
    const OPEN_LARGE_MODAL = 'large_modal';

    
    use \Wame\Core\Repositories\Traits\SortableRepositoryTrait;
	
	
	public function __construct()
    {
		parent::__construct(MenuEntity::class, MenuLangEntity::class);
	}
	
	
	/**
	 * Return menu item status list
	 * 
	 * @return array
	 */
	public function getStatusList()
	{
		return [
			self::STATUS_REMOVE => _('Deleted'),
			self::STATUS_ACTIVE => _('Active')
		];
	}
	
	
	/**
	 * Return menu item status
	 * 
	 * @param int $status
	 * @return string
	 */
	public function getStatus($status)
	{
		return $this->getStatusList()[$status];
	}
	
	
	/**
	 * Return showing list
	 * 
	 * @return array
	 */
	public function getShowingList()
	{
		return [
			self::SHOWING_NOT_LOGGED => _('Not logged'),
			self::SHOWING_LOGGED => _('Logged'),
			self::SHOWING_EVERYONE => _('Everyone')
		];
	}
	
    /**
     * Return open link type list
     * 
     * @return array
     */
    public function getOpenTypeList()
    {
        return [
            self::OPEN_NORMAL => _('Normal'),
            self::OPEN_NEW_WINDOW => _('New window'),
            self::OPEN_SMALL_MODAL => _('Small modal window'),
            self::OPEN_MEDIUM_MODAL => _('Medium modal window'),
            self::OPEN_LARGE_MODAL => _('Large modal window')
        ];
    }
    
	
	/**
	 * Return showing
	 * 
	 * @param int $showing
	 * @return array
	 */
	public function getShowing($showing)
	{
		return $this->getShowingList()[$showing];
	}

	
	/**
	 * Create menu item
	 * 
	 * @param MenuEntity $menuEntity
	 * @return MenuEntity
	 * @throws RepositoryException
	 */
	public function create($menuEntity)
	{
		$this->entityManager->persist($menuEntity);
		
		$this->entityManager->persist($menuEntity->langs);
		
		return $menuEntity;
	}
	
	
	/**
	 * Update menu item
	 * 
	 * @param MenuEntity $menuEntity
	 */
	public function update($menuEntity)
	{
		return $menuEntity;
	}
	
	
	/**
	 * Delete menu item by criteria
	 * 
	 * @param array $criteria
	 * @param int $status
	 */
	public function delete($criteria = [], $status = self::STATUS_DELETED)
	{
		$entity = $this->get($criteria);
		$entity->status = $status;
	}
	
	
	/**
	 * Return item list in actual lang
	 * 
	 * @param ComponentEntity $component
	 * @return array
	 */
	public function getItemList($component)
	{
		$return = [];
		
		$items = $this->getItems($component);
		
		foreach ($items as $item) {
			$return[$item->id] = $item->langs[$this->lang]->title;
		}
		
		return $return;
	}
	
	
	/**
	 * Get active items
	 * 
	 * @param ComponentEntity $component
	 * @return MenuEntity
	 */
	public function getItems($component, $showing = null, $orderBy = null, $limit = null, $offset = null)
	{
		$criteria = ['component' => $component, 'status' => self::STATUS_ACTIVE];

        if ($showing != 1 && ($showing == 0 || $showing == null)) {
            $criteria['showing !='] = self::SHOWING_LOGGED;
        } elseif ($showing == 1) {
            $criteria['showing !='] = self::SHOWING_NOT_LOGGED;
        }
		
		return $this->find($criteria, $orderBy, $limit, $offset);
	}
	
}