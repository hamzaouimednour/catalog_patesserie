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
            <th class="product-thumbnail wd-1">PRODUIT</th>
            <th class="product-desg">Désignation</th>
            <th class="product-price">P.U</th>
            <th class="product-quantity">Quantité</th>
            <th class="product-subtotal">Montant</th>
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
        $product = $prod::find($id);
        @endphp
        @foreach ($produit as $key => $item)
        <tr>
            <td class="product-thumbnail">
                <div class="pro-thumbnail-img">
                    <img width="100" src="/thumbs/{{$product->productImgs->first()->img}}" alt="">
                </div>
            </td>
            <td class="product-thumbnail">
                <div class="pro-thumbnail-info text-left">
                    <h6 class="product-title-2">
                        <a href="#">{{$product->name}}</a>
                    </h6>
                    <p> <b>REF:</b> {{$product->ref}}</p>
                    @if ($product->price_by_size)

                    <p><b>Dimension:</b>
                        {{$product->productSizePrices->where('size_id', $item['dimension'])->first()->size->size_name}}
                    </p>

                    @endif
                    @if (!empty($item['parfums']))

                    {{-- dimension only in parfums --}}
                    @if (!$product->price_by_size &&
                    $item['parfums']['parfum_dimension'])

                    <p><b>Dimension:</b>
                        {{$product->productComponents->where('id', $item['parfums']['product_component_id'] )->first()
                                                                                ->productComponentPrices->where('size_id', $item['parfums']['dimension_id'])->first()->size->size_name}}
                    </p>

                    @endif

                    {{-- parfum n'est pas par dimension --}}
                    @if (!$item['parfums']['parfum_dimension'])
                    <p><b>Parfum:</b>
                        {{$product->productComponents->where('id', $item['parfums']['product_component_id'] )->first()->component->name}}
                    </p>
                    @endif

                    {{-- parfum n'est pas par dimension --}}
                    @if ($item['parfums']['parfum_dimension'])
                    <p><b>Parfum:</b>
                        {{$product->productComponents->where('component_id', $item['parfums']['component_id'] )->first()->component->name}}
                    </p>
                    @endif

                    @endif

                    @if (!empty($item['decors']))

                    @if (!$product->price_by_size && (
                    (!empty($item['parfums']) &&
                    !$item['parfums']['parfum_dimension']) ||
                    empty($item['parfums']) ) &&
                    $item['decors']['decor_dimension'])

                    <p><b>Dimension:</b>
                        {{$product->productComponents->where('id', $item['decors']['product_component_id'] )->first()
                                                                                ->productComponentPrices->where('size_id', $item['decors']['dimension_id'])->first()->size->size_name}}
                    </p>

                    @endif

                    {{-- decors n'est pas par dimension --}}
                    @if (!$item['decors']['decor_dimension'])
                    <p><b>Parfum:</b>
                        {{$product->productComponents->where('id', $item['decors']['product_component_id'] )->first()->component->name}}
                    </p>
                    @endif

                    {{-- decors n'est pas par dimension --}}
                    @if ($item['decors']['decor_dimension'])
                    <p><b>Decoration:</b>
                        {{$product->productComponents->where('component_id', $item['decors']['component_id'] )->first()->component->name}}
                    </p>
                    @endif

                    @endif
                    @if (!empty($item['msg']))
                    <p><b>Message:</b> {{$item['msg']}}</p>
                    @endif
                </div>
            </td>
            <td class="product-price">{{number_format($item['pu'], 3)}}
                <small>DT</small></td>
            <td class="product-price">{{$item['qty']}}</td>
            <td class="product-subtotal">
                {{number_format($item['total'], 3)}} <small>DT</small>
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
        <p><b class="mg-r-15">TOTAL:</b>
            {{number_format($order->total,3)}} <small>DT</small></p>
    </li>
    <li class="list-group-item">
        <p><b class="mg-r-15">Cautionnement:</b>
            {{number_format($order->cautionnement,3)}} <small>DT</small>
        </p>
    </li>
    <li class="list-group-item">
        <p><b class="mg-r-15">Acompte:</b>
            {{number_format($order->acompte,3)}} <small>DT</small></p>
    </li>
    <li class="list-group-item">
        <p><b class="mg-r-15">Reste:</b>
            {{number_format(($order->total - $order->acompte), 3)}}
            <small>DT</small></p>
    </li>
    <li class="list-group-item">
        <p><b class="mg-r-15 text-primary">Livraison par :</b>
            {{($order->delivery_mode == 'C') ? 'Client' : 'Société'}}
        </p>
    </li>
</ul>
@endif