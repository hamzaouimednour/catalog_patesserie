<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\UserPermission;
use App\Models\GroupPermission;
use Illuminate\Http\Request;

class UserPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the data
        // $perms = UserPermission::all()->sortByDesc("id");
        $perms = collect([]);
        $permissions = DB::table('user_permissions')
                    ->join('company_users', 'user_permissions.user_id', '=', 'company_users.user_id')
                    ->join('company_sections', 'company_users.company_section_id', '=', 'company_sections.id')
                    // ->join('users', 'user_permissions.user_id', '=', 'users.id')
                    // ->join('module_groups', 'user_permissions.group_id', '=', 'module_groups.id')
                    // ->join('group_permissions', 'group_permissions.id', '=', 'module_groups.group_id')
                    ->where('company_sections.company_id', '=', 1)
                    ->select('user_permissions.*')
                    // ->select('user_permissions.*', 'users.*', 'group_permissions.*')
                    ->get();
        foreach ($permissions as $value) {
            $item = new UserPermission((array) $value);
            $item->id = $value->id;
            $item->created_at = $value->created_at;
            $perms->push($item);
        }
        $users = DB::table('company_users')
                        ->join('company_sections', function ($join) {
                            $join->on('company_users.company_section_id', '=', 'company_sections.id')
                                ->where('company_sections.company_id', '=', 1);
                        })
                        ->join('users', 'company_users.user_id', '=', 'users.id')
                        ->select('users.*')
                        ->get();
        $groups = GroupPermission::where('company_id', 1)->get();

        // show the view and pass the data to it
        return view('backend.user-permissions.index', compact('perms', 'users', 'groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.user-permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //temporary instead of Auth::id()
        //check if user has already perms.
        $user_perms = UserPermission::where('user_id', $request->input('user-id'))->get();
        
        $groups = $request->input('group-id');

        foreach ($user_perms as $value){
            if(in_array($value->group_id, $groups)){
                $groups = array_diff($groups, [$value->group_id]);
            }
        }
        foreach ($groups as $group) {
            foreach ($request->input('user-id') as $user) {
                $user_perm = new UserPermission;
                $user_perm->group_id = $group;
                $user_perm->user_id = $user;
                $user_perm->save();
            }
        }
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
        $user = User::where('id', $id)->first();
        $groups = GroupPermission::where('company_id', 1)->get();
        $auth_groups = UserPermission::where('user_id', $id)->get()->pluck('group_id')->toArray();

        // show the view and pass the data to it
        return view('backend.user-permissions.show', compact('groups', 'user', 'auth_groups', 'id'));
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
        $group = UserPermission::find($id);

        // show the view and pass the data to it
        return view('backend.user-permissions.edit', compact('group'));
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
        $perm = UserPermission::find($request->input('id'));

        if(is_null($perm)){
            return response()->json([
                'status' => 'failed',
                'info'   => 'Item does not exist.'
            ]);
        }

        $perm->status = $request->input('status');
        $perm->save();

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
        //check user.

        // replace old auths by the new onces.
        DB::table((new UserPermission)->getTable())->where('user_id', $id)->delete();
        
        foreach ($request->input('group-id') as $group) {
            $user_perm = new UserPermission;
            $user_perm->group_id = $group;
            $user_perm->user_id = $id;
            $user_perm->save();
        }

        return response()->json([
            'status' => 'success'
        ], 200);
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
        $group = UserPermission::find($id);
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
        $table = (new UserPermission)->getTable();
        $db_prefix =  env('DB_TABLE_PREFIX');
        DB::statement('ALTER TABLE '. $db_prefix.$table .' AUTO_INCREMENT = 0');
    }
}