@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cancel Order</h2>

    <p>Order Reference: {{ $order->reference }}</p>
    <p>Status: {{ $order->status }}</p>
    <p>Total: ${{ number_format($order->total, 2) }}</p>

    @if($order->status == 'Pending')
        <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-danger">Cancel Order</button>
        </form>
    @else
        <button type="button" class="btn btn-secondary" disabled>Order cannot be canceled</button>
    @endif
</div>
@endsection
