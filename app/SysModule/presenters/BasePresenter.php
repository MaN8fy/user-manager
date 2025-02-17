<?php

namespace App\SysModule\Presenters;

use App\Model\UserModel;

/**
 * Description of BasePresenter
 *
 */
abstract class BasePresenter extends \App\GlobalPresenter
{
    /**
     * userModel
     *
     * @var UserModel
     */
    public UserModel $userModel;

    /**
     * BasePresenter constructor.
     *
     *
     * @return void
     */
    public function startup(): void
    {
        parent::startup();
        $this->userModel = $this->container->createService('userModel');
        $this->template->user = $this->user;
    }
}
