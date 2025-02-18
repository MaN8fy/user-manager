<?php

declare(strict_types=1);

namespace App\Model;

use Nette\Security\Passwords;
use Nette\Database\Table\ActiveRow;
use Nette\Security\SimpleIdentity;

/**
 * UserModel
 *
 * @extends BaseModel<UserRepository>
 */
final class UserModel extends BaseModel
{
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
    public static array $roles = [
        'read' => 'read',
        'write' => 'write',
        'delete' => 'delete',
    ];

    /**
     * __construct
     *
     * @param UserRepository  $repository
     * @param LoginRepository $loginRepository
     * @param  Passwords       $passwords
     * @return void
     */
    public function __construct(UserRepository $userRepository, LoginRepository $loginRepository, Passwords $passwords)
    {
        parent::__construct($userRepository);
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

        return $this->repository->insert([
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
        if ($this->authenticateUser($username, $password)) {
            $user = $this->repository->getByUsername($username);
            if ($user->deactivated) {
                throw new \Nette\Security\AuthenticationException('Your account has been suspended.');
            }
            $user = new SimpleIdentity(
                $user->id,
                $user->role,
                ['firstname' => $user->firstname, 'lastname' => $user->lastname, 'username' => $user->username, 'email' => $user->email]
            );
        } else {
            throw new \Nette\Security\AuthenticationException('Invalid credentials.');
        }

        $this->logLogin($user->getId());
        return $user;
    }

    /**
     * authenticateUser
     *
     * @param  string $username
     * @param  string $password
     * @return boolean
     */
    public function authenticateUser(string $username, string $password): bool
    {
        $user = $this->repository->getByUsername($username);

        if (!$user || !$this->passwords->verify($password, $user->password)) {
            return false;
        }

        return true;
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
     * @param integer|null $page
     * @param integer|null $itemsPerPage
     * @param string       $order
     * @param string       $direction
     * @return array
     */
    public function getUserList(?int $page = null, ?int $itemsPerPage = null, string $order = 'id', string $direction = 'ASC'): array
    {
        if ($itemsPerPage !== null && $page !== null) {
            $offset = ($page - 1) * $itemsPerPage;
        } else {
            $offset = null;
        }
        return $this->repository->getAll($order, $direction, $itemsPerPage, $offset);
    }

    /**
     * Deactivate user
     *
     * @return void
     */
    public function deactivate(): void
    {
        $this->repository->deactivate($this->id);
    }

    /**
     * Activate user
     *
     * @return void
     */
    public function activate(): void
    {
        $this->repository->activate($this->id);
    }
}
