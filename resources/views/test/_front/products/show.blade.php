                            <div id="modal-msg" class="mt-5">
                                <div id="modal-msg-success" class="alert alert-success d-none">
                                    <button type="button" class="" data-dismiss="alert"><span aria-hidden="true">×</span></button>
                                    <strong>Succès!</strong> Le produit ajouté au panier avec succès.
                                </div>
                                <div id="modal-msg-failed" class="alert alert-danger d-none">
                                    <button type="button" class="" data-dismiss="alert"><span aria-hidden="true">×</span></button>
                                    <strong>Echec!</strong> échec de l'ajout du produit au panier!
                                </div>
                            </div>
                            <form id="cart-form" name="cart-form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input name="id" value="{{$product->id}}" type="hidden"/>
                            <div class="modal-product clearfix">
                                <div class="product-images mt-4">
                                    <div class="main-image images">
                                        <img id="product-img" src="/thumbs/{{$product->productImgs->first()->img}}">
                                    </div>
                                    <hr>
                                     <div class="col text-justify" >
                                        <p class="mb-0" style="font-size:16px;font-family:Arial;">{{$product->description}}</p>
                                    </div>
                                </div><!-- .product-images -->
                                
                                <div class="product-info">
                                    <h1 id="product-name">{{$product->name}}</h1>
                                    <div class="price-box-3">
                                        <div class="s-price-box text-center" style="font-family:Arial, Helvetica, sans-serif;">
                                            <span class="new-price" id="product-price">{{ ($product->default_price) ? number_format($product->default_price, 3) : number_format($productParfums->where('default', 1)->first()->default_price, 3) }} <small>DT</small></span>
                                        </div>
                                    </div>
                                    <div class="text-center pt-5 quick-add-to-cart">
                                        {{-- <form method="post" class="cart "> --}}
                                            <button id="qty-minus" class="qty single_add_to_cart_button mr-4" style="padding:0 15px;font-size:20px;">-</button>
                                            <div class="numbers-row">
                                                <input name="qty" class="qty float-num" type="text" id="items-qty" value="1" maxlength="999"  style="width:100px;font-weight: bold;font-family:Arial;color:#000;font-size:20px;text-align: center;margin-bottom: 0px;padding-left: 0px;">
                                            </div>
                                            <button id="qty-plus" class="qty single_add_to_cart_button" style="padding:0 15px;font-size:20px;">+</button>
                                        {{-- </form> --}}
                                    </div>
                                   
                                    @if ($product->price_by_size)
                                        <div class="form-group quick-desc">
                                            <label class="text-black label-cart"><strong>Dimension</strong></label>
                                            <select class="select2" name="dimension" placeholder="Sélectionnez un choix" data-allow-clear="1" style="width:100%;">
                                                @foreach ($product->productSizePrices as $item)
                                                    @if ($item->default)
                                                        @php
                                                            $selected_item = $item->id;
                                                        @endphp
                                                    @endif
                                                    <option value="{{$item->id}}" data-price="{{$item->price * 1000}}" {{($item->default) ? 'selected' : NULL}}>{{$item->Size->size_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                    @if(!$product->price_by_size && $product->default_price)
                                        <div class="form-group quick-desc">
                                        <label class="text-black label-cart"><strong>Prix</strong></label>
                                        <select class="select2 c-none" name="default_price" placeholder="Prix par defaut" data-allow-clear="1"  style="width:100%;">
                                            <option value="{{$product->default_price * 1000}}" data-price="{{$product->default_price * 1000}}" selected>{{number_format($product->default_price, 3, '.', ',')}} DT</option>
                                        </select>
                                        </div>
                                    @endif

                                    {{-- Get product parfums --}}

                                    @if ($productParfums->isNotEmpty() && $productParfums->first()->price_by_size && $product->price_by_size)
                                        <div class="form-group quick-desc">
                                        <label class="text-black label-cart"><strong>Parfums</strong></label>
                                        <select class="select2" name="parfums" data-price-size="true" placeholder="Sélectionnez un choix" data-allow-clear="1"  style="width:100%;">
                                            <option></option>
                                            @php
                                                $_dimension_id = $product->productSizePrices->where('id', $selected_item )->first()->size_id;
                                                foreach ($productParfums as $item) {
                                                    if($item->productComponentPrices->first()->size_id == $_dimension_id){
                                                        echo '<option value="'.$item->component_id.'">'.$item->Component->name.'</option>';
                                                    }
                                                }
                                            @endphp
                                            {{-- @foreach ($productParfums->unique('component_id') as $parfum)
                                                <option value="{{$parfum->component_id}}" data-price=''>{{$parfum->Component->name}}</option>
                                            @endforeach --}}
                                        </select>
                                        <input type="hidden" name="parfums-price-size" value="1">
                                        </div>                                        
                                    @endif
                                    
                                    {{-- in case there is no default prices even by size --}}
                                    @if ($productParfums->isNotEmpty() && $productParfums->first()->price_by_size && !$product->price_by_size)
                                        <div class="form-group quick-desc">
                                        <label class="text-black label-cart"><strong>Dimension</strong></label>
                                        <select class="select2" name="dimension2" placeholder="Sélectionnez un choix" data-allow-clear="1"  style="width:100%;">
                                            @foreach ($parfums_dimensions->unique('size_id') as $item)
                                                @php
                                                    if($item->price == $productParfums->where('default', 1)->first()->default_price){
                                                        $_dimension_id = $item->size_id;
                                                    }
                                                    
                                                @endphp
                                                <option value="{{$item->size_id}}" data-price="" {{($item->price == $productParfums->where('default', 1)->first()->default_price) ? "selected" : NULL}}>{{$item->Size->size_name}}</option>
                                            @endforeach
                                        </select>
                                        </div>

                                        <div class="form-group quick-desc">
                                        <label class="text-black label-cart"><strong>Parfums</strong></label>
                                        <select class="select2" name="parfums" data-price-size="true" placeholder="Sélectionnez un choix" data-allow-clear="1"  style="width:100%;">
                                            <option></option>
                                            @php
                                                foreach ($productParfums as $item) {
                                                    if($item->productComponentPrices->first()->size_id == $_dimension_id){
                                                        echo '<option value="'.$item->component_id. '" '.(($item->default) ? 'selected' : NULL).'>'.$item->Component->name.'</option>';
                                                    }
                                                }
                                            @endphp
                                            {{-- @foreach ($productParfums->unique('component_id') as $parfum)
                                                <option value="{{$parfum->component_id}}" data-price='' {{($parfum->default) ? 'selected' : NULL}}>{{$parfum->Component->name}}</option>
                                            @endforeach --}}
                                        </select>
                                        <input type="hidden" name="parfums-price-size" value="1">
                                        </div>
                                    @endif

                                    {{-- parfums not by size --}}
                                    @if ($productParfums->isNotEmpty() && !$productParfums->first()->price_by_size)
                                        <div class="form-group quick-desc">
                                        <label class="text-black label-cart"><strong>Parfums</strong></label>
                                        <select class="select2" name="parfums" data-price-size="false" placeholder="Sélectionnez un choix" data-allow-clear="1"  style="width:100%;">
                                            <option></option>
                                            @foreach ($productParfums as $parfum)
                                                <option value="{{$parfum->id}}" data-price="{{$parfum->default_price * 1000}}" {{($product->price_by_size) ? NULL : (($parfum->default) ? 'selected' : NULL)}}>{{$parfum->Component->name}}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="parfums-price-size" value="0">
                                        </div>
                                    @endif

                                    {{-- Decors --}}
                                    {{-- decors not by size --}}
                                    @if ($productDecors->isNotEmpty() && !$productDecors->first()->price_by_size)
                                        <div class="form-group quick-desc">
                                        <label class="text-black label-cart"><strong>Accessoires Décoratifs</strong></label>
                                        <select class="select2" name="decors" data-price-size="false" placeholder="Sélectionnez un choix" data-allow-clear="1"  style="width:100%;">
                                            <option></option>
                                            @foreach ($productDecors as $decor)
                                                <option value="{{$decor->id}}" data-price="{{$decor->default_price * 1000}}" >{{$decor->Component->name}}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="decors-price-size" value="0">
                                        </div>
                                    @endif
                                        
                                    @if ($productDecors->isNotEmpty() && $productDecors->first()->price_by_size && $product->price_by_size)
                                        <div class="form-group quick-desc">
                                        <label class="text-black label-cart"><strong>Accessoires Décoratifs</strong></label>
                                        <select class="select2" name="decors" data-price-size="true" placeholder="Sélectionnez un choix" data-allow-clear="1"  style="width:100%;">
                                            <option></option>
                                            @php
                                                $_dimension_id = $product->productSizePrices->where('id', $selected_item )->first()->size_id;
                                                foreach ($productDecors as $item) {
                                                    if($item->productComponentPrices->first()->size_id == $_dimension_id){
                                                        echo '<option value="'.$item->component_id.'">'.$item->Component->name.'</option>';
                                                    }
                                                }
                                            @endphp
{{--                                             
                                            @foreach ($productDecors->unique('component_id') as $decor)
                                                <option value="{{$decor->component_id}}" data-price="">{{$decor->Component->name}}</option>
                                            @endforeach --}}
                                        </select>
                                        <input type="hidden" name="decors-price-size" value="1">
                                        </div>                                        
                                    @endif
                                    
                                    {{-- <pre>{{var_dump($productDecors->where('default', 1))}} --}}
                                    {{-- in case there is no default prices even by size --}}
                                    @if ($productDecors->isNotEmpty() && $productDecors->first()->price_by_size && !$product->price_by_size)
                                        @if ($productParfums->isEmpty() || !$productParfums->first()->price_by_size)
                                            <div class="form-group quick-desc">
                                            <label class="text-black label-cart"><strong>Dimension</strong></label>
                                            <select class="select2" name="dimension2" placeholder="Sélectionnez un choix" data-allow-clear="1"  style="width:100%;">
                                                <option></option>
                                                @foreach ($decors_dimensions->unique('size_id') as $item)
                                                    @php
                                                        if($item->price == $productDecors->where('default', 1)->first()->default_price){
                                                            $_dimension_id = $item->size_id;
                                                        }
                                                    @endphp
                                                    <option value="{{$item->size_id}}" data-price="" >{{$item->Size->size_name}}</option>
                                                @endforeach
                                            </select>
                                            </div>                                     
                                        @endif

                                        <div class="form-group quick-desc">
                                        <label class="text-black label-cart"><strong>Accessoires Décoratifs</strong></label>
                                        <select class="select2" name="decors" data-price-size="true" placeholder="Sélectionnez un choix" data-allow-clear="1"  style="width:100%;">
                                            <option></option>
                                            @php
                                                foreach ($productDecors as $item) {
                                                    if($item->productComponentPrices->first()->size_id == $_dimension_id){
                                                        echo '<option value="'.$item->component_id. '">'.$item->Component->name.'</option>';
                                                    }
                                                }
                                            @endphp
{{--                                             
                                            @foreach ($productDecors->unique('component_id') as $decor)
                                                <option value="{{$decor->component_id}}" data-price=''>{{$decor->Component->name}}</option>
                                            @endforeach --}}
                                        </select>
                                        <input type="hidden" name="decors-price-size" value="1">
                                        </div>
                                    @endif
                                    <div class="form-group quick-desc">
                                        <label class="text-black label-cart"><strong>Message sur le plateau (optionnel)</strong></label>
                                        <textarea class="custom-textarea" name="item-msg" placeholder="Message"></textarea>
                                    </div>

                                    </form>
                                    <div class="col text-center">
                                        <a id="cart-add" class="button large mt-5 mb-10 btn-hover-1" href="#" style="width:350px;background: #ffc040;"><span  style="color: #303030;">AJOUTER AU PANIER</span></a>
                                    </div>
                                </div><!-- .product-info -->
                            </div><!-- .modal-product -->