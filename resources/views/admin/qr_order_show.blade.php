<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Korexo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('admins/css/ticketing.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        /* Custom Dropdown Menu */
        .dropdown-menu-glass {
            background: rgba(18, 16, 38, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            margin-top: 10px !important;
        }

        .dropdown-item {
            color: rgba(255, 255, 255, 0.7);
            padding: 10px 20px;
            font-size: 0.9rem;
        }

        .dropdown-item:hover {
            background: var(--glass);
            color: white;
        }

        .dropdown-item.active {
            background: var(--primary-red);
            color: white;
        }

        /* Order Card Styling */
        .order-card {
            background: var(--glass);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 15px;
            height: 100%;
            transition: transform 0.3s ease, border-color 0.3s ease;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .order-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-red);
        }

        .order-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 10px;
            margin-bottom: 12px;
        }

        .item-list {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
            flex-grow: 1;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .dot-placed {
            background: #007bff;
            animation: pulse 1.5s infinite;
        }

        .dot-pending {
            background: #ffc107;
        }

        .dot-served {
            background: #28a745;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.3;
            }

            100% {
                opacity: 1;
            }
        }

        .btn-action {
            font-size: 0.75rem;
            border-radius: 10px;
            padding: 5px 10px;
            width: 100%;
            margin-top: 10px;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px;
            border-radius: 8px;
            transition: 0.2s ease;
        }

        .item-row.served {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid #28a745;
        }

        .check-btn {
            background: #28a745;
            border: none;
            color: white;
            border-radius: 6px;
            padding: 4px 8px;
            font-size: 0.8rem;
        }

        .served-item {
            text-decoration: line-through;
            opacity: 0.6;
        }
    </style>
</head>

<body>

    @include('admin.left_sidebar')

    <div class="main-content" id="main-content">
        <header class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.orders.page') }}" id="menu-toggle"><i class="bi bi-arrow-left fs-4"></i></a>
                <h2 class="fw-bold mb-0">QR SCAN RESULT</h2>
            </div>
        </header>

        <div>
            @php
                $statuses = ['Placed order', 'Pending', 'Served'];
                $ordersByStatus = collect($orders)->groupBy('status');
            @endphp

            @foreach ($statuses as $statusKey)
                @if (isset($ordersByStatus[$statusKey]))
                    <h5 class="text-white mt-4">{{ $statusKey }}</h5>
                    <hr style="border-color: rgba(255,255,255,0.2);">

                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
                        @foreach ($ordersByStatus[$statusKey] as $order)
                            <div class="col">
                                <div class="order-card">

                                    {{-- Display REF and Name --}}
                                    <div class="order-header d-flex justify-content-between">
                                        <span class="fw-bold small">
                                            REF #{{ $order->reference_number }}
                                            <br>
                                            <span style="font-weight: normal; font-size: 0.75rem; opacity: 0.7;">
                                                {{ $order->fullname }}
                                            </span>
                                            <br>
                                            <span style="font-weight: normal; font-size: 0.75rem; opacity: 0.7;">
                                                {{ \Carbon\Carbon::parse($order->items->first()->reserved_at)->format('h A') }}
                                            </span>
                                        </span>

                                        @php
                                            $dotClass = match ($statusKey) {
                                                'Placed order' => 'dot-placed',
                                                'Pending' => 'dot-pending',
                                                'Served' => 'dot-served',
                                                default => 'dot-placed',
                                            };
                                        @endphp
                                        <span class="small"><i class="status-dot {{ $dotClass }}"></i>
                                            {{ $statusKey }}</span>
                                    </div>

                                    {{-- Items --}}
                                    <div class="item-list">
                                        {{-- Main items --}}
                                        @foreach ($order->items->whereNull('is_add_ons_menu') as $item)
                                            <div
                                                class="mb-1 {{ ($statusKey == 'Pending' && $item->is_served == 1) || $statusKey == 'Served' ? 'served-item' : '' }}">
                                                {{ $item->quantity }}x {{ $item->menu_name }} {{ $item->size ?? '' }}
                                                @if ($item->rice_name)
                                                    <br><small>w/ {{ $item->rice_name }}</small>
                                                @endif
                                                <br>
                                                <span style="color:red; font-weight:bold;">
                                                </span>
                                            </div>
                                        @endforeach

                                        {{-- Add-ons --}}
                                        @php
                                            $addOns = $order->items->filter(fn($i) => !is_null($i->is_add_ons_menu));
                                        @endphp
                                        @foreach ($addOns as $addon)
                                            <div
                                                class="mb-1 {{ ($statusKey == 'Pending' && $addon->is_served == 1) || $statusKey == 'Served' ? 'served-item' : '' }}">
                                                {{ $addon->quantity }}x {{ $addon->menu_name }}
                                                {{ $addon->size ?? '' }}
                                                @if ($addon->rice_name)
                                                    <br><small>w/ {{ $addon->rice_name }}</small>
                                                @endif
                                                [Add-on - <span style="color:red; font-weight:bold;">
                                                    ₱{{ number_format($addon->price * $addon->quantity, 2) }}
                                                </span>]
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Action buttons --}}
                                    <div class="mt-3">
                                        @if ($statusKey == 'Placed order')
                                            <button class="btn btn-danger btn-action fw-bold"
                                                onclick="updateStatus(this, '{{ $order->reference_number }}')">ACCEPT
                                                ORDER</button>
                                        @elseif($statusKey == 'Pending')
                                        @endif
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>


    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        function toggleMenu() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('main-content').classList.toggle('shifted');
        }

        async function updateStatus(btn, referenceNumber) {
            try {
                const res = await fetch('{{ route('admin.orders.updateStatus') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        reference_number: referenceNumber
                    })
                });

                const data = await res.json();

                if (data.success) {
                    const receiptResponse = await fetch('{{ url('/admin/orders/receipt') }}/' + referenceNumber);
                    const receiptText = await receiptResponse.text();

                    await printTwoCopies(receiptText);

                    // Store in sessionStorage and redirect
                    sessionStorage.setItem('lastPrintedRef', referenceNumber);
                    window.location.href = '{{ route('admin.orders.page') }}';
                }

            } catch (err) {
                console.error('Error updating status or printing:', err);
                alert('Error: ' + err.message);
            }
        }

        // Modified printBluetooth to accept receipt content
        async function printBluetooth(receipt) {
            const encoder = new TextEncoder();
            try {
                const device = await navigator.bluetooth.requestDevice({
                    acceptAllDevices: true,
                    optionalServices: [
                        '000018f0-0000-1000-8000-00805f9b34fb',
                        '0000ff00-0000-1000-8000-00805f9b34fb'
                    ]
                });

                const server = await device.gatt.connect();

                let service;
                try {
                    service = await server.getPrimaryService('000018f0-0000-1000-8000-00805f9b34fb');
                } catch (e) {
                    service = await server.getPrimaryService('0000ff00-0000-1000-8000-00805f9b34fb');
                }

                const characteristics = await service.getCharacteristics();
                const characteristic = characteristics.find(c => c.properties.write || c.properties
                    .writeWithoutResponse);
                if (!characteristic) throw new Error("No write characteristic found");

                const data = encoder.encode(receipt);
                const chunkSize = 20;

                for (let i = 0; i < data.length; i += chunkSize) {
                    const chunk = data.slice(i, i + chunkSize);
                    await characteristic.writeValue(chunk);
                    await new Promise(r => setTimeout(r, 25));
                }

                console.log("Print successful!");
            } catch (e) {
                console.error("Kprinter Error:", e);
                alert("Kprinter Error: " + e.message);
            }
        }

        async function printTwoCopies(receiptText) {
            const encoder = new TextEncoder();

            try {
                // Connect ONCE
                const device = await navigator.bluetooth.requestDevice({
                    acceptAllDevices: true,
                    optionalServices: [
                        '000018f0-0000-1000-8000-00805f9b34fb',
                        '0000ff00-0000-1000-8000-00805f9b34fb'
                    ]
                });

                const server = await device.gatt.connect();

                let service;
                try {
                    service = await server.getPrimaryService('000018f0-0000-1000-8000-00805f9b34fb');
                } catch (e) {
                    service = await server.getPrimaryService('0000ff00-0000-1000-8000-00805f9b34fb');
                }

                const characteristics = await service.getCharacteristics();
                const characteristic = characteristics.find(c => c.properties.write || c.properties
                    .writeWithoutResponse);
                if (!characteristic) throw new Error("No write characteristic found");

                // ========= CUSTOMER COPY =========
                await sendToPrinter(characteristic, encoder.encode(
                    "CUSTOMER COPY\n\n" + receiptText + "\n\n\n"
                ));

                // Delay (VERY IMPORTANT for 58mm)
                await new Promise(r => setTimeout(r, 1000));

                // ========= KITCHEN COPY =========
                await sendToPrinter(characteristic, encoder.encode(
                    "KITCHEN COPY\n\n" + receiptText + "\n\n\n"
                ));

                console.log("Printed 2 copies successfully!");

            } catch (e) {
                console.error("Print Error:", e);
                alert("Print Error: " + e.message);
            }
        }

        async function sendToPrinter(characteristic, data) {
            const chunkSize = 20;

            for (let i = 0; i < data.length; i += chunkSize) {
                const chunk = data.slice(i, i + chunkSize);
                await characteristic.writeValue(chunk);
                await new Promise(r => setTimeout(r, 25));
            }
        }

        async function reprintReceipt(referenceNumber) {
            try {
                // 1️⃣ Fetch receipt from Laravel
                const receiptResponse = await fetch(
                    '{{ url('/admin/orders/receipt') }}/' + referenceNumber
                );

                if (!receiptResponse.ok) {
                    throw new Error("Failed to fetch receipt");
                }

                const receiptText = await receiptResponse.text();

                // 2️⃣ Print 2 copies again
                await printTwoCopies(receiptText);

            } catch (err) {
                console.error("Reprint error:", err);
                alert("Reprint Error: " + err.message);
            }
        }
    </script>
</body>

</html>
