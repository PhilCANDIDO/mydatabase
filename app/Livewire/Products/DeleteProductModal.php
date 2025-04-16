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
        // Vérification des permissions
        if (!auth()->user()->can('delete data')) {
            session()->flash('error', __('Vous n\'avez pas les permissions nécessaires pour supprimer ce produit.'));
            $this->closeModal();
            return;
        }
        
        $product = Product::find($this->productId);
        
        if ($product) {
            $product->delete();
            session()->flash('success', __('Le produit a été supprimé avec succès.'));
            $this->dispatch('refreshProducts');
            $this->closeModal();
        }
    }

    public function render()
    {
        return view('livewire.products.delete-product-modal');
    }
}