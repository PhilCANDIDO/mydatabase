<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ZoneGeo extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'zone_geo_name',
        'zone_geo_desc',
        'zone_geo_active',
    ];

    protected $casts = [
        'zone_geo_active' => 'boolean',
    ];

    /**
     * The products that belong to the zone geo.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_zone_geos')
                    ->withTimestamps();
    }
}