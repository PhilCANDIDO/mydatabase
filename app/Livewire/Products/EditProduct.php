<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\ProductFamily;
use App\Models\ReferenceData;
use Livewire\Component;
use App\Traits\HasPermissions;
use Livewire\WithFileUploads;

class EditProduct extends Component
{
    use HasPermissions, WithFileUploads;
    
    public $product;
    public $family;
    public $productData = [];
    public $specific_attributes = [];
    public $newAvatar;
    
    protected function rules()
    {
        // Règles similaires à celles du CreateProduct
        $rules = [
            'productData.nom' => 'required|string|max:255',
            'productData.marque' => 'nullable|string|max:255',
        ];
        
        // Ajouter des règles spécifiques selon la famille
        if ($this->family->code !== 'W') {
            $rules = array_merge($rules, [
                'productData.zone_geographique' => 'nullable|string',
                'productData.description_olfactive_tete_1' => 'nullable|string',
                'productData.description_olfactive_tete_2' => 'nullable|string',
                'productData.description_olfactive_coeur_1' => 'nullable|string',
                'productData.description_olfactive_coeur_2' => 'nullable|string',
                'productData.description_olfactive_fond_1' => 'nullable|string',
                'productData.description_olfactive_fond_2' => 'nullable|string',
                'productData.famille_olfactive' => 'nullable|string',
            ]);
            
            if (in_array($this->family->code, ['D', 'M', 'U'])) {
                $rules['productData.date_sortie'] = 'nullable|integer|min:1900|max:' . (date('Y') + 1);
            }
            
            if (in_array($this->family->code, ['D', 'M'])) {
                $rules['productData.unisex'] = 'boolean';
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
    
    public function mount($familyCode, Product $product)
    {
        // Vérifier les permissions
        $this->permAuthorize('edit data');
        
        $this->family = ProductFamily::where('code', $familyCode)->firstOrFail();
        $this->product = $product;
        
        // Vérifier que le produit appartient bien à la famille
        if ($product->product_family_id !== $this->family->id) {
            abort(404);
        }
        
        // Préparer les données pour l'édition
        $this->productData = $product->toArray();
        
        // Extraire les attributs spécifiques
        if (!empty($product->specific_attributes)) {
            $this->specific_attributes = $product->specific_attributes;
        }
    }
    
    public function update()
    {
        $this->validate();
        
        // Préparer les données et mettre à jour le produit
        $this->productData['specific_attributes'] = !empty($this->specific_attributes) ? $this->specific_attributes : null;
        
        $this->product->update($this->productData);
        
        session()->flash('success', __('Produit mis à jour avec succès.'));
        
        return redirect()->route('products.family.index', $this->family->code);
    }
    
    public function render()
    {
        $referenceData = [];
        
        // Charger les données de référence selon la famille (comme dans CreateProduct)
        if ($this->family->code !== 'W') {
            $referenceData['zone_geographique'] = ReferenceData::getByType('zone_geo');
            $referenceData['famille_olfactive'] = ReferenceData::getByType('famille_olfactive');
            $referenceData['description_olfactive'] = ReferenceData::getByType('description_olfactive');
            
            if ($this->family->code === 'PM') {
                $referenceData['application'] = ReferenceData::getByType('application');
            }
        }
        
        return view('livewire.products.edit-product', [
            'referenceData' => $referenceData
        ]);
    }
}