<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductComponent;
use App\Http\Requests\ProductComponentRequest;

class ProductComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the data
        $component = ProductComponent::all();

        // show the view and pass the data to it
        return view('backend.product-components.index', compact('component'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.product-components.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductComponentRequest $request)
    {
        ProductComponent::create($request->validated());
        
        return redirect()->route('backend.product-components.index')
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
        $component = ProductComponent::find($id);

        // show the view and pass the data to it
        return view('backend.product-components.show', compact('component'));
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
        $component = ProductComponent::find($id);

        // show the view and pass the data to it
        return view('backend.product-components.edit', compact('component'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductComponentRequest $request, $id)
    {
        $component  = ProductComponent::findOrFail($id);
        $component->fill($request->all())->save();
        return redirect()->route('backend.product-components.index');
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
        $component = ProductComponent::findOrFail($id);
        if($component->delete()){
            return redirect()->route('backend.product-components')
                             ->with('success','Succès, Operation réussie.');
        }
        return redirect()->route('backend.product-components')
                         ->with('failed','Échec, Operation échouée.');
    }
}
