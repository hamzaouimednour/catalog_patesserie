@extends('layouts.master')

@section('title', 'Les Autorisation des permissions.')

@section('before-css')
    @parent
        <link href="{{ asset('assets/static/lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/static/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet">
@stop

@php
    $permissions = Session::get('perms');
    $actions = array();
    if($permissions->where('controller', 'user-permissions')->isNotEmpty() && !empty($permissions->where('controller', 'user-permissions')->first()))
        $actions = $permissions->where('controller', 'user-permissions')->first()->actions;
	if(Session::get('is_admin')){
        $actions = ['A', 'M', 'D', 'P'];
    }
@endphp
@if ($permissions->where('controller', 'user-permissions')->isNotEmpty() || Session::get('is_admin'))

@section('content')
    @parent
    <!-- ADD MODAL -->
    @if (!empty($actions) && in_array('A', $actions))
    <div id="modal-add" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse grand-titre tx-bold"><i class="fa fa-plus"></i>
                        ajouter Autorisation(s)</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon ion-ios-close"></i></span>
                    </button>
                </div>
                <form id="form-add" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    {{ csrf_field() }}
                    <div id="modal-add-body" class="modal-body pd-25">

                        <div id="modal-add-msg"></div>
                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="field-a1">Utilisateur(s) : <span class="tx-danger">*</span></label>
                            <select name="user-id[]" class="form-control select2-multi" data-placeholder="Sélectionner utilisateur(s)" multiple style="width: 100%" required>
                                <option></option>
                                @foreach ($users as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->
                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="field-a1">Groupe(s) d'autoriation(s) : <span class="tx-danger">*</span></label>
                            <select name="group-id[]" class="form-control select2-multi" data-placeholder="Sélectionner utilisateur(s)" multiple style="width: 100%" required>
                                <option></option>
                                @foreach ($groups as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->
                        <div class="form-group mg-b-0">
                            <label for="field-a6">Statut : <small>(Active par défaut)</small>&nbsp;&nbsp;</label>
                            <br>
                            <div style="bottom:-6px" class="mg-l-5 br-toggle br-toggle-success on">
                                <div class="br-toggle-switch"></div>
                            </div>
                        </div><!-- form-group -->
                    </div>
                    <div class="modal-footer">
                        <button type="submit"
                            class="btn btn-gray tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Enregistrer</button>
                        <button type="button"
                            class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium"
                            data-dismiss="modal">Annuler</button>
                    </div>
                </form>
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->
    @endif

    @if (!empty($actions) && in_array('M', $actions))
    <!-- EDIT MODAL -->
    <div id="modal-edit" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse grand-titre tx-bold"><i class="icon ion-android-create"></i>
                        modifier Autorisation</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon ion-ios-close"></i></span>
                    </button>
                </div>
                <form id="form-edit" method="post" class="needs-validation" novalidate>
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div id="modal-edit-msg"></div>
                    <div id="modal-edit-body" class="modal-body pd-25">
                    </div>
                    <div class="modal-footer">
                        <button type="submit"
                            class="btn btn-gray tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Enregistrer</button>
                        <button type="button"
                            class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium"
                            data-dismiss="modal">Annuler</button>
                    </div>
                </form>
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->
    @endif

    @if (!empty($actions) && in_array('A', $actions))
    <div class="float-right pd-b-15">
        <a href="#" class="btn btn-yellow btn-with-icon btn-block" data-toggle="modal" data-target="#modal-add">
            <div class="ht-40 justify-content-between text-black">
                <span class="pd-x-15 tx-bold">AJOUTER UNE AUTORISATION</span>
                <span class="icon wd-40"><i class="fa fa-plus-circle"></i></span>
            </div>
        </a>
    </div>
    @endif

    <div class="table-wrapper">
        <table id="datatable1" class="table display responsive nowrap">
            <thead class="thead-colored thead-black">
                <tr>
                    <th class="wd-25p">Utilisateur</th>
                    <th class="wd-25p">Tél</th>
                    <th class="wd-20p">Autorisation</th>
                    <th class="wd-20p">date d'autorisation</th>
                    <th class="wd-15p">Statut</th>
                    <th class="wd-10p">Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach($perms as $key => $item)
                <tr id="item-{{ $item->id }}">
                    <td class="tx-inverse tx-bold text-capitalize">{{ $item->user->name }}</td>
                    <td class="tx-inverse">{{ $item->user->phone }}</td>
                    <td class="tx-inverse tx-bold text-capitalize">{{ $item->groupPermission->name }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td class="status-badge">{!! Config::get('constants.status.' . $item->status ) !!}</td>
                    <td>
                        @if (!empty($actions) && in_array('M', $actions))
                        <button type="button" class="btn btn-secondary btn-sm btn-status"
                            data-status="{{ $item->status }}" data-id="{{ $item->id }}" data-toggle="tooltip"
                            data-placement="bottom"
                            title="{{ Config::get('constants.tooltip.' . $item->status . '.title') }}">
                            <i class="{{ Config::get('constants.tooltip.' . $item->status . '.icon') }}"></i>
                        </button>
                        @endif
                        @if (!empty($actions) && in_array('M', $actions))
                        <button type="button" class="modal-effect btn btn-primary btn-sm btn-edit"
                            data-id="{{ $item->user_id }}" data-effect="effect-scale" data-toggle="tooltip"
                            data-placement="bottom" title="Modifier">
                            <i class="icon ion-android-create"></i>
                        </button>
                        @endif
                        @if (!empty($actions) && in_array('D', $actions))
                        <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $item->id }}"
                            data-toggle="tooltip" data-placement="bottom" title="Supprimer">
                            <i class="fa fa-trash"></i>
                        </button>
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
    <script src="{{ asset('assets/static/js/scripts/user-perms.js') }}"></script>
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