<?php

namespace AccessibleResources\Macros;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AccessibleResourceMacro
{
    public static function register()
    {
        Builder::macro('withAccessibleTo', function ($user, string $relation, string $resourceTypeKey, string $foreignKey = null) {
            $resourceType = Config::get("accessible-resources.resources.$resourceTypeKey");

            if (!$resourceType || !$user || $user->hasRole(Config::get("accessible-resources.admin_role", "admin"))) {
                return $this->with($relation);
            }

            $ids = method_exists($user, 'getCachedAccessibleResourceIds')
                ? $user->getCachedAccessibleResourceIds($resourceType)
                : [];

            if ($foreignKey) {
                return $this->whereIn($foreignKey, $ids)->with([$relation => function ($q) use ($ids) {
                    $q->whereIn('id', $ids);
                }]);
            }

            return $this->whereHas($relation, function ($q) use ($ids) {
                $q->whereIn('id', $ids);
            })->with([$relation => function ($q) use ($ids) {
                $q->whereIn('id', $ids);
            }]);
        });
    }
}
