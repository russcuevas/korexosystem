<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Confirmation - Korexo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
        }

        hr {
            width: 50%;
            /* same width ng table */
            margin-left: 0;
            /* align left */
            margin-top: 15px;
            margin-bottom: 15px;
        }


        h2,
        h3 {
            color: #a30000;
        }

        table {
            width: 50%;
            border-collapse: collapse;
            margin-top: 15px;
            border: 2px solid #a30000;
            /* outer border */
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }


        .total {
            font-weight: bold;
        }

        .section {
            margin-top: 20px;
        }

        .rice,
        .addon {
            font-size: 0.9rem;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="{{ $message->embed(public_path('kore.png')) }}" alt="Korexo Logo"
                style="display: block; margin: 0 auto; max-width: 100px; height: auto; border-radius: 100px;">
        </div>
        <h2>Order Confirmation</h2>

        <p><strong>Reference Number:</strong> {{ $referenceNumber }}</p>
        <p><strong>Reserved Time:</strong> {{ \Carbon\Carbon::parse($reservedAt)->format('g A') }} - March 03, 2026</p>

        <h3>Order Details:</h3>

        <table>
            <tr>
                <th style="font-weight: 900">Menu</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>

            {{-- Main items --}}
            @foreach ($orders->whereNull('is_add_ons_menu') as $item)
                <tr>
                    <td style="text-align: center; font-weight: 900;">
                        {{ $item->menu_name }}
                        @if (!empty($item->rice_name))
                            <div class="rice">w/ {{ $item->rice_name }}</div>
                        @endif
                    </td>
                    <td style="text-align: center">{{ $item->quantity }}</td>
                    <td style="text-align: center">₱{{ number_format($item->price, 2) }}</td>
                    <td style="text-align: center">₱{{ number_format($item->quantity * $item->price, 2) }}</td>
                </tr>
            @endforeach

            {{-- Add-ons --}}
            @foreach ($orders->whereNotNull('is_add_ons_menu') as $addon)
                <tr>
                    <td style="text-align: center; font-weight: 900;">
                        {{ $addon->menu_name }}
                        @if (!empty($addon->rice_name))
                            <div class="addon">x {{ $addon->rice_name }}</div>
                        @endif
                    </td>
                    <td style="text-align: center">{{ $addon->quantity }}</td>
                    <td style="text-align: center">₱{{ number_format($addon->price, 2) }}</td>
                    <td style="text-align: center">₱{{ number_format($addon->quantity * $addon->price, 2) }}</td>
                </tr>
            @endforeach

        </table>

        <h3 class="section">Total Amount: ₱{{ number_format($totalAmount, 2) }}</h3>
        @if (!empty($qrFileName))
            <div class="section" style="margin: 25px 0; text-align: center;">

                <img src="{{ $message->embed(public_path('qr-codes/' . $qrFileName)) }}" alt="QR Code"
                    style="display:block; margin: 0 auto; width:150px; height:150px;">

                <p style="font-size: 12px; color: #777; margin-top:10px;">
                    Ref: {{ $referenceNumber }} <br>
                    "Please present this qr at the venue"
                </p>

            </div>
        @endif

        <p>Thank you for ordering from <strong>Korexo</strong>!</p>
    </div>
</body>

</html>
