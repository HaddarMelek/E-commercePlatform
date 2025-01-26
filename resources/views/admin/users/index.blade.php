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
</head>
<body id="page-top">
    @include('navbar.adminNavbar') 

<!-- Masthead -->
<header class="masthead">
    <div class="container px-4 px-lg-5 h-100">
        <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-8 align-self-end">
                <h1 class="text-white font-weight-bold">Manage Users</h1>
                <hr class="divider" />
            </div>
            <div class="col-lg-8 align-self-baseline">
                <p class="text-white-75 mb-5">View and manage all users, including buyers and sellers.</p>
                <div class="section">
                    <div class="section">
                        <div class="container px-4 px-lg-5">
                            @foreach($users as $role => $roleUsers)
                            @if($role !== 'admin')
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h3 class="text-primary mb-0">{{ ucfirst($role) }}s</h3>
                                    </div>
                                    <div class="card-body">
                                        <!-- Users Table -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th style="width: 10%;">ID</th>
                                                        <th style="width: 20%;">Name</th>
                                                        <th style="width: 20%;">Profile Photo</th>
                                                        <th style="width: 30%;">Email</th>
                                                        <th style="width: 20%;">Phone</th>
                                                        <th style="width: 20%;">Address</th>
                                                        <th style="width: 20%;">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($roleUsers as $user)
                                                        <tr>
                                                            <td>{{ $user->id }}</td>
                                                            <td>{{ $user->name }}</td>
                                                            <td>
                                                                @if($user->profile_photo_path)
                                                                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Photo" style="width: 50px; height: 50px; border-radius: 50%;" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="{{ asset('storage/' . $user->profile_photo_path) }}">
                                                                @else
                                                                    <img src="{{ asset('Logo.png') }}" alt="Default Profile Photo" style="width: 50px; height: 50px; border-radius: 50%;" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="{{ asset('Logo.png') }}">
                                                                @endif
                                                            </td>
                                                            <td>{{ $user->email }}</td>
                                                            <td>{{ $user->phone_number }}</td>
                                                            <td>{{ $user->address }}</td>
                                                            <td>
                                                                <!-- Action Buttons -->
                                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                                        <i class="bi bi-trash"></i> Delete
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- End of Users Table -->
                                    </div>
                                </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Full Screen Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Profile Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" alt="Profile Photo" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var imageModal = document.getElementById('imageModal');
        imageModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var imageUrl = button.getAttribute('data-image');
            var modalImage = imageModal.querySelector('#modalImage');
            modalImage.src = imageUrl;
        });
    });
</script>
</body>
</html>
