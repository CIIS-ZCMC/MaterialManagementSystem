<?php

namespace App\Repositories;

use App\Contracts\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @template TModel of Model
 *
 * @implements BaseRepositoryInterface<TModel>
 */
abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var TModel
     */
    protected Model $model;

    /**
     * @param  TModel  $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get the underlying Eloquent model instance.
     *
     * @return TModel
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Retrieve all records.
     *
     * @param  array<int, string>  $columns
     * @return Collection<int, TModel>
     */
    public function all(array $columns = ['*']): Collection
    {
        /** @var Collection<int, TModel> */
        return $this->model->all($columns);
    }

    /**
     * Retrieve paginated records.
     *
     * @param  array<int, string>  $columns
     * @return LengthAwarePaginator<int, TModel>
     */
    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        /** @var LengthAwarePaginator<int, TModel> */
        return $this->model->newQuery()->paginate($perPage, $columns);
    }

    /**
     * Find a record by its primary key.
     *
     * @param  array<int, string>  $columns
     * @return TModel|null
     */
    public function findById(int|string $id, array $columns = ['*']): ?Model
    {
        /** @var TModel|null */
        return $this->model->newQuery()->find($id, $columns);
    }

    /**
     * Find a record by its primary key or throw an exception.
     *
     * @param  array<int, string>  $columns
     * @return TModel
     *
     * @throws ModelNotFoundException
     */
    public function findOrFail(int|string $id, array $columns = ['*']): Model
    {
        /** @var TModel */
        return $this->model->newQuery()->findOrFail($id, $columns);
    }

    /**
     * Create a new record.
     *
     * @param  array<string, mixed>  $attributes
     * @return TModel
     */
    public function create(array $attributes): Model
    {
        /** @var TModel */
        return $this->model->newQuery()->create($attributes);
    }

    /**
     * Update a record by its primary key.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function update(int|string $id, array $attributes): bool
    {
        $record = $this->findById($id);

        return $record ? $record->update($attributes) : false;
    }

    /**
     * Delete a record by its primary key.
     */
    public function delete(int|string $id): bool
    {
        $record = $this->findById($id);

        return $record ? (bool) $record->delete() : false;
    }
}
