<?php

namespace Wame\MenuModule\Forms;

use Nette\Application\UI\Form;
use Nette\Security\User;
use Nette\Application\IRouter;
use Nette\Http\Request;
use Kdyby\Doctrine\EntityManager;
use Wame\Core\Forms\FormFactory;
use Wame\UserModule\Repositories\UserRepository;
use Wame\MenuModule\Entities\MenuEntity;
use Wame\MenuModule\Entities\MenuLangEntity;
use Wame\MenuModule\Repositories\MenuRepository;
use Wame\ComponentModule\Repositories\ComponentRepository;

class MenuItemForm extends FormFactory
{
	/** @var MenuEntity */
	public $menuEntity;
	
	/** @var string */
	public $lang;
	
	/** @var int */
	private $menuId;
	
	/** @var Request */
	private $httpRequest;
	
	/** @var User */
	private $user;

	/** @var EntityManager */
	private $entityManager;

	/** @var ComponentRepository */
	private $componentRepository;
	
	/** @var MenuRepository */
	private $menuRepository;
	
	/** @var UserEntity */
	private $userEntity;
	
	/** @var UserRepository */
	private $userRepository;
	
	/** @var string */
	private $type;
	
	/** @var string */
	private $actionForm;
	
	
	public function __construct(
		IRouter $router,
		Request $httpRequest,
		User $user,
		EntityManager $entityManager, 
		ComponentRepository $componentRepository,
		MenuRepository $menuRepository,
		UserRepository $userRepository
	) {
		parent::__construct();

		$this->httpRequest = $httpRequest;
		$this->user = $user;
		$this->entityManager = $entityManager;
		$this->componentRepository = $componentRepository;
		$this->menuRepository = $menuRepository;
		$this->userRepository = $userRepository;
		
		$this->menuId = $router->match($httpRequest)->getParameter('m');
		$this->lang = $menuRepository->lang;
	}

	
	public function build()
	{		
		$form = $this->createForm();
		
		$this->getActionForm($form);

		if ($this->id) {
			$form->addSubmit('submit', _('Update'));
			
			$this->menuEntity = $this->menuRepository->get(['id' => $this->id]);
			$this->setDefaultValues();
		} else {
			$form->addSubmit('submit', _('Create'));
		}

		$form->onSuccess[] = [$this, 'formSucceeded'];

		return $form;
	}
	
	public function formSucceeded(Form $form, $values)
	{
		$presenter = $form->getPresenter();
		
		$this->userEntity = $this->userRepository->get(['id' => $this->user->id]);

		try {
			if ($this->id) {
				$menuEntity = $this->update($values);
				
				$this->menuRepository->onUpdate($form, $values, $menuEntity);

				$presenter->flashMessage(_('The menu item has been successfully updated.'), 'success');
			} else {
				$menuEntity = $this->create($values);
				
				$this->menuRepository->onCreate($form, $values, $menuEntity);

				$presenter->flashMessage(_('The menu item was successfully created.'), 'success');
			}

			$presenter->redirect(':Admin:Menu:view', ['id' => $this->menuId]);
		} catch (\Exception $e) {
			if ($e instanceof \Nette\Application\AbortException) {
				throw $e;
			}
			
			$form->addError($e->getMessage());
			$this->entityManager->clear();
		}
	}
	
	
	/**
	 * Create menu item
	 * 
	 * @param array $values
	 * @return MenuEntity
	 */
	private function create($values)
	{
		$componentEntity = $this->componentRepository->get(['id' => $this->menuId]);

		$menuEntity = new MenuEntity();
		$menuEntity->setType($this->getType());
		$menuEntity->setComponent($componentEntity);
		$menuEntity->setCreateDate($this->formatDate('now'));
		$menuEntity->setCreateUser($this->userEntity);
		$menuEntity->setStatus(MenuRepository::STATUS_ACTIVE);
		$menuEntity->setShowing($this->getShowing($values));
		$menuEntity->setParameters($this->getItemParameters($values));
		
		$menuLangEntity = new MenuLangEntity();
		$menuLangEntity->item = $menuEntity;
		$menuLangEntity->setLang($this->lang);
		$menuLangEntity->setEditDate($this->formatDate('now'));
		$menuLangEntity->setEditUser($this->userEntity);

		$menuEntity->addLang($this->lang, $menuLangEntity);
		
		return $this->menuRepository->create($menuEntity);
	}
	
	
	/**
	 * Update menu item
	 * 
	 * @param array $values
	 * @return MenuEntity
	 */
	private function update($values)
	{
		$menuEntity = $this->menuEntity;
		$menuEntity->setShowing($this->getShowing($values));
		$menuEntity->setParameters($this->getItemParameters($values, $menuEntity->parameters));
		
		$menuLangEntity = $menuEntity->langs[$this->lang];
		$menuLangEntity->setEditDate($this->formatDate('now'));
		$menuLangEntity->setEditUser($this->userEntity);
		
		return $this->menuRepository->update($menuEntity);
	}
	
	
	/**
	 * Set item type
	 * 
	 * @param string $type
	 * @return \Wame\MenuModule\Forms\MenuItemForm
	 */
	public function setType($type)
	{
		$this->type = $type;
		
		return $this;
	}
	
	
	/**
	 * Get item type
	 * 
	 * @return string
	 * @throws \Exception
	 */
	public function getType()
	{
		if ($this->type) {
			return $this->type;
		} else {
			throw new \Exception(_('Type is not defined. You must use the setType() method to create a form.'));
		}
	}
	
	
	/**
	 * Get parameters
	 * 
	 * @param array $values
	 * @param array $parameters
	 * @return array
	 */
	private function getItemParameters($values, $parameters = [])
	{
		$array = [
			'class' => $values['class'],
			'icon' => $values['icon'],
			'only_icon' => $values['only_icon']
		];
		
		return array_replace($parameters, $array);
	}
	
	
	/**
	 * Set action form 
	 * for "?do=" url parameter
	 * 
	 * @param string $actionForm
	 * @return \Wame\MenuModule\Forms\MenuItemForm
	 */
	public function setActionForm($actionForm)
	{
		$this->actionForm = $actionForm;
		
		return $this;
	}
	
	
	/**
	 * Get action form
	 * 
	 * @param Form $form
	 * @return Form
	 * @throws \Exception
	 */
	private function getActionForm(Form $form)
	{
		if ($this->actionForm) {
			$form->setAction($this->httpRequest->getUrl() . '&do=' . $this->actionForm . '-submit');
		} else {
			throw new \Exception(_('Missing variable $actionForm. You must use the setActionForm() method to create the form. Used to set the parameter ?do=.'));
		}
		
		return $form;
	}
	
	
	/**
	 * Get showing item
	 * 
	 * @param array $values
	 * @return int
	 */
	private function getShowing($values)
	{
		if (isset($values['showing'])) {
			return $values['showing'];
		} else {
			return MenuRepository::SHOWING_EVERYONE;
		}
	}

}
