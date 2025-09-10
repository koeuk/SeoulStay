<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Items extends Model
{
    /** @use HasFactory<\Database\Factories\ItemsFactory> */
    use HasFactory;

    protected $fillable = [
        'uuid',
                'user_id',
        'item_type_id',
        'area_id',
        'title',
        'capacity',
        'number_of_beds',
        'number_of_bedrooms',
        'number_of_bathrooms',
        'exact_address',
        'approximate_address',
        'description',
        'attributes',
        'minimum_nights',
        'maximum_nights'
    ];

      protected $casts = [
        'attributes' => 'array',
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }

    public function area()
    {
        return $this->belongsTo(Areas::class);
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenities::class, 'item_amenities');
    }

    public function attractions()
    {
        return $this->belongsToMany(Attractions::class, 'item_attractions')
                    ->withPivot(['distance', 'duration_on_foot', 'duration_by_car'])
                    ->withTimestamps();
    }
}
