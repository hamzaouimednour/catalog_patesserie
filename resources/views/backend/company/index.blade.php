@extends('layouts.master')

@section('title', 'Les informations de l\'entreprise')

@section('css')
    @parent
@stop

@php
    $perms = Session::get('perms');
    $actions = array();
    if($perms->where('controller', 'company')->isNotEmpty() && !empty($perms->where('controller', 'company')->first()))
		$actions = $perms->where('controller', 'company')->first()->actions;
	if(Session::get('is_admin')){
        $actions = ['A', 'M', 'D', 'P'];
    }
@endphp
@if ($perms->where('controller', 'company')->isNotEmpty() || Session::get('is_admin') && !empty($actions) && in_array('M', $actions))

@section('content')
    @parent
    <form id="form-update" method="post" class="needs-validation" novalidate>
        <div id="info-section"></div>
        <div class="form-layout form-layout-1">
            
            <div class="row mg-b-25">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">Nom d'entreprise : <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="company_name" value="{{$company->company_name}}" placeholder="Nom d'entreprise" required>
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">Télephone: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="phone" value="{{!empty($company->phone) ? $company->phone : NULL }}" placeholder="Numéro de Télephone" required>
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-6">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Adresse: <span class="tx-danger">*</span></label>
                  <textarea class="form-control" type="text" name="address" value="" placeholder="Entrer Adresse" style="margin-top: 0px; margin-bottom: 0px; height: 129px;" required>{{$company->address}}</textarea>
                </div>
              </div><!-- col-8 -->
              <div class="col-lg-6">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Description: </label>
                  <textarea class="form-control" type="text" name="description" value="" placeholder="Entrer Description" style="margin-top: 0px; margin-bottom: 0px; height: 129px;">{{$company->description}}</textarea>
                </div>
              </div><!-- col-8 -->
            </div><!-- row -->

			@if (!empty($actions) && in_array('M', $actions))
            <div class="form-layout-footer">
              <button type="submit" id="btn-update" class="btn btn-yellow btn-lg font-weight-bold" style="color:black;">Sauvgarder</button>
			</div><!-- form-layout-footer -->
			@endif
        </div>
    </form>
@stop

@section('js')
    @parent
    <script src="{{ asset('assets/static/js/scripts/company.js') }}"></script>
    <script src="{{ asset('assets/static/lib/select2/js/select2.min.js') }}"></script>
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