@extends('layouts.master')

@section('title', 'Profile d\'utilisateur')

@section('css')
    @parent
@stop

@section('content')
    @parent
    <form id="form-update" method="post" class="needs-validation" novalidate>
        <div id="info-section"></div>
        <div class="form-layout form-layout-1">
        <input type="hidden" name="id" value="{{$user->id}}">
            <div class="row mg-b-25">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">Nom d'utlisateur <small>(Login)</small> : </label>
                  <input class="form-control" type="text" value="{{$user->username}}" disabled>
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">Nom & Prénom : <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="name" value="{{$user->name}}" placeholder="Nom et prénom d'utilisateur" required>
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">Télephone : <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="phone" value="{{!empty($user->phone) ? $user->phone : NULL }}" placeholder="Numéro de Télephone" required>
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label">Email : </label>
                  <input class="form-control" type="text" name="email" value="{{$user->email }}" placeholder="Email">
                </div>
              </div><!-- col-4 -->
              <hr>
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Mot de passe actuel : </label>
                  <input class="form-control" type="password" name="old_password" placeholder="Mot de passe actuel">
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Nouveau Mot de passe : </label>
                  <input class="form-control" type="password" name="password" placeholder="Nouveau Mot de passe">
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Confirmer Nouveau Mot de passe : </label>
                  <input class="form-control" type="password" name="password_confirmation" placeholder="Confirmer Nouveau Mot de passe">
                </div>
              </div><!-- col-4 -->
            </div><!-- row -->

            <div class="form-layout-footer">
              <button type="submit" id="btn-update" class="btn btn-yellow btn-lg font-weight-bold" style="color:black;">Sauvgarder</button>
            </div><!-- form-layout-footer -->
        </div>
    </form>
@stop

@section('js')
    @parent
    <script src="{{ asset('assets/static/js/scripts/profile.js') }}"></script>
    <script src="{{ asset('assets/static/lib/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/static/lib/sweetalert/sweetalert.min.js') }}"></script>
@stop