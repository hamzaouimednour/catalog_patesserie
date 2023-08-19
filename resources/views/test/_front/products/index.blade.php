@extends('layouts.master-front')

@section('title', '')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('assets/lib/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lib/css/select2-bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    @stop

@section('breadcrumb-link', 'Produits')

@section('content')
    @parent

    <!-- START QUICKVIEW PRODUCT -->
        <div id="quickview-wrapper">
            <!-- Modal -->
            <div class="modal fade" id="productModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div id="productModal-body" class="modal-body">
                            
                        </div><!-- .modal-body -->
                    </div><!-- .modal-content -->
                </div><!-- .modal-dialog -->
            </div>
            <!-- END Modal -->
        </div>
        <!-- END QUICKVIEW PRODUCT -->
        <!-- SHOP SECTION START -->
            <div class="shop-section mb-80">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 order-lg-2 order-1">
                            <div class="shop-content">
                                <!-- shop-option start -->
                                <div class="shop-option box-shadow mb-30 clearfix">
                                    <!-- Nav tabs -->
                                    <ul class="nav shop-tab f-left" role="tablist">
                                        <li>
                                            <a class="active" href="#grid-view" data-toggle="tab"><i class="zmdi zmdi-view-module"></i></a>
                                        </li>
                                    </ul>
                                    <!-- short-by -->
                                    <div class="short-by f-left text-center">
                                    <span>Trier par : </span>
                                        <select name="sort-items">
                                            <option value="date" {{( !empty($req['sort']) && $req['sort'] == "date" ) ? 'selected' : NULL }}>Nouveaux articles</option>
                                            <option value="asc" {{( !empty($req['sort']) && $req['sort'] == "asc" ) ? 'selected' : NULL }}>Prix (croissant)</option>
                                            <option value="desc" {{( !empty($req['sort']) && $req['sort'] == "desc" ) ? 'selected' : NULL }}>Prix (décroissant)</option>
                                            <option value="ref" {{( !empty($req['sort']) && $req['sort'] == "ref" ) ? 'selected' : NULL }}>Référence</option>
                                        </select> 
                                    </div>
                                    <!-- showing -->
                                    <div class="showing f-right text-right">
                                        <span>Afficher : {{$current_page}}-09 sur {{$items_nbr}}.</span>
                                    </div>
                                </div>
                                <!-- shop-option end -->
                                <!-- Tab Content start -->
                                <div class="tab-content">
                                    <!-- grid-view -->
                                    <div id="grid-view" class="tab-pane active show" role="tabpanel">
                                        <div class="row">
                                            @foreach ($products as $item)
                                                <!-- product-item start -->
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="product-item">
                                                        <div class="product-img">
                                                            <a href="#">
                                                                @php
                                                                if($item->productImgs->isNotEmpty()){
                                                                    if (!file_exists( public_path('thumbs') . DIRECTORY_SEPARATOR . 'thumb-' . $item->productImgs->first()->img)){
                                                                        if (file_exists( public_path('thumbs') . DIRECTORY_SEPARATOR . $item->productImgs->first()->img)){
                                                                            $controller::thumb($item->productImgs->first()->img);
                                                                        }
                                                                    }
                                                                }else{
                                                                    if(!empty($item->img)){
                                                                        if (!file_exists( public_path('thumbs') . DIRECTORY_SEPARATOR . 'thumb-' . $item->img)){
                                                                            $controller::thumb($item->img);
                                                                        }
                                                                    }
                                                                }
                                                                @endphp
                                                                @if ($item->productImgs->isNotEmpty())
                                                                    <img class="product-cart" src="{{ asset('/thumbs/' . 'thumb-' . $item->productImgs->first()->img ) }}" data-id="{{$item->id}}" alt=""/>
                                                                @elseif(!empty($item->img))
                                                                    <img class="product-cart" src="{{ asset('/thumbs/' . 'thumb-' . $item->img ) }}" data-id="{{$item->id}}" alt=""/>
                                                                @else
                                                                    <img class="product-cart" src="{{ asset('/thumbs/default.png')}}" data-id="{{$item->id}}" alt=""/>
                                                                @endif
                                                                
                                                                {{-- <img src="{{ asset('/thumbs/thumb-' . $item->productImgs->img ) }}" alt=""/> --}}
                                                            </a>
                                                        </div>
                                                        <div class="product-info">
                                                            {{-- {{var_dump($item)}} --}}
                                                            <h6 class="product-cart product-title ml-3 mr-3 text-truncate" data-id="{{$item->id}}">
                                                                <a href="#" title="{{$item->name}}">{{$item->name}}</a>
                                                            </h6>
                                                                @php
                                                                if(!$item->default_price){
                                                                    $productParfums = collect([]);
                                                                    $productDecors = collect([]);
                                                                    list($productParfums, $productDecors) = $item->productComponents->partition(function ($i) {
                                                                        return $i->component->category == 'C';
                                                                    });
                                                                    if($productParfums->isNotEmpty()){
                                                                        $defaultParfum = $productParfums->where('default', 1);
                                                                        $parfum_default_price = $defaultParfum->first()->default_price;
                                                                    }else{
                                                                        $parfum_default_price = 0;
                                                                    }
                                                                    
                                                                }
                                                                @endphp
                                                            <div class="pro-rating">
                                                                <a href="#">REF: {{$item->ref}}</a>
                                                            </div>
                                                            <h3 class="pro-price">{{($item->default_price) ? number_format($item->default_price, 3) : number_format($parfum_default_price, 3)}} <small>DT</small></h3>
                                                            <ul class="action-button">
                                                                <li>
                                                                    <a href="#" title="Wishlist"><i class="zmdi zmdi-favorite"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="product-cart" title="Ajouter au panier" data-id="{{$item->id}}"><i class="zmdi zmdi-shopping-cart-plus"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- product-item end -->
                                            @endforeach
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- Tab Content end -->
                                
                                <!-- shop-pagination start -->
                                    {{ $links }}
                                <!-- shop-pagination end -->
                            </div>
                        </div>
                        <div class="col-lg-3 order-lg-1 order-2">
                            <!-- widget-search -->
                            <aside class="widget-search mb-30">
                                <form action="#">
                                    <input type="text" placeholder="Chercher produit...">
                                    <button type="submit"><i class="zmdi zmdi-search"></i></button>
                                </form>
                            </aside>
                            <!-- widget-categories -->
                            <!-- widget-color -->
                            <aside class="widget widget-color box-shadow mb-30">
                                <h6 class="widget-title border-left mb-20">CATÉGORIES</h6>
                                <ul>
                                    <li class="cat-search color-1 mb-4" data-id="all"><a href="#">Tous les catégories</a></li>
                                    @foreach ($tags as $item)
                                        <li class="cat-search color-1 mb-4" data-id="{{$item->id}}"><a href="#">{{$item->name}}</a></li>
                                    @endforeach
                                </ul>
                            </aside>
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- SHOP SECTION END -->  
@stop

@section('js')
    @parent  
    <script src="{{ asset('assets/js/scripts/p-65d98101.js?' . time()) }}"></script>  
    <script src="{{ asset('assets/lib/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/static/lib/sweetalert/sweetalert.min.js') }}"></script>

@stop