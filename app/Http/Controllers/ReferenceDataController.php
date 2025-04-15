<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReferenceData;

class ReferenceDataController extends Controller
{
    /**
     * Display a listing of reference data.
     */
    public function index()
    {
        return view('reference-data.index');
    }

    /**
     * Show the form for creating a new reference data.
     */
    public function create()
    {
        return view('reference-data.create');
    }

    /**
     * Show the form for editing reference data.
     */
    public function edit(ReferenceData $referenceData)
    {
        return view('reference-data.edit', compact('referenceData'));
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