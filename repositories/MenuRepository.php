<?php

namespace Wame\MenuModule\Repositories;

use Wame\ComponentModule\Entities\ComponentEntity;
use Wame\MenuModule\Entities\MenuEntity;

class MenuRepository extends \Wame\Core\Repositories\BaseRepository
{
	const STATUS_DELETED = 0;
	const STATUS_ACTIVE = 1;
	
	const SHOWING_NOT_LOGGED = 0;
	const SHOWING_LOGGED = 1;
	const SHOWING_EVERYONE = 2;
	
	
	public function __construct(\Nette\DI\Container $container, \Kdyby\Doctrine\EntityManager $entityManager, \h4kuna\Gettext\GettextSetup $translator, \Nette\Security\User $user, $entityName = null) {
		parent::__construct($container, $entityManager, $translator, $user, MenuEntity::class);
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
	 * @throws \Wame\Core\Exception\RepositoryException
	 */
	public function create($menuEntity)
	{
		$create = $this->entityManager->persist($menuEntity);
		
		$this->entityManager->persist($menuEntity->langs);
		
		if (!$create) {
			throw new \Wame\Core\Exception\RepositoryException(_('Menu item could not be created.'));
		}
		
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