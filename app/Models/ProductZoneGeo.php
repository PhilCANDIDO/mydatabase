<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductZoneGeo extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'zone_geo_value'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    
    public function getReferenceData()
    {
        return ReferenceData::where('type', 'zone_geo')
                           ->where('value', $this->zone_geo_value)
                           ->first();
    }
    
    public function getFormattedLabel()
    {
        $ref = $this->getReferenceData();
        return $ref ? $ref->label : $this->zone_geo_value;
    }
}