<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Checkout')</title>
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
        .masthead {
            background-color: #f8f9fa;
            padding: 5rem 0;
        }
        .dashboard-content {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0 1rem rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body id="page-top">

@include('navbar.buyerNavbar')

<!-- Masthead with Checkout Details -->
<header class="masthead text-center py-5">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 align-items-center justify-content-center">
            <div class="col-lg-8">
                <h1 class="display-4 font-weight-bold">Checkout</h1>
                <hr class="divider" />
                <div class="dashboard-content">
                    <h2>Total: ${{ number_format($total, 2) }}</h2>

                    <form action="{{ route('buyer.proceedToCheckout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Bootstrap core JS -->
<script src="{{ asset('js/scripts.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
