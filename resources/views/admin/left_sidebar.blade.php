<div class="sidebar" id="sidebar">
    <div class="d-flex align-items-center justify-content-between mb-5 px-2">
        <div class="d-flex align-items-center">
            <img src="{{ asset('logo.jpeg') }}" alt="Restaurant Logo" class="me-2"
                style="width: 180px; height: 80px; object-fit: cover; border-radius: 50px;">
        </div>
        <button class="btn text-white d-lg-none" onclick="toggleMenu()"><i class="bi bi-x-lg"></i></button>
    </div>

    <nav>
        <a href="{{ route('admin.dashboard.page') }}" class="nav-link-admin active"><i class="bi bi-grid-1x2-fill"></i>
            Dashboard</a>
        <a href="{{ route('admin.ticketing.page') }} " class="nav-link-admin"><i
                class="bi bi-ticket-perforated-fill"></i>
            Tickets</a>
        <a href="{{ route('admin.menu.page') }} " class="nav-link-admin"><i class="bi bi-egg-fried"></i> Menu</a>
        <a href="{{ route('admin.orders.page') }}" class="nav-link-admin"><i class="bi bi-cart-check"></i> Orders</a>
        <a href="#" class="nav-link-admin"><i class="bi bi-graph-up"></i> Sales</a>
        <div class="mt-5 pt-5">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="nav-link-admin text-secondary mt-5 border-0 bg-transparent w-100 text-start">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>

    </nav>
</div>
