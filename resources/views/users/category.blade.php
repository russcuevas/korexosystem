<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Korexo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('users/css/menu.css') }}">
</head>

<body>


    <div class="container mt-5">
        @foreach ($categories as $category)
            <a href="{{ route('default.menu.page', ['category_id' => $category->id]) }}" class="text-decoration-none">
                <div class="category-banner banner-korean">
                    <div>
                        <h3 class="fw-bold mb-0">{{ $category->category_name }}</h3>
                    </div>
                    @if ($category->category_pic)
                        <img src="{{ asset('categories/' . $category->category_pic) }}" width="80"
                            alt="{{ $category->category_name }}">
                    @endif
                </div>
            </a>
        @endforeach
    </div>

    @include('users.bottom_navbar')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
