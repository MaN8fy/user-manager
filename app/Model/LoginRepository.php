<?php

declare(strict_types=1);

namespace App\Model;

use Nette\Database\Explorer;

/**
 * Login repository
 */
final class LoginRepository extends BaseRepository
{
    /**
     * __construct
     *
     * @param Explorer $explorer
     */
    public function __construct(Explorer $explorer)
    {
        parent::__construct($explorer, 'login');
    }
}
