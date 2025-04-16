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
    
    protected function rules()
    {
        $rules = [
            'product.nom' => 'required|string|max:255',
            'product.marque' => 'nullable|string|max:255',
        ];
        
        // Ajouter des règles spécifiques selon la famille
        if ($this->family->code !== 'W') {
            $rules = array_merge($rules, [
                'product.zone_geographique' => 'nullable|string',
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
    }
    
    public function create()
    {
        $this->validate();
        
        $this->product['specific_attributes'] = !empty($this->specific_attributes) ? $this->specific_attributes : null;
        
        $product = Product::create($this->product);
        
        session()->flash('success', __('Produit créé avec succès.'));
        
        return redirect()->route('products.family.index', $this->family->code);
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
