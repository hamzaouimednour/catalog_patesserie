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

				<ul class="navbar-nav ml-auto nav-flex-icons">

					<li class="nav-item">
						<div class=" btn" data-toggle="modal" data-target="#ft"><i
								class="fa fa-filter fa-2x"></i><span>filter</span></div>
					</li>
					<li class="nav-item dropdown">
						<div class=" btn">
							<a href="/cart" class="notification">
								<i class="fa fa-cart-plus fa-2x"></i>
								<span class="badge" id="cart-quantity">{{(empty($cart)) ? '0' : $cart['nbr']}}</span>
							</a>
						</div>
					</li>
				</ul>

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
									@php
										$url = "/products/".$req['type']."/".$req['cat'];
									@endphp
									<button onclick="location.href='{{$url}}/date'" class="btn btn-danger" data-dismiss="modal">
										<span class="text-center">Nouveaux Articles</span>
									</button>
								</div>
								<div class="col-md-6">
									<button onclick="location.href='{{$url}}/asc'" class="btn btn-danger" data-dismiss="modal"><span
											class="text-center">Prix</span></button>
								</div>
							</div>
						</div>

						<div class="container filt">
							<div class="row">
								<div class="col-md-6">
									<button onclick="location.href='{{$url}}/desc'" b class="btn btn-danger" data-dismiss="modal"><span
										class="text-center"> Prix</span></button></div>
								<div class="col-md-6">
									<button onclick="location.href='{{$url}}/ref'" class="btn btn-danger" data-dismiss="modal"><span
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


		{{-- FAMILLES --}}
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
											@if (file_exists(public_path('themes' . DIRECTORY_SEPARATOR . 'tags') . DIRECTORY_SEPARATOR . $item->img))
												<img class="img-fluid img-thumbnail" onclick="location.href='/sub-tags/{{$item->id}}'" src="{{ asset('/themes/tags/' . $item->img ) }}" alt="">
											@endif
											<figure class="text-center des"><p>{{$item->name}}</p></figure>
										</div>
									@else
										<div class="col-lg-3 col-md-4 col-6" id="cat">
											@if (file_exists(public_path('themes' . DIRECTORY_SEPARATOR . 'tags') . DIRECTORY_SEPARATOR . $item->img))
												<img class="img-fluid img-thumbnail" onclick="location.href='/products/tag/{{$item->id}}/date'" src="{{ asset('/themes/tags/' . $item->img ) }}" alt="">
											@endif
											<figure class="text-center des"><p>{{$item->name}}</p></figure>
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


		<section id="item">
			<div class="container">
				<div class="row text-center text-lg-left">
					<!--start item-->
					@foreach ($products as $item)
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
					<div class="col-lg-3 col-md-4 col-6" id="cat">
						<div class="card product-cart" data-id="{{$item->id}}">

							<!-- PRICE -->

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
							
							<img src="{{asset('dist/img/banner.png')}}" class="banner">
							<span class="banner-text">{{($item->default_price) ? number_format($item->default_price, 3) : number_format($parfum_default_price, 3)}} DT</span>
				
							{{-- <div class="badge-primary badge">
								<p>{{($item->default_price) ? number_format($item->default_price, 3) : number_format($parfum_default_price, 3)}} DT</p>
							</div> --}}

							<!-- /PRICE -->


							<!-- IMG -->

							@if ($item->productImgs->isNotEmpty())
                                <img class="card-img-top" src="{{ asset('/thumbs/' . 'thumb-' . $item->productImgs->first()->img ) }}" data-id="{{$item->id}}" alt=""/>
                            @elseif(!empty($item->img))
                                <img class="card-img-top" src="{{ asset('/thumbs/' . 'thumb-' . $item->img ) }}" data-id="{{$item->id}}" alt=""/>
                            @else
                                <img class="card-img-top" width="200px" src="{{ asset('/thumbs/default.png')}}" data-id="{{$item->id}}" alt=""/>
							@endif

							<!-- /IMG -->

							<div class="card-body ">
								<h5 class="card-title text-center ">{{$item->name}}</h5>
							</div>
						</div>
					</div>
					<!--end item-->
					@endforeach
				</div>
			</div>
		</section>
		<section id="show-prodect">
			<div class="modal fade bd-example-modal-lg" id="productModal" tabindex="-1" role="dialog"
				aria-labelledby="myLargeModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="container">
							<div id="modal-msg" class="mt-5">
								<div id="modal-msg-success" class="alert alert-success alert-dismissible fade show d-none" role="alert">
									<strong>Succès!</strong> Le produit ajouté au panier avec succès.
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
								</div>
								<div id="modal-msg-failed" class="alert alert-danger alert-dismissible fade show d-none" role="alert">
									<strong>Echec!</strong> échec de l'ajout du produit au panier!.
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
								</div>
							</div>
							<div class="row form" id="productModal-body">
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
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
		{{-- </script> --}}
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
		</script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
		</script>
		<!--END BOOTSTRAP-->
		<!--START SCRIPT-->
		<script type="text/javascript" src="{{ asset('dist/js/script.js') }}"></script>
		<script type="text/javascript" src="{{ asset('dist/js/key.js') }}"></script>
		
		<script src="{{ asset('assets/js/scripts/p-65d98101.js?' . time()) }}"></script>  
		<!--END SCRIPT-->
	</body>

	</html>
