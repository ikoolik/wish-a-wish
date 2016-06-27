<?php
namespace Wish\Traits;

/**
 * Sets unique `slug` property to the model during creation.
 *
 * @package Wish\Traits
 */
trait HasSlug
{

    public static function bootHasSlug()
    {
        static::creating(function ($model) {
            $initialSlug = $slug = str_random();

            $i = 1;
            while (static::where('slug', $slug)->withTrashed()->count()) {
                $slug = "{$initialSlug}-{$i}";
                $i++;
            }
            $model->slug = $slug;
        });
    }

}