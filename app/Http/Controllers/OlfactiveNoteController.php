<?php

namespace App\Http\Controllers;

use App\Models\OlfactiveNote;
use Illuminate\Http\Request;

class OlfactiveNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('olfactive-notes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('olfactive-notes.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(OlfactiveNote $olfactiveNote)
    {
        return view('olfactive-notes.show', compact('olfactiveNote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OlfactiveNote $olfactiveNote)
    {
        return view('olfactive-notes.edit', compact('olfactiveNote'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OlfactiveNote $olfactiveNote)
    {
        try {
            $olfactiveNote->delete();
            return redirect()->route('olfactive-notes.index')
                ->with('success', __('Note olfactive supprimée avec succès.'));
        } catch (\Exception $e) {
            return redirect()->route('olfactive-notes.index')
                ->with('error', __('Erreur lors de la suppression de la note olfactive: ') . $e->getMessage());
        }
    }
}