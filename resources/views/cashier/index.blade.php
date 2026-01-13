@extends('layouts.pos')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Menampilkan Pesan Error dari Validation --}}
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-md" role="alert">
            <p class="font-bold">Periksa Kembali:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Menampilkan Pesan Sukses/Error dari Session --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-md">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-6">
        
        {{-- Sisi Kiri: Daftar Produk --}}
        <div class="w-full lg:w-2/3 bg-white shadow-lg rounded-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Daftar Produk</h2>
                <div class="relative w-64">
                    {{-- Menambahkan Label untuk Aksesibilitas --}}
                    <label for="searchProduct" class="sr-only">Cari Produk</label>
                    <input type="text" id="searchProduct" placeholder="Cari nama atau barcode..." 
                        class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 overflow-y-auto h-[600px] pr-2">
                @foreach($products as $product)
                <div class="border rounded-xl p-4 hover:shadow-xl transition-all cursor-pointer bg-gray-50 group product-card">
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left" @if($product->stock <= 0) disabled @endif>
                            <span class="text-xs font-semibold text-blue-500 uppercase">{{ $product->kategori }}</span>
                            <h3 class="font-bold text-gray-800 group-hover:text-blue-600 truncate product-name">{{ $product->nama }}</h3>
                            
                            {{-- Warna stok berubah merah jika kritis --}}
                            <p class="text-sm {{ $product->stock <= 5 ? 'text-red-500 font-bold' : 'text-gray-500' }} mb-2">
                                Stok: {{ $product->stock }} {{ $product->satuan }}
                            </p>

                            <div class="flex justify-between items-center">
                                <span class="text-lg font-black text-gray-900">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                                <div class="{{ $product->stock <= 0 ? 'bg-gray-400' : 'bg-blue-600 group-hover:bg-blue-700' }} text-white p-2 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                            </div>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Sisi Kanan: Keranjang --}}
        <div class="w-full lg:w-1/3 flex flex-col gap-6">
            
            <div class="bg-white shadow-lg rounded-lg p-6 border-t-8 border-blue-600">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Keranjang Belanja</h2>
                    <a href="{{ route('cart.clear') }}" class="text-red-500 text-sm hover:underline" onclick="return confirm('Kosongkan keranjang?')">Hapus Semua</a>
                </div>

                <div class="h-[350px] overflow-y-auto mb-4">
                    @php $total = 0; @endphp
                    @if(session('cart') && count(session('cart')) > 0)
                        @foreach(session('cart') as $id => $item)
                        @php $total += $item['price'] * $item['quantity']; @endphp
                        <div class="flex justify-between items-center border-b py-3">
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800">{{ $item['name'] }}</h4>
                                <p class="text-sm text-gray-500">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                            </div>
                            <span class="font-bold text-gray-900">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <p class="text-gray-400">Keranjang masih kosong</p>
                        </div>
                    @endif
                </div>

                <div class="border-t pt-4 space-y-2">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-2xl font-black text-blue-600">
                        <span>TOTAL</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Form Checkout --}}
            <div class="bg-gray-800 shadow-lg rounded-lg p-6 text-white">
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="paid_amount" class="block text-sm font-medium mb-2 text-gray-400">Nominal Uang Bayar</label>
                        <input type="number" id="paid_amount" name="paid_amount" required min="{{ $total }}"
                            placeholder="Contoh: 50000"
                            class="w-full bg-gray-700 border-none rounded-lg px-4 py-3 text-2xl font-bold text-green-400 focus:ring-2 focus:ring-green-500">
                    </div>
                    <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-4 rounded-lg shadow-lg transition-all transform active:scale-95 uppercase tracking-widest disabled:bg-gray-500" @if($total <= 0) disabled @endif>
                        Proses Transaksi
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    // Search produk yang lebih akurat
    document.getElementById('searchProduct').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        let cards = document.querySelectorAll('.product-card');

        cards.forEach(function(card) {
            let productName = card.querySelector('.product-name').innerText.toLowerCase();
            if (productName.indexOf(value) > -1) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }
        });
    });
</script>
@endsection