<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manage Orders</title>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="icon" type="image/png" href="{{ asset('download.jpeg') }}" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <style>
        .btn-custom {
            width: 50px; /* Set a fixed width for icons */
            height: 50px; /* Set a fixed height for icons */
            padding: 0;
            font-size: 1.5rem; /* Adjust size of icon */
            line-height: 1;
            text-align: center;
            border-radius: 50%; /* Make buttons circular */
            transition: background-color 0.3s, color 0.3s;
        }
        .btn-custom i {
            margin: 0;
        }
        .btn-custom-tooltip {
            position: relative;
        }
        .btn-custom-tooltip:hover::after {
            content: attr(data-title);
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: #fff;
            padding: 0.5rem;
            border-radius: 0.3rem;
            white-space: nowrap;
            font-size: 0.875rem;
            opacity: 1;
            transition: opacity 0.3s;
            pointer-events: none;
            z-index: 1000;
        }
        .btn-custom-tooltip::after {
            content: '';
            opacity: 0;
        }
        .btn-custom:hover {
            background-color: #f4623a;
            color: #fff;
        }
        .btn-custom-danger {
            background-color: #dc3545;
            color: #fff;
        }
        .btn-custom-danger:hover {
            background-color: #c82333;
        }
        .btn-custom-success {
            background-color: #28a745;
            color: #fff;
        }
        .btn-custom-success:hover {
            background-color: #218838;
        }
        .btn-custom-info {
            background-color: #17a2b8;
            color: #fff;
        }
        .btn-custom-info:hover {
            background-color: #138496;
        }
        .btn-custom-primary {
            background-color: #007bff;
            color: #fff;
        }
        .btn-custom-primary:hover {
            background-color: #0069d9;
        }
    </style>
</head>
<body id="page-top">
@include('navbar.adminNavbar', ['notifications' => $notifications])

    <!-- Masthead -->
    <header class="masthead">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-white font-weight-bold">Manage Orders</h1>
                    <hr class="divider" />
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <p class="text-white-75 mb-5">View and manage all orders placed by buyers.</p>
                    <div class="section">
                        <div class="container px-4 px-lg-5">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="text-primary mb-0">Orders List</h3>
                                </div>
                                <div class="card-body">
                                    <!-- Orders Table -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Buyer</th>
                                                    <th>Status</th>
                                                    <th>Total</th>
                                                    <th>Admin Commission</th>
                                                    <th>Sellers Earnings</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($orders as $order)
                                                <tr>
                                                    <td>{{ $order->user->name }}</td>
                                                    <td>{{ $order->status }}</td>
                                                    <td>${{ $order->total }}</td>
                                                    <td>${{ $order->admin_commission }}</td>
                                                    <td>${{ $order->sellers_earnings }}</td>
                                                    <td>
                                                        <!-- View Details Button -->
                                                        <button type="button" class="btn btn-primary btn-custom btn-custom-tooltip" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#detailsModal" 
                                                            data-name="{{ $order->user->name }}" 
                                                            data-phone_number="{{ $order->phone_number }}" 
                                                            data-address="{{ $order->address }}"
                                                            data-title="View Details">
                                                            <i class="bi bi-eye"></i>
                                                        </button>

                                                        <!-- Manage Order Button -->
                                                        <button type="button" class="btn btn-primary btn-custom btn-custom-tooltip manage-order-btn" 
    data-order-id="{{ $order->id }}"
    data-bs-toggle="modal" 
    data-bs-target="#manageOrderResponseModal"
    data-title="Manage Order">
    <i class="bi bi-gear"></i>
</button>

                                                        <form id="manageOrderForm" action="{{ route('admin.orders.manage', $order->id) }}" method="POST" style="display:none;">
                                                            @csrf
                                                        </form>
                                                        
                                                       
                                                        <form action="{{ route('admin.orders.changeStatus', ['id' => $order->id]) }}" method="POST" style="display:inline;">
    @csrf
    <input type="hidden" name="status" value="shipped">
   <!-- Status Update Button -->

<button type="button" class="btn btn-primary btn-custom btn-custom-tooltip ship-order-btn" title="Mark as Shipped" data-title="Mark as Shipped" data-order-id="{{ $order->id }}" data-status="shipped">
    <i class="bi bi-truck"></i>
</button>

</form>


                                                        <!-- Delete Order Button -->
                                                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-primary btn-custom btn-custom-tooltip"   title="Delete" data-title="Delete">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- End of Orders Table -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
<!-- Manage Order Response Modal -->
<div class="modal fade" id="manageOrderResponseModal" tabindex="-1" aria-labelledby="manageOrderResponseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manageOrderResponseModalLabel">Mark as processed</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Content will be dynamically added here -->
            </div>
        </div>
    </div>
</div>



    <!-- Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="modalName"></span></p>
                    <p><strong>Phone Number:</strong> <span id="modalPhone"></span></p>
                    <p><strong>Address:</strong> <span id="modalAddress"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Order Status Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Content will be dynamically added here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var detailsModal = document.getElementById('detailsModal');
        detailsModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var name = button.getAttribute('data-name');
            var phone = button.getAttribute('data-phone_number');  
            var address = button.getAttribute('data-address');

            var modalName = detailsModal.querySelector('#modalName');
            var modalPhone = detailsModal.querySelector('#modalPhone');
            var modalAddress = detailsModal.querySelector('#modalAddress');

            modalName.textContent = name;
            modalPhone.textContent = phone;
            modalAddress.textContent = address;
        });
    });
    </script>
   <script>
    $(document).ready(function () {
        $('.manage-order-btn').on('click', function () {
            var orderId = $(this).data('order-id'); // Get the order ID from the button

            $.ajax({
                url: '/admin/orders/manage/' + orderId,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                },
                success: function (response) {
                    // Display success message in the modal
                    $('#manageOrderResponseModal .modal-body').html('<p class="text-success">' + response.success + '</p>');
                },
                error: function (xhr) {
                    var errorMessage = 'An error occurred.';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    }
                    $('#manageOrderResponseModal .modal-body').html('<p class="text-danger">' + errorMessage + '</p>');
                }
            });

            $('#manageOrderResponseModal').modal('show'); // Show the modal
        });

        
    });
</script>

<script>
    $(document).ready(function() {
        // Set up the CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.change-status-form').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            var $form = $(this);
            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: $form.serialize(),
                success: function(response) {
                    console.log('Success:', response); // Log success response for debugging
                    $('#statusModal .modal-body').html('<p>' + response.message + '</p>');
                    $('#statusModal').modal('show');
                },
                error: function(xhr) {
                    console.log('Error:', xhr); // Log error response for debugging
                    var errorMessage = 'An error occurred.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    $('#statusModal .modal-body').html('<p>' + errorMessage + '</p>');
                    $('#statusModal').modal('show');
                }
            });
        });
    });
</script>
<script>
$(document).ready(function () {
    // Handle button click for status update
    $('.ship-order-btn').on('click', function () {
        var orderId = $(this).data('order-id');
        var status = $(this).data('status');
        var token = $('meta[name="csrf-token"]').attr('content'); // CSRF token
      
        if (isNaN(orderId) || orderId <= 0) {
            console.error('Invalid order ID: ' + orderId);
            return 0; 
        }

        // Perform an AJAX request to change the order status
        $.ajax({
            url: '/orders/change-status/' + orderId,
            method: 'POST',
            data: {
                _token: token,
                status: status
            },
            success: function (response) {
                // Update the modal content based on the response
                $('#statusModal .modal-body').html('<p>' + response.message + '</p>');
                $('#statusModal').modal('show'); // Show the modal
            },
            error: function (xhr) {
                var errorMessage = 'An error occurred.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                $('#statusModal .modal-body').html('<p class="text-danger">' + errorMessage + '</p>');
                $('#statusModal').modal('show'); // Show the modal
            }
        });
    });
});
</script>

</body>
</html>