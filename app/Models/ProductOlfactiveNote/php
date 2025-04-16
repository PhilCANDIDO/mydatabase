<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductOlfactiveNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'position',
        'order',
        'description_value'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    
    public function getReferenceData()
    {
        return ReferenceData::where('type', 'description_olfactive')
                           ->where('value', $this->description_value)
                           ->first();
    }
    
    public function getFormattedLabel()
    {
        $ref = $this->getReferenceData();
        return $ref ? $ref->label : $this->description_value;
    }
}