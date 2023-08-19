@php
        $order_actions = array();
        $perms = collect([]);
        if(Session::has('perms')){
            $perms = Session::get('perms');
            if($perms->where('controller', 'orders')->isNotEmpty() && !empty($perms->where('controller', 'orders')->first()))
                $order_actions = $perms->where('controller', 'orders')->first()->actions;
        }
        
@endphp
<!DOCTPYE html>
    <html lang='fr'>

    <head>
        <title>Takacim</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{ asset('dist/img/logo.png') }}" type="image/x-icon">
        <link rel="icon" href="{{ asset('dist/img/logo.png') }}" type="image/x-icon">
        <!--STYLE-->
        <!--START BOOTSTRAP-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!--END BOOTSTRAP-->
        <!--START CSS-->
        <link rel="stylesheet" href="{{ asset('dist/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('dist/css/cursor.css') }}">
        <link rel="stylesheet" href="{{ asset('dist/css/prodect.css') }}">
        <link rel="stylesheet" href="{{ asset('dist/css/key.css') }}">
        <link rel="stylesheet" href="{{ asset('dist/css/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('dist/css/datepicker3.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/static/lib/timepicker/bootstrap-clockpicker.min.css') }}" />
        <!--END CSS-->
        <!--END STYLE-->
    </head>

    <body class="body">
        <div class="mou done"></div>
        <div class="cursor done"></div>
        <img src="{{ asset('dist/img/family/page_famille_parts-02.jpg') }}" class="img-fluid bg">
        <section id="banner">
            <div class="row">
                <img src="{{ asset('dist/img/logo.png') }}" class="img-fluid logo">
                <img src="{{ asset('dist/img/family/page_famille_parts-05.jpg') }}" class="img-fluid">
            </div>
            <!--Navbar -->
            <nav class="mb-1 navbar navbar-expand-lg navbar">
                <div class=" btn"><i class="fa fa-arrow-left fa-2x"></i></div>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target=".bd-example-modal-lg"
                    id="btn"><span class="text-center">Tous les catégories </span></button>
            </nav>
            <!--/.Navbar -->
        </section>

        <section id="filter">
            <div class="modal fade" id="ft" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Filtre</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="container filt">
                            <div class="row">
                                <div class="col-md-6">
                                    <button value="date" class="btn btn-danger" data-dismiss="modal"><span
                                            class="text-center">Nouveaux Articles</span></button>
                                </div>
                                <div class="col-md-6">
                                    <button value="asc" class="btn btn-danger" data-dismiss="modal"><span
                                            class="text-center">Prix</span></button>
                                </div>
                            </div>
                        </div>

                        <div class="container filt">
                            <div class="row">
                                <div class="col-md-6">
                                    <button value="desc" b class="btn btn-danger" data-dismiss="modal"><span
                                            class="text-center"> Prix</span></button></div>
                                <div class="col-md-6">
                                    <button value="ref" class="btn btn-danger" data-dismiss="modal"><span
                                            class="text-center">Référence</span></button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="catalog">
            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content cat">
                        <section id="family">
                            <div class="container cat showcat">
                                <div class="row text-center text-lg-left">
                                    @foreach ($tags as $item)

                                    @if ($item->subTags->isNotEmpty())

                                    <div class="col-lg-3 col-md-4 col-6" id="cat">
                                        @if (file_exists(public_path('themes' . DIRECTORY_SEPARATOR . 'tags') .
                                        DIRECTORY_SEPARATOR . $item->img))
                                        <img class="img-fluid img-thumbnail"
                                            onclick="location.href='/sub-tags/{{$item->id}}'"
                                            src="{{ asset('/themes/tags/' . $item->img ) }}" alt="">
                                        @endif
                                        <figure class="text-center des">
                                            <p>{{$item->name}}</p>
                                        </figure>
                                    </div>
                                    @else
                                    <div class="col-lg-3 col-md-4 col-6" id="cat">
                                        @if (file_exists(public_path('themes' . DIRECTORY_SEPARATOR . 'tags') .
                                        DIRECTORY_SEPARATOR . $item->img))
                                        <img class="img-fluid img-thumbnail"
                                            onclick="location.href='/products/tag/{{$item->id}}/date'"
                                            src="{{ asset('/themes/tags/' . $item->img ) }}" alt="">
                                        @endif
                                        <figure class="text-center des">
                                            <p>{{$item->name}}</p>
                                        </figure>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>


                            </div>
                        </section>
                    </div>
                </div>
            </div>

        </section>

        <!--cart-->
        <section id="cart-body">
            <div class="container">
                <!--headtable-->
                <div class="shopping-cart">
                    <div class="card-header bg-light text-dark">
                        <i class="fa fa-shopping-cart shop fa-2x" aria-hidden="true"></i>
                        <span class="tit">Panier</span>
                        
                        @if (!Auth::check())
                        <a href="/login" class="btn btn-info btn-sm pull-right">Authentification</a>
                        @else
                        <a href="/logout" class="btn btn-info btn-sm pull-right">Se déconnecter</a>
                        @endif
                        <a href="/home" class="btn btn-outline-info ml-2 mr-2 btn-sm pull-right">Continuer vos achats</a>
                        <a href="#" id="clear-cart" class="btn btn-warning ml-2 mr-2 btn-sm pull-right">Vider Panier</a>
                        <div class="clearfix"></div>
                        
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">#</th>
                                    <th class="product-thumbnail">PRODUIT</th>
                                    <th class="product-price text-center">P.U</th>
                                    <th class="product-quantity text-center">Quantité</th>
                                    <th class="product-subtotal text-center">Montant</th>
                                    <th class="product-remove text-center">Retirer</th>
                                </tr>
                            </thead>
                            <!--end headtable-->
                            <tbody>
                                <!-- tr -->
                                @if (!empty($cart))

                                @foreach ($cart['items'] as $id => $produit)
                                @php
                                $product = $prod::find($id);
                                @endphp
                                @foreach ($produit as $key => $item)
                                <tr>
                                    <!--produit-->
                                    <td>
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-2 text-center">
                                                {{-- <img class="img-responsive"
                                                    src="{{ asset('dist/img/family/page_famille_parts-07.jpg') }}"
                                                    alt="prewiew" width="120" height="80"> --}}
                                                <img width="100px" class="img-responsive" src="/thumbs/{{$product->productImgs->first()->img}}" alt="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-12 text-sm-center col-sm-12 text-md-left col-md-6 name">
                                                <h6 class="product-title-2"> <a href="#">{{$product->name}}</a> </h6>
                                                <p> <b>REF:</b> {{$product->ref}}</p>
                                                @if ($product->price_by_size)

                                                <p><b>Dimension:</b> {{$product->productSizePrices->where('size_id', $item['dimension'])->first()->size->size_name}}
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
                                        </div>
                                    </td>
                                    <!-- end produit-->
                                    <!--Pu-->
                                    <td class="text-center">
                                        <div class="prix">
                                            {{number_format($item['pu'],3)}}
                                            <small>DT</small>
                                        </div>
                                    </td>
                                    <!--end pu-->
                                    <!--qte-->
                                    <td>
                                        <div class="row">
                                            <div class="product-quantity quantity text-center col-md-12">
                                                <button class="plus-btn add" type="button" name="button">
                                                    <img src="{{ asset('dist/img/plus.svg') }}" alt="" />
                                                </button>
                                                <input data-id="{{$id}}" data-key="{{$key}}" type="text" name="qty" class="number" value="{{$item['qty']}}">
                                                <button class="minus-btn add" type="button" name="button">
                                                    <img src="{{ asset('dist/img/minus.svg') }}" alt="" />
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <!--end qte-->
                                    <!--montant-->
                                    <td class="text-center">
                                        <div class="montant product-subtotal">{{number_format($item['total'],3)}} <small>DT</small></div>
                                    </td>
                                    <!--end montant-->
                                    <!--remove-->
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm remove product-delete" data-id="{{$id}}" data-key="{{$key}}">
                                            <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                    <!--end remove-->
                                </tr>
                                <!-- tr -->
                                @endforeach
                                @endforeach
                                @else
                                <p>Pas des produits dans le panier.</p>
                                @endif
                            </tbody>
                        </table>

                        <!--finTable-->
                        <div class="card-footer container">
                            
                            @if (!empty($cart))
                            <div class="col-sm-3 col-xs-12 mb-2 text-center">
                                <span class="tot">TOTAL :</span> <b class="tot" id="order-total">{{empty($cart['total']) ? '0.000' : number_format($cart['total'],3) }} <span>DT</span></b>
                            </div>
                            @endif

                            @if (!empty($order_actions) && in_array('A', $order_actions) && !empty($cart))
                            <form id="cart-form" name="cart-form" class="needs-validation" novalidate>
                            <div class="container">
                                <div class="row">
                                    <div class="culculate-shipping box-shadow col-md-12 mb-3">
                                        <h4 class="text-center mb-3">CLIENT</h4>
                                        <div class="row">
                                            <div class="col-sm-4 col-xs-12 mb-2">
                                                <input type="text" name="customer-name" class="form-control default"
                                                    placeholder="Nom & Prénom du client" required>
                                            </div>
                                            <div class="col-sm-4 col-xs-12 mb-2">
                                                <input type="text" name="customer-phone"
                                                    class="float-num form-control number" placeholder="Numéro de Tél" required>
                                            </div>
                                            <div class="col-sm-4 col-xs-12 mb-2">
                                                <input type="text" name="customer-email" class="form-control default"
                                                    placeholder="Email (optionnel)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="culculate-shipping box-shadow col-md-12">

                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <h4 class="text-center mb-4 col-sm-12">ACCOMPTE</h4>
                            </div>

                            <div class="row">
                                
                                <div class="col-sm-3 col-xs-12 mb-2">
                                    <input class="form-control number" type="text" name="cautionnement" placeholder="Montant de Cautionnement.">
                                </div>
                                <div class="col-sm-3 col-xs-12 mb-2">
                                    <select class="custom-select" name="acompte-type">
                                        <option value="" disabled selected>Le type d'acompte</option>
                                        <option value="E">Espèce</option>
                                        <option value="C">Chèque</option>
                                    </select>
                                </div>
                                <div class="col-sm-3 col-xs-12 mb-2">
                                    <input class="form-control float-num number" type="text" name="acompte" placeholder="Montant d'acompte.">
                                </div>
                                <div class="col-sm-3 col-xs-12 mb-2">
                                    <input id="reste" class="form-control" type="text" name="reste" placeholder="Reste à payer." disabled>
                                </div>
                            </div>

                            <div class="row">
                                <h4 class="text-center mb-4 mt-4 col-sm-12">LIVRAISON</h4>
                            </div>

                            <div class="row">
                                <div class="col-sm-2 col-xs-12 mb-2">
                                    <div class="input-group mb-2">
                                        <div class="form-group">
                                            <div class="input-group date" id="datetimepicker1">
                                                <input type="text" name="delivery-date" class="form-control" placeholder="Date de livraison" required/>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3  col-xs-12 mb-2">
                                    <div class="input-group clockpicker">
                                        <input type="text" id="dark-version-example" name="delivery-time" class="form-control" placeholder="Heure de livraison" required>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-12 mb-2">
                                    <select class="custom-select" name="delivery-mode"  required>
                                        <option value="" disabled selected>Sélectionnez la maniére de livraison</option>
                                        <option value="S">Livraison par la société</option>
                                        <option value="C">Livraison par le client</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-2 text-center">
                                 {{-- data-toggle="modal" data-target="#cart" --}}
                                <button type="submit" id="submit-cart-form" class="btn btn-success">
                                    <i class="fa fa-shopping-cart shop"></i> Passer la commande
                                </button>
                            </div>

                            </form>
                            @endif
                        </div>

                        <!--end finTable-->
                    </div>

                </div>
        </section>
        <section id="cart-success">
            <div class="modal fade" id="modal-cart" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">

                            <h3 class="col-12 modal-title text-center">
                                <b>COMMANDE TERMINEE</b>
                            </h3>

                        </div>
                        <div class="modal-body">
                            <div class="alert alert-dismissible alert-success text-center">
                                Votre Commande a été enregistrée sous NUM: 
                                    <strong id="order_num" data-order-id=""></strong><br> Nous Avons bien reçu votre
                                commande et nous vous en remercions .
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="print-order" class="btn btn-primary hidden-print" onclick="">
                                <span class="fa fa-print" aria-hidden="true"></span> IMPRIMER</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--end cart-->
        <footer class="page-footer">
            <section id="foot" class="footer-copyright">
                <div class="container-fluid">
                    <div class="row">
                        <img src="{{ asset('dist/img/family/page_famille_parts-24.jpg') }}" class="img-fluid ifoot">
                        <img src="{{ asset('dist/img/footer.jpg') }}" class="img-fluid">
                    </div>
                </div>
            </section>
        </footer>


        <!--START JQUERY-->
        <script src="{{ asset('dist/js/jquery.js') }}"></script>
        <!--END JQUERY-->
        <!--START BOOTSTRAP-->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
        </script>
        <!--END BOOTSTRAP-->

        <script src="{{ asset('dist/js/bootstrap-datepicker.min.js') }}"></script>
        <!--START SCRIPT-->
        <script type="text/javascript" src="{{ asset('dist/js/script.js') }}"></script>
        <script type="text/javascript" src="{{ asset('dist/js/key.js') }}"></script>
        <script src="{{ asset('assets/static/lib/timepicker/bootstrap-clockpicker.min.js') }}"></script>
        <script src="{{ asset('assets/js/scripts/p-65d98102.js?' . time()) }}"></script>

        <script>
            $("#datetimepicker1").datepicker();

            $(function () {
                $('.clockpicker').clockpicker({
                    placement: 'top',
                    autoclose: true,
                    'default': 'now'
                });

                $('.default').keyboard();
                $('#addInputBtn').click(function () {
                    $(this).parent().append($('<input>').attr('type', 'text').addClass('form-control')
                        .addClass('keyboard'));
                    $(this).siblings('.keyboard').keyboard();
                });
                $('#removeInputBtn').click(function () {
                    $(this).siblings('.keyboard').last().remove();
                });
                $('#placement').keyboard({
                    placement: 'top'
                });

            });
            $(function () {
                $('.number').keyboard({
                    type: 'numpad'
                });
                $('#addInputBtn').click(function () {
                    $(this).parent().append($('<input>').attr('type', 'text').addClass('form-control')
                        .addClass('keyboard'));
                    $(this).siblings('.keyboard').keyboard();
                });
                $('#removeInputBtn').click(function () {
                    $(this).siblings('.keyboard').last().remove();
                });
                $('#placement').keyboard({
                    placement: 'top'
                });

            });
        </script>
        <!--END SCRIPT-->
    </body>

    </html>