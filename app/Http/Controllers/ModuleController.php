<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Module; // call the specific Model
use App\Http\Requests\ModuleRequest; // call the specific Request


class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the data
        $modules = Module::all()->sortByDesc("id");

        // show the view and pass the data to it
        return view('backend.modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.modules.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModuleRequest $request)
    {
         //temporary instead of Auth::id() 
        $request->merge(["company_id" => DB::table('company')->value('id') ]);

        if($request->has('actions')){
            if(!is_array($request->input('actions'))){
                $request->merge(["actions" => json_encode([$request->input('actions')]) ]);
            }else{
                $request->merge(["actions" => json_encode($request->input('actions')) ]);
            }
        }

        Module::create($request->all());
        
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
        $module = Module::find($id);

        if(is_null($module)){
            return response()->json([
                'status' => 'failed'
            ]);
        }
        // show the view and pass the data to it
        return response()->json([
            'data' => $module,
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
        $module = Module::find($id);

        // show the view and pass the data to it
        return view('backend.modules.edit', compact('module'));
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
        $module = Module::find($request->input('id'));

        if(is_null($module)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        Module::where('id', $request->input('id'))->update(['status' => $request->input('status')]);
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
    public function update(Request $request, $id)
    {
        $module  = Module::findOrFail($id);
        if(is_null($module)){
            return response()->json([
                'status' => 'failed'
            ]);
        }
        if($request->has('actions')){
            if(!is_array($request->input('actions'))){
                $request->merge(["actions" => json_encode([$request->input('actions')]) ]);
            }else{
                $request->merge(["actions" => json_encode($request->input('actions')) ]);
            }
        }
        $module->fill($request->all())->save();
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
        $module = Module::find($id);
        // return json data.
        if($module->delete()){
            
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
        $table = (new Module)->getTable();
        $db_prefix =  env('DB_TABLE_PREFIX');
        DB::statement('ALTER TABLE '. $db_prefix.$table .' AUTO_INCREMENT = 0');
    }
}
