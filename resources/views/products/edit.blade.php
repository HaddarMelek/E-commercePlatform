<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
<link rel="icon" type="image/png" href="{{ asset('download.jpeg') }}" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <style>
        .form-container {
            background-color: #f8f9fa;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container .form-control {
            border-radius: 0.5rem;
        }
        .btn-primary {
            background-color: #f4623a;
            border-color: #f4623a;
        }
        .btn-primary:hover {
            background-color: #e94e2b;
            border-color: #e94e2b;
        }
        .text-white-border {
            background-color: #f4623a; 
            color: white;
            border: 2px solid #f4623a;
            padding: 5px;
            border-radius: 5px;
            display: inline-block;
            
        }
        .masthead {
            padding-top: 80px; /* Adjust this value if necessary */
        }
      
    </style>
</head>
<body id="page-top">

@include('navbar.sellerNavbar', ['notifications' => $notifications])
<header class="masthead text-center py-5">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 align-items-center justify-content-center">
            <div class="col-lg-8">
                <h1 class="display-4 font-weight-bold text-white-border">Update Product</h1>
                <hr class="divider" />
                <div class="form-container">
                <form id="updateProductForm" enctype="multipart/form-data" autocomplete="off">
    @csrf
    @method('PUT')


    <div class="form-group mb-3">
                            <label for="name" class="label-left">Product Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="label-left">Description</label>
                            <textarea name="description" id="description" class="form-control" required>{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="price" class="label-left">Price</label>
                            <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}" step="0.01" required>
                        </div>

                        <div class="form-group mb-3">
    <label for="category_id" class="label-left">Category</label>
    <select name="category_id" id="category_id" class="form-control" required>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
        @endforeach
    </select>
</div>

                        <div class="form-group mb-3">
                            <label for="qte_stock" class="label-left">Quantity in Stock</label>
                            <input type="number" name="qte_stock" id="qte_stock" class="form-control" value="{{ old('qte_stock', $product->qte_stock) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="image" class="label-left">Product Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary" title="Update Product">Update Product</button>
</form>

                </div>
            </div>
        </div>
    </div>
</header>
<div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="responseModalLabel">Update Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="responseMessage">
                <!-- Message content will be injected here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap core JS -->
<script src="{{ asset('js/scripts.js') }}"></script>
<script>document.getElementById('updateProductForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch('{{ route("products.updateProduct", $product->id) }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(data => {
                return Promise.reject(data);
            });
        }
        return response.json();
    })
    .then(data => {
        let modal = new bootstrap.Modal(document.getElementById('responseModal'));

        if (data.error) {
            document.getElementById('responseMessage').innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
        } else if (data.success) {
            document.getElementById('responseMessage').innerHTML = `<div class="alert alert-success">${data.success}</div>`;
        }

        modal.show();
    })
    .catch(error => {
        console.error('Error:', error);

        let modal = new bootstrap.Modal(document.getElementById('responseModal'));
        let errorMessage = 'An unexpected error occurred.';

        if (error.errors) {
            // Extract validation error messages
            errorMessage = Object.values(error.errors).flat().join('<br>');
        } else if (error.message) {
            // Fallback to error.message if available
            errorMessage = error.message;
        }

        document.getElementById('responseMessage').innerHTML = `<div class="alert alert-danger">${errorMessage}</div>`;
        modal.show();
    });
});


</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
