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
        .card {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 1.5rem;
            height: 100%;
        }

        h5 {
            color: #fff;
        }

        /* Pie chart container for centering smaller chart */
        .pie-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        /* Small pie chart size */
        .small-pie-chart {
            max-width: 250px;
            max-height: 250px;
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .small-pie-chart {
                max-width: 200px;
                max-height: 200px;
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
                <h2 class="fw-bold mb-0">Sales</h2>
            </div>
        </header>

        <div class="container-fluid">
            <div class="row g-4">
                <!-- Left: February Sales Bar Chart -->
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <h5 class="mb-3 fw-bold">February Sales (Daily)</h5>
                        <canvas id="salesBarChart" style="height: 350px;"></canvas>
                    </div>
                </div>

                <!-- Right: Top 3 Menu Pie Chart -->
                <div class="col-12 col-lg-6">
                    <div class="card pie-container">
                        <div>
                            <h5 class="mb-3 fw-bold text-center">Top 3 Selling Menu</h5>
                            <canvas id="topMenuPieChart" class="small-pie-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // ===== February Sales Bar Chart =====
        const salesCtx = document.getElementById('salesBarChart').getContext('2d');
        const febDays = Array.from({
            length: 28
        }, (_, i) => 'Feb ' + (i + 1));
        const febSales = [
            500, 700, 300, 900, 1200, 800, 400, 600, 700, 500,
            900, 1000, 1100, 700, 800, 1200, 1300, 900, 600, 400,
            700, 500, 800, 900, 1200, 1100, 700, 600
        ];

        new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: febDays,
                datasets: [{
                    label: 'Sales (₱)',
                    data: febSales,
                    backgroundColor: 'rgba(163, 0, 0, 0.7)',
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 200
                        }
                    }
                }
            }
        });

        // ===== Top 3 Menu Pie Chart =====
        const topMenuCtx = document.getElementById('topMenuPieChart').getContext('2d');
        const topMenuNames = ['Koretea', 'Bibimbap', 'Kimchi Stew'];
        const topMenuSales = [120, 90, 60];

        new Chart(topMenuCtx, {
            type: 'pie',
            data: {
                labels: topMenuNames,
                datasets: [{
                    data: topMenuSales,
                    backgroundColor: [
                        'rgba(163, 0, 0, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
    <script>
        function toggleMenu() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('main-content').classList.toggle('shifted');
        }
    </script>
</body>

</html>
