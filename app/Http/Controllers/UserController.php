<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\CompanySection;
use App\Models\CompanyUser;
use App\Models\UserPermission;
use App\Models\ModuleGroup;
use App\Http\Requests\UserRequest; // call the specific Request
use App\Http\Requests\ProfileRequest; // call the specific Request

use Session;

class UserController extends Controller
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
        $users = User::where('is_admin', 0)->get();

        // show the view and pass the data to it
        return view('backend.users.index', compact('users', 'sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        //temporary instead of Auth::id() 
        $request->merge(["company_id" => DB::table('company')->value('id')]);

        $user = new User;
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->status = $request->input('status');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        $section_user = new CompanyUser;
        $section_user->company_section_id = $request->input('section_id');
        $section_user->user_id = $user->id;
        $section_user->save();

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
        $user = User::find($id);
        $user->section_id = $user->companyUsers->first()->company_section_id;
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        // get the data
        $user = Auth::user();
        if(is_null($user)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        // show the view and pass the data to it
        return view('backend.profile.index', compact('user'));
    }

    public function profile_update(ProfileRequest $request)
    {
        $user  = Auth::user();
        if(is_null($user)){
            return response()->json([
                'status' => 'failed'
            ]);
        }
        
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        if($request->has('old_password') && !empty($request->input('old_password'))){
            if(!Hash::check($request->input('old_password'), $user->password)){
                return response()->json([
                    'info' => 'Mot de passe actuel inccorect.'
                ], 422);
            }elseif($request->input('password') !== $request->input('password_confirmation')){
                return response()->json([
                    'info' => 'La confirmation du mot de passe ne correspond pas!'
                ], 422);
            }else{
                $user->password = Hash::make($request->input('password'));
            }
        }
        $user->save();

        return response()->json([
            'status' => 'success'
        ], 200);
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
        $group = User::find($id);

        // show the view and pass the data to it
        return view('backend.users.edit', compact('group'));
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
        $group = User::find($request->input('id'));

        if(is_null($group)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        User::where('id', $request->input('id'))->update(['status' => $request->input('status')]);
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
        $user  = User::findOrFail($id);
        if(is_null($user)){
            return response()->json([
                'status' => 'failed'
            ]);
        }
        
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        if($request->has('old_password') && !empty($request->input('old_password'))){
            if(!Hash::check($request->input('old_password'), $user->password)){
                return response()->json([
                    'info' => 'Mot de passe actuel inccorect.'
                ], 422);
            }elseif($request->input('password') !== $request->input('password_confirmation')){
                return response()->json([
                    'info' => 'La confirmation du mot de passe ne correspond pas!'
                ], 422);
            }else{
                $user->password = Hash::make($request->input('password'));
            }
        }
        $user->save();

        DB::table((new CompanyUser)->getTable())->where('user_id', $user->id)->delete();

        $section_user = new CompanyUser;
        $section_user->company_section_id = $request->input('section_id');
        $section_user->user_id = $user->id;
        $section_user->save();

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
        $group = User::find($id);
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
        $table = (new User)->getTable();
        $db_prefix =  env('DB_TABLE_PREFIX');
        DB::statement('ALTER TABLE '. $db_prefix.$table .' AUTO_INCREMENT = 0');
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'username'     => 'required',
            'password'     => 'required'
        ]);
        
        $user = User::where([
            'username' => $request->username,
            'status'   => 1,
        ])->first();
        
        if($user)
        {
            // var_dump(Hash::check($request->password, $user->password));exit;
            if(Hash::check($request->password, $user->password)){
                Auth::login($user);
                
                $request->session()->put('is_admin', $user->is_admin);

                $modules_perms = collect([]);
                
                if(!$user->is_admin){
                    // get company id.
                    $company_id = $user->companyUsers->first()->companySection->company_id;
                    $request->session()->put('company_id', $company_id);
                    
                    // get User permissions.
                    $groups_perms = UserPermission::select('group_id')
                            ->where('user_id', $user->id)
                            ->where('status', 1)
                            ->get()
                            ->pluck('group_id');
                    $modules = ModuleGroup::whereIn('group_id', $groups_perms->toArray())->get();
                    

                    foreach ($modules as $key => $item) {
                        $modules_perms->push((object) [
                            'module_id' => $item->id,
                            'controller' => $item->module->controller,
                            'actions' => json_decode($item->actions, true)
                        ]);
                    }
                }
                
                // Store all user perms.
                $request->session()->put('perms', $modules_perms);

                // return.
                return response()->json([
                    'status' => 'success',
                    'url' => redirect()->intended('/cart')->getTargetUrl()
                ]);
            }else{
                return response()->json([
                    'status' => 'failed'
                ]);
            }
        }
        return response()->json([
            'status' => 'failed'
        ]);
    }

    public function logout()
    {
        if (Session::has('perms')) {
           Session::forget('perms');
        }

        Auth::logout();

        return redirect('/home');
    }
}