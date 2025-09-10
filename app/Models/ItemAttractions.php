<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ItemAttractions extends Model
{
    /** @use HasFactory<\Database\Factories\ItemAttractionsFactory> */
    use HasFactory;

    protected $fillable = [
        'uuid',
        'item_id',
        'attraction_id',
        'distance',
        'duration_on_foot',
        'duration_by_car'
    ];

    protected $casts = [
        'distance' => 'decimal:2',
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

    public function attraction()
    {
        return $this->belongsTo(Attractions::class);
    }
}
