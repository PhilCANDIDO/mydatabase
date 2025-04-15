<?php

namespace App\Http\Controllers;

use App\Models\ProductFamily;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductFamilyController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Vérifier pour toutes les méthodes que l'utilisateur a le rôle "Superviser"
        $this->middleware(['role:Superviser|Super']);
    }

    /**
     * Display a listing of product families.
     */
    public function index()
    {
        
        $families = ProductFamily::orderBy('code')->get();
        return view('product-families.index', compact('families'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing a product family.
     */
    public function edit(ProductFamily $family)
    {
        return view('product-families.edit', compact('family'));
    }

    /**
     * Update the specified product family.
     */
    public function update(Request $request, ProductFamily $family)
    {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'active' => 'boolean',
        ]);
        
        $family->update($validated);
        
        return redirect()->route('product-families.index')
            ->with('success', __('Famille de produits mise à jour avec succès.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
