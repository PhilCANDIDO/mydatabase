<?php

namespace App\Http\Controllers;

use App\Models\ProductFamily;
use Illuminate\Http\Request;

class ProductFamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('product-families.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductFamily $productFamily)
    {
        return view('product-families.show', compact('productFamily'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductFamily $productFamily)
    {
        return view('product-families.edit', compact('productFamily'));
    }
}