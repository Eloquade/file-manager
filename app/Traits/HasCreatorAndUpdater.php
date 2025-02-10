<?php

namespace App\Traits;


trait HasCreatorAndUpdater
{
    public static function bootHasCreatorAndUpdater()
    {
        static::creating(function ($model) {
            $model->created_by = Auth::id();
            $model->updated_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }

    // public function creator()
    // {
    //     return $this->belongsTo(User::class, 'created_by');
    // }

    // public function updater()
    // {
    //     return $this->belongsTo(User::class, 'updated_by');
    // }
}