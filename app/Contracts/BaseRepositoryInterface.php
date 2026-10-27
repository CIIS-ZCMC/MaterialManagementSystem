<?php

namespace App\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @template TModel of Model
 */
interface BaseRepositoryInterface
{
    /**
     * Retrieve all records.
     *
     * @param  array<int, string>  $columns
     * @return Collection<int, TModel>
     */
    public function all(array $columns = ['*']): Collection;

    /**
     * Retrieve paginated records.
     *
     * @param  array<int, string>  $columns
     * @return LengthAwarePaginator<int, TModel>
     */
    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    /**
     * Find a record by its primary key.
     *
     * @param  array<int, string>  $columns
     * @return TModel|null
     */
    public function findById(int|string $id, array $columns = ['*']): ?Model;

    /**
     * Find a record by its primary key or throw an exception.
     *
     * @param  array<int, string>  $columns
     * @return TModel
     *
     * @throws ModelNotFoundException
     */
    public function findOrFail(int|string $id, array $columns = ['*']): Model;

    /**
     * Create a new record.
     *
     * @param  array<string, mixed>  $attributes
     * @return TModel
     */
    public function create(array $attributes): Model;

    /**
     * Update a record by its primary key.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function update(int|string $id, array $attributes): bool;

    /**
     * Delete a record by its primary key.
     */
    public function delete(int|string $id): bool;
}
