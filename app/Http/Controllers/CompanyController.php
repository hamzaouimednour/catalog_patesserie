<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Company; //call the specified Model.
use App\Http\Requests\CompanyRequest;
use Auth;
use Session;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the data
        $companies = Company::all();

        // show the view and pass the data to it
        return view('backend.companies.index', compact('companies'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function company()
    {
        // get the data
        $company = Company::where('id', Session::get('company_id'))->first();
        // show the view and pass the data to it
        return view('backend.company.index', compact('company'));
    }

    public function company_update(Request $request)
    {
        //Check Auth
        $perms = Session::get('perms');
        $actions = array();
        if($perms->where('controller', 'company')->isNotEmpty() && !empty($perms->where('controller', 'company')->first()))
            $actions = $perms->where('controller', 'company')->first()->actions;
        if(Session::get('is_admin')){
            $actions = ['A', 'M', 'D', 'P'];
        }
        
        if(!empty($actions) && in_array('M', $actions)){
            // get the data
            $company = Company::find(Session::get('company_id'));
            if(is_null($company)){
                return response()->json([
                    'status' => 'failed'
                ]);
            }
            $company->fill($request->all())->save();
        }
        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        Company::create($request->all());
        return response()->json([
            'status' => 'success'
        ], 200);        
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
        $company = Company::find($id);
        if(is_null($company)){
            return response()->json([
                'status' => 'failed'
            ]);
        }
        // show the view and pass the data to it
        // return view('backend.companies.show')->with('company', $company);
        return response()->json([
            'data' => $company,
            'status' => 'success'
        ]);
    }
    
    /**
     * Display the specified method.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        // get the data
        $company = Company::find($request->input('id'));

        if(is_null($company)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        Company::where('id', $request->input('id'))->update(['status' => $request->input('status')]);
        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::find($id);
        return view('backend.companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, $id)
    {
        $company  = Company::findOrFail($id);
        if(is_null($company)){
            return response()->json([
                'status' => 'failed'
            ]);
        }
        $company->fill($request->all())->save();

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);

        // return json data.
        if($company->delete()){
            
            self::reset_ai();
            
            return response()->json([
                'status' => 'success'
            ]);
        }
        return response()->json([
            'status' => 'failed'
        ]);
    }

    /**
     * Reset AUTO_INCREMENT in table.
     */
    public static function reset_ai()
    {
        $table = (new Company)->getTable();
        $db_prefix =  env('DB_TABLE_PREFIX');
        DB::statement('ALTER TABLE '. $db_prefix.$table .' AUTO_INCREMENT = 0');
    }

}
