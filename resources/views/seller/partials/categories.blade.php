<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
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
            padding-top: 20px;
            padding-bottom: 20px;
            background-color: #343a40;
            color: white;
        }

        .divider {
            border-color: #f8f9fa;
        }
    </style>
</head>
<body id="page-top">
@include('navbar.sellerNavbar', ['notifications' => $notifications])

<header class="masthead">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 align-items-center justify-content-center text-center">
            <div class="col-lg-8 align-self-end">
                <h1 class="font-weight-bold">Add New Category</h1>
                <hr class="divider" />
            </div>
        </div>

        <!-- Add Category Form -->
        <div class="row gx-4 gx-lg-5 justify-content-center text-center">
            <div class="col-lg-6">
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf <!-- CSRF token for security -->

                    <div class="mb-3">
                        <label for="name" class="label-left">Category Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter category name" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="label-left">Category Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter category description" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image_url" class="label-left">Category Image</label>
                        <input type="file" name="image_url" id="image_url" class="form-control">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </div>
                </form>

                <!-- Display success message -->
                @if (session('success'))
                    <div class="alert alert-success mt-4">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</header>
<section>
    <div >
        <p>Thank you for adding a new category. Keep your catalog updated!</p>
    </div>
    </section>

<!-- Bootstrap core JS -->
<script src="{{ asset('js/scripts.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
