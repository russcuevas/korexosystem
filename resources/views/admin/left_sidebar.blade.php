<div class="sidebar" id="sidebar">
    <div class="d-flex align-items-center justify-content-between mb-5 px-2">
        <div class="d-flex align-items-center">
            <img src="{{ asset('logo.jpeg') }}" alt="Restaurant Logo" class="me-2"
                style="width: 180px; height: 80px; object-fit: cover; border-radius: 50px;">
        </div>
        <button class="btn text-white d-lg-none" onclick="toggleMenu()"><i class="bi bi-x-lg"></i></button>
    </div>

    <nav>
        <a href="#" class="nav-link-admin active"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a>
        <a href="#" class="nav-link-admin"><i class="bi bi-egg-fried"></i> Menu Items</a>
        <a href="#" class="nav-link-admin"><i class="bi bi-cart-check"></i> Orders</a>
        <a href="#" class="nav-link-admin"><i class="bi bi-people"></i> Staff</a>
        <a href="#" class="nav-link-admin"><i class="bi bi-graph-up"></i> Reports</a>
        <div class="mt-5 pt-5">
            <a href="#" class="nav-link-admin text-secondary mt-5"><i class="bi bi-box-arrow-right"></i>
                Logout</a>
        </div>
    </nav>
</div>
