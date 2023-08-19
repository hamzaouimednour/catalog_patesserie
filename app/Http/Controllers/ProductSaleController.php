<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductSale;
use App\Http\Requests\ProductSaleRequest;

class ProductSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the data
        $productsales = ProductSale::all();

        // show the view and pass the data to it
        return view('backend.product-sales.index', compact('productsales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.product-sales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductSaleRequest $request)
    {
        ProductSale::create($request->validated());
        
        return redirect()->route('backend.product-sales.index')
                         ->with('success','Succès, Operation réussie.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get the data
        $productsale = ProductSale::find($id);

        // show the view and pass the data to it
        return view('backend.product-sales.show', compact('productsale'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get the data
        $productsale = ProductSale::find($id);

        // show the view and pass the data to it
        return view('backend.product-sales.edit', compact('productsale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductSaleRequest $request, $id)
    {
        $sale  = ProductSale::findOrFail($id);
        $sale->fill($request->all())->save();
        return redirect()->route('backend.product-sales.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete
        $productsale = ProductSale::find($id);
        if($productsale->delete()){
            return redirect()->route('backend.product-sales')
                             ->with('success','Succès, Operation réussie.');
        }
        return redirect()->route('backend.product-sales')
                         ->with('failed','Échec, Operation échouée.');
    }
}
