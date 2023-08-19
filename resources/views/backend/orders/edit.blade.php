@php
$perms = Session::get('perms');
$actions = array();
if($perms->where('controller', 'orders')->isNotEmpty() && !empty($perms->where('controller', 'orders')->first()))
    $actions = $perms->where('controller', 'orders')->first()->actions;
if(Session::get('is_admin')){
    $actions = ['A', 'M', 'D', 'P'];
}
@endphp
@if (!empty($actions) && in_array('M', $actions) || Session::get('is_admin'))

<table class="table text-center">
    <thead class="thead-dark">
        <tr>
            <th class="product-thumbnail" style="width:1px;white-space:nowrap;">PRODUIT</th>
            <th class="product-desg">Désignation</th>
            <th class="product-price">P.U</th>
            <th class="product-quantity">Quantité</th>
            <th class="product-subtotal">Montant</th>
            <th class="" style="width:1px;white-space:nowrap;">action</th>
        </tr>
    </thead>
    <tbody>
        <!-- tr -->
        @php
            $cart = json_decode($order->product_components, true);
        @endphp
        @if (!empty($cart))

        @foreach ($cart['items'] as $id => $produit)
        @php


            // get the data
            $product = $prod::find($id);

            $productParfums = collect([]);
            $productDecors = collect([]);
            $productTags = collect([]);

            if(!empty($product->productComponents))
                list($productParfums, $productDecors) = $product->productComponents->partition(function ($item) {
                    return $item->component->category == 'C';
                });

            //get Dimension where no price by size.
            $parfums_dimensions = collect([]);
            $decors_dimensions = collect([]);
            if ($productParfums->isNotEmpty() && $productParfums->first()->price_by_size && !$product->price_by_size){            
                $parfums_dimensions = $ProductComponentPrice::whereIn('product_component_id', $productParfums->pluck('id')->toArray())->get();
            }

            if ($productDecors->isNotEmpty() && $productDecors->first()->price_by_size && !$product->price_by_size){
                if ($productParfums->isEmpty() || !$productParfums->first()->price_by_size)
                $decors_dimensions = $ProductComponentPrice::whereIn('product_component_id', $productDecors->pluck('id')->toArray())->get();
            }


        @endphp
        @foreach ($produit as $key => $_item)
        @php
            $tr_id = str_replace('=', '', base64_encode('{"key": '.$id.', "index": '.$key.'}'));
        @endphp
        <tr id='{{$tr_id}}'>

            <td class="product-thumbnail wd-1">
                <div class="pro-thumbnail-img">
                    <img width="100" src="/thumbs/{{$product->productImgs->first()->img}}" alt="">
                </div>
            </td>

            <td class="item-data" id='{"field": "item","key": {{$id}}, "index": {{$key}}}'>
                <div class="form">

                <label class="tx-inverse"><i class="fa fa-check tx-success mg-r-8"></i> <strong class="tx-primary">{{$product->name}}</strong></label>
                @if ($product->price_by_size)
                <div class="form-group">
                    <label class="float-left text-black label-cart"><strong>Dimension</strong></label>
                    <select class="form-control select2-edit" name="dimension" placeholder="Sélectionnez un choix" 
                        style="width:100%;">
                        @foreach ($product->productSizePrices as $item)
                            <option value="{{$item->id}}" data-price="{{$item->price * 1000}}" {{(!empty($_item['dimension']) && ($item->size_id == $_item['dimension'])) ? 'selected' : NULL}}>{{$item->Size->size_name}}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                @if(!$product->price_by_size && $product->default_price)
                <div class="form-group">
                    <label class="float-left text-black label-cart"><strong>Prix</strong></label>
                    <select class="form-control select2-edit c-none" name="default_price" placeholder="Prix par defaut" style="width:100%;">
                        <option value="{{$product->default_price * 1000}}"
                            data-price="{{$product->default_price * 1000}}" selected>
                            {{number_format($product->default_price, 3, '.', ',')}} DT</option>
                    </select>
                </div>
                @endif

                {{-- Get product parfums --}}

                @if ($productParfums->isNotEmpty() && $productParfums->first()->price_by_size &&
                $product->price_by_size)
                <div class="form-group">
                    <label class="float-left text-black label-cart"><strong>Parfums</strong></label>
                    <select class="form-control select2-edit" name="parfums" data-price-size="true" placeholder="Sélectionnez un choix"
                        style="width:100%;">
                        <option></option>
                        @php
                        foreach ($productParfums as $item) {
                            var_dump($_item['parfums']['dimension_id']);
                            if($item->productComponentPrices->first()->size_id == $_item['parfums']['dimension_id']){
                                echo '<option value="'.$item->component_id.'" '. ((!empty($_item['parfums']['product_component_id']) && $item->id == $_item['parfums']['product_component_id']) ? ' selected' : NULL) .'>'.$item->Component->name.'</option>';
                            }
                        }
                        @endphp
                    </select>
                    <input type="hidden" name="parfums-price-size" value="1">
                </div>
                @endif

                {{-- in case there is no default prices even by size --}}
                @if ($productParfums->isNotEmpty() && $productParfums->first()->price_by_size &&
                !$product->price_by_size)
                <div class="form-group">
                    <label class="float-left text-black label-cart"><strong>Dimension</strong></label>
                    <select class="form-control select2-edit" name="dimension2" placeholder="Sélectionnez un choix" style="width:100%;">
                        @foreach ($parfums_dimensions->unique('size_id') as $item)
                            @php
                                if($item->size_id == $_item['parfums']['dimension_id']){
                                    $_dimension_id = $item->size_id;
                                }
                            @endphp
                        <option value="{{$item->size_id}}" {{((!empty($_item['parfums']['dimension_id']) && $item->size_id == $_item['parfums']['dimension_id']) ? "selected" : NULL)}}>
                            {{$item->Size->size_name}}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="float-left text-black label-cart"><strong>Parfums</strong></label>
                    <select class="form-control select2-edit" name="parfums" data-price-size="true" placeholder="Sélectionnez un choix"
                        style="width:100%;">
                        <option></option>
                        @php
                        foreach ($productParfums as $item) {
                            if($item->productComponentPrices->first()->size_id == $_dimension_id){
                            echo '<option value="'.$item->component_id. '" '.((!empty($_item['parfums']['product_component_id']) && $item->id == $_item['parfums']['product_component_id']) ? ' selected' : NULL).'>
                                '.$item->Component->name.'</option>';
                            }
                        }
                        @endphp
                    </select>
                    <input type="hidden" name="parfums-price-size" value="1">
                </div>
                @endif

                {{-- parfums not by size --}}
                @if ($productParfums->isNotEmpty() && !$productParfums->first()->price_by_size)
                <div class="form-group quick-desc">
                    <label class="float-left text-black label-cart"><strong>Parfums</strong></label>
                    <select class="form-control select2-edit" name="parfums" data-price-size="false" placeholder="Sélectionnez un choix"
                        style="width:100%;">
                        <option></option>
                        @foreach ($productParfums as $parfum)
                        <option value="{{$parfum->id}}"
                            {{($product->price_by_size) ? NULL : ((!empty($_item['parfums']['product_component_id']) && $parfum->id == $_item['parfums']['product_component_id']) ? 'selected' : NULL)}}>
                            {{$parfum->Component->name}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="parfums-price-size" value="0">
                </div>
                @endif

                {{-- Decors --}}
                {{-- decors not by size --}}
                @if ($productDecors->isNotEmpty() && !$productDecors->first()->price_by_size)
                <div class="form-group quick-desc">
                    <label class="float-left text-black label-cart"><strong>Accessoires Décoratifs</strong></label>
                    <select class="form-control select2-edit" name="decors" data-price-size="false" placeholder="Sélectionnez un choix"
                        style="width:100%;">
                        <option></option>
                        @foreach ($productDecors as $decor)
                        <option value="{{$decor->id}}" {{((!empty($_item['decors']['product_component_id']) && $decor->id == $_item['decors']['product_component_id']) ? 'selected' : NULL)}}>
                            {{$decor->Component->name}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="decors-price-size" value="0">
                </div>
                @endif

                @if ($productDecors->isNotEmpty() && $productDecors->first()->price_by_size && $product->price_by_size)
                <div class="form-group quick-desc">
                    <label class="float-left text-black label-cart"><strong>Accessoires Décoratifs</strong></label>
                    <select class="form-control select2-edit" name="decors" data-price-size="true" placeholder="Sélectionnez un choix"
                        style="width:100%;">
                        <option></option>
                        @php
                        foreach ($productDecors as $item) {
                            if($item->productComponentPrices->first()->size_id == $_item['decors']['dimension_id']){
                                echo '<option value="'.$item->component_id.'" '. ((!empty($_item['decors']['product_component_id']) && ($item->id == $_item['decors']['product_component_id']) ) ? 'selected' : NULL) .'>'.$item->Component->name.'</option>';
                            }
                        }
                        @endphp
                    </select>
                    <input type="hidden" name="decors-price-size" value="1">
                </div>
                @endif

                {{-- <pre>{{var_dump($productDecors->where('default', 1))}} --}}
                {{-- in case there is no default prices even by size --}}
                @if ($productDecors->isNotEmpty() && $productDecors->first()->price_by_size && !$product->price_by_size)
                @if ($productParfums->isEmpty() || !$productParfums->first()->price_by_size)
                <div class="form-group quick-desc">
                    <label class="float-left text-black label-cart"><strong>Dimension</strong></label>
                    <select class="form-control select2-edit" name="dimension2" placeholder="Sélectionnez un choix" 
                        style="width:100%;">
                        <option></option>
                        @foreach ($decors_dimensions->unique('size_id') as $item)
                        @php
                            if($item->size_id == $_item['decors']['dimension_id']){
                                $_dimension_id = $item->size_id;
                            }
                        @endphp
                        <option value="{{$item->size_id}}" {{(!empty($_item['decors']['dimension_id']) && $item->size_id == $_item['decors']['dimension_id']) ? 'selected' : NULL}}>{{$item->Size->size_name}}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="form-group quick-desc">
                    <label class="float-left text-black label-cart"><strong>Accessoires Décoratifs</strong></label>
                    <select class="form-control select2-edit" name="decors" data-price-size="true" placeholder="Sélectionnez un choix"
                        style="width:100%;">
                        <option></option>
                        @php
                        foreach ($productDecors as $item) {
                            if($item->productComponentPrices->first()->size_id == $_dimension_id){
                                echo '<option value="'.$item->component_id. '"'. ((!empty($_item['decors']['product_component_id']) && $decor->id == $_item['decors']['product_component_id']) ? 'selected' : NULL) .'>'.$item->Component->name.'</option>';
                            }
                        }
                        @endphp
                    </select>
                    <input type="hidden" name="decors-price-size" value="1">
                </div>
                @endif
                <div class="form-group quick-desc">
                    <label class="float-left text-black label-cart"><strong>Message sur le plateau (optionnel)</strong></label>
                    <textarea class="form-control custom-textarea" name="item-msg" placeholder="Message">{{$_item['msg']}}</textarea>
                </div>

                </div>
            </td><!-- form-group -->

            <td class="product-price tx-inverse font-weight-bold tx-16">
                @php
                    $pu_id = str_replace('=', '', base64_encode('{"field": "pu","key": '.$id.', "index": '.$key.'}'));
                @endphp
                <span id='{{$pu_id}}'>{{number_format($_item['pu'], 3)}}</span>
                <small>DT</small>
            </td>
            
            <td class="wd-1 tx-inverse font-weight-bold">
                
                <div class="input-group wd-150">
                    <div class="qty-minus input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-minus tx-16"></i>
                        </div>
                    </div>
                    <input style="text-align:center;font-size:20px;" type="text" name="qty" value="{{$_item['qty']}}" class="form-control float-num qty" placeholder="0"
                        autocomplete="off">
                    <div class="qty-plus input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-plus tx-16"></i>
                        </div>
                    </div>
                </div>
            </td>
            <td class="product-subtotal tx-inverse font-weight-bold tx-16">
                @php
                    $total_id = str_replace('=', '', base64_encode('{"field": "total","key": '.$id.', "index": '.$key.'}'));
                @endphp
                <span id='{{$total_id}}'>{{number_format($_item['total'], 3)}}</span>
                 <small>DT</small>
            </td>

            <td class="wd-1">
                <button data-id="{{$order->id}}" class="btn-remove-item btn btn-oblong btn-danger btn-block mg-b-10" data-toggle="tooltip" data-placement="top" title="Supprimer">
                    <i class="fa fa-times-circle"></i> Supprimer
                </button>
                <button data-id="{{$order->id}}" class="btn-save-item btn btn-oblong btn-success btn-block mg-b-10" data-toggle="tooltip" data-placement="top" title="Sauvgarder modification">
                    <i class="fa fa-check-circle"></i> Sauvgarder
                </button>
            </td>
        </tr>
        <!-- tr -->
        @endforeach
        @endforeach
        @else
        <p>Pas des produits dans le panier.</p>
        @endif
    </tbody>
</table>


<hr>
<ul class="list-group">
    <li class="list-group-item active">
        <p style="font-size:20px;"><b class="mg-r-15">TOTAL:</b> <span id="cart_total">{{number_format($cart['total'],3)}}</span> <small>DT</small></p>
    </li>
    <li class="list-group-item">
        <div class="col">
            <label>Cautionnement:</label>
            <div class="input-group">
                <input class="form-control" type="text" name="cautionnement" value="{{$order->cautionnement*1000}}">
                <div class="input-group-prepend">
                    <div class="input-group-text">Millimes</div>
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item">
        <div class="col">
            <label>Acompte:</label> 
            <div class="input-group">
                <input class="form-control" type="text" name="acompte" value="{{$order->acompte*1000}}">
                <div class="input-group-prepend">
                    <div class="input-group-text">Millimes</div>
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item">
        <div class="col">
            <label>Reste:</label> 
            <div class="input-group">
                <input class="form-control" type="text" name="reste" value="{{number_format(($cart['total'] - $order->acompte), 3)}}" disabled>
                <div class="input-group-prepend">
                    <div class="input-group-text">DT</div>
                </div>
            </div>
        </div>
    </li>
    <li class="list-group-item">
        <div class="col">
            <label class="text-primary">Livraison par :</label>
            <select class="form-control" name="delivery_mode">
                <option value="C" {{($order->delivery_mode == 'C') ? 'selected' : NULL}}>Client</option>
                <option value="S" {{($order->delivery_mode == 'S') ? 'selected' : NULL}}>Société</option>
            </select>        
        </div>
    </li>
</ul>

<input class="form-control" name="id" value="{{$order->id}}" type="hidden">


@endif