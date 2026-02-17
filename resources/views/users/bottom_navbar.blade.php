<nav class="bottom-nav">

    <a href="{{ route('home.page') }}" class="nav-link-custom {{ request()->routeIs('home.page') ? 'active' : '' }}">
        <i class="bi bi-house-door-fill"></i>
        Home
    </a>

    <div class="float-cart-container">
        <a href="{{ route('cart.page') }}" class="float-cart-btn position-relative">
            <i class="bi bi-bag-fill"></i>
            <span id="cart-badge"
                class="cart-badge position-absolute top-0 start-100 translate-middle badge rounded-pill bg-white text-dark">
            </span>
        </a>
    </div>


    <a href="{{ route('category.page') }}"
        class="nav-link-custom 
       {{ request()->routeIs('category.page') || request()->routeIs('default.menu.page') ? 'active' : '' }}">
        <i class="bi bi-file-earmark-text-fill"></i>
        Menu
    </a>

</nav>

<script>
    function updateCartCount() {
        fetch('{{ route('cart.count') }}')
            .then(res => res.json())
            .then(data => {
                document.getElementById('cart-badge').textContent = data.count;
            });
    }
    updateCartCount();
    setInterval(updateCartCount, 5000);
</script>
