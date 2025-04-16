<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\ProductFamily;
use Livewire\Component;
use App\Traits\HasPermissions;

class ProductDetail extends Component
{
    use HasPermissions;
    
    public $product;
    public $family;
    
    public function mount($familyCode, Product $product)
    {
        // Vérifier les permissions
        $this->permAuthorize('view data');
        
        $this->family = ProductFamily::where('code', $familyCode)->firstOrFail();
        
        // Vérifier que le produit appartient bien à la famille
        if ($product->product_family_id !== $this->family->id) {
            abort(404);
        }
        
        $this->product = $product;
    }
    
    public function render()
    {
        return view('livewire.products.product-detail', [
            'product' => $this->product,
            'family' => $this->family
        ]);
    }
}
