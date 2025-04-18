<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'application_value'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    
    public function getReferenceData()
    {
        return ReferenceData::where('type', 'application')
                           ->where('value', $this->application_value)
                           ->first();
    }
    
    public function getFormattedLabel()
    {
        $ref = $this->getReferenceData();
        return $ref ? $ref->label : $this->application_value;
    }
}