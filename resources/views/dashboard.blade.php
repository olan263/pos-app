<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ringkasan Toko Hari Ini') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
                    <p class="text-sm font-medium text-gray-500 uppercase">Omzet Hari Ini</p>
                    <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($todaySales) }}</h3>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
                    <p class="text-sm font-medium text-gray-500 uppercase">Transaksi</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalOrders }} Nota</h3>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-red-500">
                    <p class="text-sm font-medium text-gray-500 uppercase">Stok Kritis (< 5)</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $lowStock }} Produk</h3>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4 text-gray-700 underline decoration-blue-500">5 Transaksi Terakhir</h3>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-gray-400 text-sm uppercase">
                                <th class="pb-3">ID</th>
                                <th class="pb-3 text-right">Total</th>
                                <th class="pb-3 text-center">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @foreach($recentOrders as $order)
                            <tr class="border-t">
                                <td class="py-3 font-mono">#{{ $order->id }}</td>
                                <td class="py-3 text-right font-bold">Rp {{ number_format($order->total_amount) }}</td>
                                <td class="py-3 text-center text-xs">{{ $order->created_at->format('H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4 text-gray-700">Aksi Cepat</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('cashier.index') }}" class="flex flex-col items-center justify-center p-6 bg-blue-50 hover:bg-blue-100 rounded-xl transition border border-blue-200 group">
                            <span class="text-3xl mb-2 group-hover:scale-110 transition">🛒</span>
                            <span class="font-bold text-blue-700">Buka Kasir</span>
                        </a>
                        <a href="{{ route('products.index') }}" class="flex flex-col items-center justify-center p-6 bg-purple-50 hover:bg-purple-100 rounded-xl transition border border-purple-200 group">
                            <span class="text-3xl mb-2 group-hover:scale-110 transition">📦</span>
                            <span class="font-bold text-purple-700">Stok Barang</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>