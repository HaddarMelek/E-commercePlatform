<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Seller Dashboard')</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
<link rel="icon" type="image/png" href="{{ asset('download.jpeg') }}" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google fonts -->
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
            cursor: pointer; /* Add cursor pointer to indicate clickability */
        }
        /* Fullscreen overlay styles */
        .fullscreen-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .fullscreen-overlay img {
            max-width: 90%;
            max-height: 90%;
        }
        .fullscreen-overlay .close {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 2rem;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body id="page-top">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="{{ route('user.showProfile') }}" >
                @php
                    $user = auth()->user();
                @endphp
                @if($user->profile_photo_path)
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Photo">
                @else
                    <img src="{{ asset('Logo.png') }}" alt="Default Profile Photo">
                @endif
            </a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">
                    <li class="nav-item">
                        <form class="d-flex search-form" action="{{ route('products.searchProduct') }}" method="GET">
                            <input class="form-control search-input me-2" type="search" placeholder="Search" aria-label="Search" name="query">
                            <button class="btn search-button" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.dashboard') }}">
                            <i class="bi bi-house"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.create') }}">
                            <i class="bi bi-plus-circle"></i>
                            <span>Add Category</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.create') }}">
                            <i class="bi bi-plus-circle"></i>
                            <span>Add Product</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.showProfile') }}">
                            <i class="bi bi-person"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#notificationsModal">
                            <i class="bi bi-bell"></i>
                            <span>Notifications</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    <!-- Notifications Modal -->
    <div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationsModalLabel">Notifications</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($notifications->isEmpty())
                        <p class="text-center">No new notifications.</p>
                    @else
                        <ul class="list-group">
                            @foreach($notifications as $notification)
                                <li class="list-group-item">
                                    {{ $notification->data['message'] }}
                                    <small class="text-muted d-block">{{ $notification->created_at->diffForHumans() }}</small>
                                    @if(isset($notification->data['order_details']))
                                        @foreach($notification->data['order_details']['products'] as $productDetail)
                                            <div>
                                                <strong>{{ $productDetail['product']['name'] }}</strong> - Quantity: {{ $productDetail['quantity'] }}
                                            </div>
                                        @endforeach
                                    @endif
                                    <a href="{{ route('seller.viewOrderProducts', ['orderId' => $notification->data['order_id']]) }}" class="btn btn-primary btn-sm mt-2">View Products</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
   
</body>
</html>
