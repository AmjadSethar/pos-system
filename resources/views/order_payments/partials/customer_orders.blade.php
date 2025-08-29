@if($orders->isEmpty())
    <p>No orders found for this customer.</p>
@else
    <ul class="list-group mb-2">
        @foreach($orders as $order)
            <li class="list-group-item">
                Order #{{ $order->id }} - {{ $order->created_at->format('Y-m-d') }}
            </li>
        @endforeach
    </ul>

    <p><strong>Total Amount:</strong> {{ number_format($orders->sum('grand_total'), 2) }}</p>
    <p><strong>Paid Amount:</strong> {{ number_format($orders->sum('paid_amount'), 2) }}</p>
    <p><strong>Remaining Amount:</strong> {{ number_format($orders->sum('grand_total') - $orders->sum('paid_amount'), 2) }}</p>

@endif
