<?php

namespace App\Services;

use Closure;
use Illuminate\Support\Facades\DB;
use Throwable;

abstract class BaseService
{
    /**
     * Execute a callback within a database transaction.
     *
     * @template T
     *
     * @param  Closure(): T  $callback
     * @param  int<1, max>  $attempts
     * @return T
     *
     * @throws Throwable
     */
    protected function transaction(Closure $callback, int $attempts = 1): mixed
    {
        return DB::transaction($callback, $attempts);
    }
}
