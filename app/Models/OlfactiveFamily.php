<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OlfactiveFamily extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'olfactive_family_name',
        'olfactive_family_desc',
        'olfactive_family_active',
    ];

    protected $casts = [
        'olfactive_family_active' => 'boolean',
    ];

    /**
     * The products that belong to the olfactive family.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_olfactive_families')
                    ->withTimestamps();
    }
}