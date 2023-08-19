@extends('layouts.master')

@section('title', 'Les Collections')

@section('before-css')
    @parent
        <link href="{{ asset('assets/static/lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/static/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet">
@stop


@php
    $perms = Session::get('perms');
    $actions = array();
    if($perms->where('controller', 'products')->isNotEmpty() && !empty($perms->where('controller', 'products')->first()))
        $actions = $perms->where('controller', 'products')->first()->actions;
	if(Session::get('is_admin')){
        $actions = ['A', 'M', 'D', 'P'];
    }
@endphp
@if ($perms->where('controller', 'products')->isNotEmpty() || Session::get('is_admin'))

@section('content')
    @parent
    <!-- ADD MODAL -->
    @if (!empty($actions) && in_array('A', $actions))
    <div id="modal-add" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center" role="document" style="max-width: 710px;">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase grand-titre tx-bold"><i class="fa fa-plus"></i>
                        ajouter un produit</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon ion-ios-close"></i></span>
                    </button>
                </div>
                <form id="form-add" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    {{ csrf_field() }}
                    <div id="modal-add-body" class="modal-body pd-25">

                        <div id="modal-add-msg"></div>
                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="field-a0">Référence  : <span class="tx-danger">*</span></label>
                            <input id="field-a0" type="text" name="ref" class="form-control"
                                placeholder="Référence du produit" required>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->
                        
                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="field-a1">Produit : <span class="tx-danger">*</span></label>
                            <input id="field-a1" type="text" name="name" class="form-control"
                                placeholder="Nom du produit" required>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->
                        
                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="field-a2">Description : </label>
                            <textarea id="field-a2" type="text" name="description" class="mg-t-0 mg-b-0 form-control"
                                placeholder="Description du produit" style="height: 140px;"></textarea>
                        </div><!-- form-group -->

                        <label for="field-a3">Prix : <span class="tx-danger">*</span></label>
                        
                        {{-- price based on size --}}
                        <div class="form-group row mg-b-0 pd-b-15">

                            <div class="col-md-2 mg-t-10">
                                <div id="price-dimension" class="br-toggle-switcher br-toggle br-toggle-rounded br-toggle-success no-required">
                                    <div class="br-toggle-switch"></div>
                                </div>
                            </div>
                            <div class="col-md-5 col-form-label">
                                <span class="br-toggle-badge badge badge-black " style="font-size:14px">
                                    prix en fonction de la dimension &nbsp;<i class="fa fa-question-circle"></i>
                                    {{-- prix est en fonction de dimension &nbsp;<i class="fa fa-check-circle"></i> --}}
                                    {{-- <i class="fa fa-check-circle"></i> --}}
                                </span>
                            </div>

                        </div><!-- form-group -->

                        {{-- single default price --}}
                        <div class="group-1 form-group mg-b-0 pd-b-15">
                            <input id="field-a3" type="text" name="price" class="form-control"
                                placeholder="Prix du produit"
                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57">
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->

                        {{-- price based on size --}}
                        <div class="group-2 form-group d-none">
                            <div class="form-inline mg-b-0 pd-b-15">
                                <label class="rdiobox" data-toggle="tooltip" data-placement="top" title=""
                                    data-original-title="prix par défaut">
                                    <input name="default-price" value="" type="radio" checked>
                                    <span></span>
                                </label>
                                <div class="form-group mg-r-10">
                                    <select id="default-select-price" name="p-dimension[]" style="width:380px"
                                        class="default-select-price select2-modal-add form-control" data-placeholder="Sélectionnez un dimension">
                                        <option></option>
                                        @foreach ($sizes as $item)
                                        <option value="{{$item->id}}">{{$item->size_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mg-r-10">
                                    <input type="text" class="form-control" name="p-dimension-price[]" onpaste="return false;"
                                        onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                        placeholder="Prix" data-toggle="popover" data-placement="right"
                                        data-trigger="hover focus" data-html="true"
                                        data-content="<small><i class='text-info fa fa-info-circle'></i> <strong>Exemple du format de Prix :</strong><br><strong>500</strong> : Cinq cents millimes <br><strong>1000</strong> : Un dinar et zéro millimes.<br><strong>10500</strong> : Dix dinars et cinq cents millimes.</small> ">
                                </div>
                                <button type="button" class="btn btn-gray btn-add-row" data-content="price" data-index="0" data-toggle="tooltip"
                                    data-group="group-2" data-placement="right" title="" data-original-title="Ajouter autre dimension">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                            </div>
                            <!-- end form-inline -->
                        </div>




                        <label class="mg-t-15" for="field-a2">Parfums : <span class="tx-danger">*</span></label>
                        
                        <div class="form-group row mg-b-0 pd-b-15">

                            <div class="col-md-2 mg-t-10">
                                <div id="parfum-dimension" class="br-toggle-switcher br-toggle br-toggle-rounded br-toggle-success no-required">
                                    <div class="br-toggle-switch"></div>
                                </div>
                            </div>
                            <div class="col-md-5 col-form-label">
                                <span class="br-toggle-badge badge badge-black" style="font-size:14px">
                                    prix en fonction de la dimension &nbsp;<i class="fa fa-question-circle"></i>
                                    {{-- prix est en fonction de dimension &nbsp;<i class="fa fa-check-circle"></i> --}}
                                    {{-- <i class="fa fa-check-circle"></i> --}}
                                </span>
                            </div>

                        </div><!-- form-group -->

                        {{-- single default price --}}
                        <div class="group-1 form-group">
                            <div class="form-inline mg-b-0 pd-b-15">
                                <label class="rdiobox" data-toggle="tooltip" data-placement="top" title=""
                                    data-original-title="prix par défaut">
                                    <input name="default-price-parfum-g1" value="" type="radio" checked="checked">
                                    <span></span>
                                </label>
                                <div class="form-group mg-r-10">
                                    <select id="default-select-parfum" name="parfum[]" style="width:380px"
                                        class="default-select-parfum-g1 select2-modal-add form-control" data-placeholder="Sélectionnez un parfum">
                                        <option></option>
                                        @foreach ($parfums as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mg-r-10">
                                    <input type="text" class="form-control" name="parfum-price[]" onpaste="return false;"
                                        onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                        placeholder="Prix" data-toggle="popover" data-placement="right"
                                        data-trigger="hover focus" data-html="true"
                                        data-content="<small><i class='text-info fa fa-info-circle'></i> <strong>Exemple du format de Prix :</strong><br><strong>500</strong> : Cinq cents millimes <br><strong>1000</strong> : Un dinar et zéro millimes.<br><strong>10500</strong> : Dix dinars et cinq cents millimes.</small> ">
                                </div>
                                <button type="button" class="btn btn-gray btn-add-row" data-content="parfum-group-1" data-toggle="tooltip"
                                    data-group="group-1" data-placement="right" title="" data-original-title="Ajouter autre parfum">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                            </div><!-- form-group -->
                        </div><!-- form-group -->

                        <div class="group-2 form-group d-none">
                            <div class="form-inline mg-b-0 pd-b-15">
                                <label class="rdiobox" data-toggle="tooltip" data-placement="top" title=""
                                    data-group="group-2" data-original-title="prix par défaut">
                                    <input name="default-price-parfum-g2" value="" type="radio" checked>
                                    <span></span>
                                </label>
                                <div class="form-group mg-r-10">
                                    <select name="p-parfum[]" style="width:200px"
                                        class="default-select-parfum-g2 select2-modal-add form-control" data-placeholder="Sélectionnez un parfum">
                                        <option></option>
                                        @foreach ($parfums as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group mg-r-10">
                                    <select id="default-select-parfum-dimension" name="p-parfum-dimension[]" style="width:220px"
                                        class="default-select-parfum-dimension-g2 select2-modal-add form-control" data-placeholder="Sélectionnez un dimension">
                                        <option></option>
                                        @foreach ($sizes as $item)
                                        <option value="{{$item->id}}">{{$item->size_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mg-r-10">
                                    <input type="text" class="form-control" style="width:140px" name="p-parfum-price[]" onpaste="return false;"
                                        onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                        placeholder="Prix" data-toggle="popover" data-placement="right"
                                        data-trigger="hover focus" data-html="true"
                                        data-content="<small><i class='text-info fa fa-info-circle'></i> <strong>Exemple du format de Prix :</strong><br><strong>500</strong> : Cinq cents millimes <br><strong>1000</strong> : Un dinar et zéro millimes.<br><strong>10500</strong> : Dix dinars et cinq cents millimes.</small> ">
                                </div>
                                <button type="button" class="btn btn-gray btn-add-row" data-content="parfum-group-2" data-toggle="tooltip"
                                    data-group="group-2" data-placement="right" title="" data-original-title="Ajouter autre parfum">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                            </div>
                        </div>


                        <label class="mg-t-15" for="field-a2">Accessoires Décoratifs : </label>

                        <div class="form-group row mg-b-0 pd-b-15">

                            <div class="col-md-2 mg-t-10">
                                <div id="decors-dimension" class="br-toggle-switcher br-toggle br-toggle-rounded br-toggle-success no-required">
                                    <div class="br-toggle-switch"></div>
                                </div>
                            </div>
                            <div class="col-md-5 col-form-label">
                                <span class="br-toggle-badge badge badge-black " style="font-size:14px">
                                    prix en fonction de la dimension &nbsp;<i class="fa fa-question-circle"></i>
                                    {{-- prix est en fonction de dimension &nbsp;<i class="fa fa-check-circle"></i> --}}
                                    {{-- <i class="fa fa-check-circle"></i> --}}
                                </span>
                            </div>

                        </div><!-- form-group -->

                        {{-- single default price --}}
                        <div class="group-1 form-group">
                            <div class="form-group form-inline mg-b-0 pd-b-15">
                                <label class="rdiobox" data-toggle="tooltip" data-placement="top" title=""
                                    data-original-title="prix par défaut">
                                    <input name="default-price-decor-g1" value="" type="radio" checked>
                                    <span></span>
                                </label>
                                <div class="form-group mg-r-10">
                                    <select id="default-select-decors" name="decors[]" style="width:380px"
                                        class="default-select-decors-g1 select2-modal-add form-control" data-placeholder="Sélectionnez un accessoire">
                                        <option></option>
                                        @foreach ($decors as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mg-r-10">
                                    <input type="text" class="form-control" name="decors-price[]" onpaste="return false;"
                                        onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                        placeholder="Prix">
                                </div>
                                <button type="button" class="btn btn-gray btn-add-row" data-content="decor-group-1" data-toggle="tooltip"
                                    data-group="group-1" data-placement="right" title="" data-original-title="Ajouter autre décor">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                            </div><!-- form-group -->
                        </div><!-- form-group -->

                        <div class="group-2 form-group d-none">
                            <div class="form-inline mg-b-0 pd-b-15">
                                <label class="rdiobox" data-toggle="tooltip" data-placement="top" title=""
                                    data-original-title="prix par défaut">
                                    <input name="default-price-decor-g2" value="" type="radio" checked>
                                    <span></span>
                                </label>
                                <div class="form-group mg-r-10">
                                    <select name="p-decors[]" style="width:200px"
                                        class="default-select-decors-g2 select2-modal-add form-control" data-placeholder="Sélectionnez un accessoire">
                                        <option></option>
                                        @foreach ($decors as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group mg-r-10">
                                    <select id="default-select-decors-dimension" name="p-decors-dimension[]" style="width:220px"
                                        class="default-select-decors-dimension-g2 select2-modal-add form-control" data-placeholder="Sélectionnez un dimension">
                                        <option></option>
                                        @foreach ($sizes as $item)
                                        <option value="{{$item->id}}">{{$item->size_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mg-r-10">
                                    <input type="text" class="form-control" style="width:140px" name="p-decors-price[]" onpaste="return false;"
                                        onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                        placeholder="Prix" >
                                </div>
                                <button type="button" class="btn btn-gray btn-add-row" data-content="decor-group-2" data-toggle="tooltip"
                                    data-group="group-2" data-placement="right" title="" data-original-title="Ajouter autre décor">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-group mg-b-5 pd-b-15">
                            <label for="">Image : <small>(450x560)</small><span class="tx-danger">*</span></label>
                            <div class="custom-file">
                                <input type="file" name="img" class="field-a-upload custom-file-input" id="" required>
                                <label id="" class="file-a-label custom-file-label custom-file-label-primary" for="field-a-upload">Choisir Image</label>
                            </div>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->

                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="">Catégorie(s) : <span class="tx-danger">*</span></label>
                            <select name="tags[]" class="form-control select2-multi" data-placeholder="Sélectionner catégorie" multiple style="width: 100%" required>
                                @foreach ($tags as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->

                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="">Sous familles : </label>
                            <select name="sub_tags[]" class="form-control select2-multi" data-placeholder="Sélectionner sous famille(s)" multiple style="width: 100%">
                                {{-- @foreach ($sub_tags as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach --}}
                            </select>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->

                        <div class="form-group mg-b-0">
                            <label for="field-a6">Statut : <small>(Active par défaut)</small>&nbsp;&nbsp;</label>
                            <br>
                            <div style="bottom:-6px" class="mg-l-5 br-toggle br-toggle-rounded br-toggle-success on">
                                <div class="br-toggle-switch"></div>
                            </div>
                        </div><!-- form-group -->
                    </div>
                    <div class="modal-footer">
                        <button type="submit"
                            class="btn btn-gray tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Enregistrer</button>
                        <button id="reset-form-add" type="button"
                            class="btn btn-yellow tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Vider les champs</button>
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
        <div class="modal-dialog modal-dialog-vertical-center" role="document" style="max-width: 710px;">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold"><i class="icon ion-android-create"></i>
                        modifier UN PRODUIT</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon ion-ios-close"></i></span>
                    </button>
                </div>
                <form id="form-edit" method="post" class="needs-validation" novalidate>
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div id="modal-edit-body" class="modal-body pd-25">
                        
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
        <a href="#" class="btn btn-yellow btn-with-icon btn-block" data-toggle="modal" data-target="#modal-add">
            <div class="ht-40 justify-content-between text-black">
                <span class="pd-x-15 tx-bold">AJOUTER UN PRODUIT</span>
                <span class="icon wd-40"><i class="fa fa-plus-circle"></i></span>
            </div>
        </a>
    </div>
    @endif

    <div class="table-wrapper">
        <table id="datatable1" class="table display responsive nowrap">
            <thead class="thead-colored thead-black">
                <tr>
                    <th class="">#</th>
                    <th class="wd-10p">REF</th>
                    <th class="wd-25p">Nom de produit</th>
                    <th class="wd-15p">Prix par défaut</th>
                    <th class="wd-15p">date de création</th>
                    <th class="wd-15p">Statut</th>
                    <th class="wd-20p">Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $key => $item)
                
                <tr id="item-{{ $item->id }}">
                    <td class="text-center">
                        @if ($item->productImgs->isNotEmpty())
                            <img class="img-show ht-50 wd-50" src="{{ asset('/thumbs/' . $item->productImgs->first()->img ) }}" alt="">
                        @endif
                    </td>
                    <td class="tx-inverse">{{ $item->ref }}</td>
                    <td class="tx-inverse">{{ $item->name }}</td>
                    <td class="tx-inverse">{{ number_format($item->default_price, 3) }}</td>
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
                            data-id="{{ $item->id }}" data-effect="effect-scale" data-toggle="tooltip"
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
        <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="" class="imagepreview" style="width: 100%;">
                    </div>
                </div>
            </div>
        </div>
    @stop

@section('js')
    @parent
    <script src="{{ asset('assets/static/js/scripts/products.js') }}"></script>
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