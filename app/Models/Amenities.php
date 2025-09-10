<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Amenities extends Model
{
    /** @use HasFactory<\Database\Factories\AmenitiesFactory> */
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'icon_name',
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
        return $this->belongsToMany(Items::class, 'item_amenities');
    }
}
