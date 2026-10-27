<?php

namespace App\Services;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserService extends BaseService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    /**
     * Retrieve all users.
     *
     * @return Collection<int, User>
     */
    public function getAllUsers(): Collection
    {
        return $this->userRepository->all();
    }

    /**
     * Retrieve paginated users.
     *
     * @return LengthAwarePaginator<int, User>
     */
    public function getPaginatedUsers(int $perPage = 15): LengthAwarePaginator
    {
        return $this->userRepository->paginate($perPage);
    }

    /**
     * Find a user by ID.
     */
    public function getUserById(int|string $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    /**
     * Find a user by email.
     */
    public function getUserByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }

    /**
     * Create a new user with hashed password.
     *
     * @param  array{name: string, email: string, password: string}  $data
     *
     * @throws Throwable
     */
    public function createUser(array $data): User
    {
        return $this->transaction(function () use ($data) {
            $data['password'] = Hash::make($data['password']);

            return $this->userRepository->create($data);
        });
    }

    /**
     * Update an existing user.
     *
     * @param  array{name?: string, email?: string, password?: string}  $data
     *
     * @throws Throwable
     */
    public function updateUser(int|string $id, array $data): bool
    {
        return $this->transaction(function () use ($id, $data) {
            if (isset($data['password']) && ! empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            return $this->userRepository->update($id, $data);
        });
    }

    /**
     * Delete a user by ID.
     *
     * @throws Throwable
     */
    public function deleteUser(int|string $id): bool
    {
        return $this->transaction(function () use ($id) {
            return $this->userRepository->delete($id);
        });
    }
}
