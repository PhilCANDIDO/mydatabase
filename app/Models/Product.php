<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\FormatsAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, Auditable, FormatsAttributes;

    protected $fillable = [
        'type',
        'product_family_id',
        'nom',
        'marque',
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

    // Relations
    
    public function productFamily(): BelongsTo
    {
        return $this->belongsTo(ProductFamily::class);
    }

    public function zoneGeos(): HasMany
    {
        return $this->hasMany(ProductZoneGeo::class);
    }

    public function olfactiveFamilies(): HasMany
    {
        return $this->hasMany(ProductOlfactiveFamily::class);
    }

    public function olfactiveNotes(): HasMany
    {
        return $this->hasMany(ProductOlfactiveNote::class);
    }
    
    // Accesseurs groupés par position
    
    public function getNotesByPosition(string $position)
    {
        return $this->olfactiveNotes()
                    ->where('position', $position)
                    ->orderBy('order')
                    ->get()
                    ->map(function($note) {
                        return $note->getFormattedLabel();
                    });
    }
    
    public function getTeteNotesAttribute()
    {
        return $this->getNotesByPosition('tete');
    }
    
    public function getCoeurNotesAttribute()
    {
        return $this->getNotesByPosition('coeur');
    }
    
    public function getFondNotesAttribute()
    {
        return $this->getNotesByPosition('fond');
    }
    
    // Accesseurs de compatibilité pour l'API
    
    public function getZoneGeographiqueAttribute()
    {
        return $this->zoneGeos->pluck('zone_geo_value')->toArray();
    }
    
    public function getFormattedZoneGeographiqueAttribute()
    {
        return $this->zoneGeos
                    ->map(function($zone) { 
                        return $zone->getFormattedLabel(); 
                    })
                    ->implode(', ');
    }
    
    public function getFamilleOlfactiveAttribute()
    {
        return $this->olfactiveFamilies->pluck('famille_value')->toArray();
    }
    
    public function getFormattedFamilleOlfactiveAttribute()
    {
        return $this->olfactiveFamilies
                    ->map(function($famille) { 
                        return $famille->getFormattedLabel(); 
                    })
                    ->implode(', ');
    }
    
    // Accesseurs pour compatibilité avec le code existant
    
    public function getDescriptionOlfactiveTete1Attribute()
    {
        $note = $this->olfactiveNotes()
                     ->where('position', 'tete')
                     ->where('order', 1)
                     ->first();
                     
        return $note ? $note->getFormattedLabel() : null;
    }
    
    public function getDescriptionOlfactiveTete2Attribute()
    {
        $note = $this->olfactiveNotes()
                     ->where('position', 'tete')
                     ->where('order', 2)
                     ->first();
                     
        return $note ? $note->getFormattedLabel() : null;
    }
    
    public function getDescriptionOlfactiveCoeur1Attribute()
    {
        $note = $this->olfactiveNotes()
                     ->where('position', 'coeur')
                     ->where('order', 1)
                     ->first();
                     
        return $note ? $note->getFormattedLabel() : null;
    }
    
    public function getDescriptionOlfactiveCoeur2Attribute()
    {
        $note = $this->olfactiveNotes()
                     ->where('position', 'coeur')
                     ->where('order', 2)
                     ->first();
                     
        return $note ? $note->getFormattedLabel() : null;
    }
    
    public function getDescriptionOlfactiveFond1Attribute()
    {
        $note = $this->olfactiveNotes()
                     ->where('position', 'fond')
                     ->where('order', 1)
                     ->first();
                     
        return $note ? $note->getFormattedLabel() : null;
    }
    
    public function getDescriptionOlfactiveFond2Attribute()
    {
        $note = $this->olfactiveNotes()
                     ->where('position', 'fond')
                     ->where('order', 2)
                     ->first();
                     
        return $note ? $note->getFormattedLabel() : null;
    }
    
    // Méthodes d'accesseurs spécifiques aux familles

    public function setApplicationAttribute($value)
    {
        $attributes = $this->specific_attributes ?: [];
        $attributes['application'] = $value;
        $this->specific_attributes = $attributes;
    }
    
    public function getGenreAttribute()
    {
        return $this->product_family_id === 5 ? // ID de la famille U
            ($this->specific_attributes['genre'] ?? null) : null;
    }

    public function setGenreAttribute($value)
    {
        $attributes = $this->specific_attributes ?: [];
        $attributes['genre'] = $value;
        $this->specific_attributes = $attributes;
    }
    
    // Méthodes utilitaires
    
    protected function getFormatableAttributes()
    {
        return [
            'zone_geographique',
            'famille_olfactive',
            'unisex',
        ];
    }

    public function applications(): HasMany
    {
        return $this->hasMany(ProductApplication::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(ProductFile::class);
    }

    public function getApplicationAttribute()
    {
        $app = $this->applications->first();
        return $app ? $app->application_value : null;
    }

    public function getFormattedApplicationAttribute()
    {
        $app = $this->applications->first();
        return $app ? $app->getFormattedLabel() : null;
    }
}