<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administrator; //call the specified Model.
use App\Http\Requests\AdministratorRequest;

class AdministratorController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the data
        $administrators = Administrator::all();

        // show the view and pass the data to it
        return view('backend.administrators.index', compact('administrators'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.administrators.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdministratorRequest $request)
    {
        Administrator::create($request->validated());
        
        return redirect()->route('backend.administrators.index')
                         ->with('success','Utilisateur créé avec succès.');
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
        $administrator = Administrator::find($id);

        // show the view and pass the data to it
        //return View::make('administrators.show')->with('administrator', $administrator);
        return view('backend.administrators.show', compact('administrator'));
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
        $administrator = Administrator::find($id);

        // pass the data to view
        return view('backend.administrators.edit', compact('administrator'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdministratorRequest $request, $id)
    {
        $administrator  = Administrator::findOrFail($id);
        $this->validate($request, [
            'email' => 'required|email|unique:administrators,email,'.$administrator->id, 
            'name' => 'required|string',
            'password' => 'required|string',
            'password_confirm' => 'required|same:password',
        ]);
        $administrator->fill($request->all())->save();
        return redirect()->route('backend.administrators.index')
                         ->with('success','Utilisateur modifié avec succès.');
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
        $administrator = Administrator::findOrFail($id);
        if($administrator->delete()){
            return redirect()->route('backend.administrators')
                             ->with('success','Utilisateur supprimé avec succès.');
        }
        return redirect()->route('backend.administrators')
                         ->with('failed','Échec de supprimer l\'utilisateur.');
    }
}
