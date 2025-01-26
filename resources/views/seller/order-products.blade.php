<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Products</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('download.jpeg') }}" />
    <!-- SimpleLightbox CSS -->
    <link href="https://cdn.jsdelivr.net/npm/simplelightbox@2.0.0/dist/simple-lightbox.min.css" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <style>
        .bg-white {
            background-color: white;
        }
        .p-4 {
            padding: 20px;
        }
    </style>
</head>

<body>
    @include('navbar.sellerNavbar', ['notifications' => $notifications])
    <header class="masthead">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-white font-weight-bold">View Product</h1>
                    <div class="container">
                        @foreach($orderDetails as $sellerId => $details)
                            <h2>Products for Seller ID: {{ $sellerId }}</h2>
                            <div class="row">
                                @foreach($details['products'] as $productDetail)
                                    <div class="col-lg-4 col-md-6 mb-4">
                                        <div class="card border-light shadow-sm">
                                            <a href="{{ asset('storage/' . $productDetail['products']->image) }}" class="card-link">
                                                <img src="{{ asset('storage/' . $productDetail['products']->image) }}" alt="{{ $productDetail['products']->name }}" class="card-img-top" style="height: 250px; object-fit: cover;">
                                            </a>
                                            <div class="card-body">
                                                <h4 class="card-title">{{ $productDetail['products']->name }}</h4>
                                                <h5 class="card-price">${{ $productDetail['products']->price }}</h5>
                                                <h6 class="card-quantity">Quantity: {{ $productDetail['quantity'] }}</h6>
                                                <a href="{{ route('products.show', $productDetail['products']->id) }}" class="card-link">See Details</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @php
    // Initialize totals
    $totalPrice = 0;
    $adminCommission = 0;
    $totalEarnings = 0;

    // Calculate totals
    foreach ($details['products'] as $productDetail) {
        $price = $productDetail['products']->price;
        $totalPrice += $price;
        $adminCommission += $price * 0.1;
        $totalEarnings += $price * 0.9;
    }
@endphp

<div class="text-center mt-4 bg-white p-4">
    <h3>Admin Commission</h3>
    <p>${{ $adminCommission }}</p>
</div>
<div class="text-center bg-white p-4">
    <h3>Total Earnings for Seller</h3>
    <p>${{ $totalEarnings }}</p>
</div>

                        @endforeach

                        <div class="text-center bg-white p-4">
                            <form id="confirmOrderForm" action="{{ route('seller.confirmOrder', $orderId) }}" method="POST" style="display:inline;">
                                @csrf
                                <div class="text-center bg-white">
                                    <button type="submit" id="confirmButton" class="btn btn-success">Confirm Product Preparation</button>
                                </div>
                            </form>
                        </div>
                       
                        <div class="text-center bg-white">
                            <a href="{{ route('seller.dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="responseModalLabel">Order Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="responseModalBody">
                    <!-- Response message will be injected here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('seller.dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SimpleLightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/simplelightbox@2.0.0/dist/simple-lightbox.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('confirmOrderForm');
    var modal = new bootstrap.Modal(document.getElementById('responseModal'));
    var responseModalBody = document.getElementById('responseModalBody');
    
    var csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    var csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission

        var formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                responseModalBody.innerHTML = '<p>' + data.success + '</p>';
            } else {
                responseModalBody.innerHTML = '<p>' + data.error + '</p>';
            }
            modal.show();
        })
        .catch(error => {
            responseModalBody.innerHTML = '<p>Failed to confirm the order. Please try again later.</p>';
            modal.show();
        });
    });
});

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var lightbox = new SimpleLightbox('.card-link');
        });
    </script>
    
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
