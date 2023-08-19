@extends('layouts.master')

@section('title', 'Les Entreprises')

@section('css')
    @parent
@stop

@php
    $perms = Session::get('perms');
    $actions = array();
    if($perms->where('controller', 'companies')->isNotEmpty() && !empty($perms->where('controller', 'companies')->first()))
        $actions = $perms->where('controller', 'companies')->first()->actions;
    if(Session::get('is_admin')){
        $actions = ['A', 'M', 'D', 'P'];
    }
@endphp
@if ($perms->where('controller', 'companies')->isNotEmpty() || Session::get('is_admin'))

@section('content')
    @parent
    <!-- ADD MODAL -->
    @if (!empty($actions) && in_array('A', $actions))
    <div id="modal-add" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><i class="icon ion-android-create"></i>
                        ajouter entreprise</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon ion-ios-close"></i></span>
                    </button>
                </div>
                <form id="form-add" method="post" class="needs-validation" novalidate>
                    {{ csrf_field() }}
                    <div class="modal-body pd-25">

                        <div id="modal-add-msg"></div>

                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="field-a1">Nom d'entreprise : <span class="tx-danger">*</span></label>
                            <input id="field-a1" type="text" name="company_name" class="form-control"
                                placeholder="Nom d'entreprise" required>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->
                        <div class="form-group mg-b-0">
                            <label for="field-a2">Description : </label>
                            <textarea id="field-a2" type="text" name="description" class="mg-t-0 mg-b-0 form-control"
                                placeholder="Description d'entreprise" style="height: 140px;"></textarea>
                        </div><!-- form-group -->
                    </div>
                    <div class="modal-footer">
                        <button type="submit"
                            class="btn btn-success tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Sauvegarder</button>
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
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><i class="icon ion-android-create"></i>
                        modifier entreprise</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon ion-ios-close"></i></span>
                    </button>
                </div>
                <form id="form-edit" method="post" class="needs-validation" novalidate>
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="modal-body pd-25">

                        <div id="modal-edit-msg"></div>

                        <input name="id" type="hidden"/>
                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="field-e1">Nom d'entreprise : <span class="tx-danger">*</span></label>
                            <input id="field-e1" type="text" name="company_name" class="form-control"
                                placeholder="Nom d'entreprise" required>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->
                        <div class="form-group mg-b-0">
                            <label for="field-e2">Description : </label>
                            <textarea id="field-e2" type="text" name="description" class="mg-t-0 mg-b-0 form-control"
                                placeholder="Description d'entreprise" style="height: 140px;"></textarea>
                        </div><!-- form-group -->
                    </div>
                    <div class="modal-footer">
                        <button type="submit"
                            class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Sauvegarder</button>
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
        <a href="#" class="btn btn-success btn-with-icon btn-block" data-toggle="modal" data-target="#modal-add">
            <div class="ht-40 justify-content-between">
                <span class="pd-x-15">Ajouter nouvelle entreprise</span>
                <span class="icon wd-40"><i class="fa fa-plus-circle"></i></span>
            </div>
        </a>
    </div>
    @endif
    <table class="table table-bordered table-striped">
        <thead class="thead-colored thead-dark">
            <tr>
                <th class="wd-10p">ID</th>
                <th class="wd-30p">Nom d'entreprise</th>
                <th class="wd-25p">Date de creation</th>
                <th class="wd-20p">Status</th>
                <th class="">Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach($companies as $key => $company)
            <tr id="item-{{ $company->id }}">
                <th scope="row">{{ $company->id }}</th>
                <td>{{ $company->company_name }}</td>
                <td>{{ $company->created_at }}</td>
                <td class="status-badge">{!! Config::get('constants.status.' . $company->status ) !!}</td>
                <td>
                    @if (!empty($actions) && in_array('M', $actions))
                    <button type="button" class="btn btn-secondary btn-sm btn-status" data-status="{{ $company->status }}" data-id="{{ $company->id }}" data-toggle="tooltip" data-placement="bottom" title="{{ Config::get('constants.tooltip.' . $company->status . '.title') }}">
                        <i class="{{ Config::get('constants.tooltip.' . $company->status . '.icon') }}"></i>
                    </button>
                    @endif
                    
                    @if (!empty($actions) && in_array('M', $actions))
                    <button type="button" class="modal-effect btn btn-primary btn-sm btn-edit" data-id="{{ $company->id }}" data-effect="effect-scale" data-toggle="tooltip" data-placement="bottom" title="Modifier">
                        <i class="icon ion-android-create"></i>
                    </button>
                    @endif

                    @if (!empty($actions) && in_array('D', $actions))
                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $company->id }}" data-toggle="tooltip" data-placement="bottom" title="Supprimer">
                        <i class="fa fa-trash"></i>
                    </button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@stop

@section('js')
    @parent
    <script src="{{ asset('assets/static/js/scripts/companies.js') }}"></script>
    <script src="{{ asset('assets/static/lib/sweetalert/sweetalert.min.js') }}"></script>
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