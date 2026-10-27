<?php

use App\Contracts\UserRepositoryInterface;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

uses(RefreshDatabase::class);

test('user repository interface is bound to user repository implementation in container', function () {
    $repository = app(UserRepositoryInterface::class);

    expect($repository)->toBeInstanceOf(UserRepository::class);
});

test('user repository can perform basic CRUD operations', function () {
    $repository = app(UserRepositoryInterface::class);

    $user = $repository->create([
        'name' => 'Architecture User',
        'email' => 'arch@example.com',
        'password' => 'secret123',
    ]);

    expect($user)->toBeInstanceOf(User::class);
    expect($repository->findById($user->id))->not->toBeNull();
    expect($repository->findByEmail('arch@example.com')?->id)->toBe($user->id);

    $updated = $repository->update($user->id, ['name' => 'Updated User']);
    expect($updated)->toBeTrue();
    expect($repository->findById($user->id)?->name)->toBe('Updated User');

    $deleted = $repository->delete($user->id);
    expect($deleted)->toBeTrue();
    expect($repository->findById($user->id))->toBeNull();
});

test('user service orchestrates user creation and updates with hashing', function () {
    $service = app(UserService::class);

    $user = $service->createUser([
        'name' => 'Service User',
        'email' => 'service@example.com',
        'password' => 'plaintextpassword',
    ]);

    expect($user->id)->toBeGreaterThan(0);
    expect($user->password)->not->toBe('plaintextpassword');
    expect(password_verify('plaintextpassword', $user->password))->toBeTrue();

    $service->updateUser($user->id, ['name' => 'Updated Service User']);
    expect($service->getUserById($user->id)?->name)->toBe('Updated Service User');

    $all = $service->getAllUsers();
    expect($all)->toHaveCount(1);

    $paginated = $service->getPaginatedUsers(10);
    expect($paginated->total())->toBe(1);

    $deleted = $service->deleteUser($user->id);
    expect($deleted)->toBeTrue();
    expect($service->getUserById($user->id))->toBeNull();
});

test('user resource formats attributes correctly', function () {
    $user = User::factory()->create([
        'name' => 'Resource User',
        'email' => 'resource@example.com',
    ]);

    $resource = (new UserResource($user))->toArray(Request::create('/'));

    expect($resource)->toHaveKeys(['id', 'name', 'email', 'created_at', 'updated_at']);
    expect($resource['name'])->toBe('Resource User');
    expect($resource['email'])->toBe('resource@example.com');
});
