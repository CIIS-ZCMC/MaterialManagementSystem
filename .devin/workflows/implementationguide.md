---
description: Simplified implementation guide with pattern levels based on complexity
---

# Laravel Implementation Guide - Simplified Patterns

Choose the pattern based on your feature's complexity. Don't over-engineer simple features.

## Pattern Levels

### Level 1: Simple CRUD (Controller → Model)
**Use for:** Basic CRUD operations with no complex business rules or external integrations.

**Files needed:**
- Controller (`app/Http/Controllers/`)
- Model (`app/Models/`)
- Routes (`routes/web.php` or `routes/api.php`)

**Example:**

```php
// Controller
class CategoryController extends Controller
{
    public function index()
    {
        return Category::paginate(15);
    }

    public function show($id)
    {
        return Category::findOrFail($id);
    }
}
```

---

### Level 2: Business Logic (Controller → Service → Model)
**Use for:** Features with business rules, multi-step operations, notifications, or calculations, but where data access doesn't require a repository abstraction.

**Files needed:**
- Controller (`app/Http/Controllers/`)
- Service (`app/Services/`)
- Model (`app/Models/`)
- Routes (`routes/web.php` or `routes/api.php`)

**Example:**

```php
// Service
class StockAdjustmentService extends BaseService
{
    public function adjustStock(int $itemId, int $quantity, string $reason): StockLog
    {
        return $this->transaction(function () use ($itemId, $quantity, $reason) {
            $item = Item::findOrFail($itemId);
            $item->increment('stock_on_hand', $quantity);

            return StockLog::create([
                'item_id' => $itemId,
                'quantity' => $quantity,
                'reason' => $reason,
            ]);
        });
    }
}

// Controller
class StockAdjustmentController extends Controller
{
    public function __construct(
        protected StockAdjustmentService $service
    ) {}

    public function store(StockAdjustmentRequest $request)
    {
        $log = $this->service->adjustStock(
            $request->integer('item_id'),
            $request->integer('quantity'),
            $request->string('reason')
        );

        return response()->json($log, 201);
    }
}
```

---

### Level 3: Complex Features (Controller → Service → Repository → Model)
**Use for:** Core domain features needing strict data layer abstraction, complex database queries, mocking/testing isolation, or multi-source integration (similar to DTRService repositories).

**Files needed:**
- Controller (`app/Http/Controllers/`)
- Service (`app/Services/`)
- Repository Interface (`app/Contracts/`)
- Repository Implementation (`app/Repositories/`)
- Model (`app/Models/`)
- Service Provider binding (`app/Providers/AppServiceProvider.php`)
- Form Request (`app/Http/Requests/`)
- Resource Transformer (`app/Http/Resources/`)
- Routes

**Example:**

```php
// 1. Interface: app/Contracts/MaterialRepositoryInterface.php
namespace App\Contracts;

interface MaterialRepositoryInterface extends BaseRepositoryInterface
{
    public function findByItemCode(string $code): ?Material;
}

// 2. Repository: app/Repositories/MaterialRepository.php
namespace App\Repositories;

use App\Contracts\MaterialRepositoryInterface;
use App\Models\Material;

class MaterialRepository extends BaseRepository implements MaterialRepositoryInterface
{
    public function __construct(Material $model)
    {
        parent::__construct($model);
    }

    public function findByItemCode(string $code): ?Material
    {
        return $this->model->newQuery()->where('item_code', $code)->first();
    }
}

// 3. Service: app/Services/MaterialService.php
namespace App\Services;

use App\Contracts\MaterialRepositoryInterface;

class MaterialService extends BaseService
{
    public function __construct(
        protected MaterialRepositoryInterface $repo
    ) {}

    public function registerMaterial(array $data)
    {
        return $this->transaction(function () use ($data) {
            return $this->repo->create($data);
        });
    }
}

// 4. Controller: app/Http/Controllers/MaterialController.php
namespace App\Http\Controllers;

use App\Http\Requests\StoreMaterialRequest;
use App\Http\Resources\MaterialResource;
use App\Services\MaterialService;

class MaterialController extends Controller
{
    public function __construct(
        protected MaterialService $service
    ) {}

    public function store(StoreMaterialRequest $request)
    {
        $material = $this->service->registerMaterial($request->validated());

        return new MaterialResource($material);
    }
}

// 5. Service Provider: app/Providers/AppServiceProvider.php
public function register(): void
{
    $this->app->bind(
        \App\Contracts\MaterialRepositoryInterface::class,
        \App\Repositories\MaterialRepository::class,
    );
}
```

---

## Quick Decision Guide

| Feature Complexity | Pattern | Layer Flow | When to Use |
|---|---|---|---|
| Simple CRUD / Reference Data | Level 1 | Controller → Model | Static lists, categories, lookup tables |
| Business Logic / Single Operations | Level 2 | Controller → Service → Model | Workflows, calculations, external APIs |
| Core Entities / Multi-table Logic | Level 3 | Controller → Service → Repository → Model | Requisitions, POs, Inventory, Users |

---

## Best Practices

1. **Start at the right level**: Don't over-engineer simple lookups into Level 3; use Level 1.
2. **Lean Controllers**: Controllers should only validate requests, invoke services, and return responses or Inertia views.
3. **Form Requests**: Always use Form Requests (`app/Http/Requests`) for validating input.
4. **Transactions**: Wrap multi-table database operations inside `$this->transaction(...)` in Services.
5. **Resources**: Return consistent JSON or Inertia payloads using API Resources (`app/Http/Resources`).
6. **Interface Bindings**: Always bind new repository interfaces in `AppServiceProvider::register()`.
