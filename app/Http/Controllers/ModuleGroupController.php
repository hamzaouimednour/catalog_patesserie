<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\ModuleGroup; // call the specific Model
use App\Models\Module;
use App\Models\GroupPermission; // groups names.
use App\Http\Requests\ModuleGroupRequest; // call the specific Request


class ModuleGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the data
        $groups = GroupPermission::all()->sortByDesc("id");

        // show the view and pass the data to it
        return view('backend.module-groups.index', compact('groups'));
    }
    
    public function add()
    {
        // get the data
        $modules = Module::all();

        // show the view and pass the data to it
        return view('backend.module-groups.add', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.module-groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModuleGroupRequest $request)
    {
        //temporary instead of Auth::id()
        if($request->has('modules')){

            $request->merge(["company_id" => DB::table('company')->value('id')]);

            $modules = json_decode($request->input('modules'), true);

            $group = new GroupPermission;
            $group->company_id = 1;
            $group->name = $request->input('group');
            $group->status = $request->input('status');
            $group->save();

            foreach ($modules as $mod_id => $value) {
                $module_group = new ModuleGroup;
                $module_group->module_id = $mod_id;
                $module_group->group_id = $group->id;
                $module_group->actions = json_encode($value);
                $module_group->save();
            }

            return response()->json([
                'status' => 'success'
            ], 200);
        }else{
            return response()->json([
                'status' => 'failed',
                'info'  => 'Svp sélèctionnez des modules.'
            ], 200);
        }

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
        $group = GroupPermission::find($id);
        $modules = Module::all();

        if(is_null($group)){
            return response()->json([
                'status' => 'failed'
            ]);
        }
        // show the view and pass the data to it
        return view('backend.module-groups.show', compact('group', 'modules'));
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
        $group = ModuleGroup::find($id);

        // show the view and pass the data to it
        return view('backend.module-groups.edit', compact('group'));
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
        $group = GroupPermission::find($request->input('id'));

        if(is_null($group)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        GroupPermission::where('id', $request->input('id'))->update(['status' => $request->input('status')]);
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
        $group  = GroupPermission::findOrFail($id);
        if(is_null($group)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        if($request->has('modules')){

            $modules = json_decode($request->input('modules'), true);

            $group->name = $request->input('group');
            $group->save();

            // replace old modules by the new onces.
            DB::table((new ModuleGroup)->getTable())->where('group_id', $group->id)->delete();
            
            foreach ($modules as $mod_id => $value) {
                $module_group = new ModuleGroup;
                $module_group->module_id = $mod_id;
                $module_group->group_id = $group->id;
                $module_group->actions = json_encode($value);
                $module_group->save();
            }

            return response()->json([
                'status' => 'success'
            ], 200);
        }else{
            return response()->json([
                'status' => 'failed',
                'info'  => 'Svp sélèctionnez des modules.'
            ], 200);
        }
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
        $group = GroupPermission::find($id);
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
        $table = (new GroupPermission)->getTable();
        $table2 = (new ModuleGroup)->getTable();
        $db_prefix =  env('DB_TABLE_PREFIX');
        DB::statement('ALTER TABLE '. $db_prefix.$table .' AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE '. $db_prefix.$table2 .' AUTO_INCREMENT = 0');
    }
}
