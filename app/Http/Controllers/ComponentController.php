<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Models\Component;
use App\Http\Requests\ComponentRequest;

class ComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the data
        $components = Component::all()->sortByDesc("id");

        // show the view and pass the data to it
        return view('backend.components.index', compact('components'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.components.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ComponentRequest $request)
    {
        //temporary instead of Auth::id() 
        $request->merge(["company_id" => DB::table('company')->value('id')]);

        if($request->hasFile('img')){
            
            $file = $request->file('img');
            $fileName = time() . "-" . hash('fnv164', $file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
            if(!$file->move(public_path('thumbs'), $fileName)){
                return response()->json([
                    'status' => 'failed',
                    'error' => 'Upload Error. File could not be uploaded for some reason.'
                ]);
            }

            $request = new ComponentRequest($request->all());
            $request->merge([
                'img' => $fileName,
            ]);
            // var_dump(Storage::disk('public')->exists($fileName));
        }else{
            $request->merge([
                'img' => 'default.png',
            ]);
        }
        Component::create($request->all());
        
        return response()->json([
            'status' => 'success'
        ]);
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
        $component = Component::find($id);

        if(is_null($component)){
            return response()->json([
                'status' => 'failed'
            ]);
        }
        // show the view and pass the data to it
        return response()->json([
            'data' => $component,
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
        $component = Component::find($request->input('id'));

        if(is_null($component)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        Component::where('id', $request->input('id'))->update(['status' => $request->input('status')]);
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
        $component = Component::find($id);

        // show the view and pass the data to it
        return view('backend.components.edit', compact('component'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ComponentRequest $request, $id)
    {
        $component  = Component::findOrFail($id);
        if(is_null($component)){
            return response()->json([
                'status' => 'failed'
            ]);
        }
        if($request->hasFile('img')){
            
            $file = $request->file('img');
            $fileName = time() . "-" . hash('fnv164', $file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
            if(!$file->move(public_path('thumbs'), $fileName)){
                return response()->json([
                    'status' => 'failed',
                    'error' => 'Upload Error. File could not be uploaded for some reason.'
                ]);
            }

            $request = new ComponentRequest($request->all());
            $request->merge([
                'img' => $fileName,
            ]);
            // var_dump(Storage::disk('public')->exists($fileName));
        }

        $component->fill($request->all())->save();
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
        $component = Component::find($id);

        // return json data.
        if($component->delete()){
            
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
        $table = (new Component)->getTable();
        $db_prefix =  env('DB_TABLE_PREFIX');
        DB::statement('ALTER TABLE '. $db_prefix.$table .' AUTO_INCREMENT = 0');
    }
}
