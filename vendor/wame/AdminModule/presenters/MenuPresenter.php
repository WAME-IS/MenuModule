<?php

namespace App\AdminModule\Presenters;

use Wame\ComponentModule\Forms\ComponentForm;
use Wame\ComponentModule\Entities\ComponentEntity;
use Wame\ComponentModule\Repositories\ComponentRepository;

class MenuPresenter extends \App\AdminModule\Presenters\BasePresenter
{	
	/** @var ComponentEntity */
	private $component;
	
	/** @var array */
	private $items = [];
	
	/** @var ComponentForm @inject */
	public $componentForm;

	/** @var ComponentRepository @inject */
	public $componentRepository;

	
	public function actionDefault()
	{
		if (!$this->user->isAllowed('admin.menu', 'view')) {
			$this->flashMessage(_('To enter this section you do not have have enough privileges.'), 'danger');
			$this->redirect('Admin:Dashboard:');
		}
		
		$this->component = $this->componentRepository->get(['id' => $this->id]);
		$this->items = $this->componentRepository->getComponents();
	}
	
	
	public function actionCreate()
	{
		if (!$this->user->isAllowed('admin.menu', 'create')) {
			$this->flashMessage(_('To enter this section you do not have have enough privileges.'), 'danger');
			$this->redirect('Admin:Dashboard:');
		}
	}
	
	
	public function actionUpdate()
	{
		if (!$this->user->isAllowed('admin.menu', 'update')) {
			$this->flashMessage(_('To enter this section you do not have have enough privileges.'), 'danger');
			$this->redirect('Admin:Dashboard:');
		}
	}
	

	protected function createComponentMenuForm()
	{
		$form = $this->componentForm
						->setType('MenuModule')
						->setId($this->id)
						->addFormContainer(new \Wame\MenuModule\Forms\ComponentFormContainer(), 'ComponentFormContainer', 0)
						->build();

		return $form;
	}
	
	
	public function renderDefault()
	{
		$this->template->siteTitle = $this->component->lang($this->lang)->title;
		$this->template->items = $this->items;
	}
	
	
	public function renderCreate()
	{
		$this->template->siteTitle = _('Create menu');
	}
	
	
	public function renderUpdate()
	{
		$this->template->siteTitle = _('Edit menu');
	}
	
}
