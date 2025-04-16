<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductOlfactiveFamily extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'famille_value'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    
    public function getReferenceData()
    {
        return ReferenceData::where('type', 'famille_olfactive')
                           ->where('value', $this->famille_value)
                           ->first();
    }
    
    public function getFormattedLabel()
    {
        $ref = $this->getReferenceData();
        return $ref ? $ref->label : $this->famille_value;
    }
}