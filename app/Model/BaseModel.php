<?php

declare(strict_types=1);

namespace App\Model;

/**
 * BaseModel
 *
 * @template T of object
 */
abstract class BaseModel
{
    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @var integer
     */
    protected int $id;

    /**
     * @var T
     */
    protected $repository;

    /* @param T $repository
     * @param array $data
     */
    public function __construct($repository, array $data = [])
    {
        $this->repository = $repository;
        $this->data = $data;
    }

    /**
     * Get
     *
     * @param string $name
     * @return void
     */
    public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }

    /**
      * Setter
      *
      * @param string $name
      * @param mixed  $value
      * @return void
      */
    public function __set(string $name, mixed $value): void
    {
        $this->data[$name] = $value;
    }


    /**
     * Initialize object
     *
     * @param integer $id
     * @return self|null //použít static od php 8.0 pro přesnější doporučení v IDE
     */
    public function initID(int $id): ?self //použít static od php 8.0 pro přesnější doporučení v IDE
    {
        $this->id = $id;
        $data = $this->repository->getById($id);
        $this->data = $data ? $data->toArray() : [];
        return $this->data ? $this : null;
    }

    /**
     * return model as array
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * Update
     *
     * @param array $data
     * @return void
     */
    public function update(array $data)
    {
        $this->repository->update($this->id, $data);
    }
}
