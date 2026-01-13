<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Kasir - POS</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Sembunyikan navigasi saat mencetak struk */
        @media print {
            nav, .no-print {
                display: none !important;
            }
            body {
                background: white;
            }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <nav class="bg-white border-b border-gray-100 shadow-sm no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="font-bold text-xl text-blue-600">
                        MyPOS
                    </a>
                    <div class="hidden md:flex space-x-4">
                        <a href="{{ route('cashier.index') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Kasir</a>
                        </div>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-500 mr-4 text-sm">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-500 hover:underline">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    @if(session('success'))
        <script>
            // Menggunakan SweetAlert jika ada, jika tidak pakai alert biasa
            const msg = "{{ session('success') }}";
            
            Swal.fire({
                title: 'Berhasil!',
                text: msg,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                // Jika pesan sukses mengandung kata 'Transaksi Berhasil', 
                // kita bisa memicu print struk di sini jika Anda sudah membuat view struknya.
                if (msg.includes('Transaksi Berhasil')) {
                    console.log('Siap cetak struk...');
                    // window.print(); // Aktifkan ini jika ingin langsung cetak seluruh halaman
                }
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                title: 'Gagal!',
                text: "{{ session('error') }}",
                icon: 'error',
            });
        </script>
    @endif

    @stack('scripts')
</body>
</html>