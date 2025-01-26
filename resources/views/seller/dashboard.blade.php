<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Seller Dashboard')</title>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
<link rel="icon" type="image/png" href="{{ asset('download.jpeg') }}" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <style>
        .navbar-brand img {
            width: 50px; /* Adjust width as needed */
            height: 50px; /* Maintain aspect ratio */
            border-radius: 50%;
            object-fit: cover;
        }
        .masthead {
            background-color: #343a40;
            color: #fff;
            padding: 5rem 0;
        }
        .btn-shop-now {
            background-color: #f4623a;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
        }
        .btn-shop-now:hover {
            background-color: #e94e2b;
        }
        .product-section {
            padding: 4rem 0;
        }
        .divider {
            height: 1px;
            background-color: #ffffff;
            margin: 2rem 0;
        }
    </style>
</head>
<body id="page-top">
@include('navbar.sellerNavbar', ['notifications' => $notifications])

    <!-- Masthead -->
    <header class="masthead">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-white font-weight-bold">Welcome to Your Seller Dashboard</h1>
                    <hr class="divider" />
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <p class="text-white-75 mb-5">Manage your products, view orders, and more!</p>
                    <a class="btn-shop-now" href="{{ route('products.create') }}">
    Manage Products <i class="bi bi-bag"></i>
</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Content Sections -->
    @yield('content')
<header class="masthead">
    <!-- Products Section -->
    @if(isset($products) && $products->count() > 0)
    <div class="product-section" id="products-section">
        <div class="container px-4 px-lg-5">
            <h2 class="text-center">Your Products</h2>
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body">
                                <h5 class="card-title" style="color: black;">{{ $product->name }}</h5>
                                <p class="card-text" style="color: black;">{{ $product->price }} $</p>
                                <a href="{{ route('products.editProduct', $product->id) }}" class="btn btn-primary">Edit</a>
                                
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @else
    <div class="product-section" id="products-section">
        <div class="container px-4 px-lg-5">
            <p class="text-center">No products available.</p>
        </div>
    </div>
    @endif
  

    </header>
    <!-- Bootstrap core JS -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
