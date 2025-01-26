<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Buyer Dashboard')</title>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
<link rel="icon" type="image/png" href="{{ asset('download.jpeg') }}" />
    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <style>
        .navbar-brand img {
            width: 50px; /* Adjust width as needed */
            height: 50px; /* Maintain aspect ratio */
            border-radius: 50%;
            object-fit: cover;
            cursor: pointer; /* Add cursor pointer to indicate clickability */
        }
        .dropdown-menu {
            max-height: 300px; /* Adjust this value as needed */
            overflow-y: auto;
        }

        /* Change background color of dropdown item when clicked */
        .dropdown-item.active, .dropdown-item:active {
            background-color: #f4623a !important;
            color: white !important; /* Ensure the text is readable */
        }
    </style>
</head>
<body id="page-top">
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
                        <a class="nav-link" href="{{ route('buyer.index') }}">
                            <i class="bi bi-house"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('buyer.orders') }}">
                            <i class="bi bi-bag"></i>
                            <span>Orders</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.view') }}">
                            <i class="bi bi-cart"></i>
                            <span>Cart</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-list-ul"></i>
                        <span>Categories</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach ($categories as $category)
                            <li><a class="dropdown-item" href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if(auth()->user()->profile_photo_path)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="Profile Photo" class="rounded-circle" style="width: 40px; height: 40px;">
                            @else
                                <img src="{{ asset('Logo.png') }}" alt="Default Profile Photo" class="rounded-circle" style="width: 40px; height: 40px;">
                            @endif
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="{{ route('user.showProfile') }}">Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="modal fade modal-fullscreen" id="profilePhotoModal" tabindex="-1" aria-labelledby="profilePhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body">
                    <span class="close-btn" data-bs-dismiss="modal" aria-label="Close">&times;</span>
                    @if(auth()->user()->profile_photo_path)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="Profile Photo">
                    @else
                        <img src="{{ asset('Logo.png') }}" alt="Default Profile Photo">
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownItems = document.querySelectorAll('.dropdown-item');

        dropdownItems.forEach(function (item) {
            item.addEventListener('click', function () {
                dropdownItems.forEach(function (el) {
                    el.classList.remove('active');
                });
                this.classList.add('active');
            });
        });
    });
</script>
</body>
</html>
