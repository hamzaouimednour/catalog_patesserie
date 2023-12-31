<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administrator;

class AdministratorController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        /*
        $administrators = Administrator::all();
        // load the view and pass the data
        return View::make('administrators.index')
            ->with('administrators', $administrators);
        */
        return view('administrators.index', ['administrators' => Administrator::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return view('administrator.profile', ['administrator' => User::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}