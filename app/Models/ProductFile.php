<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductFile extends Pivot
{
    use Auditable;

    protected $table = 'product_files';
}