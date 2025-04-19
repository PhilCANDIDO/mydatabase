<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory, SoftDeletes, Auditable;

    protected $fillable = [
        'product_type',
        'product_family_id',
        'product_name',
        'product_marque',
        'product_annee_sortie',
        'product_unisex',
        'product_avatar',
        'application_id',
        'product_genre',
    ];

    protected $casts = [
        'product_annee_sortie' => 'integer',
        'product_unisex' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the product family that owns the product.
     */
    public function productFamily(): BelongsTo
    {
        return $this->belongsTo(ProductFamily::class);
    }

    /**
     * Get the application associated with the product.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * The zone geos that belong to the product.
     */
    public function zoneGeos(): BelongsToMany
    {
        return $this->belongsToMany(ZoneGeo::class, 'product_zone_geos')
                    ->using(ProductZoneGeo::class)
                    ->withTimestamps();
    }

    /**
     * The olfactive families that belong to the product.
     */
    public function olfactiveFamilies(): BelongsToMany
    {
        return $this->belongsToMany(OlfactiveFamily::class, 'product_olfactive_families')
                    ->using(ProductOlfactiveFamily::class)
                    ->withTimestamps();
    }

    /**
     * The olfactive notes that belong to the product.
     */
    public function olfactiveNotes(): BelongsToMany
    {
        return $this->belongsToMany(OlfactiveNote::class, 'product_olfactive_notes')
                    ->using(ProductOlfactiveNote::class)
                    ->withPivot('olfactive_note_position', 'olfactive_note_order')
                    ->withTimestamps();
    }

    /**
     * The files that belong to the product.
     */
    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class, 'product_files')
                    ->using(ProductFile::class)
                    ->withTimestamps();
    }
}