@php
    $perms = Session::get('perms');
    $order_actions = array();
    if($perms->where('controller', 'orders')->isNotEmpty() && !empty($perms->where('controller', 'orders')->first()))
        $order_actions = $perms->where('controller', 'orders')->first()->actions;
@endphp
@if (!empty($order_actions) && in_array('P', $order_actions) || Session::get('is_admin'))
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Takacim - Facture</title>

    <!-- vendor css -->
    <link href="{{ asset('assets/static/lib/fontawesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/static/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{ asset('assets/static/css/bracket.css') }}">
    <style>
        @page 
        {
            size: auto;   /* auto is the current printer page size */
            margin: 0mm;  /* this affects the margin in the printer settings */
        }
    </style>
  </head>

  <body>
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="ml-3 mr-3">
        
      <div class="br-pagebody">
          <div class="card bd-0 shadow-base">
              <div class="col mt-3">
                <a href="" onclick="window.print();" class="float-right btn btn-oblong btn-primary btn-sm">Imprimer</a>
              </div>
            <div class="card-body pd-30 pd-md-60">
            <div class="d-md-flex justify-content-between flex-row-reverse">
              <h1 class="mg-b-0 tx-uppercase tx-gray-400 tx-mont tx-bold"><img src="{{asset('static/logo.png')}}" width="150" alt="main logo"></h1>
              <div class="mg-t-25 mg-md-t-0">
				
                @if (!empty($company))
                <h6 class="tx-primary">{{$company->company_name}}</h6>
                <p class="lh-7">{{$company->address}}<br>
                Tél: {{$company->phone}}<br>
                Email: {{$company->email}}</p>
                @endif
              </div>
            </div><!-- d-flex -->

            <div class="row mg-t-20">
              <div class="col-md">
                <label class="tx-uppercase tx-13 tx-bold mg-b-20">CLIENT</label>
                <h6 class="tx-inverse">{{$order->customer->name}}</h6>
                {{-- <p class="lh-7">4033 Patterson Road, Staten Island, NY 10301 <br> --}}
                Tel: {{$order->customer->phone}}<br>
                Email: {{$order->customer->email}}</p>
              </div><!-- col -->
              <div class="col-md">
                <label class="tx-uppercase tx-13 tx-bold mg-b-20">BON DE commande</label>
                <p class="d-flex justify-content-between mg-b-5">
                  <span>N°:</span>
                  <span>{{$order->order_num}}</span>
                </p>
                <p class="d-flex justify-content-between mg-b-5">
                  <span>Date Livraison:</span>
                  <span>{{$order->delivery_date}}</span>
                </p>
                <p class="d-flex justify-content-between mg-b-5">
                  <span>Date d'échéance:</span>
                  <span>{{$order->created_at}}</span>
                </p>
              </div><!-- col -->
            </div><!-- row -->

            <div class="table-responsive mg-t-40">
              <table class="table">
                <thead>
                  <tr>
                    <th class="wd-10p">#</th>
                    <th class="wd-20p">Article</th>
                    <th class="wd-40p">Désignation</th>
                    <th class="tx-center">Quantité</th>
                    <th class="tx-right">P.U</th>
                    <th class="tx-right">MONTANT</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $cart = json_decode($order->product_components, true);
                    @endphp
                    @if (!empty($cart))
                        @foreach ($cart['items'] as $id => $produit)
                        @php
                            $product = $prod::find($id);
                        @endphp

                        @foreach ($produit as $key => $item)
                    <tr>
                        <td class="tx-left wd-10p"><img class="w-100" src="/thumbs/thumb-{{$product->productImgs->first()->img}}" /></td>
                        <td>{{$product->name}}</td>
                        <td class="tx-12">
                            <p> <b>REF:</b> {{$product->ref}}</p>
                            @if ($product->price_by_size)

                            <p><b>Dimension:</b>
                                {{$product->productSizePrices->where('size_id', $item['dimension'])->first()->size->size_name}}
                            </p>

                            @endif
                            @if (!empty($item['parfums']))

                            {{-- dimension only in parfums --}}
                            @if (!$product->price_by_size &&
                            $item['parfums']['parfum_dimension'])

                            <p><b>Dimension:</b>
                                {{$product->productComponents->where('id', $item['parfums']['product_component_id'] )->first()
                                        ->productComponentPrices->where('size_id', $item['parfums']['dimension_id'])->first()->size->size_name}}
                            </p>

                            @endif

                            {{-- parfum n'est pas par dimension --}}
                            @if (!$item['parfums']['parfum_dimension'])
                            <p><b>Parfum:</b>
                                {{$product->productComponents->where('id', $item['parfums']['product_component_id'] )->first()->component->name}}
                            </p>
                            @endif

                            {{-- parfum n'est pas par dimension --}}
                            @if ($item['parfums']['parfum_dimension'])
                            <p><b>Parfum:</b>
                                {{$product->productComponents->where('component_id', $item['parfums']['component_id'] )->first()->component->name}}
                            </p>
                            @endif

                            @endif

                            @if (!empty($item['decors']))

                            @if (!$product->price_by_size && (
                            (!empty($item['parfums']) &&
                            !$item['parfums']['parfum_dimension']) ||
                            empty($item['parfums']) ) &&
                            $item['decors']['decor_dimension'])

                            <p><b>Dimension:</b>
                                {{$product->productComponents->where('id', $item['decors']['product_component_id'] )->first()
                                        ->productComponentPrices->where('size_id', $item['decors']['dimension_id'])->first()->size->size_name}}
                            </p>

                            @endif

                            {{-- decors n'est pas par dimension --}}
                            @if (!$item['decors']['decor_dimension'])
                            <p><b>Parfum:</b>
                                {{$product->productComponents->where('id', $item['decors']['product_component_id'] )->first()->component->name}}
                            </p>
                            @endif

                            {{-- decors n'est pas par dimension --}}
                            @if ($item['decors']['decor_dimension'])
                            <p><b>Decoration:</b>
                                {{$product->productComponents->where('component_id', $item['decors']['component_id'] )->first()->component->name}}
                            </p>
                            @endif

                            @endif
                            @if (!empty($item['msg']))
                            <p><b>Message:</b> {{$item['msg']}}</p>
                            @endif
                        </td>
                        <td class="tx-center">{{$item['qty']}}</td>
                        <td class="tx-right">{{number_format($item['pu'], 3)}} <small>DT</small></td>
                        <td class="tx-right">{{number_format($item['total'], 3)}} <small>DT</small></td>
                    </tr>
                        @endforeach

                        @endforeach
                    @endif
                  <tr>
                    <td colspan="3" rowspan="4" class="valign-middle">
                      <div class="mg-r-20">
                        <label class="tx-uppercase tx-13 tx-bold mg-b-10">Remarques</label>
                        <p class="tx-13">pas de remarques.</p>
                      </div>
                    </td>
                    <td class="tx-right tx-bold">Acompte</td>
                    <td colspan="3" class="tx-right">{{number_format($order->acompte, 3)}} <small>DT</small></td>
                  </tr>
                  <tr>
                    <td class="tx-right tx-bold ">Reste</td>
                    <td colspan="3"  class="tx-right">{{number_format(($order->total - $order->acompte), 3)}} <small>DT</small></td>
                  </tr>
                  <tr>
                    <td class="tx-right tx-uppercase tx-bold tx-inverse">Total</td>
                    <td colspan="3" class="tx-right"><h4 class="tx-teal tx-bold tx-lato">{{number_format($order->total, 3)}} <small>DT</small></h4></td>
                  </tr>
                </tbody>
              </table>
            </div><!-- table-responsive -->
            <hr class="mg-b-60">
          </div><!-- card-body -->
        </div><!-- card -->

      </div><!-- br-pagebody -->
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

        <!-- ########## START: FOOTER SCRIPTS ########## -->
        @include('includes.backend.footer-scripts')
        <!-- ########## END: FOOTER SCRIPTS ########## -->
        
    </body>
</html>
@endif