@extends('layouts.master-front')

@section('title', 'Panier')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('assets/lib/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lib/css/select2-bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/static/lib/datepicker/css/bootstrap-datepicker3.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/static/lib/timepicker/bootstrap-clockpicker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    @stop

@section('breadcrumb-link', 'Panier')

@section('content')
    @parent
    @php
        $order_actions = array();
        $perms = collect([]);
        if(Session::has('perms')){
            $perms = Session::get('perms');
            if($perms->where('controller', 'orders')->isNotEmpty() && !empty($perms->where('controller', 'orders')->first()))
                $order_actions = $perms->where('controller', 'orders')->first()->actions;
        }
        
    @endphp
    <!-- Start page content -->
        <section id="page-content" class="page-wrapper section">

            <!-- SHOP SECTION START -->
            <div class="shop-section mb-80">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-2">
                            <ul class="cart-tab">
                                <li>
                                    <a class="active" href="#shopping-cart" data-toggle="tab">
                                        <span>01</span>
                                        Panier
                                    </a>
                                </li>
                                <li>
                                    <a href="#order-complete" data-toggle="tab">
                                        <span>02</span>
                                        Commande Terminée
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-10">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <!-- shopping-cart start -->
                                <div class="tab-pane active" id="shopping-cart">
                                    <div class="shopping-cart-content">
                                        <form action="#" id="cart-form">
                                            <div class="table-content table-responsive mb-50">
                                                <table class="text-center">
                                                    <thead>
                                                        <tr>
                                                            <th class="product-thumbnail">PRODUIT</th>
                                                            <th class="product-price">P.U</th>
                                                            <th class="product-quantity">Quantité</th>
                                                            <th class="product-subtotal">Montant</th>
                                                            <th class="product-remove">retirer</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- tr -->
                                                        @if (!empty($cart))

                                                        @foreach ($cart['items'] as $id => $produit)
                                                        @php
                                                        $product = $prod::find($id);
                                                        @endphp
                                                        @foreach ($produit as $key => $item)
                                                        <tr>
                                                            <td class="product-thumbnail">
                                                                <div class="pro-thumbnail-img">
                                                                    <img src="/thumbs/{{$product->productImgs->first()->img}}"
                                                                        alt="">
                                                                </div>
                                                                <div class="pro-thumbnail-info text-left">
                                                                    <h6 class="product-title-2">
                                                                        <a href="#">{{$product->name}}</a>
                                                                    </h6>
                                                                    <p> REF: {{$product->ref}}</p>
                                                                    @if ($product->price_by_size)

                                                                    <p>Dimension:
                                                                        {{$product->productSizePrices->where('size_id', $item['dimension'])->first()->size->size_name}}
                                                                    </p>

                                                                    @endif
                                                                    @if (!empty($item['parfums']))

                                                                    {{-- dimension only in parfums --}}
                                                                    @if (!$product->price_by_size &&
                                                                    $item['parfums']['parfum_dimension'])

                                                                    <p>Dimension:
                                                                        {{$product->productComponents->where('id', $item['parfums']['product_component_id'] )->first()
                                                                                ->productComponentPrices->where('size_id', $item['parfums']['dimension_id'])->first()->size->size_name}}
                                                                    </p>

                                                                    @endif

                                                                    {{-- parfum n'est pas par dimension --}}
                                                                    @if (!$item['parfums']['parfum_dimension'])
                                                                    <p>Parfum:
                                                                        {{$product->productComponents->where('id', $item['parfums']['product_component_id'] )->first()->component->name}}
                                                                    </p>
                                                                    @endif

                                                                    {{-- parfum n'est pas par dimension --}}
                                                                    @if ($item['parfums']['parfum_dimension'])
                                                                    <p>Parfum:
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

                                                                    <p>Dimension:
                                                                        {{$product->productComponents->where('id', $item['decors']['product_component_id'] )->first()
                                                                                ->productComponentPrices->where('size_id', $item['decors']['dimension_id'])->first()->size->size_name}}
                                                                    </p>

                                                                    @endif

                                                                    {{-- decors n'est pas par dimension --}}
                                                                    @if (!$item['decors']['decor_dimension'])
                                                                    <p>Parfum:
                                                                        {{$product->productComponents->where('id', $item['decors']['product_component_id'] )->first()->component->name}}
                                                                    </p>
                                                                    @endif

                                                                    {{-- decors n'est pas par dimension --}}
                                                                    @if ($item['decors']['decor_dimension'])
                                                                    <p>Decoration:
                                                                        {{$product->productComponents->where('component_id', $item['decors']['component_id'] )->first()->component->name}}
                                                                    </p>
                                                                    @endif

                                                                    @endif
                                                                    @if (!empty($item['msg']))
                                                                    <p>Message: {{$item['msg']}}</p>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td class="product-price">{{number_format($item['pu'], 3)}}
                                                                <small>DT</small></td>
                                                            <td class="product-quantity">
                                                                <div class="cart-plus-minus f-left">
                                                                    <input data-id="{{$id}}" data-key="{{$key}}"
                                                                        type="text" value="{{$item['qty']}}"
                                                                        name="qtybutton"
                                                                        class="float-num cart-plus-minus-box">
                                                                </div>
                                                            </td>
                                                            <td class="product-subtotal">
                                                                {{number_format($item['total'], 3)}} <small>DT</small>
                                                            </td>
                                                            <td class="product-remove">
                                                                <a class="product-delete" href="#" data-id="{{$id}}"
                                                                    data-key="{{$key}}"><i
                                                                        class="zmdi zmdi-close"></i></a>
                                                            </td>
                                                        </tr>
                                                        <!-- tr -->
                                                        @endforeach
                                                        @endforeach
                                                        @else
                                                        <p>Pas des produits dans le panier.</p>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>

                                            @if (!empty($order_actions) && in_array('A', $order_actions))
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="coupon-discount box-shadow p-30 mb-50">
                                                        <h6 class="widget-title border-left mb-20">Cautionnement</h6>
                                                        <p>Montant de Cautionnement en millimes.</p>
                                                        <input class="float-num" type="text" name="cautionnement"
                                                            placeholder="Entrer montant de Cautionnement.">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="payment-details box-shadow p-30 mb-50">
                                                        <h6 class="widget-title border-left mb-20">Détails de paiement
                                                        </h6>
                                                        <table>
                                                            <tr>
                                                                <td class="order-total">Total de la commande</td>
                                                                <td id="order-total" class="order-total-price">
                                                                    300.000
                                                                    <small>DT</small></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-5">
                                                    <div class="culculate-shipping box-shadow p-30">
                                                        <h6 class="widget-title border-left mb-5">ACOMPTE</h6>
                                                        <p>Montant d'acompte en millimes.</p>
                                                        <div class="row">
                                                            <div class="col-sm-4 col-xs-12 mb-5">
                                                                <input class="float-num" type="text" name="acompte"
                                                                    placeholder="Entrer montant d'acompte.">
                                                            </div>

                                                            <div class="col-sm-4 col-xs-12">
                                                                <select class="custom-select" name="acompte-type">
                                                                    <option value="" disabled selected>Sélectionnez le
                                                                        type d'acompte</option>
                                                                    <option value="E">Espèce</option>
                                                                    <option value="C">Chèque</option>
                                                                </select>

                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="culculate-shipping box-shadow p-30">
                                                        <h6 class="widget-title border-left mb-5">client</h6>
                                                        <div class="row">
                                                            <div class="col-sm-4 col-xs-12 mb-5">
                                                                <input type="text" name="customer-name" class="form-control"
                                                                        id="" placeholder="Nom & Prénom du client">
                                                            </div>
                                                            <div class="col-sm-4 col-xs-12">
                                                                <input type="text" name="customer-phone" class="float-num form-control" id=""
                                                                        placeholder="Numéro de Tél">
                                                            </div>
                                                            <div class="col-sm-4 col-xs-12">
                                                                <input type="text" name="customer-email" class="form-control" id=""
                                                                        placeholder="Email (optionnel)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="culculate-shipping box-shadow p-30">
                                                        <h6 class="widget-title border-left mb-5">LIVRAISON</h6>
                                                        <div class="row">
                                                            <div class="col-sm-4 col-xs-12 mb-5">
                                                                <div class="input-group">

                                                                    <input type="text" name="delivery-date" class="datepicker form-control"
                                                                        id="" placeholder="Date de livraison">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id=""><span
                                                                                style="font-size:15px;"
                                                                                class="zmdi zmdi-calendar"></span></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4 col-xs-12">
                                                                <div class="input-group clockpicker">

                                                                    <input type="text" name="delivery-time" class="form-control" id=""
                                                                        placeholder="Heure de livraison">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id=""><span
                                                                                style="font-size:15px;"
                                                                                class="zmdi zmdi-time"></span></span>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="col-sm-4 col-xs-12">
                                                                <select class="custom-select" name="delivery-mode">
                                                                    <option value="" disabled selected>Sélectionnez la
                                                                        maniére de livraison</option>
                                                                    <option value="S">Livraison par la société</option>
                                                                    <option value="C">Livraison par le client</option>
                                                                </select>

                                                            </div>

                                                        </div>

                                                    </div>
                                                    <div class="col-md-12 mt-5 text-center">
                                                        <button id="submit-cart-form" class="submit-btn-1 black-bg btn-hover-2"
                                                            style="height:50px;"><i style="font-size:15px;"
                                                                class="zmdi zmdi-shopping-cart-plus"></i> Passer la
                                                            commande</button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                                <!-- shopping-cart end -->
                                <!-- order-complete start -->
                                <!-- order-complete end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- SHOP SECTION END -->             

        </section>
        <!-- End page content -->
@stop

@section('js')
    @parent  
    <script src="{{ asset('assets/lib/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/static/lib/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/static/lib/moment/moment.js') }}"></script>    
    <script src="{{ asset('assets/static/lib/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/static/lib/datepicker/locales/bootstrap-datepicker.fr.min.js') }}"></script>
    <script src="{{ asset('assets/static/lib/timepicker/bootstrap-clockpicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts/p-65d98102.js?' . time()) }}"></script>  

@stop