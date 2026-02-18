<h2>Order Details for Reference: {{ $referenceNumber }}</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Menu</th>
        <th>Rice</th>
        <th>Add-ons</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total</th>
    </tr>
    @foreach ($orders as $item)
        <tr>
            <td>{{ $item->menu_name }}</td>
            <td>{{ $item->rice_name ?? '-' }}</td>
            <td>{{ $item->addon_name ?? '-' }}</td>
            <td>{{ $item->quantity }}</td>
            <td>₱{{ number_format($item->price, 2) }}</td>
            <td>₱{{ number_format($item->price * $item->quantity, 2) }}</td>
        </tr>
    @endforeach
</table>
