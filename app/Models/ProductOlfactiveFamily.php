<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductOlfactiveFamily extends Pivot
{
    use Auditable;

    protected $table = 'product_olfactive_families';
}