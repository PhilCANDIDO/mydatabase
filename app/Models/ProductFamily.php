<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductFamily extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'product_family_code',
        'product_family_name',
        'product_family_desc',
        'product_family_active',
    ];

    protected $casts = [
        'product_family_active' => 'boolean',
    ];

    /**
     * Get the products for the product family.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}