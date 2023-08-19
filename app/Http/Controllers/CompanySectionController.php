<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\CompanySection;
use App\Http\Requests\CompanySectionRequest;

class CompanySectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the data
        $sections = CompanySection::all();

        // show the view and pass the data to it
        return view('backend.company-sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.company-sections.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanySectionRequest $request)
    {  
        //temporary instead of Auth::id() 
        $request->merge(["company_id" => DB::table('company')->value('id')]);
        CompanySection::create($request->all());
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
        $section = CompanySection::find($id);
        if(is_null($section)){
            return response()->json([
                'status' => 'failed'
            ]);
        }
        // show the view and pass the data to it
        return response()->json([
            'data' => $section,
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
        $section = CompanySection::find($request->input('id'));

        if(is_null($section)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        CompanySection::where('id', $request->input('id'))->update(['status' => $request->input('status')]);
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
        // get the data
        $section = CompanySection::find($id);

        // pass the data to view
        return view('backend.company-sections.edit', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanySectionRequest $request, $id)
    {
        $section  = CompanySection::findOrFail($id);
        if(is_null($section)){
            return response()->json([
                'status' => 'failed'
            ]);
        }
        $section->fill($request->all())->save();

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
        $section = CompanySection::findOrFail($id);

        // return json data.
        if($section->delete()){
            
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
        $table = (new CompanySection)->getTable();
        $db_prefix =  env('DB_TABLE_PREFIX');
        DB::statement('ALTER TABLE '. $db_prefix.$table .' AUTO_INCREMENT = 0');
    }
}
