<!DOCTPYE html>
    <html lang='fr'>

    <head>
    <title>Takacim</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <link rel="icon" href="img/logo.png" type="image/x-icon">
    <!--STYLE-->
    <!--START BOOTSTRAP-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!--END BOOTSTRAP-->
    <!--START CSS-->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/cursor.css">
    <link rel="stylesheet" href="../css/prodect.css">
	<link rel="stylesheet" href="../css/cart.css">
    <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
    <!--END CSS-->
    <!--END STYLE-->
</head>

<body class="body">
    <div class="mou done"></div>
    <div class="cursor done"></div>
    <img src="../img/family/page_famille_parts-02.jpg" class="img-fluid bg">
    <section id="banner">
        <div class="row">
            <img src="../img/logo.png" class="img-fluid logo">
            <img src="../img/family/page_famille_parts-05.jpg" class="img-fluid">
        </div>
        <!--Navbar -->
        <nav class="mb-1 navbar navbar-expand-lg navbar">
            <div class=" btn"><i class="fa fa-arrow-left fa-2x"></i></div>
            <button type="button" class="btn btn-default" data-toggle="modal" data-target=".bd-example-modal-lg" id="btn"><span class="text-center">Tous les catégories </span></button>




            <ul class="navbar-nav ml-auto nav-flex-icons">

                <li class="nav-item">
                    <div class=" btn" data-toggle="modal" data-target="#ft"><i class="fa fa-filter fa-2x"></i><span>filter</span></div>
                </li>
                <li class="nav-item dropdown">
                    <div class=" btn">
                        <a href="#" class="notification">
                            <i class="fa fa-cart-plus fa-2x"></i>
                            <span class="badge">0</span>
                        </a>
                    </div>
                </li>
            </ul>

        </nav>
        <!--/.Navbar -->
    </section>

    <section id="filter">
        <div class="modal fade" id="ft" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                <button value="date" class="btn btn-danger" data-dismiss="modal"><span class="text-center">Nouveaux Articles</span></button>
                            </div>
                            <div class="col-md-6">
                                <button value="asc" class="btn btn-danger" data-dismiss="modal"><span class="text-center">Prix</span></button>
                            </div>
                        </div>
                    </div>

                    <div class="container filt">
                        <div class="row">
                            <div class="col-md-6">
                                <button value="desc" b class="btn btn-danger" data-dismiss="modal"><span class="text-center"> Prix</span></button></div>
                            <div class="col-md-6">
                                <button value="ref" class="btn btn-danger" data-dismiss="modal"><span class="text-center">Référence</span></button>
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
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content cat">
                    <section id="family">
                        <div class="container cat showcat">
                            <div class="row text-center text-lg-left">
                                @foreach ($cats as $item)
                                @if (file_exists(public_path('themes' . DIRECTORY_SEPARATOR . 'tags') . DIRECTORY_SEPARATOR . $item->img))
                                <div class="col-lg-3 col-md-4 col-6" id="cat">
                                    @endif
                                    <img class="img-fluid img-thumbnail" onclick="location.href='products/{{$item->id}}/date'" src="../img/family/page_famille_parts-06.jpg" alt="">
                                    <figure class="text-center des">
                                        <p>{{$item->name}}</p>
                                    </figure>
                                </div>
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
            <div class="card shopping-cart">
                <div class="card-header bg-light text-dark">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    Shipping cart
                    <a href="" class="btn btn-outline-info btn-sm pull-right">Continiu shopping</a>
                    <div class="clearfix"></div>
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="product-thumbnail">PRODUIT</th>
                        <th class="product-price text-center">P.U</th>
                        <th class="product-quantity text-center">Quantité</th>
                        <th class="product-subtotal text-center">Montant</th>
                        <th class="product-remove text-center">retirer</th>
                    </tr>
                </thead>
<!--end headtable-->
                <tbody>
                    <tr>
                       <!--produit-->
                        <td>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-2 text-center">
                                    <img class="img-responsive" src="../img/family/page_famille_parts-07.jpg" alt="prewiew" width="120" height="80">
                                </div>
                                <div class="col-12 text-sm-center col-sm-12 text-md-left col-md-6 name">
                                    <h4 class="product-name"><strong>Product Name</strong></h4>
                                    <h4>
                                        <small>Product description</small>
                                    </h4>
                                </div>
                            </div>
                        </td>
                        <!-- end produit-->
                        <!--Pu-->
                        <td class="text-center">
                            <div class="prix">15<span>Dt</span></div>
                        </td>
                        <!--end pu-->
                        <!--qte-->
                        <td>
                            <div class="row">
                                <div class="quantity text-center col-md-12">
                                    <button class="plus-btn add" type="button" name="button">
                                        <img src="https://designmodo.com/demo/shopping-cart/plus.svg" alt="" />
                                    </button>
                                    <input type="text" name="name" value="1">
                                    <button class="minus-btn add" type="button" name="button">
                                        <img src="https://designmodo.com/demo/shopping-cart/minus.svg" alt="" />
                                    </button>
                                </div>
                            </div>
                        </td>
                        <!--end qte-->
                        <!--montant-->
                        <td class="text-center">
                            <div class="montant">15<span>Dt</span></div>
                        </td>
                        <!--end montant-->
                        <!--remove-->
                        <td class="text-center">


                            <button type="button" class="btn btn-danger btn-sm remove">
                                <i class="fa fa-times"></i>
                            </button>



                        </td>
                        <!--end remove-->
                    </tr>

                   
                </tbody>
            </table>
             <!--finTable-->
            <div class="card-footer">
                <div class="row">
                    <div class="pull-right" style="margin: 10px">
                        <a href="" class="btn btn-success pull-right" data-toggle="modal" data-target="#cart">Submit</a>
                        <div class="pull-right" style="margin: 5px">
                            Total price: <b>50.00<span>Dt</span></b>
                        </div>
                    </div>
                </div>

            </div>
            <!--end finTable-->
        </div>
    </section>
    <section id="cart-success">
        <div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
	  
	  <h3 class="col-12 modal-title text-center">
<b>COMMANDE TERMINEE</b>
		</h3>

      </div>
      <div class="modal-body">
                <div class="alert alert-dismissible alert-success text-center">
  <strong>Votre Commande a été enregistrée</strong><br> Nous Avons bien reçu votre commande et nous vous en remercions .
        </div>	
      </div>
      <div class="modal-footer">
<button class="btn btn-primary hidden-print" onclick="window.print();"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> IMPRIMER</button>
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
                    <img src="../img/family/page_famille_parts-24.jpg" class="img-fluid ifoot">
                    <img src="../img/footer.jpg" class="img-fluid">
                </div>
            </div>
        </section>
    </footer>
    <!--START BOOTSTRAP-->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!--END BOOTSTRAP-->
    <!--START JQUERY-->
    <script src="js/jquery.js"></script>
    <!--END JQUERY-->
    <!--START SCRIPT-->
    <script type="text/javascript" src="../js/script.js"></script>
    <!--END SCRIPT-->
</body></html>
