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

        .app-header {
            padding: 20px;
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .category-scroll-wrapper {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            gap: 12px;
            padding: 5px 15px 15px 15px;
            -webkit-overflow-scrolling: touch;
            cursor: grab;

        }

        .category-scroll-wrapper:active {
            cursor: grabbing;
        }

        .category-scroll-wrapper::-webkit-scrollbar {
            display: none;
        }

        .cat-pill {
            flex: 0 0 auto;
            background: var(--glass);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 8px 22px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .cat-pill.active {
            background: var(--primary-red);
            border-color: var(--primary-red);
            box-shadow: 0 4px 15px rgba(163, 0, 0, 0.3);
        }

        .cat-pill:not(.active):active {
            background: rgba(255, 255, 255, 0.1);
        }

        /* GRID SYSTEM STYLES */
        .food-card {
            background: var(--glass);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 12px;
            height: 100%;
            text-align: center;
            transition: transform 0.2s;
            position: relative;

            display: flex;
            flex-direction: column;
        }


        .info-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            cursor: pointer;
            z-index: 10;
        }

        .info-btn:active {
            transform: scale(0.9);
        }


        .food-info-modal .modal-content {
            background: var(--dark-bg);
            border-radius: 20px;
            border: none;
            animation: popUp 0.3s ease;
        }

        .food-modal-img {
            width: 90px;
        }

        .ingredients-list {
            text-align: left;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .ingredients-list li {
            font-size: 0.75rem;
            padding: 6px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        @keyframes popUp {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }


        .food-card:active {
            transform: scale(0.95);
        }

        .food-img-bg {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 10px;
        }

        .food-thumb {
            width: 100%;
            max-width: 70px;
            height: auto;
        }

        .price-tag {
            color: #ff4d4d;
            font-weight: 800;
            font-size: 0.9rem;
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

        .add-btn {
            background: white;
            color: black;
            border: none;
            border-radius: 10px;
            width: 100%;
            font-size: 0.75rem;
            font-weight: bold;
            padding: 5px;
            margin-top: auto;
            /* 🔥 IMPORTANT */
        }

        .food-card h6 {
            min-height: 38px;
        }

        .food-card p {
            min-height: 18px;
        }

        .food-info-modal {
            z-index: 99999 !important;
        }

        /* Also increase the backdrop so it covers all */
        .food-info-modal .modal-backdrop {
            z-index: 99998 !important;
        }

        .rice-option {
            border: 2px solid transparent;
            /* default border */
            transition: border 0.2s ease, box-shadow 0.2s ease;
        }

        .rice-option input[type="radio"]:checked+.food-img-bg,
        .rice-option input[type="radio"]:checked {
            /* no direct effect, we target parent below with JS */
        }

        /* Use JS to add class when checked (cleanest) */
        .rice-option.selected {
            border: 2px solid #a30000;
            /* primary red */
            box-shadow: 0 0 10px rgba(163, 0, 0, 0.4);
        }
    </style>
</head>

<body>
    <div class="app-header">
        <a href="{{ route('category.page') }}" class="text-white"><i class="bi bi-chevron-left fs-4"></i></a>
    </div>

    <div class="container mt-2">
        <div class="mt-4 mb-3">
            <h5 class="fw-bold mb-3 px-3">Choose other categories</h5>

            <div class="category-scroll-wrapper px-3">
                @foreach ($categories as $category)
                    <a style="text-decoration: none" href="{{ route('default.menu.page', $category->id) }}"
                        class="cat-pill 
                {{ $category->id == $category_id ? 'active' : '' }}">
                        {{ $category->category_name }}
                    </a>
                @endforeach
            </div>
        </div>


        @php
            use Illuminate\Support\Facades\DB;

            // Get the current reference number (adjust as needed)
            $referenceNumber = session('reference_number') ?? null;

            // Get all category_ids already added to cart for this reference number
            $cartCategories = [];

            if ($referenceNumber) {
                $cartCategories = DB::table('carts')
                    ->join('menus', 'carts.menu_id', '=', 'menus.id')
                    ->where('carts.reference_number', $referenceNumber)
                    ->pluck('menus.category_id')
                    ->toArray();
            }
        @endphp

        <div class="row g-3">
            @foreach ($menus as $menu)
                @php
                    // Check if this menu's category is already in cart
                    $disableAdd = in_array($menu->category_id, $cartCategories ?? []);
                @endphp

                <div class="col-6 col-md-4">
                    <div class="food-card">

                        <!-- Info Button -->
                        <div class="info-btn" data-bs-toggle="modal"
                            data-bs-target="#foodInfoModal{{ $menu->menu_id }}">
                            <i class="bi bi-info"></i>
                        </div>

                        <!-- Image -->
                        <div class="food-img-bg">
                            @if ($menu->menu_pic)
                                <img src="{{ asset('menus/' . $menu->menu_pic) }}" class="food-thumb"
                                    alt="{{ $menu->menu_name }}">
                            @else
                                <img src="https://cdn-icons-png.flaticon.com/128/1046/1046784.png" class="food-thumb"
                                    alt="No Image">
                            @endif
                        </div>

                        <!-- Name -->
                        <h6 class="fw-bold mb-1" style="font-size: 0.85rem;">
                            {{ $menu->menu_name }}
                        </h6>

                        <!-- Category -->
                        <p class="text-secondary mb-1" style="font-size: 0.65rem;">
                            {{ $menu->category_name }}
                        </p>

                        <!-- Price -->
                        <div class="price-tag">
                            @if ($menu->is_add_ons_menu)
                                ₱{{ number_format($menu->menu_price, 2) }}
                            @endif
                        </div>

                        <!-- Add Button -->
                        <!-- Add Button -->
                        @if ($menu->category_name === 'Main')
                            {{-- Show Rice selection modal --}}
                            <button type="button" class="add-btn" data-bs-toggle="modal"
                                data-bs-target="#riceSelectionModal{{ $menu->menu_id }}"
                                @if ($disableAdd) disabled style="cursor: not-allowed; background-color: #ccc;" @endif>
                                @if ($disableAdd)
                                    🚫
                                @else
                                    + Add
                                @endif
                            </button>
                        @else
                            {{-- Regular add to cart --}}
                            @if ($disableAdd)
                                <button class="add-btn" disabled style="cursor: not-allowed; background-color: #ccc;">
                                    🚫
                                </button>
                            @else
                                <form action="{{ route('cart.add') }}" method="POST" class="mt-2">
                                    @csrf
                                    <input type="hidden" name="menu_id" value="{{ $menu->menu_id }}">
                                    <input type="hidden" name="is_rice_menu" value="">
                                    <input type="hidden" name="is_add_ons_menu"
                                        value="{{ $menu->is_add_ons_menu ? $menu->menu_id : '' }}">
                                    <button type="submit" class="add-btn"
                                        {{ strtolower($menu->status) !== 'available' || $menu->stock_number <= 0 ? 'disabled' : '' }}>
                                        + Add
                                    </button>
                                </form>
                            @endif
                        @endif

                        <!-- Optional Stock / Status -->
                        @if ($menu->stock_number <= 0)
                            <span class="badge bg-danger mt-1">Out of Stock</span>
                        @endif

                    </div>
                </div>

                <!-- Rice Selection Modal -->
                <div class="modal fade food-info-modal" id="riceSelectionModal{{ $menu->menu_id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog modal-lg">
                        <div class="modal-content food-modal-content p-3">

                            <!-- Modal Header -->
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title text-white">Choose Rice for {{ $menu->menu_name }}</h5>
                                <button type="button" class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal Body -->
                            <div class="modal-body">
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="menu_id" value="{{ $menu->menu_id }}">
                                    <input type="hidden" name="is_add_ons_menu"
                                        value="{{ $menu->is_add_ons_menu ? $menu->menu_id : '' }}">

                                    <div class="row g-3">
                                        @foreach ($riceMenus as $rice)
                                            @php
                                                $showRice = false;

                                                if ($menu->required_addon === 'Salsa Strips') {
                                                    $showRice = in_array($rice->menu_name, [
                                                        'Kimchi Fried Rice',
                                                        'Plain Rice',
                                                    ]);
                                                } elseif ($menu->required_addon === 'Bulgogi Strips') {
                                                    $showRice = in_array($rice->menu_name, [
                                                        'Mexican Rice',
                                                        'Plain Rice',
                                                    ]);
                                                }
                                            @endphp

                                            @if ($showRice)
                                                <div class="col-6 col-md-4">
                                                    <label class="food-card cursor-pointer text-center rice-option"
                                                        style="cursor: pointer">

                                                        <input type="radio" name="is_rice_menu"
                                                            value="{{ $rice->menu_id }}" required class="d-none">

                                                        <div class="info-btn" data-bs-toggle="modal"
                                                            data-bs-target="#riceInfoModal{{ $rice->menu_id }}">
                                                            <i class="bi bi-info"></i>
                                                        </div>

                                                        <div class="food-img-bg mb-2">
                                                            <img src="{{ $rice->menu_pic ? asset('menus/' . $rice->menu_pic) : 'https://cdn-icons-png.flaticon.com/128/1046/1046784.png' }}"
                                                                class="food-modal-img" alt="{{ $rice->menu_name }}">
                                                        </div>

                                                        <h6 class="fw-bold mb-1"
                                                            style="font-size: 0.85rem; color: white;">
                                                            {{ $rice->menu_name }}
                                                        </h6>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <!-- Add Button -->
                                    <button type="submit" class="btn btn-primary w-100 mt-3">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                @foreach ($riceMenus as $rice)
                    @php
                        $showRice = false;

                        if ($menu->required_addon === 'Salsa Strips') {
                            $showRice = in_array($rice->menu_name, ['Kimchi Fried Rice', 'Plain Rice']);
                        } elseif ($menu->required_addon === 'Bulgogi Strips') {
                            $showRice = in_array($rice->menu_name, ['Mexican Rice', 'Plain Rice']);
                        }
                    @endphp

                    @if ($showRice)
                        <!-- Rice Info Modal -->
                        <div class="modal fade food-info-modal" id="riceInfoModal{{ $rice->menu_id }}"
                            tabindex="-1">
                            <div class="modal-dialog modal-dialog modal-lg">
                                <div class="modal-content food-modal-content p-3">
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title text-white">{{ $rice->menu_name }}</h5>
                                        <button type="button" class="btn-close btn-close-white"
                                            data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <div class="food-img-bg mb-3">
                                            <img src="{{ $rice->menu_pic ? asset('menus/' . $rice->menu_pic) : 'https://cdn-icons-png.flaticon.com/128/1046/1046784.png' }}"
                                                class="food-modal-img" alt="{{ $rice->menu_name }}">
                                        </div>

                                        <p class="text-secondary small mb-3">Ingredients used</p>

                                        <div class="ingredients-list">
                                            {!! $rice->ingredients !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach




                <!-- Modal -->
                <div class="modal fade food-info-modal" id="foodInfoModal{{ $menu->menu_id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog">
                        <div class="modal-content food-modal-content">

                            <button type="button" class="btn-close btn-close-white ms-auto m-2"
                                data-bs-dismiss="modal"></button>

                            <div class="text-center px-4 pb-4">
                                <img src="{{ $menu->menu_pic ? asset('menus/' . $menu->menu_pic) : 'https://cdn-icons-png.flaticon.com/128/1046/1046784.png' }}"
                                    class="food-modal-img mb-3" alt="{{ $menu->menu_name }}">

                                <h5 class="fw-bold mb-2">{{ $menu->menu_name }}</h5>

                                <p class="text-secondary small mb-3">Ingredients used</p>

                                <div class="ingredients-list">
                                    {!! $menu->ingredients !!}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

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
        const slider = document.querySelector('.category-scroll-wrapper');

        let isDown = false;
        let startX;
        let scrollLeft;

        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });

        slider.addEventListener('mouseleave', () => {
            isDown = false;
        });

        slider.addEventListener('mouseup', () => {
            isDown = false;
        });

        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 1.5; // scroll speed
            slider.scrollLeft = scrollLeft - walk;
        });

        /* MOBILE TOUCH SUPPORT */
        slider.addEventListener('touchstart', (e) => {
            startX = e.touches[0].pageX;
            scrollLeft = slider.scrollLeft;
        });

        slider.addEventListener('touchmove', (e) => {
            const x = e.touches[0].pageX;
            const walk = (x - startX) * 1.5;
            slider.scrollLeft = scrollLeft - walk;
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const wrapper = document.querySelector('.category-scroll-wrapper');
            const active = document.querySelector('.cat-pill.active');

            if (wrapper && active) {
                wrapper.scrollTo({
                    left: active.offsetLeft - 20,
                    behavior: "smooth"
                });
            }
        });
    </script>

    <script>
        document.querySelectorAll('.rice-option input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const labels = this.closest('.modal-body').querySelectorAll('.rice-option');
                labels.forEach(label => label.classList.remove('selected'));
                this.closest('.rice-option').classList.add('selected');
            });
        });
    </script>


</body>

</html>
