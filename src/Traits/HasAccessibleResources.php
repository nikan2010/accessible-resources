<?php

namespace AccessibleResources\Traits;

use Illuminate\Support\Facades\Cache;

trait HasAccessibleResources
{
    public function accessibleResources(string $type)
    {
        return $this->morphedByMany($type, 'resource', 'resource_user');
    }

    public function getCachedAccessibleResourceIds(string $type): array
    {
        $key = "user:{$this->id}:resources:" . md5($type);

        return Cache::remember($key, now()->addDay(), function () use ($type) {
            return $this->accessibleResources($type)->select($type::getTable() . '.id')->pluck('id')->toArray();
        });
    }

    public function clearCachedAccessibleResourceIds(string $type)
    {
        $key = "user:{$this->id}:resources:" . md5($type);
        Cache::forget($key);
    }
}
