<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Http\Requests\CustomerRequest;
use DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the data
        $_customers = DB::table('orders')
                        ->distinct()
                        ->join('customers', 'customers.id', '=', 'orders.customer_id')
                        ->where('orders.company_id', '=', 1)
                        ->select('customers.*')
                        ->get();

        $customers = collect([]);
        foreach ($_customers as $value) {
            $item =  new Customer((array) $value);
            $item->id = $value->id;
            $item->created_at = $value->created_at;
            $customers->push( $item );
        }
        // show the view and pass the data to it
        return view('backend.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        Customer::create($request->all());
        return redirect()->route('backend.customers.index')
                         ->with('success','Utilisateur créé avec succès.');
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
        $customer = Customer::find($id);
        
        // show the view and pass the data to it
        return view('backend.customers.show', compact('customer'));
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
        $customer = Customer::find($id);

        // show the view and pass the data to it
        return view('backend.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {
        $customerUpdate  = Customer::findOrFail($id);
        $this->validate($request, [
            'email' => 'nullable|email|unique:customers,email,'.$customerUpdate->id, 
            'phone' => 'required|digits:8|unique:customers,phone,'.$customerUpdate->id,
            'name' => 'required',
        ]);
        $customerUpdate->fill($request->all())->save();
        return redirect()->route('backend.customers.index')
                         ->with('success','Utilisateur modifié avec succès.');
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
        $customer = Customer::find($id);
        if($customer->delete()){
            return redirect()->route('backend.customers')
                             ->with('success','Succès, Operation réussie.');
        }
        return redirect()->route('backend.customers')
                         ->with('failed','Échec, Operation échouée.');
    }
}
