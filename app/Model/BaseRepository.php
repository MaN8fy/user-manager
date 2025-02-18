<?php

declare(strict_types=1);

namespace App\Model;

use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

/**
 * Default repository scheme
 *
 */
abstract class BaseRepository
{
    /**
     * @var Explorer
     */
    protected Explorer $database;

    /**
     * @var Selection
     */
    protected Selection $table;

    /**
     * BaseRepository constructor.
     *
     * @param Explorer $database
     * @param string   $table
     */
    public function __construct(Explorer $database, string $table)
    {
        $this->database = $database;
        $this->table = $this->database->table($table);
    }

    /**
     * Get row by id
     *
     * @param integer $id
     * @return ActiveRow|null
     */
    public function getById(int $id): ?ActiveRow
    {
        return $this->table->get($id);
    }

    /**
     * Get all rows
     *
     * @param string  $order
     * @param string  $direction
     * @param integer $limit
     * @param integer $offset
     * @return ActiveRow[]
     */
    public function getAll(string $order = 'id', string $direction = 'ASC', int $limit = null, int $offset = null): array
    {
        return $this->table->order($order . ' ' . $direction)->limit($limit, $offset)->fetchAll();
    }


    /**
     * Insert row
     *
     * @param array $data
     * @return ActiveRow
     */
    public function insert(array $data): ActiveRow
    {
        return $this->table->insert($data);
    }

    /**
     * Update row
     *
     * @param integer $id
     * @param array   $data
     * @return void
     */
    public function update(int $id, array $data): void
    {
        $this->table->wherePrimary($id)->update($data);
    }

    /**
     * Delete row
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->table->wherePrimary($id)->delete();
    }
}
