<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
        <title>Takacim - Bienvenue chez nous</title>
        <!-- All CSS Files -->
        <!-- Theme main style -->
        <link rel="stylesheet" href="{{ asset('static/style.css') }}">
        <link rel="stylesheet" href="{{ asset('static/bootstrap-4.0.0/dist/css/bootstrap.css') }}">
    </head>
<body>

<div class="main-image"></div>

<div class="content-body" style="margin: 0px 39px 0px 45px;">
    <div class="text-center">
        <img width="300" src="{{ asset('static/page_famille_parts-23.jpg') }}">
    </div>
    <div class="row">
        @foreach ($cats as $item)
            
        <div class="col-md-3 mt-3">
            <div class="card text-center" style="">
                @if (file_exists(public_path('themes' . DIRECTORY_SEPARATOR . 'tags') . DIRECTORY_SEPARATOR . $item->img))
                    <img onclick="location.href='products/{{$item->id}}/date'" class="card-img-top" src="{{ asset('/themes/tags/' . $item->img ) }}" alt="">
                @endif
                <div class="card-body">
                    <h5 class="card-title" onclick="location.href='products/{{$item->id}}/date'"> {{$item->name}}</h5>
                </div>
            </div>
        </div>

        @endforeach
    </div>
    <div class="d-flex justify-content-end mt-3">
        <img width="300" src="{{ asset('static/page_famille_parts-24.jpg') }}">
    </div>
    <div class="d-flex justify-content-center">
        <img width="100%" src="{{ asset('static/page_famille_parts-footer2.jpg') }}">
    </div>
</div>
{{-- <div class="footer-image"></div> --}}

</body>
</html>
