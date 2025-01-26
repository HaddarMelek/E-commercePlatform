<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Orders</title>
        <!-- Favicon-->
        <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
        <link rel="icon" type="image/png" href="{{ asset('download.jpeg') }}" />        <!-- Bootstrap Icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
        <!-- SimpleLightbox plugin CSS-->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    </head>
    <body id="page-top">
    

        <!-- Masthead -->
        <header class="masthead">
            <div class="container px-4 px-lg-5 h-100">
                <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-8 align-self-end">
                        <h2 class="text-white font-weight-bold">Your orders</h2>
                        <hr class="divider" />
                    </div>
                    <div class="col-lg-8 align-self-baseline">
                        @if($orders->isEmpty())
                            <p>You have no orders yet.</p>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Action</th> <!-- New Action Column -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                            <td>${{ number_format($order->total, 2) }}</td>
                                            <td>{{ $order->status }}</td>
                                            <td>
    @if($order->status == 'Pending')
        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-danger">Cancel</button>
        </form>
    @else
    <button type="submit" class="btn btn-danger" disabled>Cancel</button>
    @endif
    <!-- View Details Button -->
    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewDetailsModal{{ $order->id }}">
        View Details
    </button>
</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif                        
                    </div>
                </div>
            </div>
        </header>
        @foreach($orders as $order)
    <!-- Modal -->
    <div class="modal fade" id="viewDetailsModal{{ $order->id }}" tabindex="-1" aria-labelledby="viewDetailsModalLabel{{ $order->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewDetailsModalLabel{{ $order->id }}">Order Details for {{ $order->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('orders.updateDetails', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="name{{ $order->id }}" class="form-label">Name</label>
                            <input type="text" name="name" id="name{{ $order->id }}" class="form-control" value="{{ $order->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone_number{{ $order->id }}" class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number{{ $order->id }}" class="form-control" value="{{ $order->phone_number }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="address{{ $order->id }}" class="form-label">Address</label>
                            <textarea name="address" id="address{{ $order->id }}" class="form-control" rows="3" required>{{ $order->address }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Details</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

        <!-- Bootstrap core JS -->
        <script src="{{ asset('js/scripts.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>
