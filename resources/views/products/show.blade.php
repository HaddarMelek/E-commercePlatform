<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Product Details')</title>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
<link rel="icon" type="image/png" href="{{ asset('download.jpeg') }}" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <style>
        .product-image {
            width: 200px;
            height: 200px; 
            object-fit: cover;
        }
        .text-white-border {
            background-color: #f4623a; 

    color: white;
    border: 2px solid #f4623a;
    padding: 5px;
    border-radius: 5px;
    display: inline-block;
}

    </style>
</head>
<body id="page-top">

@include('navbar.sellerNavbar', ['notifications' => $notifications])

<header class="masthead text-center py-5">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 align-items-center justify-content-center">
            <div class="col-lg-8">
            <h1 class="display-4 font-weight-bold text-white-border">{{ $product->name }}</h1>
            <hr class="divider" />
                <div class="card">
                    <div class="card-body">
                        <p><strong>Description:</strong> {{ $product->description }}</p>
                        <p><strong>Price:</strong> ${{ $product->price }}</p>
                        <p><strong>Category:</strong> {{ $product->category->name }}</p>
                        <p><strong>Stock:</strong> {{ $product->qte_stock }}</p>
                        @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image mt-3">
                        @endif
                    </div>
                </div>
                <a href="{{ url()->previous() }}" class="btn btn-primary mt-3">Back to Products</a>
            </div>
        </div>
    </div>
</header>


    <!-- Bootstrap core JS -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
