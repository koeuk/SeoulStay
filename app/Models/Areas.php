<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Areas extends Model
{
    /** @use HasFactory<\Database\Factories\AreasFactory> */
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid();
            }
        });
    }

    // Relationships
    public function items()
    {
        return $this->hasMany(Items::class);
    }

    public function attractions()
    {
        return $this->hasMany(Attractions::class);
    }
}
