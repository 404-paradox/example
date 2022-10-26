<?php

namespace App\Bundles\CacheBundle;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

use function MongoDB\BSON\toJSON;

trait Cacheable
{
    /**
     * get
     */
    public static function cacheAll(...$parameters): array
    {
        $model = CacheBuilder::build(self::modelName(), 'all');

        if (!$model->hasCache()) {
            log::info('no cache go tosave');
            $model->saveCache(self::all()->toJSON());
        }

        return $model->getCache();
    }

    /**
     * Model name
     *
     * @return string
     */
    private static function modelName(): string
    {
        $ModelPathParts = explode('\\', self::class);

        return strtolower(array_pop($ModelPathParts));
    }
}
