<?php

declare(strict_types=1);

namespace App\Model;

use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;

/**
 * User repository
 */
final class UserRepository extends BaseRepository
{
    /**
     * __construct
     *
     * @param Explorer $explorer
     */
    public function __construct(Explorer $explorer)
    {
        parent::__construct($explorer, 'user');
    }

    /**
     * Get user by unique username
     *
     * @param string $username
     * @return ActiveRow|null
     */
    public function getByUsername(string $username): ?ActiveRow
    {
        return $this->table
            ->where('username', $username)
            ->fetch();
    }

    /**
     * Get user by unique email
     *
     * @param string $email
     * @return ActiveRow|null
     */
    public function getByEmail(string $email): ?ActiveRow
    {
        return $this->table
            ->where('email', $email)
            ->fetch();
    }
}
