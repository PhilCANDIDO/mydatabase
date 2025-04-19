<?php

namespace App\Http\Controllers;

use App\Models\ZoneGeo;
use Illuminate\Http\Request;

class ZoneGeoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('zone-geos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('zone-geos.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(ZoneGeo $zoneGeo)
    {
        return view('zone-geos.show', compact('zoneGeo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ZoneGeo $zoneGeo)
    {
        return view('zone-geos.edit', compact('zoneGeo'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ZoneGeo $zoneGeo)
    {
        try {
            $zoneGeo->delete();
            return redirect()->route('zone-geos.index')
                ->with('success', __('Zone géographique supprimée avec succès.'));
        } catch (\Exception $e) {
            return redirect()->route('zone-geos.index')
                ->with('error', __('Erreur lors de la suppression de la zone géographique: ') . $e->getMessage());
        }
    }
}