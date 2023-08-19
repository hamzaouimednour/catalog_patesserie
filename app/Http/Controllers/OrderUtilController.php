<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class OrderUtilController extends Controller
{
    //Passing by Reference (&$cart)
    public function total(&$cart, $param = null)
    {
        $total = 0 ;
        // var_dump($cart);
        foreach ($cart['items'] as $item) {
            foreach ($item as $key => $product) {
                $total += $product["total"];
            }
        }
        $cart['total'] = $total;

        if(!is_null($param)){
            return $total;
        }
    }

    public function cart(array $itemArray, &$cart_item, &$cart, Request $request)
    {
        $_price = 0;
        $_parfum_price = 0;
        $_decor_price = 0;
        $total = 0;
        $parfumArray = array();
        $decorArray = array();

        // check item existence.
        $product = Product::find($itemArray['key']);
        if(is_null($product)){
            return false;
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
                        'price' => number_foramt($_decor_price, 3, '.', '')
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
        $total = $pu * $qty;
        $cart_item = array(
            'qty' => $qty,
            'pu' => number_format($pu, 3, '.', ''),
            'parfums' => $parfumArray ,
            'decors' => $decorArray ,
            'msg' => $request->input('item-msg'),
            'total' => number_format($total, 3, '.', '')
        );
        if($product->price_by_size){
            $cart_item['dimension'] = $_dimension_id;
        }

        $cart['items'][$itemArray['key']][$itemArray['index']] = $cart_item;

        // cart nbr items.
        $nbr = 0;
        foreach ($cart['items'] as $product) {
            foreach ($product as $item) {
                $nbr += 1 ;
            }
        }
        $cart['nbr'] = $nbr;
        
        // recalculate the total.
        $this->total($cart);

    }
}