<?php

namespace App\Security;

use Nette\Security\Authenticator;
use App\Model\UserModel;
use Nette\Security\SimpleIdentity;

/**
 * User authenticator
 */
class UserAuthenticator implements Authenticator
{
    /**
     * @var UserModel
     */
    private UserModel $userModel;

    /**
     * __contruct
     *
     * @param UserModel $userModel
     */
    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * Authenticate
     *
     * @param string $username
     * @param string $password
     * @return SimpleIdentity
     */
    public function authenticate(string $username, string $password): SimpleIdentity
    {
        return $this->userModel->loginUser($username, $password);
    }
}
