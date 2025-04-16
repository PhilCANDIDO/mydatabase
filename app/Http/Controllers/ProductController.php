<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductFamily;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request, $familyCode = null)
    {
        // Vérifie si l'utilisateur a la permission de voir les données
        if (!Auth::user()->can('view data')) {
            abort(403, __('Unauthorized action.'));
        }

        // Si aucun code de famille n'est fourni, rediriger vers la première famille active
        if (!$familyCode) {
            $defaultFamily = ProductFamily::where('active', true)->orderBy('name')->first();
            if ($defaultFamily) {
                return redirect()->route('products.family.index', $defaultFamily->code);
            }
        }

        // Si le code de famille est fourni, récupérer cette famille
        $family = null;
        if ($familyCode) {
            $family = ProductFamily::where('code', $familyCode)->firstOrFail();
        }

        // Récupérer toutes les familles pour le menu latéral
        $families = ProductFamily::where('active', true)->orderBy('name')->get();

        return view('products.index', compact('family', 'families'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(Request $request, $familyCode)
    {
        // Vérifie si l'utilisateur a la permission d'ajouter des données
        if (!Auth::user()->can('add data')) {
            abort(403, __('Unauthorized action.'));
        }

        $family = ProductFamily::where('code', $familyCode)->firstOrFail();
        
        return view('products.create', compact('family'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function show(Request $request, $familyCode, Product $product)
    {
        // Vérifie si l'utilisateur a la permission de voir les données
        if (!Auth::user()->can('view data')) {
            abort(403, __('Unauthorized action.'));
        }

        $family = ProductFamily::where('code', $familyCode)->firstOrFail();
        
        // Vérifier que le produit appartient bien à la famille demandée
        if ($product->product_family_id !== $family->id) {
            abort(404);
        }
        
        return view('products.show', compact('family', 'product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Request $request, $familyCode, Product $product)
    {
        // Vérifie si l'utilisateur a la permission de modifier des données
        if (!Auth::user()->can('edit data')) {
            abort(403, __('Unauthorized action.'));
        }

        $family = ProductFamily::where('code', $familyCode)->firstOrFail();
        
        // Vérifier que le produit appartient bien à la famille demandée
        if ($product->product_family_id !== $family->id) {
            abort(404);
        }
        
        return view('products.edit', compact('family', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Vérification des permissions
        if (!Auth::user()->can('delete data')) {
            return redirect()->back()->with('error', __('Unauthorized action.'));
        }
        
        try {
            $product->delete();
            return redirect()->back()->with('success', __('Produit supprimé avec succès.'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('Erreur lors de la suppression du produit.'));
        }
    }

     /**
     * Show the import form for the specified family.
     */
    public function showImport($familyCode)
    {
        // Vérifie si l'utilisateur a la permission d'importer des données
        if (!Auth::user()->can('import data')) {
            abort(403, __('Unauthorized action.'));
        }

        $family = ProductFamily::where('code', $familyCode)->firstOrFail();
        
        return view('products.import', compact('family'));
    }

    /**
     * Show the export form for the specified family.
     */
    public function showExport($familyCode)
    {
        // Vérifie si l'utilisateur a la permission d'exporter des données
        if (!Auth::user()->can('export data')) {
            abort(403, __('Unauthorized action.'));
        }

        $family = ProductFamily::where('code', $familyCode)->firstOrFail();
        
        return view('products.export', compact('family'));
    }
}
