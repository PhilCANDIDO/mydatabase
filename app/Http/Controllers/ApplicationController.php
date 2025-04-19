<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('applications.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('applications.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        return view('applications.show', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        return view('applications.edit', compact('application'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        try {
            $application->delete();
            return redirect()->route('applications.index')
                ->with('success', __('Application deleted successfully.'));
        } catch (\Exception $e) {
            return redirect()->route('applications.index')
                ->with('error', __('Error deleting application: ') . $e->getMessage());
        }
    }
}