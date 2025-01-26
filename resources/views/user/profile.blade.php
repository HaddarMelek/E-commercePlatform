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
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <style>
        .modal-dialog.modal-fullscreen {
            max-width: 100%;
            margin: 0;
        }
        .modal-content {
            background: transparent;
            border: none;
        }
        .modal-body {
            padding: 0;
            position: relative;
        }
        .modal-body img {
            width: 100%;
            height: auto;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 2rem;
            color: white;
            cursor: pointer;
            z-index: 1050;
        }
        .close-button {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px 20px;
            font-size: 1rem;
            background-color: #000;
            color: #fff;
            border: none;
            cursor: pointer;
            z-index: 1050;
        }
    </style>
</head>
<body id="page-top">
@if(Auth::check())
    @if(Auth::user()->role === "buyer")
        @include('navbar.buyerNavbar')
    @elseif(Auth::user()->role === "seller")
        @include('navbar.sellerNavbar')
    @elseif(Auth::user()->role === "admin")
        @include('navbar.adminNavbar')
    @endif
@endif

@yield('content')

<!-- Profile Section -->
<header class="masthead">
    <div class="container px-4 px-lg-5 h-100">
        <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-8 align-self-end">
                <div class="logo-circle">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#profilePhotoModal">
                        @php
                            $user = auth()->user();
                        @endphp
                        @if($user->profile_photo_path)
                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Photo">
                        @else
                            <img src="{{ asset('Logo.png') }}" alt="Default Profile Photo">
                        @endif
                    </a>
                </div>
            </div>

            <!-- Update Profile Form -->
            <form action="{{ route('user.updateProfile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name" class="label-left">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="email" class="label-left">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
                </div>
                <br>

                <div class="form-group">
                    <label for="phone_number" class="label-left">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{ Auth::user()->phone_number }}">
                </div>
                <br>

                <div class="form-group">
                    <label for="address" class="label-left">Address</label>
                    <input type="text" id="address" name="address" class="form-control" value="{{ Auth::user()->address }}">
                </div>
                <br>

                <div class="form-group">
                    <label for="profile_photo" class="label-left">Profile Photo</label>
                    <input type="file" id="profile_photo" name="profile_photo" class="form-control">
                </div>
                <br>
                <br>

                <button type="submit" class="btn btn-primary">Update Profile</button>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </form>

            <!-- Delete Profile Form -->
            <form id="deleteProfileForm" method="POST" action="{{ route('user.deleteProfile') }}" style="margin-top: 20px;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-primary" onclick="confirmDelete()">Delete Profile</button>
            </form>

            <hr class="divider" />
        </div>
    </div>
</header>

<!-- Fullscreen Modal for Profile Photo -->
<div class="modal fade modal-fullscreen" id="profilePhotoModal" tabindex="-1" aria-labelledby="profilePhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen">
        <div class="modal-content">
            <div class="modal-body">
                <span class="close-btn" data-bs-dismiss="modal" aria-label="Close">&times;</span>
                @if($user->profile_photo_path)
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Photo">
                @else
                    <img src="{{ asset('Logo.png') }}" alt="Default Profile Photo">
                @endif
                <button type="button" class="close-button" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('js/scripts.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function confirmDelete() {
        if (confirm("Are you sure you want to delete your profile? This action cannot be undone.")) {
            document.getElementById('deleteProfileForm').submit();
        }
    }
</script>
</body>
</html>
