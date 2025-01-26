<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
<link rel="icon" type="image/png" href="{{ asset('download.jpeg') }}" />
    <title>@yield('title', 'Product Management')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        .form-select {
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 8px;
    background-color: #f8f9fa;
    font-size: 16px;
}

.form-select option:checked {
    background-color: #f4623a; /* Background color for selected option */
    color: white; /* Text color for selected option */
}
    </style>
</head>
<body id="page-top">

    <!-- Navigation -->
    @include('navbar.sellerNavbar', ['notifications' => $notifications])

    <!-- Header Section -->
    <header class="masthead bg-primary text-white text-center py-5">
        <div class="container">
            <h1 class="display-4">Manage Products</h1>
            <p class="lead">Add, view, update, and delete your products here.</p>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mt-5">
        <!-- Form to add a new product -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Add New Product</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" step="0.01" name="price" id="price" class="form-control" required>
                    </div>
                    <div class="mb-3">
    <label for="category" class="form-label">Category</label>
    <select name="category" id="category" class="form-select" required>
        @foreach ($categories as $category)
            <option value="{{ $category->name }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>

                    <div class="mb-3">
                        <label for="qte_stock" class="form-label">Quantity in Stock</label>
                        <input type="number" name="qte_stock" id="qte_stock" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>
                @if ($errors->has('qte_stock'))
    <div class="alert alert-danger">
        {{ $errors->first('qte_stock') }}
    </div>
@endif

            </div>
        </div>

        <!-- Products Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Product List</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>${{ $product->price }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->qte_stock }}</td>
                            <td>
                                @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="width: 100px;">
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm" title="View">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('products.editProduct', $product->id) }}" class="btn btn-warning btn-sm" title="Update">
                                    
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('products.deleteProduct', $product->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="{{ route('products.deleteProduct', $product->id) }}">

                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                   

                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

<!-- Modal for Delete Confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Delete Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this product?
      </div>
      <div class="modal-footer">
        <form id="deleteProductForm" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Add this script to your HTML file or in a separate JS file -->
<script>
document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
    button.addEventListener('click', function() {
        const actionUrl = this.getAttribute('data-action');
        document.getElementById('deleteProductForm').action = actionUrl;
    });
});


</script>

</body>
</html>
