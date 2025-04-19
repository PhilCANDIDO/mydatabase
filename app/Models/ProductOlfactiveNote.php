<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductOlfactiveNote extends Pivot
{
    use Auditable;

    protected $table = 'product_olfactive_notes';

    protected $fillable = [
        'product_id',
        'olfactive_note_id',
        'olfactive_note_position',
        'olfactive_note_order',
    ];
}