@extends('layouts.master')

@section('title', 'Les travailleurs d\'entreprise')

@section('css')
    @parent
@stop

@section('content')
    @parent
    <!-- ADD MODAL -->
    <div id="modal-add" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><i class="fa fa-plus"></i>
                        ajouter travailleur</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon ion-ios-close"></i></span>
                    </button>
                </div>
                <form id="form-add" method="post" class="needs-validation" novalidate>
                    {{ csrf_field() }}
                    <div id="modal-add-body" class="modal-body pd-25">

                        <div id="modal-add-msg"></div>

                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="field-a1">Nom complet : <span class="tx-danger">*</span></label>
                            <input id="field-a1" type="text" name="name" class="form-control"
                                placeholder="Nom d'ouvrier" required>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->
                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="field-a2">Télephone : <span class="tx-danger">*</span></label>
                            <input id="field-a2" type="number" name="phone" minlength="8" maxlength="8" pattern="[0-9.]+" class="form-control"
                                placeholder="Numéro de tél" required>
                            <div class="invalid-feedback">Numéro de télephone invalide</div>
                        </div><!-- form-group -->
                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="field-a3">Email :</label>
                            <input id="field-a3" type="email" name="email" class="form-control"
                                placeholder="example@website.com" required>
                            <div class="invalid-feedback">Email format invalide</div>
                        </div><!-- form-group -->
                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="field-a4">Section : <span class="tx-danger">*</span></label>
                            <select id="field-a4" name="company_section_id" style="width:100%" class="select2-modal-add form-control" data-placeholder="Sélectionnez un choix" required>
                                <option></option>
                                @foreach ($sections as $item)
                                     <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach   
                            </select>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->
                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="field-a6">Mot de passe : <span class="tx-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" placeholder="******" required>
                                <div class="input-group-append">
                                    <button class="btn btn-primary show-pwd" data-toggle="tooltip" data-placement="bottom" data-trigger="hover" title="afficher / masquer mot de passe" type="button">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">Ce champ est obligatoire</div>
                            </div>
                        </div><!-- form-group -->
                        <div class="form-group mg-b-0">
                            <label for="field-a5">Statut : <small>(Active par défaut)</small>&nbsp;&nbsp;</label>
                            <br>
                            <div style="bottom:-6px" class="mg-l-5 br-toggle br-toggle-success on">
                                <div class="br-toggle-switch"></div>
                            </div>
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
    <!-- EDIT MODAL -->
    <div id="modal-edit" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><i class="icon ion-android-create"></i>
                        modifier travailleur</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon ion-ios-close"></i></span>
                    </button>
                </div>
                <form id="form-edit" method="post" class="needs-validation" novalidate>
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div id="modal-edit-body" class="modal-body pd-25">

                        <div id="modal-edit-msg"></div>

                        <input name="id" type="hidden"/>
                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="field-e1">Nom complet : <span class="tx-danger">*</span></label>
                            <input id="field-e1" type="text" name="name" class="form-control"
                                placeholder="Nom d'ouvrier" required>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->
                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="field-e2">Télephone : <span class="tx-danger">*</span></label>
                            <input id="field-e2" type="number" name="phone" minlength="8" maxlength="8" pattern="[0-9.]+" class="form-control"
                                placeholder="Numéro de tél" required>
                            <div class="invalid-feedback">Numéro de télephone invalide</div>
                        </div><!-- form-group -->
                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="field-e3">Email :</label>
                            <input id="field-e3" type="email" name="email" class="form-control"
                                placeholder="example@website.com" required>
                            <div class="invalid-feedback">Email format invalide</div>
                        </div><!-- form-group -->
                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="field-e4">Section : <span class="tx-danger">*</span></label>
                            <select id="field-e4" name="company_section_id" style="width:100%" class="select2-modal-edit form-control" data-placeholder="Sélectionnez un choix" required>
                                <option></option>
                                @foreach ($sections as $item)
                                     <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach                               
                            </select>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->
                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="field-e5">Mot de passe : <span class="tx-danger">*</span></label>
                            <div class="input-group">
                                <input id="field-e5" type="password" name="password" class="form-control" placeholder="******">
                                <div class="input-group-append">
                                    <button class="btn btn-primary show-pwd" data-toggle="tooltip" data-placement="bottom" data-trigger="hover" title="afficher / masquer mot de passe" type="button">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
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

    <div class="float-right pd-b-15">
        <a href="#" class="btn btn-success btn-with-icon btn-block" data-toggle="modal" data-target="#modal-add">
            <div class="ht-40 justify-content-between">
                <span class="pd-x-15">Ajouter Travailleur</span>
                <span class="icon wd-40"><i class="fa fa-plus-circle"></i></span>
            </div>
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="thead-colored thead-primary">
            <tr>
                <th class="">Nom complet</th>
                <th class="">teléphone</th>
                <th class="">Poste du travail</th>
                <th class="">Section</th>
                <th class="">Date de creation</th>
                <th class="">Statut</th>
                <th class="wd-20p">Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $key => $item)

            <tr id="item-{{ $item->id }}">
                <td>{{ $item->name }}</td>
                <td class="tx-inverse">{{ $item->phone }}</td>
                <td>{{ $item->companySection->section == "S" ? "Point de vente" : "Usine" }}</td>
                <td class="tx-inverse">{{ $item->companySection->name }}</td>
                <td>{{ $item->created_at }}</td>
                <td class="status-badge">{!! Config::get('constants.status.' . $item->status ) !!}</td>
                <td>
                    <button type="button" class="btn btn-secondary btn-sm btn-status" data-status="{{ $item->status }}" data-id="{{ $item->id }}" data-toggle="tooltip" data-placement="bottom" title="{{ Config::get('constants.tooltip.' . $item->status . '.title') }}">
                        <i class="{{ Config::get('constants.tooltip.' . $item->status . '.icon') }}"></i>
                    </button>
                    <button type="button" class="modal-effect btn btn-primary btn-sm btn-edit" data-id="{{ $item->id }}" data-effect="effect-scale" data-toggle="tooltip" data-placement="bottom" title="Modifier">
                        <i class="icon ion-android-create"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $item->id }}" data-toggle="tooltip" data-placement="bottom" title="Supprimer">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@stop

@section('js')
    @parent
    <script src="{{ asset('assets/static/js/scripts/company-users.js') }}"></script>
    <script src="{{ asset('assets/static/lib/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/static/lib/sweetalert/sweetalert.min.js') }}"></script>
@stop