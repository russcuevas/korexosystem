<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Korexo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('users/css/reference_number.css') }}">
    <style>
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.85)),
                url('background.jpg');
            /* Matches your dark theme */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
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
            /* Your primary red */
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

        /* Hide content until loaded */
        .loaded #preloader {
            opacity: 0;
            pointer-events: none;
        }
    </style>
</head>

<body>
    <div id="preloader">
        <div class="loader-wrapper">
            <div class="loader-ring"></div>
            <img src="{{ asset('logo.jpeg') }}" alt="Logo" class="loader-logo">
        </div>
        <p class="loader-text">Loading KoREXO...</p>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div class=" text-center">
                    <div class="logo-container mb-3"></div>
                    <h4 class="fw-bold text-white mb-3">Welcome to KoREXO!</h4>
                    <p class="small opacity-75 px-3">
                        Check your reference number located at the bottom of your ticket please fill out the form first
                        to proceed!
                    </p>
                    <form action="{{ route('check.ticket') }}" method="POST" class="text-start mt-4 needs-validation"
                        novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Reference #</label>
                            <input type="text" class="form-control" id="reference_number" name="reference_number"
                                placeholder="" required
                                style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 10px; padding: 10px; color: white;">
                            <div class="invalid-feedback text-end px-3">
                                Please enter a valid Reference #.
                            </div>
                        </div>
                        <button type="submit" class="btn btn-view-menu w-100">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
        }

        @if (Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @endif

        @if (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif
    </script>
    <script>
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
    <script>
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            const mainContent = document.querySelector('body > .container');

            // Optional: add smooth fade-out
            preloader.style.transition = 'opacity 0.5s ease';
            preloader.style.opacity = '0';

            setTimeout(() => {
                preloader.style.display = 'none'; // hide preloader
                mainContent.style.display = 'block'; // show main content
            }, 500); // match the fade-out duration
        });
    </script>
</body>

</html>
