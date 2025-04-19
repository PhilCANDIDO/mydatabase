<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class File extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'file_desc',
    ];

    /**
     * The products that belong to the file.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_files')
                    ->withTimestamps();
    }
}