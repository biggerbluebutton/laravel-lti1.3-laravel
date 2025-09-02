<?php

namespace xcesaralejandro\lti1p3\Traits;

trait CastModelOnSave
{
    // use the boot-with-trait naming convention
    public static function bootCastModelOnSave(): void
    {
        static::saving(function ($model) {
            foreach ($model->getCasts() as $key => $type) {
                // cast anything that is present in $attributes
                if (array_key_exists($key, $model->attributes)) {
                    $model->attributes[$key] =
                        $model->castAttribute($key, $model->attributes[$key]);
                }
            }
        });
    }
}

