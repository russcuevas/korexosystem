<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Korexo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
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

        .swiper {
            width: 100%;
            height: 500px;
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* This makes sure the images fill the space */
        }

        /* Makes the dots look like your glassmorphism theme */
        .swiper-pagination-bullet {
            background: rgba(255, 255, 255, 0.3) !important;
            opacity: 1;
        }

        .swiper-pagination-bullet-active {
            background: var(--swiper-pagination) !important;
            /* Your red accent */
            width: 25px;
            /* Makes the active dot a pill shape */
            border-radius: 5px;
            transition: width 0.3s ease;
        }
    </style>
</head>

<body>

    @include('admin.left_sidebar')

    <div class="main-content" id="main-content">
        <header class="d-flex justify-content-between align-items-center mb-5">
            <div class="d-flex align-items-center gap-3">
                <button id="menu-toggle" onclick="toggleMenu()"><i class="bi bi-list fs-4"></i></button>
                <h2 class="fw-bold mb-0">Dashboard</h2>
            </div>
        </header>

        <div class="row g-4">
            <div class="col-12">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><img
                                src="https://images.unsplash.com/photo-1590301157890-4810ed352733?q=80&w=1600"
                                alt="K-Food 1"></div>
                        <div class="swiper-slide"><img
                                src="https://bpic.588ku.com/back_pic/19/04/04/54f5a15e908df86f67f7f609bed64ae6.jpg"
                                alt="K-Food 2"></div>
                        <div class="swiper-slide"><img
                                src="https://images.unsplash.com/photo-1585032226651-759b368d7246?q=80&w=1600"
                                alt="K-Food 3"></div>
                        <div class="swiper-slide"><img
                                src="https://png.pngtree.com/back_origin_pic/05/05/46/654363fbdf2476f5f692b062a088e305.jpg"
                                alt="K-Food 4"></div>
                        <div class="swiper-slide"><img
                                src="https://images.unsplash.com/photo-1498654896293-37aacf113fd9?q=80&w=1600"
                                alt="K-Food 5"></div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            // Navigation block removed
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
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
