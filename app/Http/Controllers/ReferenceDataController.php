<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReferenceData;

class ReferenceDataController extends Controller
{
    /**
     * Display a listing of reference data.
     */
    public function index(Request $request)
    {
        // Groupe les données par type pour faciliter l'affichage
        $types = ReferenceData::select('type')->distinct()->pluck('type');
        $referenceData = [];
        
        foreach ($types as $type) {
            $referenceData[$type] = ReferenceData::where('type', $type)
                ->orderBy('order')
                ->orderBy('label')
                ->get();
        }
        
        return view('reference-data.index', compact('referenceData', 'types'));
    }

    /**
     * Show the form for creating a new reference data.
     */
    public function create()
    {
        $types = ReferenceData::select('type')->distinct()->pluck('type');
        return view('reference-data.create', compact('types'));
    }

    /**
     * Store a newly created reference data in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:50',
            'value' => 'required|string|max:100',
            'label' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'integer|min:0',
            'active' => 'boolean',
        ]);
        
        // Validation d'unicité de la paire type/value
        $exists = ReferenceData::where('type', $validated['type'])
            ->where('value', $validated['value'])
            ->exists();
            
        if ($exists) {
            return back()->withErrors(['value' => __('Cette valeur existe déjà pour ce type de référence.')]);
        }
        
        ReferenceData::create($validated);
        
        return redirect()->route('reference-data.index')
            ->with('success', __('Donnée de référence créée avec succès.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing reference data.
     */
    public function edit(ReferenceData $referenceData)
    {
        $types = ReferenceData::select('type')->distinct()->pluck('type');
        return view('reference-data.edit', compact('referenceData', 'types'));
    }

    /**
     * Update the specified reference data in storage.
     */
    public function update(Request $request, ReferenceData $referenceData)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:50',
            'value' => 'required|string|max:100',
            'label' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'integer|min:0',
            'active' => 'boolean',
        ]);
        
        // Vérification d'unicité seulement si type ou value a changé
        if ($referenceData->type !== $validated['type'] || $referenceData->value !== $validated['value']) {
            $exists = ReferenceData::where('type', $validated['type'])
                ->where('value', $validated['value'])
                ->where('id', '!=', $referenceData->id)
                ->exists();
                
            if ($exists) {
                return back()->withErrors(['value' => __('Cette valeur existe déjà pour ce type de référence.')]);
            }
        }
        
        $referenceData->update($validated);
        
        return redirect()->route('reference-data.index')
            ->with('success', __('Donnée de référence mise à jour avec succès.'));
    }

    /**
     * Remove the specified reference data from storage.
     */
    public function destroy(ReferenceData $referenceData)
    {
        $referenceData->delete();
        
        return redirect()->route('reference-data.index')
            ->with('success', __('Donnée de référence supprimée avec succès.'));
    }
}
