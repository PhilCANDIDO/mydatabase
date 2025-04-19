<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'application_name',
        'application_desc',
        'application_active',
    ];

    protected $casts = [
        'application_active' => 'boolean',
    ];

    /**
     * Get the products for the application.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}