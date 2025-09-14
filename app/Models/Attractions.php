<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Attractions extends Model
{
    /** @use HasFactory<\Database\Factories\AttractionsFactory> */
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'area_id',
        'address',
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
    public function area()
    {
        return $this->belongsTo(Areas::class);
    }

    public function items()
    {
        return $this->belongsToMany(Items::class, 'item_attractions', 'attraction_id', 'item_id')
            ->withPivot(['distance', 'duration_on_foot', 'duration_by_car'])
            ->withTimestamps();
    }
}
