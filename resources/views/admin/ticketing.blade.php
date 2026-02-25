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
        #addTicketBtn {
            background: var(--primary-red);
            border: none;
            border-radius: 12px;
            padding: 8px 16px;
            font-weight: 600;
            transition: 0.3s;
        }

        #addTicketBtn:hover {
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
            #addTicketBtn {
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
                <h2 class="fw-bold mb-0">Tickets</h2>
            </div>
        </header>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-xl-11"
                    style="background-color: rgba(255, 255, 255, 0.05); border-radius: 24px; padding: 1.5rem;">

                    @php
                        $usedTickets = $tickets->where('is_used', 1)->count();
                        $notUsedTickets = $tickets->where('is_used', 0)->count();
                    @endphp

                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-6">
                            <div class="small-box shadow-sm"
                                style="background: #111111; border-radius: 12px; color: #fff; position: relative; overflow: hidden;">
                                <div class="inner" style="padding: 1.5rem; text-align: center">
                                    <h3 style="font-weight: 700;">{{ $usedTickets }}</h3>
                                    <p style="color: #adb5bd; margin-bottom: 0; font-weight: 900;">USED</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="small-box shadow-sm"
                                style="background: #111111; border-radius: 12px; color: #fff; position: relative; overflow: hidden;">
                                <div class="inner" style="padding: 1.5rem; text-align: center">
                                    <h3 style="font-weight: 700;">{{ $notUsedTickets }}</h3>
                                    <p style="color: #adb5bd; margin-bottom: 0; font-weight: 900;">NOT USED</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="ticketTable" class="table table-dark table-hover align-middle mb-0"
                            style="min-width: 800px;">
                            <thead style="background-color: #000;">
                                <tr class="border-bottom border-secondary">
                                    <th class="py-3 px-3">REFERENCE #</th>
                                    <th class="py-3">STATUS</th>
                                    <th class="py-3">CREATED AT</th>
                                    <th class="py-3">UPDATED AT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                    <tr class="ticket-row border-bottom border-secondary"
                                        style="background-color: transparent;">
                                        <td class="px-3 fw-bold" style="color: #f3f3f3;">{{ $ticket->reference_number }}
                                        </td>
                                        <td>
                                            @if ($ticket->is_used)
                                                <span
                                                    class="badge rounded-pill bg-danger text-white border border-danger">Yes</span>
                                            @else
                                                <span
                                                    class="badge rounded-pill bg-success text-white border border-success">No</span>
                                            @endif
                                        </td>
                                        <td class="text-white-50 small">{{ $ticket->created_at->format('Y-m-d h:i A') }}
                                        </td>
                                        <td class="text-white-50 small">{{ $ticket->updated_at->format('Y-m-d h:i A') }}
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
