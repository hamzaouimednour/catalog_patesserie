<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyAdministration;
use App\Http\Requests\CompanyAdministrationRequest;

class CompanyAdministrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the data
        $administrations = CompanyAdministration::all();

        // show the view and pass the data to it
        return view('backend.company-administrations.index', compact('administrations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.company-administrations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyAdministrationRequest $request)
    {
        CompanyAdministration::create($request->validated());
        
        return redirect()->route('backend.company-administrations.index')
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
        $administration = CompanyAdministration::find($id);

        // show the view and pass the data to it
        return view('backend.company-administrations.show', compact('administration'));
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
        $administration = CompanyAdministration::find($id);

        // pass the data to view
        return view('backend.company-administrations.edit', compact('administration'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyAdministrationRequest $request, $id)
    {
        $administration  = CompanyAdministration::findOrFail($id);
        $this->validate($request, [
            'email' => 'required|email|unique:company_administrations,email,'.$administration->id, 
            'phone' => 'required|numeric|digits:8|unique:company_administrations,phone,'.$administration->id, 
            'name' => 'required|string',
            'password' => 'required|string',
            'password_confirm' => 'required|same:password',
        ]);
        $administration->fill($request->all())->save();
        return redirect()->route('backend.company-administrations.index')
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
        $administration = CompanyAdministration::find($id);
        if($administration->delete()){
            return redirect()->route('backend.company-administrations')
                             ->with('success','Succès, Operation réussie.');
        }
        return redirect()->route('backend.company-administrations')
                         ->with('failed','Échec, Operation échouée.');
    }
}
