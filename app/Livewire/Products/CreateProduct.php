<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\ProductFamily;
use App\Models\Application;
use App\Models\OlfactiveFamily;
use App\Models\OlfactiveNote;
use App\Models\ZoneGeo;
use App\Traits\HasPermissions;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateProduct extends Component
{
    use HasPermissions, WithFileUploads;
    
    // Propriétés de base
    public $selectedFamily = null;
    public $product_type = '';
    public $product_name = '';
    public $product_marque = '';
    public $product_annee_sortie = null;
    public $product_unisex = false;
    public $product_genre = null;
    public $application_id = null;
    public $product_avatar = null;
    
    // Propriétés pour les relations
    public $selectedZoneGeos = [];
    public $selectedOlfactiveFamilies = [];
    
    // Notes olfactives (head, heart, base)
    public $headNotes = [['id' => null, 'order' => 1], ['id' => null, 'order' => 2]];
    public $heartNotes = [['id' => null, 'order' => 1], ['id' => null, 'order' => 2]];
    public $baseNotes = [['id' => null, 'order' => 1], ['id' => null, 'order' => 2]];
    
    protected $rules = [
        'selectedFamily' => 'required|exists:product_families,id',
        'product_name' => 'required|string|max:255',
        'product_marque' => 'nullable|string|max:255',
    ];
    
    // Règles de validation dynamiques en fonction de la famille
    protected function getDynamicRules()
    {
        if (!$this->selectedFamily) {
            return [];
        }
        
        $family = ProductFamily::find($this->selectedFamily);
        
        if (!$family) {
            return [];
        }
        
        $rules = [];
        
        switch ($family->product_family_code) {
            case 'W': // Solinote
                // Pas de règles supplémentaires pour Solinote
                break;
                
            case 'PM': // Produits du Marché
                $rules['application_id'] = 'required|exists:applications,id';
                break;
                
            case 'D': // Dame
            case 'M': // Masculin
                $rules['product_annee_sortie'] = 'nullable|integer|min:1900|max:' . date('Y');
                $rules['product_unisex'] = 'boolean';
                break;
                
            case 'U': // Unisex
                $rules['product_annee_sortie'] = 'nullable|integer|min:1900|max:' . date('Y');
                $rules['product_genre'] = 'required|in:M,F';
                break;
        }
        
        return $rules;
    }
    
    public function updatedSelectedFamily()
    {
        // Générer automatiquement le type de produit en fonction de la famille
        if ($this->selectedFamily) {
            $family = ProductFamily::find($this->selectedFamily);
            if ($family) {
                // Trouver le dernier ID dans cette famille
                $lastProduct = Product::where('product_type', 'like', $family->product_family_code . '%')
                                     ->orderBy('product_type', 'desc')
                                     ->first();
                
                $lastId = 0;
                if ($lastProduct) {
                    $lastId = (int)substr($lastProduct->product_type, strlen($family->product_family_code));
                }
                
                $newId = $lastId + 1;
                $this->product_type = $family->product_family_code . str_pad($newId, 6, '0', STR_PAD_LEFT);
            }
        }
    }
    
    public function create()
    {
        $this->permAuthorize('add data');
        
        // Fusion des règles de base avec les règles dynamiques
        $rules = array_merge($this->rules, $this->getDynamicRules());
        
        $this->validate($rules);
        
        try {
            DB::beginTransaction();
            
            // Créer le produit de base
            $product = Product::create([
                'product_type' => $this->product_type,
                'product_family_id' => $this->selectedFamily,
                'product_name' => $this->product_name,
                'product_marque' => $this->product_marque,
                'product_annee_sortie' => $this->product_annee_sortie,
                'product_unisex' => $this->product_unisex,
                'product_genre' => $this->product_genre,
                'application_id' => $this->application_id,
            ]);
            
            // Traiter l'avatar si uploadé
            if ($this->product_avatar) {
                $avatarPath = $this->product_avatar->store('product-avatars', 'public');
                $product->update(['product_avatar' => $avatarPath]);
            }
            
            // Gérer les associations seulement si ce n'est pas un produit Solinote (W)
            $family = ProductFamily::find($this->selectedFamily);
            if ($family && $family->product_family_code !== 'W') {
                // Associer les zones géographiques
                if (!empty($this->selectedZoneGeos)) {
                    $product->zoneGeos()->attach($this->selectedZoneGeos);
                }
                
                // Associer les familles olfactives
                if (!empty($this->selectedOlfactiveFamilies)) {
                    $product->olfactiveFamilies()->attach($this->selectedOlfactiveFamilies);
                }
                
                // Associer les notes olfactives
                foreach (['head' => $this->headNotes, 'heart' => $this->heartNotes, 'base' => $this->baseNotes] as $position => $notes) {
                    foreach ($notes as $note) {
                        if (!empty($note['id'])) {
                            $product->olfactiveNotes()->attach($note['id'], [
                                'olfactive_note_position' => $position,
                                'olfactive_note_order' => $note['order'],
                            ]);
                        }
                    }
                }
            }
            
            DB::commit();
            
            session()->flash('message', __('Produit créé avec succès.'));
            
            return redirect()->route('products.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', __('Erreur lors de la création du produit: ') . $e->getMessage());
        }
    }
    
    public function render()
    {
        $this->permAuthorize('add data');
        
        $productFamilies = ProductFamily::where('product_family_active', true)
                                       ->orderBy('product_family_name')
                                       ->get();
        
        $applications = Application::where('application_active', true)
                                  ->orderBy('application_name')
                                  ->get();
        
        $zoneGeos = ZoneGeo::where('zone_geo_active', true)
                          ->orderBy('zone_geo_name')
                          ->get();
        
        $olfactiveFamilies = OlfactiveFamily::where('olfactive_family_active', true)
                                          ->orderBy('olfactive_family_name')
                                          ->get();
        
        $olfactiveNotes = OlfactiveNote::where('olfactive_note_active', true)
                                     ->orderBy('olfactive_note_name')
                                     ->get();
                                     
        // Déterminer la famille sélectionnée pour les champs conditionnels                           
        $selectedFamilyCode = null;
        if ($this->selectedFamily) {
            $family = ProductFamily::find($this->selectedFamily);
            if ($family) {
                $selectedFamilyCode = $family->product_family_code;
            }
        }
        
        return view('livewire.products.create-product', [
            'productFamilies' => $productFamilies,
            'applications' => $applications,
            'zoneGeos' => $zoneGeos,
            'olfactiveFamilies' => $olfactiveFamilies,
            'olfactiveNotes' => $olfactiveNotes,
            'selectedFamilyCode' => $selectedFamilyCode,
        ]);
    }
}