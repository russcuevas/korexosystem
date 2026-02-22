<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Korexo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap (optional if you already use it) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for check icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
                url('background.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;

            color: white;
            font-family: 'Inter', sans-serif;
            padding-bottom: 70px;
        }


        html::-webkit-scrollbar,
        body::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }


        .app-header {
            margin-top: 40px;
            padding: 20px;
        }

        /* New Home Styles */
        .logo-container {
            width: 200px;
            height: 200px;
            background: url('logo.jpeg') no-repeat center center;
            background-size: cover;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo-container i {
            font-size: 3rem;
            color: var(--primary-red);
        }

        .glass-card {
            background: var(--glass);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 25px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .mission-vision-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 20px;
        }

        .cat-box {
            background: #ffffff;
            border-radius: 15px;
            padding: 15px 10px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .cat-box img {
            width: 35px;
            height: 35px;
            margin-bottom: 8px;
            border-radius: 30%;
        }

        .cat-box span {
            color: black;
            font-size: 0.75rem;
            display: block;
            font-weight: 600;
        }

        .btn-view-menu {
            background: var(--primary-red);
            color: white;
            border-radius: 50px;
            padding: 12px 40px;
            font-weight: bold;
            border: none;
            width: 100%;
            margin-top: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(163, 0, 0, 0.3);
        }

        /* Bottom Nav Styles */
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
            box-shadow: 0 8px 20px rgba(163, 0, 0, 0.4);
            border: none;
        }

        .cart-badge {
            font-size: 0.7rem;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-red);
            font-weight: bold;
            border-radius: 50%;
            border: 1px solid var(--primary-red);
        }

        .success-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .success-card {
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        .check-icon {
            font-size: 90px;
            color: #28a745;
            margin-bottom: 20px;
        }

        .success-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .success-message {
            font-size: 16px;
            color: #6c757d;
        }
    </style>
</head>

<body>

    <div class="success-container">
        <div class="success-card">

            <div class="check-icon">
                <i class="fas fa-check-circle"></i>
            </div>

            <div class="success-title">
                Thank You for Ordering!
            </div>

            <p class="success-message">
                Please check your email for your order receipt.
            </p>

            @isset($reference_number)
                <p class="mt-3">
                    <strong>Reference Number:</strong> {{ $reference_number }}
                </p>
            @endisset

            <a href="{{ route('reference.number.page') }}" class="btn btn-view-menu mt-4">
                Back
            </a>

        </div>
    </div>

</body>

</html>
