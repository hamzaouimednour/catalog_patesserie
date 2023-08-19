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
        $perms = Session::get('perms');
        $order_actions = array();
        if($perms->where('controller', 'orders')->isNotEmpty() && !empty($perms->where('controller', 'orders')->first()))
            $order_actions = $perms->where('controller', 'orders')->first()->actions;
    @endphp
    @if (!empty($order_actions) && in_array('P', $order_actions))
    <!-- Start page content -->
        <section id="page-content" class="page-wrapper section">

            <!-- SHOP SECTION START -->
            <div class="shop-section mb-80">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-2">
                            <ul class="cart-tab">
                                <li>
                                    <a href="#" data-toggle="tab">
                                        <span>01</span>
                                        Panier
                                    </a>
                                </li>
                                <li>
                                    <a class="active" href="#order-complete" data-toggle="tab">
                                        <span>02</span>
                                        Commande Terminée
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-10">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="card text-center">
                                <div class="card-header">
                                    <b>COMMANDE TERMINÉE</b>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Votre commande a été enregistrée</h5>
                                    <p class="card-text">Nous avons bien reçu votre commande et nous vous en remercions.</p>
                                    <a href="#" id="print-order" data-id="{{$id}}" class="btn btn-primary">IMPRIMER</a>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- SHOP SECTION END -->             

        </section>
        <!-- End page content -->
    @endif
@stop

@section('js')
    @parent  
    <script src="{{ asset('assets/lib/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/static/lib/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/static/lib/moment/moment.js') }}"></script>    
    <script src="{{ asset('assets/static/lib/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/static/lib/datepicker/locales/bootstrap-datepicker.fr.min.js') }}"></script>
    <script src="{{ asset('assets/static/lib/timepicker/bootstrap-clockpicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts/p-script.js?' . time()) }}"></script>  

@stop