<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OlfactiveNote extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'olfactive_note_name',
        'olfactive_note_desc',
        'olfactive_note_active',
    ];

    protected $casts = [
        'olfactive_note_active' => 'boolean',
    ];

    /**
     * The products that belong to the olfactive note.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_olfactive_notes')
                    ->withPivot('olfactive_note_position', 'olfactive_note_order')
                    ->withTimestamps();
    }
}