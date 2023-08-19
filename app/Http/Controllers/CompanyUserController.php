<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\CompanyUser;
use App\Models\CompanySection;
use App\Http\Requests\CompanyUserRequest;

class CompanyUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the data

            // $users = DB::table('company_users')
            //                 ->join('company_sections', function ($join) {
            //                     $join->on('company_sections.id', '=', 'company_users.company_section_id')
            //                          ->where('company_sections.section', '=', 'F');
            //         })
            //         ->get();
        $users = CompanyUser::all();
        $sections = CompanySection::all('id', 'name');

        // show the view and pass the data to it
        return view('backend.company-users.index', compact('users', 'sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.company-users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyUserRequest $request)
    {   
        $request->merge([
            'password' => Hash::make($request->password),
        ]);
        CompanyUser::create($request->all());
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
        $user = CompanyUser::find($id);

        if(is_null($user)){
            return response()->json([
                'status' => 'failed'
            ]);
        }
        // show the view and pass the data to it
        return response()->json([
            'data' => $user,
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
        // get the data
        $user = CompanyUser::find($id);

        // pass the data to view
        return view('backend.company-sections.edit', compact('user'));
    }    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        // get the data
        $user = CompanyUser::find($request->input('id'));

        if(is_null($user)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        CompanyUser::where('id', $request->input('id'))->update(['status' => $request->input('status')]);
        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyUserRequest $request, $id)
    {
        $user  = CompanyUser::findOrFail($id);
        if(is_null($user)){
            return response()->json([
                'status' => 'failed'
            ]);
        }
        if(!empty($request->password)){
            $request->merge([
                'password' => Hash::make($request->password),
            ]);
        }else{
            //$request->except(['password']);
            $request->offsetUnset('password');
        }
        $user->fill($request->all())->save();

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
        $user = CompanyUser::findOrFail($id);

        // return json data.
        if($user->delete()){
            
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
        $table = (new CompanyUser)->getTable();
        $db_prefix =  env('DB_TABLE_PREFIX');
        DB::statement('ALTER TABLE '. $db_prefix.$table .' AUTO_INCREMENT = 0');
    }
}
