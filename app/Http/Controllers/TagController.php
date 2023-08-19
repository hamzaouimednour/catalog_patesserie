<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Tag; // call the specific Model
use App\Http\Requests\TagRequest; // call the specific Request


class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the data
        $tags = Tag::all()->sortByDesc("id");

        // show the view and pass the data to it
        return view('backend.tags.index', compact('tags'));
    }
    public function home()
    {
        // get the data
        $cats = Tag::where('status', 1)->get()->sortByDesc("id");

        // show the view and pass the data to it
        return view('front.home', compact('cats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        //temporary instead of Auth::id()
        $fileName = 'default.png';
        if($request->hasFile('img')){
            $file = $request->file('img');
            $fileName = time() . "-" . hash('fnv164', $file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
            if(!$file->move(public_path('themes' . DIRECTORY_SEPARATOR . 'tags'), $fileName)){
                return response()->json([
                    'status' => 'failed',
                    'error' => 'Upload Error. File could not be uploaded for some reason.'
                ]);
            }
        }
        

        $tag = new Tag;
        $tag->company_id = DB::table('company')->value('id');
        $tag->name = $request->input('name');
        $tag->img = $fileName;
        $tag->description = $request->input('description');
        $tag->save();

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
        $tag = Tag::find($id);

        if(is_null($tag)){
            return response()->json([
                'status' => 'failed'
            ]);
        }
        // show the view and pass the data to it
        return response()->json([
            'data' => $tag,
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
        $tag = Tag::find($id);

        // show the view and pass the data to it
        return view('backend.tags.edit', compact('tag'));
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
        $tag = Tag::find($request->input('id'));

        if(is_null($tag)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        Tag::where('id', $request->input('id'))->update(['status' => $request->input('status')]);
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
        $tag  = Tag::findOrFail($id);
        if(is_null($tag)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        if($request->hasFile('img')){
            
            $file = $request->file('img');
            $fileName = time() . "-" . hash('fnv164', $file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
            if(!$file->move(public_path('themes' . DIRECTORY_SEPARATOR . 'tags'), $fileName)){
                return response()->json([
                    'status' => 'failed',
                    'error' => 'Upload Error. File could not be uploaded for some reason.'
                ]);
            }

            //remove old img.
            if (file_exists(public_path('themes' . DIRECTORY_SEPARATOR . 'tags') . DIRECTORY_SEPARATOR . $tag->img)) {
                @unlink(public_path('themes' . DIRECTORY_SEPARATOR . 'tags') . DIRECTORY_SEPARATOR . $tag->img);
            }

            //Insert Img.
            $tag->img = $fileName;
        }

        $tag->name = $request->input('name');
        $tag->description = $request->input('name');
        $tag->save();
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
        $tag = Tag::find($id);
        // return json data.
        if (file_exists(public_path('themes' . DIRECTORY_SEPARATOR . 'tags') . DIRECTORY_SEPARATOR . $tag->img)) {
            @unlink(public_path('themes' . DIRECTORY_SEPARATOR . 'tags') . DIRECTORY_SEPARATOR . $tag->img);
        }
        if($tag->delete()){
            
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
        $table = (new Tag)->getTable();
        $db_prefix =  env('DB_TABLE_PREFIX');
        DB::statement('ALTER TABLE '. $db_prefix.$table .' AUTO_INCREMENT = 0');
    }
}
