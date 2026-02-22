<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Receipt #{{ $order['reference_number'] }}</title>
    <style>
        body {
            font-family: monospace;
            font-size: 12px;
            width: 280px;
            /* Typical thermal printer width */
        }

        .center {
            text-align: center;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .item {
            display: flex;
            justify-content: space-between;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="center">
        <h3>Korexo</h3>
        <p>Receipt #{{ $order['reference_number'] }}</p>
        <p>{{ date('Y-m-d H:i') }}</p>
    </div>

    <div class="line"></div>

    @foreach ($order['items'] as $item)
        <div class="item">
            <span>{{ $item->quantity }}x {{ $item->menu_name }}</span>
            <span>₱{{ number_format($item->price, 2) }}</span>
        </div>
        @if ($item->rice_name)
            <div> w/ {{ $item->rice_name }}</div>
        @endif
        @if (!is_null($item->is_add_ons_menu))
            <div>[Add-on]</div>
        @endif
    @endforeach

    <div class="line"></div>

    <div class="item total">
        <span>Total</span>
        <span>₱{{ number_format($order['items']->sum('price'), 2) }}</span>
    </div>

    <div class="center">
        <p>Thank you for your order!</p>
    </div>
</body>

</html>
