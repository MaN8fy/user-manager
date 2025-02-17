<?php

namespace App\SysModule\Presenters;

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

    /**
     * renderDefault
     *
     * @return void
     */
    public function renderDefault(): void
    {
    }

    /**
     * renderDetail
     *
     * @param int User ID
     * @return void
     */
    public function renderDetail(int $userId = null): void
    {
        if (!$userId) {
            $this->flashMessage("Missing user ID", "warning");
            $this->redirect("default");
        }
    }
}
