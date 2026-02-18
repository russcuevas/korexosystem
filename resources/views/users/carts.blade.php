<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Korexo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <style>
        :root {
            --dark-bg: #000000;
            --glass: rgba(255, 255, 255, 0.05);
            --primary-red: #a30000;
        }

        html,
        body {
            background:
                linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.85)),
                url("{{ asset('background.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;

            color: white;
            font-family: 'Inter', sans-serif;
            padding-bottom: 120px;
        }

        body::-webkit-scrollbar {
            display: none;
        }

        .food-card {
            background: var(--glass);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 12px;
            transition: transform 0.2s;
            display: flex;
            flex-direction: column;
            /* default for other uses */
        }

        .food-card:active {
            transform: scale(0.95);
        }

        /* Cart-specific override for horizontal layout */
        .cart-item-card {
            flex-direction: row !important;
            text-align: left !important;
            align-items: center;
        }

        /* Image in cart */
        .cart-item-card img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 15px;
        }

        /* Info column */
        .cart-item-info {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Name + Rice */
        .cart-item-info h6 {
            font-size: 0.95rem;
            margin-bottom: 5px;
            color: white;
        }

        /* Qty, Price, Total */
        .cart-item-info .cart-item-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: white;
        }

        /* Delete button */
        .cart-item-card .btn-danger {
            height: 35px;
            width: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        /* BOTTOM NAV STYLES */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 80px;
            background: white;
            display: flex;
            justify-content: space-around;
            align-items: center;
            border-radius: 30px 30px 0 0;
            z-index: 2000;
        }

        .nav-link-custom {
            text-align: center;
            color: #888;
            text-decoration: none;
            font-size: 11px;
            font-weight: 600;
        }

        .nav-link-custom i {
            font-size: 1.4rem;
            display: block;
        }

        .nav-link-custom.active {
            color: var(--primary-red);
        }

        .float-cart-container {
            position: relative;
            top: -30px;
            background: var(--dark-bg);
            padding: 8px;
            border-radius: 50%;
        }

        .float-cart-btn {
            width: 60px;
            height: 60px;
            background: var(--primary-red);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            border: none;
        }

        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.85)),
                url("{{ asset('background.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader-wrapper {
            position: relative;
            width: 120px;
            height: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .loader-logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            z-index: 10;
            animation: pulse 2s infinite ease-in-out;
        }

        .loader-ring {
            position: absolute;
            width: 110px;
            height: 110px;
            border: 3px solid transparent;
            border-top: 3px solid #a30000;
            border-bottom: 3px solid #a30000;
            border-radius: 50%;
            animation: spin 1.5s linear infinite;
        }

        .loader-text {
            margin-top: 20px;
            color: white;
            font-size: 0.9rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            opacity: 0.7;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(0.9);
                opacity: 0.8;
            }
        }
    </style>
</head>

<body>

    <div id="preloader" style="display:none;">
        <div class="loader-wrapper">
            <div class="loader-ring"></div>
            <img src="{{ asset('logo.jpeg') }}" alt="Logo" class="loader-logo">
        </div>
        <p class="loader-text">Processing your order...</p>
    </div>


    <div class="container mt-2">

        <div class="mt-4 mt-5 d-flex justify-content-between align-items-center px-3">
            <h5 class="fw-bold mb-3">Your Cart</h5>
        </div>


        @if ($cartItems->isEmpty())
            <p class="text-white px-3">Your cart is empty.</p>
        @else
            <div class="row g-3">
                @foreach ($cartItems->whereNull('is_add_ons_menu') as $item)
                    <div class="col-12">
                        <div class="food-card cart-item-card d-flex align-items-center">
                            <!-- Left: Menu Image -->
                            @if ($item->menu_pic ?? false)
                                <img src="{{ asset('menus/' . $item->menu_pic) }}" alt="{{ $item->menu_name }}"
                                    style="width:70px; height:70px; object-fit:cover; border-radius:10px; margin-right:15px;">
                            @else
                                <img src="https://cdn-icons-png.flaticon.com/128/1046/1046784.png"
                                    style="width:70px; height:70px; object-fit:cover; border-radius:10px; margin-right:15px;"
                                    alt="No Image">
                            @endif

                            <!-- Right: Info Column -->
                            <div class="flex-grow-1 d-flex flex-column justify-content-between">
                                <!-- Name + Rice -->
                                <h6 class="fw-bold mb-1" style="font-size:0.95rem; color:white;">
                                    {{ $item->menu_name }}
                                    @if ($item->rice_name)
                                        <br>w/ {{ $item->rice_name }}
                                    @endif
                                </h6>

                                <!-- Quantity + Price + Total -->
                                <div class="d-flex justify-content-between" style="font-size:0.85rem; color:white;">
                                    <span>Quantity: {{ $item->quantity }}</span>
                                </div>
                            </div>

                            <!-- Remove Button -->
                            <form action="{{ route('cart.delete', $item->id) }}" method="POST" class="ms-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>

                        </div>
                    </div>
                @endforeach

                <!-- Add Ons Section -->
                @php
                    // Filter items where 'is_add_ons_menu' is not null
                    $addOns = $cartItems->filter(function ($item) {
                        return !is_null($item->is_add_ons_menu);
                    });
                @endphp

                @if ($addOns->isNotEmpty())
                    <div class="col-12">
                        <h6 class="mt-4 px-3 fw-bold" style="color:white;">Add Ons/Extra</h6>

                        @foreach ($addOns as $addon)
                            <div class="food-card cart-item-card d-flex align-items-center mt-2">
                                <!-- Left: Menu Image -->
                                @if ($addon->menu_pic ?? false)
                                    <img src="{{ asset('menus/' . $addon->menu_pic) }}" alt="{{ $addon->menu_name }}"
                                        style="width:70px; height:70px; object-fit:cover; border-radius:10px; margin-right:15px;">
                                @else
                                    <img src="https://cdn-icons-png.flaticon.com/128/1046/1046784.png"
                                        style="width:70px; height:70px; object-fit:cover; border-radius:10px; margin-right:15px;"
                                        alt="No Image">
                                @endif

                                <!-- Right: Info Column -->
                                <div class="flex-grow-1 d-flex flex-column justify-content-between">
                                    <!-- Menu Name + Rice if any -->
                                    <h6 class="fw-bold mb-1" style="font-size:0.95rem; color:white;">
                                        {{ $addon->menu_name }}
                                        @if ($addon->rice_name)
                                            <br>x {{ $addon->rice_name }}
                                        @endif
                                    </h6>

                                    <!-- Quantity + Price + Total -->
                                    <div style="font-size:0.85rem; color:white;">
                                        <span>Quantity: {{ $addon->quantity }}</span><br>
                                        <span>₱{{ number_format($addon->price, 2) }}</span><br>
                                        <span>Total: ₱{{ number_format($addon->quantity * $addon->price, 2) }}</span>
                                    </div>
                                </div>

                                <!-- Remove Button -->
                                <form action="{{ route('cart.delete', $addon->id) }}" method="POST" class="ms-3">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Cart Summary -->
                <div class="col-12 mt-3">
                    @php
                        $totalAmount = $cartItems->sum(function ($i) {
                            return $i->quantity * $i->menu_price;
                        });
                    @endphp
                    <div class="food-card d-flex justify-content-between align-items-center">
                        <strong>Total Amount:</strong>
                        <strong>₱{{ number_format($totalAmount, 2) }}</strong>
                    </div>
                </div>
            </div>
            <!-- Checkout Button -->
            <div class="col-12 mt-3 mb-5">
                <button type="button" class="btn btn-primary w-100 py-2 fw-bold"
                    style="background-color: #a30000; border-color: #a30000;" data-bs-toggle="modal"
                    data-bs-target="#reservationModal">
                    Checkout
                </button>
            </div>

            <div class="modal fade" id="reservationModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header">
                            <h5 class="modal-title">Checkout Form</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>

                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="" required
                                        style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 10px; padding: 10px; color: white;">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Preferred Time</label>

                                    <select name="reservation_id" class="form-select" required>
                                        <option value="">-- Select Time --</option>

                                        @foreach ($reservations as $slot)
                                            <option value="{{ $slot->id }}">
                                                {{ $slot->time_slot }}
                                                ({{ $slot->available_slots }} slots left)
                                            </option>
                                        @endforeach

                                    </select>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger w-100">
                                    Confirm & Checkout
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        @endif

    </div>

    @include('users.bottom_navbar')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Toastr configuration
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        // Display messages from Laravel session
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if (session('info'))
            toastr.info("{{ session('info') }}");
        @endif

        @if (session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif
    </script>



    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const checkoutForm = document.querySelector('#reservationModal form');

            if (checkoutForm) {
                checkoutForm.addEventListener('submit', function() {

                    // Show loader
                    document.getElementById('preloader').style.display = "flex";

                    // Disable all buttons
                    const buttons = document.querySelectorAll('button');
                    buttons.forEach(btn => btn.disabled = true);
                });
            }

        });
    </script>



</body>

</html>
