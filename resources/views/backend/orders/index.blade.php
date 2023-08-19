@extends('layouts.master')

@section('title', 'Les Commandes')

@section('before-css')
    @parent
        <link href="{{ asset('assets/static/lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/static/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet">
@stop


@php
    $perms = Session::get('perms');
    $actions = array();
    if($perms->where('controller', 'orders')->isNotEmpty() && !empty($perms->where('controller', 'orders')->first()))
        $actions = $perms->where('controller', 'orders')->first()->actions;
    if(Session::get('is_admin')){
        $actions = ['A', 'M', 'D', 'P'];
    }
@endphp
@if ($perms->where('controller', 'orders')->isNotEmpty() || Session::get('is_admin'))

@section('content')
    @parent
    
    
    <!-- EDIT MODAL -->
    <div id="modal-edit" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center" role="document" style="max-width: 800px;">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><i class="icon ion-android-create"></i>
                        Commande</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon ion-ios-close"></i></span>
                    </button>
                </div>
                <form id="form-edit" method="post" class="needs-validation" novalidate>
                    {{ csrf_field() }}
                    <div id="modal-edit-body" class="modal-body pd-25">
                        
                    </div>
                    <div class="modal-footer">
                        
                        <button type="button"
                            class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium"
                            data-dismiss="modal">Fermer</button>
                    </div>
                </form>
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    @if (!empty($actions) && in_array('M', $actions))
    <div id="modal-status" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><i class="icon ion-android-create"></i>
                        État du Commande</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon ion-ios-close"></i></span>
                    </button>
                </div>
                <form id="form-status" method="post" class="needs-validation" novalidate>
                    {{ csrf_field() }}

                    <div id="status-info-section"></div>
                    <input type="hidden" name="id" value="">
                    <div id="modal-status-body" class="modal-body pd-25">
                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="">État du Commande : <span class="tx-danger">*</span></label>
                            <select name="status" class="form-control select2-status" data-placeholder="Sélectionner un choix" style="width: 100%" required>
                                <option value="P">Commande en attente</option>
                                <option value="M">En cours de préparation</option>
                                <option value="R">Prête a livraison</option>
                                <option value="D">En cours de livraison</option>
                                <option value="L">Livrée</option>
                                <option value="C">Commande Annulée</option>
                            </select>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-gray tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Enregistrer</button>
                        <button type="button"
                            class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium"
                            data-dismiss="modal">Fermer</button>
                    </div>
                </form>
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="modal-edit-order" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center" role="document" style="max-width: 1100px;">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><i class="icon ion-android-create"></i>
                        Modifier Commande</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon ion-ios-close"></i></span>
                    </button>
                </div>
                <form id="form-edit-order" method="post" class="needs-validation" novalidate>
                    {{ csrf_field() }}

                    <div id="edit-info-section"></div>
                    <div id="modal-edit-order-body" class="modal-body pd-25">

                    </div>
                    <div class="modal-footer">
                        <button id="order-update" type="submit" class="btn btn-gray tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Enregistrer</button>
                        <button type="button"
                            class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium"
                            data-dismiss="modal">Fermer</button>
                    </div>
                </form>
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->
    @endif

    <div class="table-wrapper">
        <form id="filter-form" name="filter-form" action="/backend/orders/filter" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row mb-3">
            <div class="col">
                <label for="exampleFormControlSelect1">Filtrer par Magasin</label>
                <select name="sections" class="form-control" id="exampleFormControlSelect1">
                    <option value="0" {{(empty($filters)) ? 'selected' : NULL}}>Filtrer par défault</option>
                    @foreach ($sections as $item)
                        <option value="{{$item->id}}" {{(!empty($filters) && ($item->id==$filters['sections']) ) ? 'selected' : NULL}}>{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label for="exampleFormControlSelect2">Filtrer par Famille</label>
                <select name="tags" class="form-control" id="exampleFormControlSelect2">
                    <option value="0" {{(empty($filters)) ? 'selected' : NULL}}>Filtrer par défault</option>
                    @foreach ($tags as $item)
                        <option value="{{$item->id}}" {{(!empty($filters) && ($item->id==$filters['tags']) ) ? 'selected' : NULL}}>{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label for="exampleFormControlSelect3">Filtrer par Sous Famille</label>
                <select name="sub_tags" class="form-control" id="exampleFormControlSelect3">
                    <option value="0" {{(empty($filters)) ? 'selected' : NULL}}>Filtrer par défault</option>
                    @foreach ($sub_tags as $item)
                        <option value="{{$item->id}}" {{(!empty($filters) && ($item->id==$filters['sub_tags']) ) ? 'selected' : NULL}}>{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label for="">&nbsp;</label>
                <button type="submit" class="form-control btn btn-warning">
                    FILTRER <i class="icon ion-search"></i>
                </button>
            </div>
        </form>
        </div>
        <table id="datatable1" class="table display responsive nowrap">
            <thead class="thead-colored thead-black">
                <tr>
                    <th class="">NUM</th>
                    <th class="wd-25p">Client</th>
                    <th class="wd-10p">Téléphone</th>
                    <th class="wd-15p">Total</th>
                    <th class="wd-15p">date du commande</th>
                    <th class="wd-15p">Livraison le</th>
                    <th class="wd-15p">Statut</th>
                    <th class="wd-20p">Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $item)
                
                @php
                    $cart = json_decode($item->product_components, true);
                @endphp
                <tr id="item-{{ $item->id }}">
                <td class="tx-inverse">{{$item->order_num}}</td>
                    <td class="text-center">{{$item->customer->name}}</td>
                    <td class="tx-inverse">{{ $item->customer->phone }}</td>
                    <td class="tx-inverse">{{ number_format($cart['total'], 3) }} <small>DT</small></td>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->delivery_date }}</td>
                    {{-- {{var_dump(Config::get('constants.order-status.' . $item->status ))}} --}}
                    <td class="status-badge">{!! Config::get('constants.order-status.' . $item->status ) !!}</td>
                    <td>
                        <button type="button" class="modal-effect btn btn-primary btn-sm btn-show"
                            data-id="{{ $item->id }}" data-effect="effect-scale" data-toggle="tooltip"
                            data-placement="bottom" title="Afficher">
                            <i class="icon ion-eye"></i>
                        </button>

                        @if (!empty($actions) && in_array('M', $actions))
                        <button type="button" class="btn-status btn btn-success btn-sm btn-show"
                            data-id="{{ $item->id }}" data-toggle="tooltip"
                            data-placement="bottom" title="Changer état">
                            <i class="icon ion-android-checkbox-outline"></i>
                        </button>
                        @endif

                        @if (!empty($actions) && in_array('M', $actions))
                        <button type="button" class="btn-edit btn btn-success btn-sm btn-show"
                            data-id="{{ $item->id }}" data-toggle="tooltip"
                            data-placement="bottom" title="Modifier">
                            <i class="icon ion-android-create"></i>
                        </button>
                        @endif
                        
                        @if (!empty($actions) && in_array('P', $actions))
                        <a style="color:#fff;" href="/order/print/{{ $item->id }}" target="_blank" class="btn btn-primary btn-sm btn-print"
                            data-id="{{ $item->id }}" data-toggle="tooltip"
                            data-placement="bottom" title="Imprimer">
                            <i class="icon ion-ios-printer-outline"></i>
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div><!-- table-wrapper -->
    @stop

@section('js')
    @parent
    <script src="{{ asset('assets/static/js/scripts/orders.js') }}"></script>
    <script src="{{ asset('assets/static/lib/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/static/lib/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/static/lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/static/lib/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/static/lib/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/static/lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js') }}"></script>
@stop

@else
@section('content')
    @parent
    <div class="alert alert-danger" role="alert">
        <div class="d-flex align-items-center justify-content-start">
            <i class="icon ion-ios-close alert-icon tx-32"></i>
            <span><strong>Interdit ! </strong>, L'accès de cette page n'est pas autorisé.</span>
        </div><!-- d-flex -->
    </div>
@stop
@endif