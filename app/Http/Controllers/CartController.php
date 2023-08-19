<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Tag;
use Session;

class CartController extends Controller
{
    public function index() {
        $cart = NULL;
        if(Session::has('cart')){
            $cart = Session::get('cart');
            $prod = new Product;
        }
        $tags = Tag::all();
        return view('front.cart.index', compact('cart', 'prod', 'tags'));
    }
    
    public function remove(Request $request) {
        $total = 0;
        if(Session::has('cart')){
            $cart = Session::get('cart');
            unset($cart['items'][$request->input('id')][$request->input('key')]);
            $cart['nbr'] -= 1;
            Session::put('cart', $cart);
            $total = $this->total(1);
        }

        return response()->json([
            'status' => 'success',
            'nbr' => $cart['nbr'],
            'order_total' => number_format($total, 3)
        ]);
    }
        
    public function qty(Request $request) {
        
        $total = 0;
        if(Session::has('cart')){
            $cart = Session::get('cart');
            $cart['items'][$request->input('id')][$request->input('key')]['qty'] = $request->input('qty') ;
            $cart['items'][$request->input('id')][$request->input('key')]['total'] = $request->input('qty') * $cart['items'][$request->input('id')][$request->input('key')]['pu'];
            
            Session::put('cart', $cart);
            $total = $this->total(1);
        }

        return response()->json([
            'status' => 'success',
            'total' => number_format($cart['items'][$request->input('id')][$request->input('key')]['total'], 3),
            'order_total' => number_format($total, 3)
        ]);
    }
    
    static function array_equal(array $a, array $b) {
        return (
            is_array($a) 
            && is_array($b) 
            && count($a) == count($b) 
            && serialize($a) === serialize($b)
        );
    }

    /**
     * 
     */
    public function cart(Request $request, $save)
    {
        
        $_price = 0;
        $_parfum_price = 0;
        $_decor_price = 0;
        $total = 0;
        $parfumArray = array();
        $decorArray = array();
        // check item existence.
        $product = Product::find($request->input('id'));
        if(is_null($product)){
            return response()->json([
                'status' => 'failed',
                'info'   => 'Le produit n\'est pas existe.'
            ]);
        }

        // product by dimensions.
        if($product->price_by_size){

            //get selected dimension
            $_dimension = $request->input('dimension');

            $_price = $product->productSizePrices->where('id', $_dimension )->first()->price;
            $_dimension_id = $product->productSizePrices->where('id', $_dimension )->first()->size_id;

        // only a default price.
        }elseif(!$product->price_by_size && $product->default_price){

            $_price = $product->default_price;

        }else{

            // No default/size price.
            $_price = NULL;
        }

        // check Parfums/Decors existence.
        $productParfums = collect([]);
        $productDecors = collect([]);

        if(!empty($product->productComponents)){

            // get all components.
            list($productParfums, $productDecors) = $product->productComponents->partition(function ($item) {
                return $item->component->category == 'C';
            });

            // Product contain parfums.
            if($productParfums->isNotEmpty() && !empty($request->input('parfums')) ){
                
                // Parfum price not by size.
                if (!$productParfums->first()->price_by_size){
                    
                    // get parfum price.
                    $_parfum_price = $productParfums->where('id', $request->input('parfums') )->first()->default_price;
                    $parfumArray = array(
                        'parfum_dimension' => 0,
                        'product_component_id' => $request->input('parfums'),
                        'price' => number_format($_parfum_price, 3, '.', '')
                    );

                // Parfum price is by size.
                }else{

                    // Get selected parfum id.
                    $_parfum_id = $request->input('parfums');

                    if(!$product->price_by_size){

                        $_parfum_dimension = $request->input('dimension2');
                        foreach ($productParfums->where('component_id', $_parfum_id) as $item) {
                            if(!empty($item->productComponentPrices->where('size_id', $_parfum_dimension)->first())){
                                $_parfum_price = $item->productComponentPrices->where('size_id', $_parfum_dimension)->first()->price;
                                $_product_component_id = $item->productComponentPrices->where('size_id', $_parfum_dimension)->first()->product_component_id;
                            }
                            
                        }

                        $parfumArray = array(
                            'parfum_dimension' => 1,
                            'product_component_id' => $_product_component_id,
                            'component_id' => $_parfum_id,
                            'dimension_id' => $_parfum_dimension,
                            'price' => number_format($_parfum_price, 3, '.', '')
                        );                            
                        
                    }else{
                        foreach ($productParfums->where('component_id', $_parfum_id) as $item) {
                            if( !empty($item->productComponentPrices->where('size_id', $_dimension_id)->first() )){
                                $_parfum_price = $item->productComponentPrices->where('size_id', $_dimension_id)->first()->price;
                                $_product_component_id = $item->productComponentPrices->where('size_id', $_dimension_id)->first()->product_component_id;
                            }
                                
                        }
                        $parfumArray = array(
                            'parfum_dimension' => 1,
                            'product_component_id' => $_product_component_id,
                            'component_id' => $_parfum_id,
                            'dimension_id' => $_dimension_id,
                            'price' => number_format($_parfum_price, 3, '.', '')
                        );
                    }
                }
            }
            
            // Product contain parfums.
            if($productDecors->isNotEmpty() && !empty($request->input('decors')) ){
                
                // Parfum price not by size.
                if (!$productDecors->first()->price_by_size){
                    
                    // get parfum price.
                    $_decor_price = $productDecors->where('id', $request->input('decors') )->first()->default_price;
                    // var_dump($_decor_price);
                    $decorArray = array(
                        'decor_dimension' => 0,
                        'product_component_id' => $request->input('decors'),
                        'price' => number_format($_decor_price, 3, '.', '')
                    );

                // Parfum price is by size.
                }else{

                    // Get selected parfum id.
                    $_decor_id = $request->input('decors');

                    if(!$product->price_by_size){

                        $_decor_dimension = $request->input('dimension2');

                        foreach ($productDecors->where('component_id', $_decor_id) as $item) {
                            if(!empty($item->productComponentPrices->where('size_id', $_decor_dimension)->first())){
                                $_decor_price = $item->productComponentPrices->where('size_id', $_decor_dimension)->first()->price;
                                $_product_component_id = $item->productComponentPrices->where('size_id', $_decor_dimension)->first()->product_component_id;
                            }
                            
                        }
                        $decorArray = array(
                            'decor_dimension' => 1,
                            'product_component_id' => $_product_component_id,
                            'component_id' => $_decor_id,
                            'dimension_id' => $_decor_dimension,
                            'price' => number_format($_decor_price, 3, '.', '')
                        );
                        
                    }else{
                        foreach ($productDecors->where('component_id', $_decor_id) as $item) {
                            if( !empty($item->productComponentPrices->where('size_id', $_dimension_id)->first() )){
                                $_decor_price = $item->productComponentPrices->where('size_id', $_dimension_id)->first()->price;
                                $_product_component_id = $item->productComponentPrices->where('size_id', $_dimension_id)->first()->product_component_id;
                            }
                                
                        }
                        $decorArray = array(
                            'decor_dimension' => 1,
                            'product_component_id' => $_product_component_id,
                            'component_id' => $_decor_id,
                            'dimension_id' => $_dimension_id,
                            'price' => number_format($_decor_price, 3, '.', '')
                        );
                    }
                }
            }

        }

        // calc.
        $pu = $_price + $_parfum_price + $_decor_price;
        $qty = $request->input('qty');
        $total = number_format(($pu * $qty), 3, '.', '');
        $item = array(
            'qty' => $request->input('qty'),
            'pu' => number_format($pu, 3, '.', ''),
            'parfums' => $parfumArray ,
            'decors' => $decorArray ,
            'msg' => $request->input('item-msg'),
            'total' => $total
        );
        if($product->price_by_size){
            $item['dimension'] = $_dimension_id;
        }

        $cart_qty = 0;
        $nbr = 0;
        if($save){
            if($request->session()->has('cart') && !empty($request->session()->get('cart'))){

                $array_item = $item;
                unset($array_item['qty']);
                unset($array_item['total']);

                $cart = $request->session()->get('cart');
                // $request->session()->push('cart.items', $item);
                $checkExists = false;
                $existItem = -1;
                if(!array_key_exists($product->id, $cart['items'])){
                    $checkExists = false;
                }else{
                    
                    foreach ($cart['items'][$product->id] as $key => $array) {

                        $array_item_2 = $array;
                        unset($array_item_2['qty']);
                        unset($array_item_2['total']);

                        if(self::array_equal($array_item_2, $array_item)){
                            $checkExists = true;
                            $existItem = $key;
                        }
                    }
                }
                if($checkExists){

                    //increase Qty.
                    $cart['items'][$product->id][$existItem]['qty'] += $item['qty'];
                    $cart['items'][$product->id][$existItem]['total'] = $cart['items'][$product->id][$existItem]['qty'] * $cart['items'][$product->id][$existItem]['pu'];
                }else{

                    $cart['items'][$product->id][] = $item;
                }
                

            }else{

                // Init cart.

                $cart = array(
                    'items' => array(
                        $product->id => array(
                            $item
                        )
                    ),
                    'total' => $total
                );

                
            }
            
            foreach ($cart['items'] as $product) {
                foreach ($product as $item) {
                    $nbr += 1 ;
                }
            }
            $cart['nbr'] = $nbr;

            // set the session.
            $request->session()->put('cart', $cart);

            
            // recalculate the total.
            $this->total();
        }
        return response()->json([
            'status' => 'success',
            'nbr' => $nbr,
            'total' => number_format($item['total'], 3)
        ]);
        
    }
    
    public function total($param = null)
    {
        $total = 0 ;

        if(Session::has('cart')){
            $session_cart = Session::get('cart');
            // var_dump($session_cart);
            foreach ($session_cart['items'] as $item) {
                foreach ($item as $key => $product) {
                    $total += number_format( ($product["pu"]*$product["qty"]), 3, '.', '');
                }
            }
            $session_cart['total'] = number_format($total, 3, '.', '');

            // re set the session
            Session::put('cart', $session_cart);

            if(!is_null($param)){
                return $total;
            }
        }
    }    
    public function destroy()
    {
        if(Session::has('cart')){
            session()->forget('cart');
            // session()->flush();
        }
    }
    
    public function order($id)
    {
        // show the view and pass the data to it
        return view('front.cart.order', compact('id'));
    }
}
