<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Tag;
use App\Models\ProductTag;
use App\Models\ProductSubTag;
use App\Models\SubTag;
use App\Models\ProductComponentPrice;
use App\Models\Company;
use App\Models\CompanySection;
use App\Models\User;
use App\Models\CompanyUser;
use App\Models\OrderFilter;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Controllers\OrderUtilController;

use Session;
use DB;
use DateTime;
use Auth;

class OrderController extends Controller
{
    public function calc_acompte(Request $request){

        $cart = Session::get('cart');
        $reste = number_format($cart['total'], 3, '.', '') - number_format($request->input('acompte')/1000, 3, '.', '');
        return response()->json([
            'total' => number_format($reste,3)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the data
        $filters = [];
        $orders = Order::all();
        $tags = Tag::all();
        $sub_tags = SubTag::all();
        $sections = CompanySection::all();
        // show the view and pass the data to it
        return view('backend.orders.index', compact('filters', 'orders', 'tags', 'sub_tags', 'sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.orders.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        // get the data
        $product = Order::find($request->input('id'));

        if(is_null($product)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        Order::where('id', $request->input('id'))->update(['status' => $request->input('status')]);
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function status_get($id)
    {
        // get the data
        $order = Order::find($id);

        if(is_null($order)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data'   => array(
                'id' => $order->id,
                'status' => $order->status
            )
        ]);
    }

    public function remove_item($id)
    {
        // get the data
        $order = Order::find($id);

        if(is_null($order)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        $item = json_decode($request->input('item'), true);
        $cart = json_decode($order->product_components, true);
        unset($cart['items'][$item['key']][$item['index']]);
        if(empty($cart['items'][$item['key']])){
            unset($cart['items'][$item['key']]);
        }
        
        $cart['nbr'] -= 1;

        $util = new OrderUtilController;
        $util->total($cart);

        // update order.
        $order->product_components = json_encode($cart);
        $order->total = number_format($cart['total'], 3, '.', '');
        $order->save();

        return response()->json([
            'status' => 'success',
            'total' => number_format($order->total, 3),
            'reste' => number_format( ($cart['total']-$order->acompte),3)
        ]);
    }

    public function update_item(Request $request, $id)
    {
        // get the data
        $order = Order::find($id);

        if(is_null($order)){
            return response()->json([
                'status' => 'failed'
            ]);
        }
        $item = json_decode(base64_decode($request->input('item')), true);

        $cart = json_decode($order->product_components, true);

        $cart_item = $cart['items'][$item['key']][$item['index']];

        //update data.
        $util = new OrderUtilController;
        $util->cart($item, $cart_item, $cart, $request);

        // update order.
        $order->product_components = json_encode($cart);
        $order->total = number_format($cart['total'], 3, '.', '');
        $order->save();

        $item_id_pu = str_replace('=', '', base64_encode('{"field": "pu","key": '.$item['key'].', "index": '.$item['index'].'}'));
        $item_id_total = str_replace('=', '', base64_encode('{"field": "total","key": '.$item['key'].', "index": '.$item['index'].'}'));

        return response()->json([
            'status' => 'success',
            'data'  => [
                'item_id_pu' => $item_id_pu,
                'item_id_total' => $item_id_total,
                'total' => number_format($cart['items'][$item['key']][$item['index']]['total'],3),
                'cart_total' => number_format($cart['total'],3),
                'reste' => number_format( ($cart['total']-$order->acompte),3),
                'pu'    => number_format($cart['items'][$item['key']][$item['index']]['pu'],3)
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // get company user data
        $user = User::find(Auth::id());
        $section_id = $user->companyUsers->first()->id;
        // get customer data
        $customer = Customer::where('phone', '=', $request->input('customer-phone'))->first();
        if (is_null($customer)) {
            $customer = new Customer;
            $customer->name = $request->input('customer-name');
            $customer->phone = $request->input('customer-phone');
            if($request->has('customer-email')){
                $customer->email = $request->input('customer-email');
            }
            $customer->save();
        }
        
        $cart = Session::get('cart');

        $order = new Order;
        $order->company_id = DB::table('company')->value('id');
        $order->customer_id = $customer->id;
        $order->product_components = json_encode($cart);

        $dateTime = DateTime::createFromFormat('d/m/Y H:i', $request->input('delivery-date') . ' ' . $request->input('delivery-time'));
        $order->delivery_date =  $dateTime->format('Y-m-d H:i');

        $order->delivery_mode = $request->input('delivery-mode');
        $order->acompte = number_format($request->input('acompte')/1000,3,'.','');
        $order->acompte_type = $request->input('acompte-type');
        $order->cautionnement = number_format($request->input('cautionnement')/1000,3,'.','');
        $order->total = $cart['total'];

        $orderFormat = date('ymd').'.'.$customer->id. '.' . DB::table('orders')->where('customer_id', $customer->id)->count();
        $order->order_num = mb_strtoupper(hash('fnv132', $orderFormat));
        
        $order->save();


        $tags = array();
        $subtags = array();
        foreach ($cart['items'] as $id => $value) {
            // $product = Product::find($id);
            $tags_d = ProductTag::where('product_id', $id)->pluck('tag_id')->toArray();
            $subtags_d = ProductSubTag::where('product_id', $id)->pluck('sub_tag_id')->toArray();
            if(!empty($tags_d)){
                $tags[] = $tags_d;
            }
            if(!empty($subtags_d)){
                $subtags[] = $subtags_d;
            }
        }
        $order_filter = new OrderFilter;
        $order_filter->order_id = $order->id;
        $order_filter->company_section_id = $section_id;
        $order_filter->tags = json_encode($tags);
        $order_filter->sub_tags = json_encode($subtags);
        $order_filter->save();

        // show the view and pass the data to it
         return response()->json([
            'status' => 'success',
            'num' => $order->order_num,
            'id' => $order->id
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
        $order = Order::find($id);
        $prod = new Product;

        // show the view and pass the data to it
        return view('backend.orders.show', compact('order', 'prod'));
    }

    public function update_order($id)
    {
        // get the data
        $order = Order::find($id);
        $prod = new Product;
        $ProductComponentPrice = new ProductComponentPrice;

        // show the view and pass the data to it
        return view('backend.orders.edit', compact('order', 'prod', 'ProductComponentPrice' ));
    }
    
    public function edit_order(Request $request)
    {
        // get the data
        $order = Order::find($request->input('id'));
        if(is_null($order)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        $order->delivery_mode = $request->input('delivery_mode');
        $order->acompte = number_format($request->input('acompte')/1000, 3, '.', '');
        $order->cautionnement = number_format($request->input('cautionnement')/1000, 3, '.', '');
        $order->save();
        // show the view and pass the data to it
        return response()->json([
            'status' => 'success'
        ], 200);
    }

    public function calc_reste(Request $request)
    {
        // get the data
        $order = Order::find($request->input('id'));
        if(is_null($order)){
            return response()->json([
                'status' => 'failed'
            ]);
        }

        $reste = $order->total - number_format($request->input('acompte')/1000, 3, '.', '');
        // show the view and pass the data to it
        return response()->json([
            'status' => 'success',
            'reste' =>number_format($reste, 3) 
        ], 200);
    }    
    
    
    public function imprimer($id)
    {
        // get the data
        $order = Order::find($id);
        $prod = new Product;
        $company = Company::find($order->company_id);
        
        // show the view and pass the data to it.
        return view('front.order.index', compact('order', 'prod', 'company'));
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
        $order = Order::find($id);

        // show the view and pass the data to it
        return view('backend.orders.edit', compact('order'));
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
        //
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
        $order = Order::find($id);
        if($order->delete()){
            return redirect()->route('backend.orders')
                             ->with('success','Succès, Operation réussie.');
        }
        return redirect()->route('backend.orders')
                         ->with('failed','Échec, Operation échouée.');
    }
}
