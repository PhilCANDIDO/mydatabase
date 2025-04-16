<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\ProductFamily;
use App\Models\ReferenceData;
use Livewire\Component;
use App\Traits\HasPermissions;
use Livewire\WithFileUploads;

class CreateProduct extends Component
{
    use HasPermissions, WithFileUploads;
    
    public $family;
    public $product = [];
    public $specific_attributes = [];
    public $avatar;
    public $zoneGeoValues = []; // Pour stocker les valeurs multi-select des zones géographiques
    
    protected function rules()
    {
        $rules = [
            'product.type' => 'required|string|unique:products,type',
            'product.nom' => 'required|string|max:255',
            'product.marque' => 'nullable|string|max:255',
            'zoneGeoValues' => 'nullable|array', // Pour la validation des zones géographiques
            'zoneGeoValues.*' => 'string|exists:reference_data,value,type,zone_geo',
        ];
        
        // Ajouter des règles spécifiques selon la famille
        if ($this->family->code !== 'W') {
            $rules = array_merge($rules, [
                'product.description_olfactive_tete_1' => 'nullable|string',
                'product.description_olfactive_tete_2' => 'nullable|string',
                'product.description_olfactive_coeur_1' => 'nullable|string',
                'product.description_olfactive_coeur_2' => 'nullable|string',
                'product.description_olfactive_fond_1' => 'nullable|string',
                'product.description_olfactive_fond_2' => 'nullable|string',
                'product.famille_olfactive' => 'nullable|string',
            ]);
            
            if (in_array($this->family->code, ['D', 'M', 'U'])) {
                $rules['product.date_sortie'] = 'nullable|integer|min:1900|max:' . (date('Y') + 1);
            }
            
            if (in_array($this->family->code, ['D', 'M'])) {
                $rules['product.unisex'] = 'boolean';
            }
            
            if ($this->family->code === 'PM') {
                $rules['specific_attributes.application'] = 'required|string';
            }
            
            if ($this->family->code === 'U') {
                $rules['specific_attributes.genre'] = 'required|string';
            }
        }
        
        return $rules;
    }
    
    public function mount($familyCode)
    {
        // Vérifier les permissions
        $this->permAuthorize('add data');
        
        $this->family = ProductFamily::where('code', $familyCode)->firstOrFail();
        
        // Initialiser les valeurs par défaut
        $this->product['product_family_id'] = $this->family->id;
        
        if (in_array($this->family->code, ['D', 'M'])) {
            $this->product['unisex'] = false;
        }
        
        // Générer le prochain type disponible
        $this->product['type'] = $this->generateNextType();
    }
    
    /**
     * Génère le prochain numéro de type disponible
     * Format: Code de famille + numéro à 6 chiffres (ex: D000001)
     */
    protected function generateNextType()
    {
        $latestProduct = Product::where('product_family_id', $this->family->id)
                               ->orderBy('type', 'desc')
                               ->first();
        
        $prefix = $this->family->code;
        
        if (!$latestProduct) {
            // Premier produit de cette famille
            return $prefix . '000001';
        }
        
        // Extraire le numéro de la dernière référence
        $lastType = $latestProduct->type;
        $numericPart = intval(substr($lastType, strlen($prefix)));
        
        // Incrémenter et formater avec des zéros
        $nextNumericPart = $numericPart + 1;
        $formattedNumericPart = str_pad($nextNumericPart, 6, '0', STR_PAD_LEFT);
        
        return $prefix . $formattedNumericPart;
    }
    
    public function create()
    {
        $this->validate();
        
        $this->product['specific_attributes'] = !empty($this->specific_attributes) ? $this->specific_attributes : null;
        
        // Le type a déjà été défini dans mount()
        if (empty($this->product['type'])) {
            $this->product['type'] = $this->generateNextType();
        }
        
        // Début de la transaction pour assurer l'intégrité des données
        \DB::beginTransaction();
        
        try {
            // Création du produit principal
            $product = Product::create($this->product);
            
            // Création des relations avec les zones géographiques
            if (!empty($this->zoneGeoValues)) {
                foreach ($this->zoneGeoValues as $zoneGeoValue) {
                    $product->zoneGeos()->create([
                        'zone_geo_value' => $zoneGeoValue
                    ]);
                }
            }
            
            // Si upload d'avatar, le traiter et l'associer au produit
            if ($this->avatar) {
                $avatarPath = $this->avatar->store('avatars', 'public');
                $product->update(['avatar' => $avatarPath]);
            }
            
            // Création des notes olfactives (si présentes)
            $this->createOlfactiveNotes($product);
            
            // Création des familles olfactives (si présentes)
            if (!empty($this->product['famille_olfactive'])) {
                $product->olfactiveFamilies()->create([
                    'famille_value' => $this->product['famille_olfactive']
                ]);
            }
            
            \DB::commit();
            
            session()->flash('success', __('Produit créé avec succès.'));
            
            return redirect()->route('products.family.index', $this->family->code);
            
        } catch (\Exception $e) {
            \DB::rollBack();
            
            session()->flash('error', __('Erreur lors de la création du produit: ') . $e->getMessage());
        }
    }
    
    /**
     * Créer les notes olfactives pour le produit
     */
    protected function createOlfactiveNotes($product)
    {
        // Notes de tête
        if (!empty($this->product['description_olfactive_tete_1'])) {
            $product->olfactiveNotes()->create([
                'position' => 'tete',
                'order' => 1,
                'description_value' => $this->product['description_olfactive_tete_1']
            ]);
        }
        
        if (!empty($this->product['description_olfactive_tete_2'])) {
            $product->olfactiveNotes()->create([
                'position' => 'tete',
                'order' => 2,
                'description_value' => $this->product['description_olfactive_tete_2']
            ]);
        }
        
        // Notes de cœur
        if (!empty($this->product['description_olfactive_coeur_1'])) {
            $product->olfactiveNotes()->create([
                'position' => 'coeur',
                'order' => 1,
                'description_value' => $this->product['description_olfactive_coeur_1']
            ]);
        }
        
        if (!empty($this->product['description_olfactive_coeur_2'])) {
            $product->olfactiveNotes()->create([
                'position' => 'coeur',
                'order' => 2,
                'description_value' => $this->product['description_olfactive_coeur_2']
            ]);
        }
        
        // Notes de fond
        if (!empty($this->product['description_olfactive_fond_1'])) {
            $product->olfactiveNotes()->create([
                'position' => 'fond',
                'order' => 1,
                'description_value' => $this->product['description_olfactive_fond_1']
            ]);
        }
        
        if (!empty($this->product['description_olfactive_fond_2'])) {
            $product->olfactiveNotes()->create([
                'position' => 'fond',
                'order' => 2,
                'description_value' => $this->product['description_olfactive_fond_2']
            ]);
        }
    }
    
    public function render()
    {
        $referenceData = [];
        
        // Charger les données de référence selon la famille
        if ($this->family->code !== 'W') {
            $referenceData['zone_geographique'] = ReferenceData::getByType('zone_geo');
            $referenceData['famille_olfactive'] = ReferenceData::getByType('famille_olfactive');
            $referenceData['description_olfactive'] = ReferenceData::getByType('description_olfactive');
            
            if ($this->family->code === 'PM') {
                $referenceData['application'] = ReferenceData::getByType('application');
            }
        }
        
        return view('livewire.products.create-product', [
            'referenceData' => $referenceData
        ]);
    }
}