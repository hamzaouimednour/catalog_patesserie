<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductSizePrice;
use App\Http\Requests\ProductSizePriceRequest;

class ProductSizePriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the data
        $pricesbysizes = ProductSizePrice::all();

        // show the view and pass the data to it
        return view('backend.product-size-prices.index', compact('pricesbysizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.product-size-prices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductSizePriceRequest $request)
    {
        ProductSizePrice::create($request->validated());
        
        return redirect()->route('backend.product-size-prices.index')
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
        $pricebysize = ProductSizePrice::find($id);

        // show the view and pass the data to it
        return view('backend.product-size-prices.show', compact('pricebysize'));
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
        $pricebysize = ProductSizePrice::find($id);

        // show the view and pass the data to it
        return view('backend.product-size-prices.edit', compact('pricebysize'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductSizePriceRequest $request, $id)
    {
        $price  = ProductSizePrice::findOrFail($id);
        $this->validate($request, [
            'price' => 'required'
        ]);
        $price->fill($request->all())->save();
        return redirect()->route('backend.product-size-prices.index');
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
        $pricebysize = ProductSizePrice::find($id);
        if($pricebysize->delete()){
            return redirect()->route('backend.product-size-prices')
                             ->with('success','Succès, Operation réussie.');
        }
        return redirect()->route('backend.product-size-prices')
                         ->with('failed','Échec, Operation échouée.');
    }
}
