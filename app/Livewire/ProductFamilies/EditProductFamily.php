<?php

namespace App\Livewire\ProductFamilies;

use App\Models\ProductFamily;
use Livewire\Component;

class EditProductFamily extends Component
{
    public ProductFamily $family;

    public $familyName = '';
    public $familyDescription = '';
    public $familyActive = true;

    protected function rules()
    {
        return [
            'familyName' => 'required|string|max:255',
            'familyDescription' => 'nullable|string',
            'familyActive' => 'boolean'
        ];
    }

    public function mount(ProductFamily $family)
    {
        $this->family = $family;
        $this->familyName = $family->name;
        $this->familyDescription = $family->description;
        $this->familyActive = $family->active;
    }

    public function update()
    {
        $this->validate();

        $this->family->update([
            'name' => $this->familyName,
            'description' => $this->familyDescription,
            'active' => $this->familyActive
        ]);

        session()->flash('success', __('Famille de produits mise à jour avec succès.'));
        return redirect()->route('product-families.index');
    }

    public function render()
    {
        return view('livewire.product-families.edit-product-family');
    }
}