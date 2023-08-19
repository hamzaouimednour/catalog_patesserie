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

        <section id="family">
            <div class="container">

                <div class="row text-center text-lg-left">
                    @if ($sub_tags->isNotEmpty())
                    @foreach ($sub_tags as $item)
                    <div class="col-lg-3 col-md-4 col-6" id="cat">
                        @if (file_exists(public_path('themes' . DIRECTORY_SEPARATOR . 'tags') . DIRECTORY_SEPARATOR .
                        $item->img))
                        <img class="img-fluid img-thumbnail"
                            onclick="location.href='/products/sub-tag/{{$item->id}}/date'"
                            src="{{ asset('/themes/tags/' . $item->img ) }}" alt="">
                        @endif
                        <figure class="text-center des">
                            <p>{{$item->name}}</p>
                        </figure>
                    </div>
                    @endforeach
                    @endif
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
        <!--START BOOTSTRAP-->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
        </script>
        <!--END BOOTSTRAP-->
        <!--START JQUERY-->
        <script src="{{ asset('dist/js/jquery.js') }}"></script>
        <!--END JQUERY-->
        <!--START SCRIPT-->
        <script type="text/javascript" src="{{ asset('dist/js/script.js') }}"></script>
        <!--END SCRIPT-->
    </body>

    </html>
