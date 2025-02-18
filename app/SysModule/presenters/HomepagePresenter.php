<?php

namespace App\SysModule\Presenters;

use Tracy\Debugger;
use Tracy\ILogger;
use Ublaboo\DataGrid\DataGrid;

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{
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
            ->setRenderCondition(fn($row) => $this->getUser()->isAllowed('edit', $row->role));
        $grid->addAction('delete', '', 'delete!')
            ->setTitle('Delete')
            ->setIcon('trash')
            ->setClass('btn btn-sm btn-danger')
            ->setRenderCondition(fn($row) => $this->getUser()->isAllowed('delete', $row->role) && $this->getUser()->id !== $row->id);

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
    }

    /**
     * delete (deactivate) user
     *
     * @param integer $id
     * @return void
     */
    public function handleDelete(int $id): void
    {
        try {
            $userToDeactivate = $this->userModel->initID($id);
            $isAllowed = $this->getUser()->isAllowed('delete', $userToDeactivate->role) && $this->getUser()->id !== $id;
            if ($isAllowed) {
                $userToDeactivate->deactivate();
            }
        } catch (\Exception $e) {
            Debugger::log($e, ILogger::ERROR);
            $this->flashMessage("Something went wrong.", "error");
            $this->redirect("default");
        }
        $this->redirect("default");
    }
}
