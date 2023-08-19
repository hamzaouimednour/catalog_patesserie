<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductComponentGroup;
use App\Http\Requests\ProductComponentGroupRequest;

class ProductComponentGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the data
        $group = ProductComponentGroup::all();

        // show the view and pass the data to it
        return view('backend.product-component-groups.index', compact('group'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.product-component-groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductComponentGroupRequest $request)
    {
        ProductComponentGroup::create($request->validated());
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
        $group = ProductComponentGroup::find($id);

        // show the view and pass the data to it
        return view('backend.product-component-groups.show', compact('group'));
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
        $group = ProductComponentGroup::find($id);

        // show the view and pass the data to it
        return view('backend.product-component-groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductComponentGroupRequest $request, $id)
    {
        $group  = ProductComponentGroup::findOrFail($id);
        $group->fill($request->all())->save();
        return redirect()->route('backend.product-component-groups.index');
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
        $group = CompanyAdministration::find($id);
        $group->delete();
    }
}
