
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shopping Online')</title>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
<link rel="icon" type="image/png" href="{{ asset('download.jpeg') }}" />
    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />

</head>
<body id="page-top">
@include('navbar.buyerNavbar')


    <!-- Masthead -->
   
    <header class="masthead">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-white font-weight-bold">Your Cart</h1>
                    <hr class="divider" />
                </div>
                <div class="col-lg-8 align-self-baseline">
                @if($cartItems->isEmpty())
                
                <p>Your cart is empty.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($cartItems as $item)
    <tr>
    <td>{{ $item->product->name }}</td>
        <td>{{ $item->quantity }}</td>
        <td>${{ number_format($item->product->price, 2) }}</td>
        <td>${{ number_format($item->quantity * $item->product->price, 2) }}</td>
        <td>
        <form action="{{ route('buyer.removeFromCart', $item->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-trash"></i>
    </button>
</form>

        </td>
        </tr>
@endforeach

                            </tbody>
                        </table>
                        <a href="{{ route('buyer.checkout') }}" class="btn btn-primary">Proceed to Checkout</a>
                        @endif                     
                    </div>
   
            </div>
        </div>
    </header>
    


    

    <!-- Bootstrap core JS -->
        <script src="{{ asset('js/scripts.js') }}"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

