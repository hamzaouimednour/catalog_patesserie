<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductComponentPrice;
use App\Http\Requests\ProductComponentPriceRequest;

class ProductComponentPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the data
        $prices = ProductComponentPrice::all();

        // show the view and pass the data to it
        return view('backend.product-component-prices.index', compact('prices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.product-component-prices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductComponentPriceRequest $request)
    {
        ProductComponentPrice::create($request->validated());
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
        $price = ProductComponentPrice::find($id);

        // show the view and pass the data to it
        return view('backend.product-component-prices.show', compact('price'));
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
        $price = ProductComponentPrice::find($id);

        // show the view and pass the data to it
        return view('backend.product-component-prices.edit', compact('price'));    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductComponentPriceRequest $request, $id)
    {
        $group  = ProductComponentPrice::findOrFail($id);
        $this->validate($request, [
            'price' => 'required'
        ]);
        $group->fill($request->all())->save();
        return redirect()->route('backend.product-component-prices.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $price = ProductComponentPrice::findOrFail($id);
        $price->delete();
    }
}
