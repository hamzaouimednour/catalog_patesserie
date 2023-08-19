<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\ComponentGroup;
use App\Http\Requests\ComponentGroupRequest;

class ComponentGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the data
        $groups = ComponentGroup::all()->sortByDesc("id");
        
        // show the view and pass the data to it
        return view('backend.component-groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.component-groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ComponentGroupRequest $request)
    {
        //temporary instead of Auth::id() 
        $request->merge(["company_id" => DB::table('company')->value('id')]);

        ComponentGroup::create($request->all());
        
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
        $group = ComponentGroup::find($id);

        // show the view and pass the data to it
        if(is_null($group)){
            return response()->json([
                'status' => 'failed'
            ]);
        }
        // show the view and pass the data to it
        return response()->json([
            'data' => $group,
            'status' => 'success'
        ]);
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
        $group = ComponentGroup::find($request->input('id'));

        if(is_null($group)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        ComponentGroup::where('id', $request->input('id'))->update(['status' => $request->input('status')]);
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
        $group = ComponentGroup::find($id);

        // show the view and pass the data to it
        return view('backend.component-groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ComponentGroupRequest $request, $id)
    {
        $group  = ComponentGroup::findOrFail($id);
        if(is_null($group)){
            return response()->json([
                'status' => 'failed'
            ]);
        }
        $group->fill($request->all())->save();
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
        // delete
        $group = ComponentGroup::find($id);

        // return json data.
        if($group->delete()){
            
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
        $table = (new ComponentGroup)->getTable();
        $db_prefix =  env('DB_TABLE_PREFIX');
        DB::statement('ALTER TABLE '. $db_prefix.$table .' AUTO_INCREMENT = 0');
    }
}
