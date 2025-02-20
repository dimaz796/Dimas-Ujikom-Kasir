<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Produk')</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="path/to/script.js"></script>

</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <nav class=" bg-white top-0 left-0 w-full z-50 shadow-md">
        @include('component.navbar')
    </nav>

    <main class="flex-grow container my-4">
        @yield('content')
    </main>

    <footer class="bg-blue-500 text-center text-white shadow-md bottom-0 w-full mt-auto py-4">
        @include('component.footer')
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/keranjang.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete(id,ket) {
            if (confirm("Apakah Anda Yakin Ingin Menghapus " + ket + " Ini?")) {
            document.getElementById('delete-form-' + id).submit();
            } else {
                event.preventDefault();
            }
        }
    </script>
</body>
</html>
