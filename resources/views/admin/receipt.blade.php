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
        <h3>KOREXO</h3>
        <p>Receipt #{{ $order['reference_number'] }}</p>
        <p>{{ date('Y-m-d H:i') }}</p>
    </div>

    <div class="line"></div>

    @php
        $grandTotal = 0;
        $currentMainQty = 1;
    @endphp

    @foreach ($order['items'] as $item)
        {{-- MAIN ITEM --}}
        @if (is_null($item->is_add_ons_menu))
            @php
                $currentMainQty = $item->quantity;
                $lineTotal = $item->price * $item->quantity;
                $grandTotal += $lineTotal;
            @endphp

            <div class="item">
                <span>{{ $item->quantity }}x {{ $item->menu_name }}</span>
                <span>₱{{ number_format($lineTotal, 2) }}</span>
            </div>

            @if ($item->rice_name)
                <div> &nbsp;&nbsp;w/ {{ $item->rice_name }}</div>
            @endif

            {{-- ADD-ON ITEM --}}
        @else
            @php
                // Force multiply by main item quantity
                $lineTotal = $item->price * $currentMainQty;
                $grandTotal += $lineTotal;
            @endphp

            <div class="item">
                <span>&nbsp;&nbsp;{{ $currentMainQty }}x {{ $item->menu_name }} [Add-on]</span>
                <span>₱{{ number_format($lineTotal, 2) }}</span>
            </div>
        @endif
    @endforeach

    <div class="line"></div>

    <div class="item total">
        <span>TOTAL</span>
        <span>₱{{ number_format($grandTotal, 2) }}</span>
    </div>

    <div class="line"></div>

    <div class="center">
        <p>Thank you for your order!</p>
    </div>

</body>

</html>
