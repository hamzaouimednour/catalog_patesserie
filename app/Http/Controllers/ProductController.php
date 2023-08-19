<?php

namespace App\Http\Controllers;

use App\Classes\ImageResize;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Session;
use Auth;

use App\Models\Product;
use App\Models\Tag;
use App\Models\SubTag;
use App\Models\Size;
use App\Models\ProductComponent;
use App\Models\ProductComponentPrice;
use App\Models\ProductSizePrice;
use App\Models\ProductImg;
use App\Models\ProductTag;
use App\Models\ProductSubTag;
use App\Models\Component;

use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the data
        $products = Product::all();
        $sizes = Size::all();
        $components = Component::all();
        $parfums = $components->where('category', 'C');
        $decors = $components->where('category', 'D');
        $tags = Tag::all();
        // $sub_tags = SubTag::all();

        // show the view and pass the data to it
        return view('backend.products.index', compact('products', 'sizes', 'parfums', 'decors', 'tags'));
    }
    
    public static function thumb($img)
    {
        $thumb = new ImageResize(public_path('thumbs') . DIRECTORY_SEPARATOR . $img);
        $thumb->resize(240, 336);
        $thumb->save(public_path('thumbs') . DIRECTORY_SEPARATOR . 'thumb-' . $img);
    }
    
    public function all($type = null, $cat = null, $sort = null)
    {
        $status = 1;
        $req = ['type' => $type,'cat' => $cat, 'sort' => $sort ];

        // get the data
        if(!is_null($cat) && $cat != "all"){

            if($type == 'tag'){
                $tag = Tag::find(preg_replace('/[^0-9]/', '', $cat));
            }else{
                $tag = SubTag::find(preg_replace('/[^0-9]/', '', $cat));
            }
            
            if(is_null($tag)){
                return redirect('products/all');
            }
            if($type == 'tag'){
                $products = Product::join('product_tags', 'products.id', '=', 'product_tags.product_id')
                                ->join('product_imgs', 'products.id', '=', 'product_imgs.product_id')
                                ->where('product_tags.tag_id', '=', preg_replace('/[^0-9]/', '', $cat))
                                ->select('product_imgs.*', 'product_tags.*', 'products.*')
                                ->get();
            }else{
                $products = Product::join('product_sub_tags', 'products.id', '=', 'product_sub_tags.product_id')
                                ->join('product_imgs', 'products.id', '=', 'product_imgs.product_id')
                                ->where('product_sub_tags.sub_tag_id', '=', preg_replace('/[^0-9]/', '', $cat))
                                ->select('product_imgs.*', 'product_sub_tags.*', 'products.*')
                                ->get();
            }
        }else{
            $products = Product::where('status', $status)->get();
        }

        // $links = $products->links();
        // $current_page = $products->currentPage();

        if($sort == "asc"){
            $products = $products->sortBy('default_price');
        }elseif($sort == "desc"){
            $products = $products->sortByDesc('default_price');
        }elseif($sort == "ref"){
            $products = $products->sortBy('ref');
        }else{
            $products = $products->sortByDesc('created_at');
        }
        $tags = Tag::all();
        $items_nbr = $products->count();
        $controller = $this;
        
        $cart = null;
        if(Session::has('cart')){
            $cart = Session::get('cart');
        }

        // show the view and pass the data to it
        return view('front.products.index', compact('controller', 'products', 'tags', 'items_nbr', 'req', 'cart'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        if(is_null(Auth::user())){
            return response()->json([
                'status' => 'failed'
            ]);
        }
        
            if(
                ( count(array_filter($request->input('parfum'))) != count(array_filter($request->input('parfum-price'))) )
                ||
                (
                    (count(array_filter($request->input('p-parfum'))) != count(array_filter($request->input('p-parfum-dimension'))))
                    &&
                    (count(array_filter($request->input('p-parfum'))) != count(array_filter($request->input('p-parfum-price'))))
                )
            ){
                return response()->json([
                    'status' => 'failed',
                    'error' => 'Verifier les champs des Parfums.'
                ]);
            }
            if(
                ( count(array_filter($request->input('decors'))) != count(array_filter($request->input('decors-price'))) )
                ||
                (
                    (count(array_filter($request->input('p-decors'))) != count(array_filter($request->input('p-decors-dimension'))))
                    &&
                    (count(array_filter($request->input('p-decors'))) != count(array_filter($request->input('p-decors-price'))))
                )
            ){
                return response()->json([
                    'status' => 'failed',
                    'error' => 'Verifier les champs des Accessoires Décoratifs.'
                ]);
            }
        //temporary instead of Auth::id() 
        $request->merge(["company_id" => DB::table('company')->value('id')]);
        
        $fileName = 'default.png';
        $thumbImg = 0;
        if($request->hasFile('img')){
            
            $file = $request->file('img');
            $fileName = time() . "-" . hash('fnv164', $file->getClientOriginalName()) . "." . $file->getClientOriginalExtension();
            if(!$file->move(public_path('thumbs'), $fileName)){
                return response()->json([
                    'status' => 'failed',
                    'error' => 'Upload Error. File could not be uploaded for some reason.'
                ]);
            }
            $thumb = new ImageResize(public_path('thumbs') . DIRECTORY_SEPARATOR . $fileName);
            $thumb->resize(240, 336);
            $thumb->save(public_path('thumbs') . DIRECTORY_SEPARATOR . 'thumb-' . $fileName);
            $thumbImg = 1;
            // var_dump(Storage::disk('public')->exists($fileName));
        }

        $product = new Product;
        $product->ref = $request->input('ref');
        $product->name = $request->input('name');
        $product->company_id = $request->input('company_id');

        //set default price
        $dimensions = $request->input('p-dimension');

        $price_by_size = array_combine($dimensions, $request->input('p-dimension-price'));
        
        $product->price_by_size = (int) ($request->input('price-dimension') && !empty(array_filter($price_by_size)));
        
        // var_dump($request->input('default-price'));
        // print_r($price_by_size[$request->input('default-price')]);
        // print_r($price_by_size);
        // exit;
        
        //check if ether price or price by size field.
        if(!empty(array_filter($price_by_size)) || !empty($request->input('price'))){
            if($product->price_by_size){
                $product->default_price = number_format(($price_by_size[$request->input('default-price')]/1000),3, ".", "");
            }else{
                $product->default_price = number_format(($request->input('price')/1000),3, ".", "");
            }
        }else{
            //No Prices.
            $product->price_by_size = '0'; // for ignoring inserting prices.
            $product->default_price = number_format((0/1000),3);
        }
        
        
        $product->description = $request->input('description');
        $product->status = $request->input('status');
        $product->save();

        //Insert Img.
        $img = new ProductImg;
        $img->product_id = $product->id;
        $img->img = $fileName;
        $img->thumb = $thumbImg;
        $img->save();


        // Insert prices.
        // if zero noop.
        if($product->price_by_size){
            foreach ($price_by_size as $key => $value) {
                if(!empty($key)) {
                    $dataSize[] = array(
                        'product_id' => $product->id,
                        'size_id' => $key,
                        'price' => number_format(($value/1000),3, ".", ""),
                        'default' => (int) ($request->input('default-price') == $key),
                        'status' => '1'
                    );
                }
                
            }
            ProductSizePrice::insert($dataSize);
        }

        // Insert tags.
        if(!empty($request->input('tags'))){
            foreach ($request->input('tags') as $value) {
                if(!empty($value)){
                    $dataTags[] = array(
                        'product_id' => $product->id,
                        'tag_id' => $value,
                        'status' => '1'
                    );
                }

            }
        
            ProductTag::insert($dataTags);
        }

        // Insert sub_tags.
        if(!empty($request->input('sub_tags'))){
            foreach ($request->input('sub_tags') as $value) {
                if(!empty($value)){
                    $dataSubTags[] = array(
                        'product_id' => $product->id,
                        'sub_tag_id' => $value,
                        'status' => '1'
                    );
                }

            }
        
            ProductSubTag::insert($dataSubTags);
        }
        
        //Insert parfums.
        if( 
            (
                !empty(array_filter($request->input('p-parfum'))) 
                && 
                !empty(array_filter($request->input('p-parfum-dimension'))) 
                && 
                !empty(array_filter($request->input('p-parfum-price')))
            ) 
            || 
            (
                !empty(array_filter($request->input('parfum'))) 
                && 
                !empty(array_filter($request->input('parfum-price')))) 
        ){
            if($request->input('parfum-dimension')){

                $parfums = $request->input('p-parfum');
                $dimensions = $request->input('p-parfum-dimension');
                $prices = $request->input('p-parfum-price');

                $p_data = array_map(function ($parfums, $dimensions, $prices) {
                    return array_combine(
                        ['parfum', 'dimension', 'price'],
                        [$parfums, $dimensions, $prices]
                    );
                }, $parfums, $dimensions, $prices);

                list($d_parfum, $d_size) = explode("-", $request->input('default-price-parfum-g2'));
                
                foreach ($p_data as $key => $value) {

                    $d_price = ($value['parfum'] == $d_parfum && $value['dimension'] == $d_size) ? number_format(($value['price']/1000),3, ".", "") : 0;
                    
                    if(!empty($value['parfum']) && $value['dimension']){
                   
                        $item = new ProductComponent;
                        $item->product_id = $product->id;
                        $item->component_id = $value['parfum'];
                        $item->price_by_size = '1';
                        $item->default_price = $d_price;
                        $item->default = (int) ($value['parfum'] == $d_parfum && $value['dimension'] == $d_size);
                        $item->status = '1';
                        $item->save();

                        $item_price = new ProductComponentPrice;
                        $item_price->product_component_id = $item->id;
                        $item_price->size_id = $value['dimension'];
                        $item_price->price = number_format(($value['price']/1000),3, ".", "");
                        $item_price->save();
                    }

                }
            }else{
                $parfums = array_combine(
                    $request->input('parfum'),
                    $request->input('parfum-price')
                );
                foreach ($parfums as $key => $value) {
                    if(!empty($key)){
                        $dataParfums[] = array(
                            'product_id' => $product->id,
                            'component_id' => $key,
                            'price_by_size' => '0',
                            'default_price' => number_format(($value/1000),3, ".", ""),
                            'default' => (int) ($request->input('default-price-parfum-g1') == $key),
                            'status' => '1'
                        );
                    }

                }
                ProductComponent::insert($dataParfums);
            }

        }
        //Insert decors.
        if( 
            (
                !empty(array_filter($request->input('p-decors'))) 
                && 
                !empty(array_filter($request->input('p-decors-dimension'))) 
                && 
                !empty(array_filter($request->input('p-decors-price')))
            ) 
            || 
            (
                !empty(array_filter($request->input('decors'))) 
                && 
                !empty(array_filter($request->input('decors-price')))) 
        ){
            if($request->input('decors-dimension')){

                $decors = $request->input('p-decors');
                $dimensions = $request->input('p-decors-dimension');
                $prices = $request->input('p-decors-price');

                $d_data = array_map(function ($decors, $dimensions, $prices) {
                    return array_combine(
                        ['decor', 'dimension', 'price'],
                        [$decors, $dimensions, $prices]
                    );
                }, $decors, $dimensions, $prices);

                list($d_decor, $d_size) = explode("-", $request->input('default-price-decor-g2'));
                
                foreach ($d_data as $key => $value) {

                    $d_price = ($value['decor'] == $d_decor && $value['dimension'] == $d_size) ? number_format(($value['price']/1000),3, ".", "") : 0;
                    
                    if(!empty($value['decor']) && !empty($value['dimension'])){
                        $item = new ProductComponent;
                        $item->product_id = $product->id;
                        $item->component_id = $value['decor'];
                        $item->price_by_size = '1';
                        $item->default_price = $d_price;
                        $item->default = (int) ($value['decor'] == $d_decor && $value['dimension'] == $d_size);
                        $item->status = '1';
                        $item->save();

                        $item_price = new ProductComponentPrice;
                        $item_price->product_component_id = $item->id;
                        $item_price->size_id = $value['dimension'];
                        $item_price->price = number_format(($value['price']/1000),3, ".", "");
                        $item_price->save();
                    }

                }
            }elseif(!empty(array_filter($request->input('decors')))){
                $decors = array_combine(
                    $request->input('decors'),
                    $request->input('decors-price')
                );
                foreach ($decors as $key => $value) {
                    if(!empty( $key)){
                        $dataDecors[] = array(
                            'product_id' => $product->id,
                            'component_id' => $key,
                            'price_by_size' => '0',
                            'default_price' => number_format(($value/1000),3, ".", ""),
                            'default' => (int) ($request->input('default-price-decor-g1') == $key),
                            'status' => '1'
                        );
                    }
                }
                ProductComponent::insert($dataDecors);
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
        $product = Product::find($id);

        // show the view and pass the data to it
        if(is_null($product)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        $productParfums = collect([]);
        $productDecors = collect([]);
        $productTags = collect([]);
        $productSubTags = collect([]);

        if(!empty($product->productComponents))
        list($productParfums, $productDecors) = $product->productComponents->partition(function ($item) {
            return $item->component->category == 'C';
        });

        if(!empty($product->productTags))
        $productTags = $product->productTags->pluck('tag_id');

        $sizes = Size::all();
        $components = Component::all();
        $parfums = $components->where('category', 'C');
        $decors = $components->where('category', 'D');
        $tags = Tag::all();
        $sub_tags = SubTag::whereIn('tag_id', $productTags)->get();

        if(!empty($product->productSubTags))
        $productSubTags = $product->productSubTags->pluck('sub_tag_id');

        // show the view and pass the data to it
        return view('backend.products.show', compact(
            'product',
            'sizes',
            'parfums',
            'decors',
            'tags',
            'sub_tags',
            'productParfums',
            'productDecors',
            'productTags',
            'productSubTags'
        ));
    }
    
    /**
     * Display the specified resource to Json.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fetch($id)
    {
        // get the data
        $product = Product::find($id);

        // show the view and pass the data to it
        if(is_null($product)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        $productParfums = collect([]);
        $productDecors = collect([]);
        $productTags = collect([]);

        //get Tags.
        if(!empty($product->productComponents))
        list($productParfums, $productDecors) = $product->productComponents->partition(function ($item) {
            return $item->component->category == 'C';
        });

       
        //get Tags.
        if(!empty($product->productTags)){
            $productTagsId = $product->productTags->pluck('tag_id')->toArray();
            $productTags = Tag::select('id', 'name')->whereIn('id', $productTagsId)->where('status', '1')->get();

        }

        //get Prices By Sizes.


        //get Parfums By Sizes.
        //get Decors By Sizes.

        //get Dimension where no price by size.
        $parfums_dimensions = collect([]);
        $decors_dimensions = collect([]);
        if ($productParfums->isNotEmpty() && $productParfums->first()->price_by_size && !$product->price_by_size){            
            $parfums_dimensions = ProductComponentPrice::whereIn('product_component_id', $productParfums->pluck('id')->toArray())->get();

        }
        if ($productDecors->isNotEmpty() && $productDecors->first()->price_by_size && !$product->price_by_size){
            if ($productParfums->isEmpty() || !$productParfums->first()->price_by_size)
            
            $decors_dimensions = ProductComponentPrice::whereIn('product_component_id', $productDecors->pluck('id')->toArray())->get();

        }
        
        return view('front.products.show', compact(
            'product',
            'productParfums',
            'productDecors',
            'productTags',
            'parfums_dimensions',
            'decors_dimensions'
        ));
    }
    
    public function items(Request $request)
    {
        // get the data
        $product = Product::find($request->input('id'));

        // show the view and pass the data to it
        if(is_null($product)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        $productParfums = collect([]);
        $productDecors = collect([]);

        if(!empty($product->productComponents))
        list($productParfums, $productDecors) = $product->productComponents->partition(function ($item) {
            return $item->component->category == 'C';
        });

        

        if($product->price_by_size){

            //get selected dimension
            $_dimension = $request->input('dimension');

            $_dimension_id = $product->productSizePrices->where('id', $_dimension )->first()->size_id ;
            $parfums_str = '<option value="" selected>Sélectionnez un choix</option>';
            $decors_str = '<option value="" selected>Sélectionnez un choix</option>';

        }else{
            if(!empty($request->input('dimension2'))){

                $_dimension_id = $request->input('dimension2');
                $parfums_str = '<option value="" selected>Sélectionnez un choix</option>';
                $decors_str = '<option value="" selected>Sélectionnez un choix</option>';
            }
        }
            $parfums_spec = array();
            $decors_spec = array();
            

            if($productParfums->isNotEmpty() && $productParfums->first()->price_by_size){
                foreach ($productParfums as $item) {
                    if($item->productComponentPrices->first()->size_id == $_dimension_id){
                        $parfums_spec[] = array(
                            'component_id' => $item->component_id,
                            'component_name' => $item->Component->name
                        );
                        if($product->price_by_size){
                            $parfums_str .= '<option value="'.$item->component_id.'">'.$item->Component->name.'</option>';
                        }else{
                            $parfums_str .= '<option value="'.$item->component_id.'" '.(($item->default) ? 'selected' : NULL).'>'.$item->Component->name.'</option>';
                        }
                        
                    }
                }
            }
            if($productDecors->isNotEmpty() && $productDecors->first()->price_by_size){
                foreach ($productDecors as $item) {
                    if($item->productComponentPrices->first()->size_id == $_dimension_id){
                        $decors_spec[] = array(
                            'component_id' => $item->component_id,
                            'component_name' => $item->Component->name
                        );
                        $decors_str .= '<option value="'.$item->component_id.'">'.$item->Component->name.'</option>';
                    }
                }
            }
        return response()->json([
            'status' => 'success',
            'parfums' => $parfums_spec,
            'decors' => $decors_spec,
            'parfums_str' => $parfums_str,
            'decors_str' => $decors_str
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
        $product = Product::find($request->input('id'));

        if(is_null($product)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        Product::where('id', $request->input('id'))->update(['status' => $request->input('status')]);
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
        $product = Product::find($id);

        // show the view and pass the data to it
        return view('backend.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        if(is_null(Auth::user())){
            return response()->json([
                'status' => 'failed',
                'info' => "s'il vous plaît l'authentification est requise"
            ]);
        }
        $db_prefix =  env('DB_TABLE_PREFIX'); //cp_

        //check item existence.
        $product  = Product::findOrFail($id);
        if(is_null($product)){
            return response()->json([
                'status' => 'failed'
            ]);
        }
        
            if(
                ( count(array_filter($request->input('parfum'))) != count(array_filter($request->input('parfum-price'))) )
                ||
                (
                    (count(array_filter($request->input('p-parfum'))) != count(array_filter($request->input('p-parfum-dimension'))))
                    &&
                    (count(array_filter($request->input('p-parfum'))) != count(array_filter($request->input('p-parfum-price'))))
                )
            ){
                return response()->json([
                    'status' => 'failed',
                    'error' => 'Verifier les champs des Parfums.'
                ]);
            }
            if(
                ( count(array_filter($request->input('decors'))) != count(array_filter($request->input('decors-price'))) )
                ||
                (
                    (count(array_filter($request->input('p-decors'))) != count(array_filter($request->input('p-decors-dimension'))))
                    &&
                    (count(array_filter($request->input('p-decors'))) != count(array_filter($request->input('p-decors-price'))))
                )
            ){
                return response()->json([
                    'status' => 'failed',
                    'error' => 'Verifier les champs des Accessoires Décoratifs.'
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

            //remove old img.
            $imgc = new ProductImg;
            $imgc->where('product_id', $product->id)->get()->first();
            // if (file_exists(public_path('thumbs') . $imgc->img)) {
            if (file_exists(public_path('thumbs') . DIRECTORY_SEPARATOR . $imgc->img)) {
                @unlink(public_path('thumbs') . DIRECTORY_SEPARATOR . $imgc->img);
            }
            DB::table($imgc->getTable())->where('product_id', $product->id)->delete();
            
            if (file_exists(public_path('thumbs') . DIRECTORY_SEPARATOR . 'thumb-' . $imgc->img)) {
                @unlink(public_path('thumbs') . DIRECTORY_SEPARATOR . 'thumb-' . $imgc->img);
            }

            $thumbImg = 0;
            $thumb = new ImageResize(public_path('thumbs') . DIRECTORY_SEPARATOR . $fileName);
            $thumb->resize(240, 336);
            $thumb->save(public_path('thumbs') . DIRECTORY_SEPARATOR . 'thumb-' . $fileName);
            $thumbImg = 1;

            //Insert Img.
            $img = new ProductImg;
            $img->product_id = $product->id;
            $img->img = $fileName;
            $img->thumb = $thumbImg;
            $img->save();
        }

        //Initialize product.
        $product->ref = $request->input('ref');
        $product->name = $request->input('name');

        //set default price
        $dimensions = $request->input('p-dimension');

        $price_by_size = array_combine($dimensions, $request->input('p-dimension-price'));
                
        $product->price_by_size = (int) ($request->input('price-dimension') && !empty(array_filter($price_by_size)));

        //remove old prices.
        if($product->price_by_size == "1"){
            DB::table((new ProductSizePrice)->getTable())->where('product_id', $product->id)->delete();
        }

        //check if ether price or price by size field.
        if(!empty(array_filter($price_by_size)) || !empty($request->input('price'))){
            if($product->price_by_size){
                $product->default_price = number_format(($price_by_size[$request->input('default-price')]/1000),3, ".", "");
            }else{
                $product->default_price = number_format(($request->input('price')/1000),3, ".", "");
            }
        }else{
            //No prices.
            $product->price_by_size = '0'; // for ignoring inserting prices.
            $product->default_price = number_format((0/1000),3);
        }
        $product->description = $request->input('description');

        if(!$product->save()){
            return response()->json([
                'status' => 'failed',
                'error' => 'Product save error.'
            ]);
        }

        // Insert prices.
        // if zero noop.
        if($product->price_by_size){
            foreach ($price_by_size as $key => $value) {
                $dataSize[] = array(
                    'product_id' => $product->id,
                    'size_id' => $key,
                    'price' => number_format(($value/1000),3, ".", ""),
                    'default' => (int) ($request->input('default-price') == $key),
                    'status' => '1'
                );
            }
            ProductSizePrice::insert($dataSize);
        }

        // Insert tags.
        if(!empty($request->input('tags'))){

            //remove old tags.
            DB::table((new ProductTag)->getTable())->where('product_id', $product->id)->delete();
            
            foreach ($request->input('tags') as $value) {
                $dataTags[] = array(
                    'product_id' => $product->id,
                    'tag_id' => $value,
                    'status' => '1'
                );
            }
            ProductTag::insert($dataTags);
        }

        // Insert Subtags.
        if(!empty($request->input('sub_tags'))){

            //remove old tags.
            DB::table((new ProductSubTag)->getTable())->where('product_id', $product->id)->delete();
            
            foreach ($request->input('sub_tags') as $value) {
                $dataSubTags[] = array(
                    'product_id' => $product->id,
                    'sub_tag_id' => $value,
                    'status' => '1'
                );
            }
            ProductSubTag::insert($dataSubTags);
        }


        //Insert parfums.
        if(
            (
                $request->input('parfum-dimension') == 1
                &&
                !empty(array_filter($request->input('p-parfum'))) 
                && 
                !empty(array_filter($request->input('p-parfum-dimension'))) 
                && 
                !empty(array_filter($request->input('p-parfum-price')))
                
            ) 
            || 
            (
                $request->input('parfum-dimension') == 0
                &&
                !empty(array_filter($request->input('parfum'))) 
                && 
                !empty(array_filter($request->input('parfum-price')))
                
            ) 
        ){
            /**
             * remove all old parfums.
             * this with auto remove all ProductComponentPrices if exist.
             */
            DB::table((new ProductComponent)->getTable())
                ->join('components', 'components.id', '=', 'product_components.component_id')
                ->where('product_id', $product->id)
                ->where('components.category', 'C')
                ->delete();

            /**
             * Parfum par dimension.
             */
            if($request->input('parfum-dimension')){

                $parfums = $request->input('p-parfum');
                $dimensions = $request->input('p-parfum-dimension');
                $prices = $request->input('p-parfum-price');

                $p_data = array_map(function ($parfums, $dimensions, $prices) {
                    return array_combine(
                        ['parfum', 'dimension', 'price'],
                        [$parfums, $dimensions, $prices]
                    );
                }, $parfums, $dimensions, $prices);

                list($d_parfum, $d_size) = explode("-", $request->input('default-price-parfum-g2'));
                
                foreach ($p_data as $key => $value) {

                    $d_price = ($value['parfum'] == $d_parfum && $value['dimension'] == $d_size) ? number_format(($value['price']/1000),3, ".", "") : 0;
                    
                    // check not empty $item->component_id value.
                    if(!empty($value['parfum']) && !empty($value['dimension'])){
                        $item = new ProductComponent;
                        $item->product_id = $product->id;
                        $item->component_id = $value['parfum'];
                        $item->price_by_size = '1';
                        $item->default_price = $d_price;
                        $item->default = (int) ($value['parfum'] == $d_parfum && $value['dimension'] == $d_size);
                        $item->status = '1';
                        $item->save();

                        $item_price = new ProductComponentPrice;
                        $item_price->product_component_id = $item->id;
                        $item_price->size_id = $value['dimension'];
                        $item_price->price = number_format(($value['price']/1000),3, ".", "");
                        $item_price->save();
                    }

                }
            }else{

                /**
                 * Parfum par prix.
                 */
                $parfums = array_combine(
                    $request->input('parfum'),
                    $request->input('parfum-price')
                );
                foreach ($parfums as $key => $value) {
                    if(!empty($key)){
                        $dataParfums[] = array(
                            'product_id' => $product->id,
                            'component_id' => $key,
                            'price_by_size' => '0',
                            'default_price' => number_format(($value/1000),3, ".", ""),
                            'default' => (int) ($request->input('default-price-parfum-g1') == $key),
                            'status' => '1'
                        );
                    }
                    
                }

                ProductComponent::insert($dataParfums);
            }

        }
        
        //Insert decors.
        if( 
            (
                $request->input('decors-dimension') == 1
                &&
                !empty(array_filter($request->input('p-decors'))) 
                && 
                !empty(array_filter($request->input('p-decors-dimension'))) 
                && 
                !empty(array_filter($request->input('p-decors-price')))
            )
            || 
            (
                $request->input('decors-dimension') == 0
                &&
                !empty(array_filter($request->input('decors'))) 
                && 
                !empty(array_filter($request->input('decors-price')))
            ) 
        ){
            
            /**
             * remove all old Decors.
             * this with auto remove all ProductComponentPrices if exist.
             */
            DB::table((new ProductComponent)->getTable())
                ->join('components', 'components.id', '=', 'product_components.component_id')
                ->where('product_id', $product->id)
                ->where('components.category', 'D')
                ->delete();
            /**
             * Decor par dimension.
             */
            if($request->input('decors-dimension')){

                $decors = $request->input('p-decors');
                $dimensions = $request->input('p-decors-dimension');
                $prices = $request->input('p-decors-price');

                $d_data = array_map(function ($decors, $dimensions, $prices) {
                    return array_combine(
                        ['decor', 'dimension', 'price'],
                        [$decors, $dimensions, $prices]
                    );
                }, $decors, $dimensions, $prices);

                list($d_decor, $d_size) = explode("-", $request->input('default-price-decor-g2'));
                
                foreach ($d_data as $key => $value) {

                    $d_price = ($value['decor'] == $d_decor && $value['dimension'] == $d_size) ? number_format(($value['price']/1000),3, ".", "") : 0;
                    
                    if(!empty($value['decor']) && !empty($value['dimension'])){
                        $item = new ProductComponent;
                        $item->product_id = $product->id;
                        $item->component_id = $value['decor'];
                        $item->price_by_size = '1';
                        $item->default_price = $d_price;
                        $item->default = (int) ($value['decor'] == $d_decor && $value['dimension'] == $d_size);
                        $item->status = '1';
                        $item->save();

                        $item_price = new ProductComponentPrice;
                        $item_price->product_component_id = $item->id;
                        $item_price->size_id = $value['dimension'];
                        $item_price->price = number_format(($value['price']/1000),3, ".", "");
                        $item_price->save();
                    }
                }

            /**
             * Decor par prix.
             */
            }elseif(!empty(array_filter($request->input('decors')))){
                $decors = array_combine(
                    $request->input('decors'),
                    $request->input('decors-price')
                );
                foreach ($decors as $key => $value) {
                    if(!empty($key)){
                        $dataDecors[] = array(
                            'product_id' => $product->id,
                            'component_id' => $key,
                            'price_by_size' => '0',
                            'default_price' => number_format(($value/1000),3, ".", ""),
                            'default' => (int) ($request->input('default-price-decor-g1') == $key),
                            'status' => '1'
                        );
                    }
                }
                ProductComponent::insert($dataDecors);
            }
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
        $product = Product::find($id);
        // return json data.
        if($product->delete()){
            
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
        $table = (new Product)->getTable();
        $db_prefix =  env('DB_TABLE_PREFIX');
        DB::statement('ALTER TABLE '. $db_prefix.$table .' AUTO_INCREMENT = 0');
    }
}
