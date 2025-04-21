<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Traits\HasPermissions;
use Livewire\Component;

class ProductDetail extends Component
{
    use HasPermissions;
    
    public Product $product;
    
    public function mount(Product $product)
    {
        $this->product = $product;
        $this->product->load([
            'productFamily',
            'application',
            'zoneGeos',
            'olfactiveFamilies',
            'olfactiveNotes' => function ($query) {
                $query->orderBy('olfactive_note_position')->orderBy('olfactive_note_order');
            }
        ]);
    }
    
    public function render()
    {
        $this->permAuthorize('view data');
        
        // Organiser les notes olfactives par position (head, heart, base)
        $headNotes = $this->product->olfactiveNotes
            ->where('pivot.olfactive_note_position', 'head')
            ->sortBy('pivot.olfactive_note_order');
            
        $heartNotes = $this->product->olfactiveNotes
            ->where('pivot.olfactive_note_position', 'heart')
            ->sortBy('pivot.olfactive_note_order');
            
        $baseNotes = $this->product->olfactiveNotes
            ->where('pivot.olfactive_note_position', 'base')
            ->sortBy('pivot.olfactive_note_order');
        
        return view('livewire.products.product-detail', [
            'headNotes' => $headNotes,
            'heartNotes' => $heartNotes,
            'baseNotes' => $baseNotes,
        ]);
    }
}