<?php

namespace App\Livewire\ProductFamilies;

use App\Models\ProductFamily;
use App\Traits\HasPermissions;
use Livewire\Component;

class EditProductFamily extends Component
{
    use HasPermissions;
    
    public ProductFamily $productFamily;
    public $product_family_name;
    public $product_family_desc;
    
    protected function rules()
    {
        return [
            'product_family_name' => 'required|string|max:255',
            'product_family_desc' => 'nullable|string',
        ];
    }

    public function mount(ProductFamily $productFamily)
    {
        $this->productFamily = $productFamily;
        $this->product_family_name = $productFamily->product_family_name;
        $this->product_family_desc = $productFamily->product_family_desc;
    }

    public function update()
    {
        $this->permAuthorize('edit data');
        
        $this->validate();
        
        try {
            $this->productFamily->update([
                'product_family_name' => $this->product_family_name,
                'product_family_desc' => $this->product_family_desc,
            ]);
            
            session()->flash('message', __('Famille de produit mise à jour avec succès.'));
            
            return redirect()->route('product-families.index');
        } catch (\Exception $e) {
            session()->flash('error', __('Erreur lors de la mise à jour de la famille de produit: ') . $e->getMessage());
        }
    }

    public function render()
    {
        $this->permAuthorize('edit data');
        
        return view('livewire.product-families.edit-product-family');
    }
}