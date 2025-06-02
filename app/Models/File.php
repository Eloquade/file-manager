<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCreatorAndUpdater;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;



class File extends Model
{
    use HasFactory, NodeTrait, SoftDeletes, HasCreatorAndUpdater; 

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }   

    public function parent(): BelongsTo
    {
        return $this->belongsTo(File::class, 'parent_id');
    }

    public function owner(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                return $attributes['created_by'] == Auth::id() ? 'me' : $this->user->name;
            }
        ); 
    }

    public function isOwnedBy($userId): bool
    {
        return $this->created_by == $userId;
    }

    public function isRoot(): bool
    {
        return $this->parent_id == null;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
           if(!$model->parent){
                return;
           }
           $model->path = ($model->parent && $model->parent->path ? $model->parent->path . '/' : '') . Str::slug($model->name);

        });
    }
}
