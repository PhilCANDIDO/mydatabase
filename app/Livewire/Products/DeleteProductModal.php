<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class DeleteProductModal extends ModalComponent
{
    public $productId;
    public $productName;

    public function mount($productId, $productName)
    {
        $this->productId = $productId;
        $this->productName = $productName;
    }

    public function delete()
    {
        $product = Product::find($this->productId);
        
        if ($product) {
            $product->delete();
            $this->dispatch('refreshProducts');
            $this->closeModal();
            
            // Afficher un message de succès
            session()->flash('success', __("Produit supprimé avec succès."));
        }
    }

    public function render()
    {
        return view('livewire.products.delete-product-modal');
    }
}