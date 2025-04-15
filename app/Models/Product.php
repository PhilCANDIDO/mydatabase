<?php

namespace App\Models;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, Auditable;

    protected $fillable = [
        'type',
        'product_family_id',
        'nom',
        'marque',
        'zone_geographique',
        'description_olfactive_tete_1',
        'description_olfactive_tete_2',
        'description_olfactive_coeur_1',
        'description_olfactive_coeur_2',
        'description_olfactive_fond_1',
        'description_olfactive_fond_2',
        'famille_olfactive',
        'specific_attributes',
        'date_sortie',
        'unisex',
        'avatar'
    ];

    protected $casts = [
        'specific_attributes' => 'array',
        'date_sortie' => 'integer',
        'unisex' => 'boolean',
    ];

    public function productFamily(): BelongsTo
    {
        return $this->belongsTo(ProductFamily::class);
    }

    // Générer automatiquement le type lors de la création
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (!$model->type) {
                $family = ProductFamily::findOrFail($model->product_family_id);
                $lastProduct = self::where('product_family_id', $model->product_family_id)
                    ->orderBy('id', 'desc')
                    ->first();
                
                $sequenceNumber = $lastProduct ? (int)substr($lastProduct->type, strlen($family->code)) + 1 : 1;
                $model->type = $family->code . str_pad($sequenceNumber, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    // Scopes pour faciliter les requêtes
    public function scopeFamily($query, $familyCode)
    {
        return $query->whereHas('productFamily', function ($q) use ($familyCode) {
            $q->where('code', $familyCode);
        });
    }
    
    // Pour les choix uniques (déjà existants, à utiliser comme modèle)
    public function getApplicationAttribute()
    {
        return $this->product_family_id === 2 ? // Assurez-vous que 2 est l'ID de PM
            ($this->specific_attributes['application'] ?? null) : null;
    }

    // Pour les choix multiples - nouveau
    public function getFamilleOlfactiveAttribute()
    {
        return $this->specific_attributes['famille_olfactive'] ?? [];
    }

    // Setter pour un choix unique (déjà existant)
    public function setApplicationAttribute($value)
    {
        $attributes = $this->specific_attributes ?: [];
        $attributes['application'] = $value;
        $this->specific_attributes = $attributes;
    }

    // Setter pour un choix multiple - nouveau
    public function setFamilleOlfactiveAttribute($values)
    {
        $attributes = $this->specific_attributes ?: [];
        $attributes['famille_olfactive'] = is_array($values) ? $values : [$values];
        $this->specific_attributes = $attributes;
    }
}