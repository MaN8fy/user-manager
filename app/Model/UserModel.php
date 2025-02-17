<?php

declare(strict_types=1);

namespace App\Model;

use Nette\Security\Passwords;
use Nette\Database\Table\ActiveRow;
use Nette\Security\SimpleIdentity;

/**
 * UserModel
 */
class UserModel
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @var LoginRepository
     */
    private LoginRepository $loginRepository;

    /**
     * @var Passwords
     */
    private Passwords $passwords;

    /**
     * @var array
     */
    public static $roles = [
        'read' => 'read',
        'write' => 'write',
        'delete' => 'delete',
    ];

    /**
     * __construct
     *
     * @param  UserRepository  $userRepository
     * @param LoginRepository $loginRepository
     * @param  Passwords       $passwords
     * @return void
     */
    public function __construct(UserRepository $userRepository, LoginRepository $loginRepository, Passwords $passwords)
    {
        $this->userRepository = $userRepository;
        $this->loginRepository = $loginRepository;
        $this->passwords = $passwords;
    }

    /**
     * registerUser
     *
     * @param  array $data
     * @return ActiveRow
     */
    public function registerUser(array $data): ActiveRow
    {
        $role = $data['role'] ?? self::$roles["read"];

        return $this->userRepository->insert([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $this->passwords->hash($data['password']),
            'role' => $role,
        ]);
    }

    /**
     * Login user
     *
     * @param string $username
     * @param string $password
     * @return SimpleIdentity
     */
    public function loginUser(string $username, string $password): SimpleIdentity
    {
        $user = $this->authenticateUser($username, $password);
        $this->logLogin($user->getId());

        return $user;
    }

    /**
     * authenticateUser
     *
     * @param  string $username
     * @param  string $password
     * @return SimpleIdentity
     */
    private function authenticateUser(string $username, string $password): SimpleIdentity
    {
        $user = $this->userRepository->getByUsername($username);

        if (!$user || !$this->passwords->verify($password, $user->password)) {
            throw new \Nette\Security\AuthenticationException('Invalid credentials.');
        }

        return new SimpleIdentity(
            $user->id,
            $user->role,
            ['firstname' => $user->firstname, 'lastname' => $user->lastname, 'username' => $user->username, 'email' => $user->email]
        );
    }

    /**
     * Log user's login
     *
     * @param integer $userId
     * @return void
     */
    private function logLogin(int $userId): void
    {
        $this->loginRepository->insert([
        'user_id' => $userId,
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'login_time' => new \DateTime(),
        ]);
    }

    /**
     * getUserList
     *
     * @return array
     */
    public function getUserList(): array
    {
        return $this->userRepository->getAll();
    }
}
