@extends('layouts.master')

@section('title', 'Les Clients')

@section('before-css')
    @parent
        <link href="{{ asset('assets/static/lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/static/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet">
@stop

@section('content')
    @parent

@php
    $perms = Session::get('perms');
    $actions = array();
    if($perms->where('controller', 'customers')->isNotEmpty() && !empty($perms->where('controller', 'customers')->first()))
        $actions = $perms->where('controller', 'customers')->first()->actions;
    if(Session::get('is_admin')){
        $actions = ['A', 'M', 'D', 'P'];
    }

@endphp
@if ($perms->where('controller', 'customers')->isNotEmpty() || Session::get('is_admin'))
    
    <div class="table-wrapper">
        <table id="datatable1" class="table display responsive nowrap">
            <thead class="thead-colored thead-black">
                <tr>
                    <th class="wd-25p">Nom & Prénom</th>
                    <th class="wd-10p">Téléphone</th>
                    <th class="wd-15p">Email</th>
                    <th class="wd-15p">Nombre des commandes</th>
                    <th class="wd-15p">Date de création</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $item)
                <tr id="item-{{ $item->id }}">
                    <td class="tx-inverse">{{$item->name}}</td>
                    <td class="tx-inverse">{{ $item->phone }}</td>
                    <td class="tx-inverse">{{ (empty($item->email)) ? '-' : $item->customer->email }}</td>
                    <td class="tx-inverse">{{ (!empty($item->orders)) ? $item->orders->count() : 0}}</td>
                    <td>{{ $item->created_at }}</td>                
                </tr>
                @endforeach
            </tbody>
        </table>
        </div><!-- table-wrapper -->
    @stop

@section('js')
    @parent
    <script src="{{ asset('assets/static/js/scripts/customers.js') }}"></script>
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