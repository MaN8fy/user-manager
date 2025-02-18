<?php

namespace App\SysModule\Presenters;

use App\Components\Factories\CustomForm;
use App\Model\UserModel;
use Exception;
use Nette\Application\UI\Form;
use Tracy\Debugger;
use Tracy\ILogger;
use Ublaboo\DataGrid\DataGrid;

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{
     /**
     *
     * @var UserModel|null
     */
    private ?UserModel $userToEdit = null;

    /**
     * startup
     *
     * @return void
     */
    public function startup(): void
    {
        parent::startup();
    }

    /**
     * beforeRender
     *
     * @return void
     */
    public function beforeRender(): void
    {
        parent::beforeRender();
        if (!$this->user->isLoggedIn()) {
            $this->redirect(":Public:Sign:in");
        }
    }

    protected function createComponentUserGrid(): DataGrid
    {
        $grid = new DataGrid();

        $grid->setDataSource($this->userModel->getUserList());

        $grid->addColumnText('id', 'ID')->setSortable();
        $grid->addColumnText('firstname', 'First name')->setSortable();
        $grid->addColumnText('lastname', 'Last name')->setSortable();
        $grid->addColumnText('username', 'Username')->setSortable();
        $grid->addColumnText('email', 'Email')->setSortable();
        $grid->addColumnText('role', 'Role')->setSortable();

        $grid->addAction('edit', '', 'edit')
            ->setTitle('Edit')
            ->setIcon('pen-to-square')
            ->setClass('btn btn-sm btn-primary')
            ->setRenderCondition(fn($row) => $this->user->id === $row->id || $this->user->isAllowed('edit', $row->role));

        $grid->addAction('deactivate', '', 'deactivate!')
            ->setTitle('Deactivate')
            ->setIcon('ban')
            ->setClass('btn btn-sm btn-danger')
            ->setRenderCondition(fn($row) => !$row->deactivated && $this->user->isAllowed('delete', $row->role) && $this->user->id !== $row->id);

        $grid->addAction('activate', '', 'activate!')
            ->setTitle('Activate')
            ->setIcon('star')
            ->setClass('btn btn-sm btn-warning')
            ->setRenderCondition(fn($row) => $row->deactivated && $this->user->isAllowed('delete', $row->role) && $this->user->id !== $row->id);

        $grid->setPagination(true);

        return $grid;
    }

    /**
     * renderDefault
     *
     * @return void
     */
    public function renderDefault(): void
    {
    }

    /**
     * renderEdit
     *
     * @param int User ID
     * @return void
     */
    public function renderEdit(int $id = null): void
    {
        if (!$id) {
            $this->flashMessage("Missing user ID", "warning");
            $this->redirect("default");
        }

        $this->userToEdit = $this->userModel->initID($id);
        if (!$this->userToEdit) {
            $this->flashMessage("Invalid user ID", "warning");
            $this->redirect("default");
        }

        $isAllowed = $this->user->isAllowed('edit', $this->userToEdit->role) || $this->user->id === $id;
        if (!$isAllowed) {
            $this->flashMessage("You are not allowed to do that", "warning");
            $this->redirect("default");
        }
    }

    /**
     * edit form
     *
     * @return Form
     */
    protected function createComponentEditForm(): Form
    {
        $id = $this->getParameter('id') ?? null;
        $this->userToEdit = $this->userModel->initID($id);

        if (!$this->userToEdit) {
            throw new Exception("Invalid user");
        }

        $form = new CustomForm();
        $form->addHidden('id');

        $form->addText('firstname', 'First name:')
            ->setRequired('Please enter firstname.');

        $form->addText('lastname', 'Last name:')
            ->setRequired('Please enter lastname.');

        $form->addText('email', 'Email:')
            ->setRequired('Please enter email.')
            ->addRule(Form::EMAIL, 'Please enter a valid email address.');

        $form->addText('username', 'Username:')
            ->setRequired('Please enter username.');

        if ($this->user->isAllowed('delete', $this->userToEdit->role) && $this->user->id !== $this->userToEdit->id) {
            $form->addRadioList('role', 'Role:', UserModel::$roles);
        }

        $form->addSubmit('save', 'Save');

        if ($this->userToEdit !== null) {
            $form->setDefaults($this->userToEdit->toArray());
        }

        $form->onSuccess[] = [$this, 'editFormSucceeded'];
        return $form;
    }

    /**
     * editFormSucceeded
     *
     * @param  Form  $form
     * @param  array $values
     * @return void
     */
    public function editFormSucceeded(Form $form, array $values): void
    {
        try {
            $this->userToEdit = $this->userModel->initID($values['id']);
            if ($this->userToEdit !== null) {
                $this->userToEdit->update($values);
            }
        } catch (\Nette\Database\UniqueConstraintViolationException $e) {
            $this->flashMessage('Username or email is already taken.', 'danger');
            $this->redirect('this');
        } catch (\Exception $e) {
            Debugger::log($e, \Tracy\ILogger::ERROR);

            $this->flashMessage('Something went wrong. Try again later.', 'danger');
            $this->redirect('this');
        }
        $this->redirect(':Sys:Homepage:default');
    }

    /**
     * Deactivate user
     *
     * @param integer $id
     * @return void
     */
    public function handleDeactivate(int $id): void
    {
        try {
            $userToDeactivate = $this->userModel->initID($id);
            if (!$userToDeactivate) {
                $this->flashMessage("Invalid user ID", "warning");
                $this->redirect("default");
            }

            $isAllowed = $this->user->isAllowed('delete', $userToDeactivate->role) && $this->user->id !== $id;
            if ($isAllowed) {
                $userToDeactivate->deactivate();
            } else {
                $this->flashMessage("You are not allowed to do that", "warning");
            }
        } catch (\Exception $e) {
            Debugger::log($e, ILogger::ERROR);
            $this->flashMessage("Something went wrong.", "danger");
            $this->redirect("default");
        }
        $this->redirect("default");
    }

    /**
     * Activate user
     *
     * @param integer $id
     * @return void
     */
    public function handleActivate(int $id): void
    {
        try {
            $userToActivate = $this->userModel->initID($id);
            if (!$userToDeactivate) {
                $this->flashMessage("Invalid user ID", "warning");
                $this->redirect("default");
            }

            $isAllowed = $this->user->isAllowed('delete', $userToActivate->role) && $this->user->id !== $id;
            if ($isAllowed) {
                $userToActivate->activate();
            } else {
                $this->flashMessage("You are not allowed to do that", "warning");
            }
        } catch (\Exception $e) {
            Debugger::log($e, ILogger::ERROR);
            $this->flashMessage("Something went wrong.", "danger");
            $this->redirect("default");
        }
        $this->redirect("default");
    }
}
