<?php

namespace App\Bundles\CacheBundle;

class CacheBuilder
{
    /**
     * Cache builder
     *
     * @param $modelName
     * @param $fileName
     *
     * @return Model
     */
    public static function build($modelName, $fileName): Model
    {
        return new Model($modelName, $fileName);
    }
}
