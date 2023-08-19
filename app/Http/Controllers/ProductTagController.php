<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductTag;
use App\Http\Requests\ProductTagStoreRequest;

class ProductTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the data
        $tag = ProductTag::all();

        // show the view and pass the data to it
        return view('backend.product-tags.index', compact('tag'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.product-tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductTagStoreRequest $request)
    {
        ProductTag::create($request->validated());
        
        return redirect()->route('backend.product-tags.index')
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
        $tag = ProductTag::find($id);

        // show the view and pass the data to it
        return view('backend.product-tags.show', compact('tag'));
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
        $tag = ProductTag::find($id);

        // show the view and pass the data to it
        return view('backend.product-tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tag  = ProductTag::findOrFail($id);
        $tag->fill($request->all())->save();
        return redirect()->route('backend.product-tags.index');
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
        $tag = ProductTag::find($id);
        if($tag->delete()){
            return redirect()->route('backend.product-tags')
                             ->with('success','Succès, Operation réussie.');
        }
        return redirect()->route('backend.product-tags')
                         ->with('failed','Échec, Operation échouée.');
    }
}
