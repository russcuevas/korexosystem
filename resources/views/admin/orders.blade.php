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
    </style>
</head>

<body>

    @include('admin.left_sidebar')

    <div class="main-content" id="main-content">
        <header class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-3">
                <button id="menu-toggle" onclick="toggleMenu()"><i class="bi bi-list fs-4"></i></button>
                <h2 class="fw-bold mb-0">Orders</h2>
            </div>
        </header>

        <div class="d-flex flex-wrap gap-2 mb-4 justify-content-end">
            <div class="flex-grow-1 flex-sm-grow-0">
                <input type="text" id="searchRef" class="form-control" placeholder="Search REF #"
                    style="height: 41px;">
            </div>
        </div>




        <div id="orderContainer">
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

                                    {{-- Display REF --}}
                                    <div class="order-header d-flex justify-content-between">
                                        <span class="fw-bold small">
                                            REF #{{ $order['reference_number'] }}
                                            <br>
                                            <span style="font-weight: normal; font-size: 0.75rem; opacity: 0.7;">
                                                {{ $order['fullname'] }}
                                            </span>
                                            <br>
                                            <span style="font-weight: normal; font-size: 0.75rem; opacity: 0.7;">
                                                {{ \Carbon\Carbon::parse($order['items']->first()->reserved_at)->format('h A') }}
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
                                        @foreach ($order['items']->whereNull('is_add_ons_menu') as $item)
                                            <div class="mb-1">
                                                {{ $item->quantity }}x {{ $item->menu_name }}
                                                @if ($item->rice_name)
                                                    w/ {{ $item->rice_name }}
                                                @endif
                                            </div>
                                        @endforeach

                                        {{-- Add-ons --}}
                                        @php
                                            $addOns = $order['items']->filter(fn($i) => !is_null($i->is_add_ons_menu));
                                        @endphp
                                        @foreach ($addOns as $addon)
                                            <div class="mb-1">
                                                {{ $addon->quantity }}x {{ $addon->menu_name }}
                                                @if ($addon->rice_name)
                                                    <br>w/ {{ $addon->rice_name }}
                                                @endif
                                                <br>
                                                {{ $addon->size }} [Add-on - <span
                                                    style="color:red; font-weight:bold;">₱{{ number_format($addon->price, 2) }}</span>]
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Action button --}}
                                    <div class="mt-3">
                                        @if ($statusKey == 'Placed order')
                                            <button class="btn btn-danger btn-action fw-bold"
                                                onclick="updateStatus(this, '{{ $order['reference_number'] }}')">ACCEPT
                                                ORDER</button>
                                        @elseif($statusKey == 'Pending')
                                            <button class="btn btn-warning btn-action fw-bold text-dark"
                                                onclick="openServeModal('{{ $order['reference_number'] }}')">
                                                SERVED
                                            </button>
                                        @else
                                        @endif
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Serve Order Modal -->
        <div class="modal fade" id="serveModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content bg-dark text-white rounded-4 border-0">

                    <div class="modal-header border-bottom border-secondary">
                        <h5 class="modal-title fw-bold">
                            REF #<span id="modalRefNumber"></span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body" id="modalOrderItems">

                    </div>

                    <div class="modal-footer border-0">
                        <button class="btn btn-success w-100 fw-bold" id="completeOrderBtn">
                            COMPLETE ALL
                        </button>
                    </div>

                </div>
            </div>
        </div>





    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        let isSearching = false;
        // ---------------- Search REF # ----------------
        let timeout = null;
        document.getElementById('searchRef').addEventListener('keyup', function() {

            let query = this.value;

            if (query.length > 0) {
                isSearching = true;
            } else {
                isSearching = false;
            }

            clearTimeout(timeout);

            timeout = setTimeout(() => {
                fetch(`{{ route('admin.orders.search') }}?q=` + query)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('orderContainer').innerHTML = data;
                    });
            }, 300);
        });

        // ---------------- Realtime Orders Fetch ----------------
        function fetchOrdersRealtime() {

            if (isSearching) return; // 🚫 stop auto refresh while searching

            fetch("{{ route('admin.orders.fetch') }}")
                .then(response => response.text())
                .then(data => {
                    document.getElementById('orderContainer').innerHTML = data;
                })
                .catch(error => console.log(error));
        }
        setInterval(fetchOrdersRealtime, 5000);

        // ---------------- Sidebar Toggle ----------------
        function toggleMenu() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('main-content').classList.toggle('shifted');
        }

        // ---------------- Kprinter ESC/POS Bluetooth Print ----------------
        async function updateStatus(btn, referenceNumber) {
            try {
                // 1️⃣ Update order status via AJAX
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
                    // 2️⃣ Update the UI
                    const card = btn.closest('.order-card');
                    const dot = card.querySelector('.status-dot');
                    const statusText = card.querySelector('.small i').nextSibling;

                    dot.className = 'status-dot dot-pending';
                    statusText.textContent = ' Pending';
                    btn.className = 'btn btn-warning btn-action fw-bold text-dark';
                    btn.textContent = 'SERVED';

                    // 3️⃣ Fetch receipt content from Laravel route
                    const receiptResponse = await fetch('{{ url('/admin/orders/receipt') }}/' + referenceNumber);
                    const receiptText = await receiptResponse.text();

                    // 4️⃣ Print Customer + Kitchen copy
                    await printTwoCopies(receiptText);
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

        let currentReference = null;

        function openServeModal(referenceNumber) {
            currentReference = referenceNumber;

            fetch(`/admin/orders/items/${referenceNumber}`)
                .then(res => res.json())
                .then(order => {

                    document.getElementById('modalRefNumber').textContent = referenceNumber;

                    let html = '';

                    order.items.forEach(item => {

                        let servedClass = item.is_served == 1 ? 'served' : '';

                        html += `
                    <div class="item-row ${servedClass}" id="item-${item.id}">
                        <div>
                            ${item.quantity}x ${item.menu_name}
                        </div>
                        <button class="check-btn"
                            onclick="markItemServed(${item.id})">
                            ✔
                        </button>
                    </div>
                `;
                    });

                    document.getElementById('modalOrderItems').innerHTML = html;

                    let modal = new bootstrap.Modal(document.getElementById('serveModal'));
                    modal.show();
                });
        }

        function markItemServed(itemId) {

            fetch('/admin/orders/item/serve', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        item_id: itemId
                    })
                })
                .then(res => res.json())
                .then(data => {

                    if (data.success) {

                        // highlight item
                        document
                            .getElementById(`item-${itemId}`)
                            .classList.add('served');

                        // if order completed
                        if (data.completed) {
                            toastr.success("Order Completed!", "Success");
                            bootstrap.Modal.getInstance(
                                document.getElementById('serveModal')
                            ).hide();
                            fetchOrdersRealtime();
                        }
                    }
                });
        }

        document.getElementById('completeOrderBtn')
            .addEventListener('click', function() {

                if (!currentReference) return;

                fetch('/admin/orders/complete-all', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            reference_number: currentReference
                        })
                    })
                    .then(res => res.json())
                    .then(data => {

                        if (data.success) {

                            // Highlight all items in modal
                            document.querySelectorAll('.item-row')
                                .forEach(row => row.classList.add('served'));

                            toastr.success("Order Completed!", "Success");

                            // Close modal after small delay
                            setTimeout(() => {
                                bootstrap.Modal.getInstance(
                                    document.getElementById('serveModal')
                                ).hide();

                                fetchOrdersRealtime();
                            }, 800);
                        }
                    });

            });

        // ---------------- Sort Dropdown ----------------
        function updateSortText(text) {
            const btn = document.querySelector('#sortDropdown span');
            btn.textContent = text;

            const items = document.querySelectorAll('#sortDropdown + .dropdown-menu .dropdown-item');
            items.forEach(item => item.classList.remove('active'));
            event.target.classList.add('active');
        }

        // ---------------- Status Dropdown ----------------
        function updateStatusText(text) {
            const btn = document.querySelector('#statusDropdown span');
            btn.textContent = text;

            const items = document.querySelectorAll('#statusDropdown + .dropdown-menu .dropdown-item');
            items.forEach(item => item.classList.remove('active'));
            event.target.classList.add('active');
        }
    </script>
</body>

</html>
