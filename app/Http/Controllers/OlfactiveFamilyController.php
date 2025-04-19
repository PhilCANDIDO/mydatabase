<?php

namespace App\Http\Controllers;

use App\Models\OlfactiveFamily;
use Illuminate\Http\Request;

class OlfactiveFamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('olfactive-families.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('olfactive-families.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(OlfactiveFamily $olfactiveFamily)
    {
        return view('olfactive-families.show', compact('olfactiveFamily'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OlfactiveFamily $olfactiveFamily)
    {
        return view('olfactive-families.edit', compact('olfactiveFamily'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OlfactiveFamily $olfactiveFamily)
    {
        try {
            $olfactiveFamily->delete();
            return redirect()->route('olfactive-families.index')
                ->with('success', __('Famille olfactive supprimée avec succès.'));
        } catch (\Exception $e) {
            return redirect()->route('olfactive-families.index')
                ->with('error', __('Erreur lors de la suppression de la famille olfactive: ') . $e->getMessage());
        }
    }
}