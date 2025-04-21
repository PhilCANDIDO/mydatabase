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
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProduct extends Component
{
    use HasPermissions, WithFileUploads;
    
    public Product $product;
    
    // Propriétés de base
    public $product_type = '';
    public $product_name = '';
    public $product_marque = '';
    public $product_annee_sortie = null;
    public $product_unisex = false;
    public $product_genre = null;
    public $application_id = null;
    public $new_product_avatar = null;  // Pour l'upload de nouveaux avatars
    public $current_avatar = null;      // Pour afficher l'avatar actuel
    
    // Propriétés pour les relations
    public $selectedZoneGeos = [];
    public $selectedOlfactiveFamilies = [];
    
    // Notes olfactives (head, heart, base)
    public $headNotes = [['id' => null, 'order' => 1], ['id' => null, 'order' => 2]];
    public $heartNotes = [['id' => null, 'order' => 1], ['id' => null, 'order' => 2]];
    public $baseNotes = [['id' => null, 'order' => 1], ['id' => null, 'order' => 2]];
    
    protected function rules()
    {
        $rules = [
            'product_name' => 'required|string|max:255',
            'product_marque' => 'nullable|string|max:255',
            'new_product_avatar' => 'nullable|image|max:1024',
        ];
        
        // Règles dynamiques en fonction de la famille
        $family = $this->product->productFamily;
        
        switch ($family->product_family_code) {
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
    
    public function mount(Product $product)
    {
        $this->permAuthorize('edit data');
        
        $this->product = $product;
        
        // Charger les relations
        $this->product->load([
            'zoneGeos', 
            'olfactiveFamilies', 
            'olfactiveNotes'
        ]);
        
        // Remplir les propriétés de base
        $this->product_type = $product->product_type;
        $this->product_name = $product->product_name;
        $this->product_marque = $product->product_marque;
        $this->product_annee_sortie = $product->product_annee_sortie;
        $this->product_unisex = $product->product_unisex;
        $this->product_genre = $product->product_genre;
        $this->application_id = $product->application_id;
        $this->current_avatar = $product->product_avatar;
        
        // Remplir les relations
        $this->selectedZoneGeos = $product->zoneGeos->pluck('id')->toArray();
        $this->selectedOlfactiveFamilies = $product->olfactiveFamilies->pluck('id')->toArray();
        
        // Remplir les notes olfactives
        $headNotes = $product->olfactiveNotes()
            ->where('olfactive_note_position', 'head')
            ->orderBy('olfactive_note_order')
            ->get();
            
        $heartNotes = $product->olfactiveNotes()
            ->where('olfactive_note_position', 'heart')
            ->orderBy('olfactive_note_order')
            ->get();
            
        $baseNotes = $product->olfactiveNotes()
            ->where('olfactive_note_position', 'base')
            ->orderBy('olfactive_note_order')
            ->get();
        
        // Initialiser les tableaux de notes
        for ($i = 0; $i < 2; $i++) {
            if (isset($headNotes[$i])) {
                $this->headNotes[$i]['id'] = $headNotes[$i]->id;
                $this->headNotes[$i]['order'] = $headNotes[$i]->pivot->olfactive_note_order;
            }
            
            if (isset($heartNotes[$i])) {
                $this->heartNotes[$i]['id'] = $heartNotes[$i]->id;
                $this->heartNotes[$i]['order'] = $heartNotes[$i]->pivot->olfactive_note_order;
            }
            
            if (isset($baseNotes[$i])) {
                $this->baseNotes[$i]['id'] = $baseNotes[$i]->id;
                $this->baseNotes[$i]['order'] = $baseNotes[$i]->pivot->olfactive_note_order;
            }
        }
    }
    
    public function update()
    {
        $this->permAuthorize('edit data');
        
        $this->validate($this->rules());
        
        try {
            DB::beginTransaction();
            
            // Mettre à jour les propriétés de base
            $this->product->update([
                'product_name' => $this->product_name,
                'product_marque' => $this->product_marque,
                'product_annee_sortie' => $this->product_annee_sortie,
                'product_unisex' => $this->product_unisex,
                'product_genre' => $this->product_genre,
                'application_id' => $this->application_id,
            ]);
            
            // Traiter l'avatar si un nouveau est uploadé
            if ($this->new_product_avatar) {
                // Supprimer l'ancien avatar s'il existe
                if ($this->current_avatar) {
                    Storage::disk('public')->delete($this->current_avatar);
                }
                
                $avatarPath = $this->new_product_avatar->store('product-avatars', 'public');
                $this->product->update(['product_avatar' => $avatarPath]);
                $this->current_avatar = $avatarPath;
            }
            
            // Gérer les associations seulement si ce n'est pas un produit Solinote (W)
            $family = $this->product->productFamily;
            if ($family->product_family_code !== 'W') {
                // Synchroniser les zones géographiques
                $this->product->zoneGeos()->sync($this->selectedZoneGeos);
                
                // Synchroniser les familles olfactives
                $this->product->olfactiveFamilies()->sync($this->selectedOlfactiveFamilies);
                
                // Supprimer toutes les notes olfactives existantes
                $this->product->olfactiveNotes()->detach();
                
                // Ajouter les nouvelles notes olfactives
                foreach (['head' => $this->headNotes, 'heart' => $this->heartNotes, 'base' => $this->baseNotes] as $position => $notes) {
                    foreach ($notes as $note) {
                        if (!empty($note['id'])) {
                            $this->product->olfactiveNotes()->attach($note['id'], [
                                'olfactive_note_position' => $position,
                                'olfactive_note_order' => $note['order'],
                            ]);
                        }
                    }
                }
            }
            
            DB::commit();
            
            session()->flash('message', __('Produit mis à jour avec succès.'));
            
            return redirect()->route('products.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', __('Erreur lors de la mise à jour du produit: ') . $e->getMessage());
        }
    }
    
    public function render()
    {
        $this->permAuthorize('edit data');
        
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
                                     
        $selectedFamilyCode = $this->product->productFamily->product_family_code;
        
        return view('livewire.products.edit-product', [
            'applications' => $applications,
            'zoneGeos' => $zoneGeos,
            'olfactiveFamilies' => $olfactiveFamilies,
            'olfactiveNotes' => $olfactiveNotes,
            'selectedFamilyCode' => $selectedFamilyCode,
        ]);
    }
}