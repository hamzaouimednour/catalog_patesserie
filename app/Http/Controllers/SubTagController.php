<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\SubTag; // call the specific Model
use App\Models\Tag; // call the specific Model
use Session;

class SubTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the data
        $familles = Tag::all()->sortByDesc("id");
        $tags = SubTag::all()->sortByDesc("id");

        // show the view and pass the data to it
        return view('backend.sub-tags.index', compact('familles', 'tags'));
    }
    
    public function getSubTags($id)
    {
        $cart = Session::get('cart');
        $tags = Tag::all();
        $sub_tags = collect([]);
        $sub_tags = SubTag::where("tag_id", $id)->get()->sortByDesc("id");
        return view('front.sub-tags.index', compact('sub_tags', 'tags', 'cart'));

    }    
    public function get_items(Request $request)
    {
        if(!empty($request->input('tags'))){
            $sub_tags = SubTag::whereIn("tag_id", $request->input('tags'))->get();
            $data = "";
            foreach ($sub_tags as $item) {
                $data .= '<option value="'.$item->id.'">'.$item->name.'</option>';
            }
            return response()->json([
                'data' => $data,
                'status' => 'success'
            ], 200);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $fileName = 'default.png';
        if($request->hasFile('img')){
            $file = $request->file('img');
            $fileName = 'sub-' . time() . "-" . hash('fnv164', $file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
            if(!$file->move(public_path('themes' . DIRECTORY_SEPARATOR . 'tags'), $fileName)){
                return response()->json([
                    'status' => 'failed',
                    'error' => 'Upload Error. File could not be uploaded for some reason.'
                ]);
            }
        }

        $tag = new SubTag;
        $tag->tag_id = $request->input('tag_id');
        $tag->name = $request->input('name');
        $tag->img = $fileName;
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
        $tag = SubTag::find($id);

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

    public function status(Request $request)
    {
        // get the data
        $tag = SubTag::find($request->input('id'));

        if(is_null($tag)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        SubTag::where('id', $request->input('id'))->update(['status' => $request->input('status')]);
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
        //
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
        $tag  = SubTag::findOrFail($id);
        if(is_null($tag)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        if($request->hasFile('img')){
            
            $file = $request->file('img');
            $fileName = 'sub-' . time() . "-" . hash('fnv164', $file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
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
        $tag = SubTag::find($id);

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
