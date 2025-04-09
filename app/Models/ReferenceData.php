<?php

namespace App\Models;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferenceData extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'type',
        'value',
        'label',
        'description',
        'order',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    // Récupérer toutes les valeurs d'un type spécifique
    public static function getByType(string $type, bool $onlyActive = true)
    {
        $query = self::where('type', $type)
                    ->orderBy('order')
                    ->orderBy('label');
        
        if ($onlyActive) {
            $query->where('active', true);
        }
        
        return $query->get();
    }
    
    // Récupérer comme un tableau associatif (value => label)
    public static function getOptionsArray(string $type, bool $onlyActive = true)
    {
        return self::getByType($type, $onlyActive)
                  ->pluck('label', 'value')
                  ->toArray();
    }
}
