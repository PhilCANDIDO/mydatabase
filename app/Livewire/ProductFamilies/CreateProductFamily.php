<?php

namespace App\Livewire\ProductFamilies;

use App\Models\ProductFamily;
use Livewire\Component;

class CreateProductFamily extends Component
{
    public $familyCode = '';
    public $familyName = '';
    public $familyDescription = '';
    public $familyActive = true;

    protected $rules = [
        'familyCode' => 'required|string|max:10|unique:product_families,code',
        'familyName' => 'required|string|max:255',
        'familyDescription' => 'nullable|string',
        'familyActive' => 'boolean'
    ];

    public function create()
    {
        $this->validate();

        ProductFamily::create([
            'code' => $this->familyCode,
            'name' => $this->familyName,
            'description' => $this->familyDescription,
            'active' => $this->familyActive
        ]);

        session()->flash('success', __('Famille de produits créée avec succès.'));
        return redirect()->route('product-families.index');
    }

    public function render()
    {
        return view('livewire.product-families.create-product-family');
    }
}