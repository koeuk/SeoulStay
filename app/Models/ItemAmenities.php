<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ItemAmenities extends Model
{
    /** @use HasFactory<\Database\Factories\ItemAmenitiesFactory> */
    use HasFactory;

    protected $fillable = [
        'uuid',
        'item_id',
        'amenity_id',
        'kk',
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
    public function item()
    {
        return $this->belongsTo(Items::class);
    }

    public function amenity()
    {
        return $this->belongsTo(Amenities::class);
    }
}
