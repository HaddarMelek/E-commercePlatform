
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Shopping Online')</title>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('download.jpeg') }}" />
    <!-- Core theme CSS (includes Bootstrap) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
</head>

<body id="page-top">
@include('navbar.buyerNavbar')

    <!-- Masthead -->
    <header class="masthead">
    <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-white font-weight-bold">{{ $category->name }}</h1>
                    <hr class="divider" />
                    </div>
                
                <div class="col-lg-8 align-self-baseline">
                    <p class="text-white-75 mb-5">{{ $category->description }}</p>
                    <div id="products-section" class="py-5">
                        <div class="container">
                            <div class="row">
                            @foreach($products as $product)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card border-light shadow-sm">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top" style="height: 250px; object-fit: cover;">
                                    <div class="card-body">
                                        <h4 class="card-title">{{ $product->name }}</h4><br>
                                        <h5 class="card-price">${{ $product->price }}</h5><br>
                                        <a href="{{ route('products.show', $product->id) }}" class="card-link">See Details</a><br>
                                    </div>
                                    <div class="card-footer d-flex justify-content-between align-items-center">
                                        <form id="buyNowForm_{{ $product->id }}" action="{{ route('buyer.placeOrder', $product->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="button" class="btn-buy-now" data-product-id="{{ $product->id }}">Buy Now</button>
                                        </form>
                                        <form id="addToCartForm_{{ $product->id }}" action="{{ route('products.addToCart', $product->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="button" class="btn-add-to-cart" data-product-id="{{ $product->id }}">Add to Cart</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="alert alert-danger d-none" id="errorAlert"></div>
                        <div class="alert alert-success d-none" id="successAlert"></div>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </header>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>

    <!-- Modal -->
    <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="responseModalLabel">Response</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="responseModalBody">
                    <!-- Response message will be injected here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function getCsrfToken() {
                return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            }

            function handleAction(form, action) {
                var formData = new FormData(form);

                fetch(action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken()
                    }
                })
                .then(response => response.json())
                .then(data => {
                    var modal = new bootstrap.Modal(document.getElementById('responseModal'));
                    var modalBody = document.getElementById('responseModalBody');

                    if (data.error) {
                        modalBody.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
                    } else if (data.success) {
                        modalBody.innerHTML = `<div class="alert alert-success">${data.success}</div>`;
                    }

                    modal.show();
                })
                .catch(error => console.error('Error:', error));
            }

            document.querySelectorAll('.btn-buy-now').forEach(button => {
                button.addEventListener('click', function() {
                    var productId = this.getAttribute('data-product-id');
                    var form = document.getElementById('buyNowForm_' + productId);
                    handleAction(form, form.action);
                });
            });

            document.querySelectorAll('.btn-add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    var productId = this.getAttribute('data-product-id');
                    var form = document.getElementById('addToCartForm_' + productId);
                    handleAction(form, form.action);
                });
            });
        });
    </script>
</body>
</html>
