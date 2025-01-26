<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
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
        .btn-dashboard {
            background-color: #f4623a;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
        }
        .btn-dashboard:hover {
            background-color: #e94e2b;
        }
        .section {
            padding: 4rem 0;
        }
        .divider {
            height: 1px;
            background-color: #ffffff;
            margin: 2rem 0;
        }
        .icon-card {
            font-size: 2rem;
            margin-right: 0.5rem;
        }
       
        .modal-header {
            background-color: #f4623a;
            color:#fff;          }
    </style>
</head>
<body id="page-top">
@include('navbar.adminNavbar', ['notifications' => $notifications])

    <!-- Masthead -->
    <header class="masthead">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-white font-weight-bold">Welcome to Your Admin Dashboard</h1>
                    <hr class="divider" />
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <p class="text-white-75 mb-5">Manage users, view orders, and more!</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#discountsModal">
                        View Discounts
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Discounts Modal -->
    <div class="modal fade" id="discountsModal" tabindex="-1" aria-labelledby="discountsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title" id="discountsModalLabel">Discount Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    @if(isset($totalCommission))
                        <p >Total Commission Earned from Discounts: <strong>${{ $totalCommission }}</strong></p>
                    @else
                        <span>Total Commission: Not Available</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
