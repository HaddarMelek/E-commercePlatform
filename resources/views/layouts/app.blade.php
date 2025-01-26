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
    
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        /* Navbar styling */
      
        #mainNav {
            padding-top: 10rem;
  padding-bottom: calc(10rem - 4.5rem);
  background: linear-gradient(to bottom, rgba(92, 77, 66, 0.8) 0%, rgba(92, 77, 66, 0.8) 100%), 
              url("../assets/img/bg-masthead.jpg");
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  background-attachment: fixed; 
  transition: background-image 0.5s ease-in-out; 
  height: 100vh; 
  width: 100%; 
        }
        .navbar-brand img {
            width: 50px;
            height: 50px;
        }
        .nav-link i {
            font-size: 1.5rem;
            color: white;
        }
        .nav-link {
            position: relative;
        }
        .nav-link:hover::after {
            content: attr(data-bs-title);
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            padding: 3px 6px;
            background-color: rgba(0, 0, 0, 0.75);
            color: white;
            border-radius: 4px;
            font-size: 0.8rem;
        }
    </style>
</head>
<body id="page-top">
    <!-- Navigation -->
  

    <!-- Main Content -->
    <main class="container mt-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-light py-5">
        <div class="container text-center">
        </div>
    </footer>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS -->
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
