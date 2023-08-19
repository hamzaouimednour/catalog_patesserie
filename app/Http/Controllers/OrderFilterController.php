<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\SubTag;
use App\Models\Order;
use App\Models\Company;
use App\Models\CompanySection;

use Illuminate\Http\Request;

use Session;
use DB;

class OrderFilterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function filter(Request $request)
    {
        if($request->input('sections')==0 && $request->input('tags')==0 && $request->input('sub_tags')==0){
            return redirect('backend/orders');
        }
        $operations = ['=', 'LIKE', 'LIKE'];
        if($request->input('sections') == 0){
            $operations[0] = '<>';
        }
        if($request->input('tags') == 0){
            $operations[1] = '<>';
        }
        if($request->input('sub_tags') == 0){
            $operations[2] = '<>';
        }
        $orders = Order::join('order_filters', 'orders.id', '=', 'order_filters.order_id')
                        ->join('company_users', 'company_users.id', '=', 'order_filters.company_section_id')
                        ->where('company_users.company_section_id', $operations[0], $request->input('sections'))
                        ->where('order_filters.tags', $operations[1], '%' . $request->input('tags') . '%')
                        ->where('order_filters.sub_tags', $operations[2], '%' . $request->input('sub_tags') . '%')
                        ->select('orders.*')
                        ->get();
        $filters = array(
            'sections' => $request->input('sections'),
            'tags' => $request->input('tags'),
            'sub_tags' => $request->input('sub_tags')
        );
        // get the data
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
