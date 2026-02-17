<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Korexo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('admins/css/ticketing.css') }}">
    <style>
        #ticketTable tbody tr {
            background: rgba(255, 255, 255, 0.05) !important;
            transition: 0.3s !important;
        }

        #ticketTable tbody tr:hover {
            background: rgba(163, 0, 0, 0.15) !important;
        }

        /* Badges */
        #ticketTable .badge {
            font-size: 0.8rem;
            padding: 0.3em 0.6em;
        }

        /* Add Ticket button */
        #addMenuBtn {
            background: var(--primary-red);
            border: none;
            border-radius: 12px;
            padding: 8px 16px;
            font-weight: 600;
            transition: 0.3s;
        }

        #addMenuBtn:hover {
            background: #000000;
        }

        /* Table headers */
        #ticketTable thead th {
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }

        .table> :not(caption)>*>* {
            background-color: transparent !important;
            box-shadow: none !important;
        }

        .active>.page-link,
        .page-link.active {
            z-index: 3;
            color: white;
            background-color: black !important;
            border-color: black !important;
        }

        .pagination {
            --bs-pagination-color: #a30000;
            --bs-pagination-hover-color: #a30000;
            --bs-pagination-focus-color: #a30000;
            --bs-pagination-active-color: #a30000;
            --bs-pagination-active-bg: black;
            --bs-pagination-active-border-color: black;
        }

        /* Table responsiveness on mobile */
        @media (max-width: 767px) {
            #addMenuBtn {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>
    <div id="overlay" onclick="toggleMenu()"></div>

    @include('admin.left_sidebar')

    <div class="main-content" id="main-content">
        <header class="d-flex justify-content-between align-items-center mb-5">
            <div class="d-flex align-items-center gap-3">
                <button id="menu-toggle" onclick="toggleMenu()"><i class="bi bi-list fs-4"></i></button>
                <h2 class="fw-bold mb-0">Menu</h2>
            </div>
        </header>

        <div class="container-fluid">

            <div class="row justify-content-center">

                <div class="col-12 col-xl-11"
                    style="background-color: rgba(255, 255, 255, 0.05); border-radius: 24px; padding: 2.5rem;">
                    <div class="table-responsive">
                        <table id="ticketTable" class="table table-dark table-hover align-middle mb-0"
                            style="min-width: 800px;">
                            <thead style="background-color: #000;">
                                <tr class="border-bottom border-secondary">
                                    <th class="py-3 px-3">CATEGORY</th>
                                    <th class="py-3">NAME</th>
                                    <th class="py-3">PRICE</th>
                                    <th class="py-3">STATUS</th>
                                    <th class="py-3">STOCK</th>
                                    <th class="py-3 text-center">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menu as $menu)
                                    <tr class="ticket-row border-bottom border-secondary"
                                        style="background-color: transparent;">
                                        <td class="px-3 fw-bold" style="color: #f3f3f3;">
                                            {{ $menu->category_name }}

                                        <td class="px-3 fw-bold" style="color: #f3f3f3;">{{ $menu->menu_name }}
                                        </td>
                                        <td class="px-3 fw-bold" style="color: #f3f3f3">
                                            @if ($menu->menu_price == 0)
                                                FREE
                                            @else
                                                ₱{{ number_format($menu->menu_price, 2) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($menu->is_add_ons_menu)
                                                <span
                                                    class="badge rounded-pill bg-info text-white border border-info">ADD
                                                    ONS</span>
                                            @elseif ($menu->is_rice_menu)
                                                <span
                                                    class="badge rounded-pill bg-secondary text-white border border-secondary">MAIN
                                                    MENU - RICE</span>
                                            @else
                                                <span
                                                    class="badge rounded-pill bg-success text-white border border-success">MAIN
                                                    MENU</span>
                                            @endif
                                        </td>
                                        @php
                                            $isAvailable = strtolower($menu->status) === 'available';
                                        @endphp

                                        <td>
                                            <span
                                                class="badge rounded-pill 
                                                {{ $isAvailable ? 'bg-success border-success' : 'bg-danger border-danger' }} 
                                                text-white border"
                                                style="text-transform: capitalize">

                                                {{ $menu->stock_number }} - {{ $menu->status }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-warning mx-1">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#ticketTable').DataTable({
                order: [
                    [2, 'desc']
                ],
                pageLength: 10
            });
        });
    </script>
    <script>
        function toggleMenu() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('main-content').classList.toggle('shifted');
            if (window.innerWidth <= 991) {
                document.getElementById('overlay').classList.toggle('active');
            }
        }
    </script>
</body>

</html>
