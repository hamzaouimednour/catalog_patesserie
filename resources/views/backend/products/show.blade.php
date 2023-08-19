@php
    $perms = Session::get('perms');
    $actions = array();
    if($perms->where('controller', 'products')->isNotEmpty() && !empty($perms->where('controller', 'products')->first()))
        $actions = $perms->where('controller', 'products')->first()->actions;
	if(Session::get('is_admin')){
        $actions = ['A', 'M', 'D', 'P'];
    }
@endphp
@if (!empty($actions) && in_array('M', $actions) || Session::get('is_admin'))
                        <div id="modal-edit-msg"></div>
                        
                        <input name="id" value="{{$product->id}}" type="hidden"/>

                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="field-e0">Référence  : <span class="tx-danger">*</span></label>
                            <input id="field-e0" type="text" name="ref" class="form-control"
                                value="{{$product->ref}}" placeholder="Référence du produit" required>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->
                        
                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="field-e1">Produit : <span class="tx-danger">*</span></label>
                            <input id="field-e1" type="text" name="name" class="form-control"
                                value="{{$product->name}}" placeholder="Nom du produit" required>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->
                        
                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="field-e2">Description : </label>
                            <textarea id="field-e2" type="text" name="description" class="mg-t-0 mg-b-0 form-control"
                                placeholder="Description du produit" style="height: 140px;">{{$product->description}}</textarea>
                        </div><!-- form-group -->

                        <label for="field-a3">Prix : <span class="tx-danger">*</span></label>
                        
                        {{-- price based on size --}}
                        <div class="form-group row mg-b-0 pd-b-15">

                            {{-- check if item has one price or prices by sizes --}}
                            
                            <div class="col-md-2 mg-t-10">
                            <div id="price-dimension-edit" class="br-toggle-switcher br-toggle br-toggle-rounded br-toggle-success no-required {{($product->price_by_size == '1') ? 'on' : NULL}}">
                                    <div class="br-toggle-switch"></div>
                                </div>
                            </div>
                            <div class="col-md-5 col-form-label">
                                <span class="br-toggle-badge badge badge-black " style="font-size:14px">
                                    @php
                                        if(!$product->price_by_size){
                                            echo 'prix en fonction de la dimension &nbsp;<i class="fa fa-question-circle"></i>';
                                        }else{
                                            echo 'prix est en fonction de dimension &nbsp;<i class="fa fa-check-circle"></i>';
                                        }
                                    @endphp
                                </span>
                            </div>

                        </div><!-- form-group -->

                        {{-- single default price --}}
                        <div class="group-1 form-group mg-b-0 pd-b-15 {{($product->price_by_size == '1') ? 'd-none' : NULL}}">
                            <input type="text" name="price" class="form-control"
                                value="{{($product->price_by_size == '0') ? ($product->default_price * 1000) : NULL}}"
                                placeholder="Prix du produit"
                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57">
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->

                        {{-- price based on size --}}
                        {{-- get default price id --}}
                        <div class="group-2 form-group {{($product->price_by_size == '1') ? NULL : 'd-none'}}">
                        @if ($product->price_by_size)
                        @php
                            $firstRow = 0;
                        @endphp
                        @foreach ($product->productSizePrices as $sizePrice)
                                
                            <div class="form-inline mg-b-0 pd-b-15">
                                <label class="rdiobox" data-toggle="tooltip" data-placement="top" title=""
                                    data-original-title="prix par défaut">
                                    {{-- set default price --}}
                                    <input name="default-price" value="{{$sizePrice->size_id}}" type="radio" {{($sizePrice->default) ? "checked" : NULL}}>
                                    <span></span>
                                </label>
                                <div class="form-group mg-r-10">
                                    <select name="p-dimension[]" style="width:380px"
                                        class="default-select-price select2-modal-edit form-control" data-placeholder="Sélectionnez un dimension">
                                        <option></option>
                                        @foreach ($sizes as $item)
                                            <option value="{{$item->id}}" {{ ($sizePrice->size_id == $item->id) ? "selected" : NULL}}>{{$item->size_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mg-r-10">
                                    <input type="text" class="form-control" name="p-dimension-price[]" onpaste="return false;"
                                        value="{{($sizePrice->price * 1000)}}" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                        placeholder="Prix" data-toggle="popover" data-placement="right"
                                        data-trigger="hover focus" data-html="true"
                                        data-content="<small><i class='text-info fa fa-info-circle'></i> <strong>Exemple du format de Prix :</strong><br><strong>500</strong> : Cinq cents millimes <br><strong>1000</strong> : Un dinar et zéro millimes.<br><strong>10500</strong> : Dix dinars et cinq cents millimes.</small> ">
                                </div>
                                @if ($firstRow)
                                    <button type="button" class="btn btn-danger btn-del" data-toggle="tooltip"
                                        data-placement="right" title="" data-original-title="Supprimer ce champ">
                                        <i class="fa fa-times-circle"></i>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-gray btn-add-row" data-content="price" data-index="0" data-toggle="tooltip"
                                        data-group="group-2" data-placement="right" title="" data-original-title="Ajouter autre dimension">
                                        <i class="fa fa-plus-circle"></i>
                                    </button>
                                @endif
                                
                            </div>
                            @php
                                $firstRow++;
                            @endphp
                            @endforeach
                            @else
                                <div class="form-inline mg-b-0 pd-b-15">
                                    <label class="rdiobox" data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="prix par défaut">
                                        <input name="default-price" value="" type="radio" checked>
                                        <span></span>
                                    </label>
                                    <div class="form-group mg-r-10">
                                        <select name="p-dimension[]" style="width:380px"
                                            class="default-select-price select2-modal-edit form-control" data-placeholder="Sélectionnez un dimension">
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
                            @endif
                        </div>




                        <label class="mg-t-15" for="field-a2">Parfums : <span class="tx-danger">*</span></label>
                        
                        <div class="form-group row mg-b-0 pd-b-15">

                            <div class="col-md-2 mg-t-10">
                                <div id="parfum-dimension-edit" class="br-toggle-switcher br-toggle br-toggle-rounded br-toggle-success no-required {{($productParfums->isNotEmpty() && $productParfums->first()->price_by_size == '1') ? 'on' : NULL}}">
                                    <div class="br-toggle-switch"></div>
                                </div>
                            </div>
                            <div class="col-md-5 col-form-label">
                                <span class="br-toggle-badge badge badge-black" style="font-size:14px">
                                    @if ($productParfums->isNotEmpty() && !$productParfums->first()->price_by_size)
                                        prix en fonction de la dimension &nbsp;<i class="fa fa-question-circle"></i>
                                    @else
                                        prix est en fonction de dimension &nbsp;<i class="fa fa-check-circle"></i>
                                    @endif
                                </span>
                            </div>

                        </div><!-- form-group -->

                        @if ($productParfums->isEmpty())
                            {{-- single default price --}}
                        <div class="group-1 form-group">
                            <div class="form-inline mg-b-0 pd-b-15">
                                <label class="rdiobox" data-toggle="tooltip" data-placement="top" title=""
                                    data-original-title="prix par défaut">
                                    <input name="default-price-parfum-g1" value="" type="radio" checked="checked">
                                    <span></span>
                                </label>
                                <div class="form-group mg-r-10">
                                    <select name="parfum[]" style="width:380px"
                                        class="default-select-parfum-g1 select2-modal-edit form-control" data-placeholder="Sélectionnez un parfum">
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
                                        class="default-select-parfum-g2 select2-modal-edit form-control" data-placeholder="Sélectionnez un parfum">
                                        <option></option>
                                        @foreach ($parfums as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group mg-r-10">
                                    <select name="p-parfum-dimension[]" style="width:220px"
                                        class="default-select-parfum-dimension-g2 select2-modal-edit form-control" data-placeholder="Sélectionnez un dimension">
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
                        @else
                            
                        {{-- single default price --}}
                        <div class="group-1 form-group {{($productParfums->first()->price_by_size) ? 'd-none' : NULL }}">
                           {{-- empty fields --}}
                            @if ($productParfums->first()->price_by_size)
                                <div class="form-inline mg-b-0 pd-b-15">
                                    <label class="rdiobox" data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="prix par défaut">
                                        <input name="default-price-parfum-g1" value="" type="radio" checked="checked">
                                        <span></span>
                                    </label>
                                    <div class="form-group mg-r-10">
                                        <select name="parfum[]" style="width:380px"
                                            class="default-select-parfum-g1 select2-modal-edit form-control" data-placeholder="Sélectionnez un parfum">
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
                            @else
                            {{-- Not empty fields --}}
                            @php
                                $firstRow = 0;
                            @endphp
                            @foreach ($productParfums as $parfum)
                                <div class="form-inline mg-b-0 pd-b-15">
                                    <label class="rdiobox" data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="prix par défaut">
                                        <input name="default-price-parfum-g1" value="{{$parfum->component_id}}" type="radio" {{($parfum->default) ? "checked" : NULL }}>
                                        <span></span>
                                    </label>
                                    <div class="form-group mg-r-10">
                                        <select name="parfum[]" style="width:380px"
                                            class="default-select-parfum-g1 select2-modal-edit form-control" data-placeholder="Sélectionnez un parfum">
                                            <option></option>
                                            @foreach ($parfums as $item)
                                                <option value="{{$item->id}}" {{($item->id == $parfum->component_id) ? "selected" : NULL}}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mg-r-10">
                                        <input type="text" class="form-control" name="parfum-price[]" onpaste="return false;"
                                            value="{{($parfum->default_price * 1000)}}" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                            placeholder="Prix" data-toggle="popover" data-placement="right"
                                            data-trigger="hover focus" data-html="true"
                                            data-content="<small><i class='text-info fa fa-info-circle'></i> <strong>Exemple du format de Prix :</strong><br><strong>500</strong> : Cinq cents millimes <br><strong>1000</strong> : Un dinar et zéro millimes.<br><strong>10500</strong> : Dix dinars et cinq cents millimes.</small> ">
                                    </div>
                                    @if ($firstRow)
                                        <button type="button" class="btn btn-danger btn-del" data-toggle="tooltip"
                                            data-placement="right" title="" data-original-title="Supprimer ce champ">
                                            <i class="fa fa-times-circle"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-gray btn-add-row" data-content="parfum-group-1" data-toggle="tooltip"
                                            data-group="group-1" data-placement="right" title="" data-original-title="Ajouter autre parfum">
                                            <i class="fa fa-plus-circle"></i>
                                        </button>
                                    @endif
                                </div><!-- form-group -->
                            @php
                                $firstRow++;
                            @endphp
                            @endforeach
                            @endif

                        </div><!-- form-group -->

                        <div class="group-2 form-group {{($productParfums->first()->price_by_size) ? NULL : 'd-none' }}">
                            @if ($productParfums->first()->price_by_size)
                            @php
                                $firstRow = 0;
                            @endphp
                            @foreach ($productParfums as $parfum)
                                {{-- avoid getting error bcz of humain stupidty --}}
                                @if(!empty($parfum->productComponentPrices->first()))
                                <div class="form-inline mg-b-0 pd-b-15">
                                    <label class="rdiobox" data-toggle="tooltip" data-placement="top" title=""
                                        data-group="group-2" data-original-title="prix par défaut">
                                        <input name="default-price-parfum-g2" value="{{$parfum->component_id}}-{{$parfum->productComponentPrices->first()->size_id}}" type="radio" {{($parfum->default && ($parfum->productComponentPrices->first()->price == $parfum->default_price) ) ? "checked" : NULL}}>
                                        <span></span>
                                    </label>
                                    <div class="form-group mg-r-10">
                                        <select name="p-parfum[]" style="width:200px"
                                            class="default-select-parfum-g2 select2-modal-edit form-control" data-placeholder="Sélectionnez un parfum">
                                            <option></option>
                                            @foreach ($parfums as $item)
                                                <option value="{{$item->id}}" {{($parfum->component_id == $item->id) ? "selected" : NULL}}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group mg-r-10">
                                        <select name="p-parfum-dimension[]" style="width:220px"
                                            class="default-select-parfum-dimension-g2 select2-modal-edit form-control" data-placeholder="Sélectionnez un dimension">
                                            <option></option>
                                            @foreach ($sizes as $item)
                                                <option value="{{$item->id}}" {{($parfum->productComponentPrices->first()->size_id ==$item->id) ? "selected" : NULL}}>{{$item->size_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mg-r-10">
                                        <input type="text" class="form-control" style="width:140px" name="p-parfum-price[]" onpaste="return false;"
                                            value="{{($parfum->productComponentPrices->first()->price*1000)}}" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                            placeholder="Prix" data-toggle="popover" data-placement="right"
                                            data-trigger="hover focus" data-html="true"
                                            data-content="<small><i class='text-info fa fa-info-circle'></i> <strong>Exemple du format de Prix :</strong><br><strong>500</strong> : Cinq cents millimes <br><strong>1000</strong> : Un dinar et zéro millimes.<br><strong>10500</strong> : Dix dinars et cinq cents millimes.</small> ">
                                    </div>
                                    @if ($firstRow)
                                        <button type="button" class="btn btn-danger btn-del" data-toggle="tooltip"
                                            data-placement="right" title="" data-original-title="Supprimer ce champ">
                                            <i class="fa fa-times-circle"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-gray btn-add-row" data-content="parfum-group-2" data-toggle="tooltip"
                                            data-group="group-2" data-placement="right" title="" data-original-title="Ajouter autre parfum">
                                            <i class="fa fa-plus-circle"></i>
                                        </button>
                                    @endif
                                    
                                </div>
                                @endif

                            @php
                                $firstRow++;
                            @endphp
                            @endforeach
                            {{-- No price by size --}}
                            @else
                                <div class="form-inline mg-b-0 pd-b-15">
                                    <label class="rdiobox" data-toggle="tooltip" data-placement="top" title=""
                                        data-group="group-2" data-original-title="prix par défaut">
                                        <input name="default-price-parfum-g2" value="" type="radio" checked>
                                        <span></span>
                                    </label>
                                    <div class="form-group mg-r-10">
                                        <select name="p-parfum[]" style="width:200px"
                                            class="default-select-parfum-g2 select2-modal-edit form-control" data-placeholder="Sélectionnez un parfum">
                                            <option></option>
                                            @foreach ($parfums as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group mg-r-10">
                                        <select name="p-parfum-dimension[]" style="width:220px"
                                            class="default-select-parfum-dimension-g2 select2-modal-edit form-control" data-placeholder="Sélectionnez un dimension">
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
                            @endif
                        </div>
                        @endif

                        <label class="mg-t-15" for="field-a2">Accessoires Décoratifs : </label>

                        <div class="form-group row mg-b-0 pd-b-15">

                            <div class="col-md-2 mg-t-10">
                                <div id="decors-dimension-edit" class="br-toggle-switcher br-toggle br-toggle-rounded br-toggle-success no-required {{($productDecors->isNotEmpty() && $productDecors->first()->price_by_size == '1') ? 'on' : NULL}}">
                                    <div class="br-toggle-switch"></div>
                                </div>
                            </div>
                            <div class="col-md-5 col-form-label">
                                <span class="br-toggle-badge badge badge-black " style="font-size:14px">
                                    @if ($productDecors->isNotEmpty() && !$productDecors->first()->price_by_size)
                                        prix en fonction de la dimension &nbsp;<i class="fa fa-question-circle"></i>
                                    @else
                                        prix est en fonction de dimension &nbsp;<i class="fa fa-check-circle"></i>
                                    @endif
                                </span>
                            </div>

                        </div><!-- form-group -->

                        @if ($productDecors->isEmpty())
                            {{-- single default price --}}
                        <div class="group-1 form-group">
                            <div class="form-group form-inline mg-b-0 pd-b-15">
                                <label class="rdiobox" data-toggle="tooltip" data-placement="top" title=""
                                    data-original-title="prix par défaut">
                                    <input name="default-price-decor-g1" value="" type="radio" checked>
                                    <span></span>
                                </label>
                                <div class="form-group mg-r-10">
                                    <select name="decors[]" style="width:380px"
                                        class="default-select-decors-g1 select2-modal-edit form-control" data-placeholder="Sélectionnez un accessoire">
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
                                        class="default-select-decors-g2 select2-modal-edit form-control" data-placeholder="Sélectionnez un accessoire">
                                        <option></option>
                                        @foreach ($decors as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group mg-r-10">
                                    <select name="p-decors-dimension[]" style="width:220px"
                                        class="default-select-decors-dimension-g2 select2-modal-edit form-control" data-placeholder="Sélectionnez un dimension">
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
                        @else

                        {{-- single default price --}}
                        <div class="group-1 form-group {{($productDecors->first()->price_by_size) ? 'd-none' : NULL}}">
                            @if ($productDecors->first()->price_by_size)
                                <div class="form-group form-inline mg-b-0 pd-b-15">
                                    <label class="rdiobox" data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="prix par défaut">
                                        <input name="default-price-decor-g1" value="" type="radio" checked>
                                        <span></span>
                                    </label>
                                    <div class="form-group mg-r-10">
                                        <select name="decors[]" style="width:380px"
                                            class="default-select-decors-g1 select2-modal-edit form-control" data-placeholder="Sélectionnez un accessoire">
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
                            @else
                            @php
                                $firstRow = 0;
                            @endphp
                            @foreach ($productDecors as $decor)
                                <div class="form-group form-inline mg-b-0 pd-b-15">
                                    <label class="rdiobox" data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="prix par défaut">
                                        <input name="default-price-decor-g1" value="{{$decor->component_id}}" type="radio" {{($decor->default) ? "checked" : NULL }}>
                                        <span></span>
                                    </label>
                                    <div class="form-group mg-r-10">
                                        <select name="decors[]" style="width:380px"
                                            class="default-select-decors-g1 select2-modal-edit form-control" data-placeholder="Sélectionnez un accessoire">
                                            <option></option>
                                            @foreach ($decors as $item)
                                            <option value="{{$item->id}}" {{($item->id == $decor->component_id) ? "selected" : NULL}}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mg-r-10">
                                        <input type="text" class="form-control" name="decors-price[]" onpaste="return false;"
                                            value="{{($decor->default_price * 1000)}}" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                            placeholder="Prix">
                                    </div>
                                    @if ($firstRow)
                                        <button type="button" class="btn btn-danger btn-del" data-toggle="tooltip"
                                            data-placement="right" title="" data-original-title="Supprimer ce champ">
                                            <i class="fa fa-times-circle"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-gray btn-add-row" data-content="decor-group-1" data-toggle="tooltip"
                                            data-group="group-1" data-placement="right" title="" data-original-title="Ajouter autre décor">
                                            <i class="fa fa-plus-circle"></i>
                                        </button>
                                    @endif
                                    
                                </div><!-- form-group -->
                            @php
                                $firstRow++;
                            @endphp
                            @endforeach
                            @endif
                            
                        </div><!-- form-group -->

                        <div class="group-2 form-group {{($productDecors->first()->price_by_size) ? NULL : 'd-none'}}">
                            @if ($productDecors->first()->price_by_size)
                            @php
                                $firstRow = 0;
                            @endphp
                            @foreach ($productDecors as $decor)
                                @if(!empty($productDecors->productComponentPrices->first()))
                                <div class="form-inline mg-b-0 pd-b-15">
                                    <label class="rdiobox" data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="prix par défaut">
                                        <input name="default-price-decor-g2" value="{{$decor->component_id}}-{{$decor->productComponentPrices->first()->size_id}}" type="radio" {{($decor->default && ($decor->productComponentPrices->first()->price == $decor->default_price) ) ? "checked" : NULL}}>
                                        <span></span>
                                    </label>
                                    <div class="form-group mg-r-10">
                                        <select name="p-decors[]" style="width:200px"
                                            class="default-select-decors-g2 select2-modal-edit form-control" data-placeholder="Sélectionnez un accessoire">
                                            <option></option>
                                            @foreach ($decors as $item)
                                            <option value="{{$item->id}}" {{($decor->component_id == $item->id) ? "selected" : NULL}}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group mg-r-10">
                                        <select name="p-decors-dimension[]" style="width:220px"
                                            class="default-select-decors-dimension-g2 select2-modal-edit form-control" data-placeholder="Sélectionnez un dimension">
                                            <option></option>
                                            @foreach ($sizes as $item)
                                            <option value="{{$item->id}}" {{($decor->productComponentPrices->first()->size_id == $item->id) ? "selected" : NULL}}>{{$item->size_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mg-r-10">
                                        <input type="text" class="form-control" style="width:140px" name="p-decors-price[]" onpaste="return false;"
                                            value="{{($decor->productComponentPrices->first()->price*1000)}}" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                            placeholder="Prix" >
                                    </div>
                                    @if ($firstRow)
                                        <button type="button" class="btn btn-danger btn-del" data-toggle="tooltip"
                                            data-placement="right" title="" data-original-title="Supprimer ce champ">
                                            <i class="fa fa-times-circle"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-gray btn-add-row" data-content="decor-group-2" data-toggle="tooltip"
                                            data-group="group-2" data-placement="right" title="" data-original-title="Ajouter autre décor">
                                            <i class="fa fa-plus-circle"></i>
                                        </button>
                                    @endif
                                </div>
                                @endif
                                
                            @php
                                $firstRow++;
                            @endphp
                            @endforeach
                            {{-- No price by size --}}
                            @else
                                <div class="form-inline mg-b-0 pd-b-15">
                                    <label class="rdiobox" data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="prix par défaut">
                                        <input name="default-price-decor-g2" value="" type="radio" checked>
                                        <span></span>
                                    </label>
                                    <div class="form-group mg-r-10">
                                        <select name="p-decors[]" style="width:200px"
                                            class="default-select-decors-g2 select2-modal-edit form-control" data-placeholder="Sélectionnez un accessoire">
                                            <option></option>
                                            @foreach ($decors as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group mg-r-10">
                                        <select name="p-decors-dimension[]" style="width:220px"
                                            class="default-select-decors-dimension-g2 select2-modal-edit form-control" data-placeholder="Sélectionnez un dimension">
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
                            @endif

                        </div>
                        @endif
                        
                        <div class="form-group mg-b-5 pd-b-15">
                            <label for="">Image Cart: <small>(450x560)</small><span class="tx-danger">*</span></label>
                            <div class="custom-file">
                                <input type="file" name="img" class="field-e-upload custom-file-input" id="">
                                <label id="" class="file-e-label custom-file-label custom-file-label-primary" for="field-a-upload">Choisir Image</label>
                            </div>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->

                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="">Catégorie(s) : <span class="tx-danger">*</span></label>
                            <select name="tags[]" class="form-control select2-multi" data-placeholder="Sélectionner catégorie" multiple style="width: 100%" required>
                                @foreach ($tags as $item)
                                    <option value="{{$item->id}}" {{(!empty($productTags) && $productTags->contains($item->id)) ? "selected" : NULL}}>{{$item->name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->

                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="">Sous familles : </label>
                            <select name="sub_tags[]" class="form-control select2-multi" data-placeholder="Sélectionner sous famille(s)" multiple style="width: 100%">
                                @foreach ($sub_tags as $item)
                                    <option value="{{$item->id}}" {{(!empty($productSubTags) && $productSubTags->contains($item->id)) ? "selected" : NULL}}>{{$item->name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->
@endif