<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductZoneGeo extends Pivot
{
    use Auditable;

    protected $table = 'product_zone_geos';
}