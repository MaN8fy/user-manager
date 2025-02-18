<?php

namespace App\Security;

use Nette\Security\Permission;

class Authorizator extends Permission
{
    public function __construct()
    {
        $this->addRole(\App\Model\UserModel::$roles["read"]);
        $this->addRole(\App\Model\UserModel::$roles["write"], \App\Model\UserModel::$roles["read"]);
        $this->addRole(\App\Model\UserModel::$roles["delete"], \App\Model\UserModel::$roles["write"]);

        $this->addResource('edit');
        $this->addResource(\App\Model\UserModel::$roles["delete"]);

        $this->allow(\App\Model\UserModel::$roles["write"], 'edit');
        $this->allow(\App\Model\UserModel::$roles["delete"], \App\Model\UserModel::$roles["delete"]);
    }
}
