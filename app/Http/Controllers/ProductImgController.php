<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductImg;
use App\Http\Requests\ProductImgRequest;

class ProductImgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the data
        $imgs = ProductImg::all();

        // show the view and pass the data to it
        return view('backend.product-imgs.index', compact('imgs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.product-imgs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductImgRequest $request)
    {
        ProductImg::create($request->validated());
        
        return redirect()->route('backend.product-imgs.index')
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
        $img = ProductImg::find($id);

        // show the view and pass the data to it
        return view('backend.product-imgs.show', compact('img'));
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
        $img = ProductImg::find($id);

        // show the view and pass the data to it
        return view('backend.product-imgs.edit', compact('img'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductImgRequest $request, $id)
    {
        $img  = ProductImg::findOrFail($id);
        $img->fill($request->all())->save();
        return redirect()->route('backend.product-imgs.index');
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
        $img = ProductImg::find($id);
        if($img->delete()){
            return redirect()->route('backend.product-imgs')
                             ->with('success','Succès, Operation réussie.');
        }
        return redirect()->route('backend.product-imgs')
                         ->with('failed','Échec, Operation échouée.');
    }
}
