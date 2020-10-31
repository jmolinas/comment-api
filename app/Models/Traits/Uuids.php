<?php

namespace App\Models\Traits;

use Webpatser\Uuid\Uuid;

trait Uuids
{
    /**
     * Boot function from laravel.
     */
    protected static function bootUuids()
    {
        static::creating(
            function ($model) {
                $model->{$model->getKeyName()} = Uuid::generate()->string;
            }
        );
    }
}
