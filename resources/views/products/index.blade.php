@extends('layouts.pos')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Stok Barang</h2>
            <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow-md transition">
                + Tambah Produk Baru
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase text-sm tracking-wider">
                        <th class="px-4 py-3 border-b">Kode / Barcode</th>
                        <th class="px-4 py-3 border-b">Nama Barang</th>
                        <th class="px-4 py-3 border-b">Kategori</th>
                        <th class="px-4 py-3 border-b text-right">Modal (HPP)</th>
                        <th class="px-4 py-3 border-b text-right">Harga Jual</th>
                        <th class="px-4 py-3 border-b text-center">Stok</th>
                        <th class="px-4 py-3 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @foreach($products as $product)
                    <tr class="hover:bg-gray-50 transition border-b">
                        <td class="px-4 py-4">
                            <span class="font-mono text-blue-600 block">{{ $product->kode_barang }}</span>
                            <span class="text-xs text-gray-400">{{ $product->barcode }}</span>
                        </td>
                        <td class="px-4 py-4 font-bold text-gray-800">{{ $product->nama }}</td>
                        <td class="px-4 py-4 italic">{{ $product->kategori ?? '-' }}</td>
                        <td class="px-4 py-4 text-right italic">Rp {{ number_format($product->hpp) }}</td>
                        <td class="px-4 py-4 text-right font-bold text-green-600">Rp {{ number_format($product->harga_jual) }}</td>
                        <td class="px-4 py-4 text-center">
                            @if($product->stock <= 5)
                                <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold">Kritis: {{ $product->stock }}</span>
                            @else
                                <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-bold">{{ $product->stock }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('products.edit', $product->id) }}" class="text-yellow-500 hover:text-yellow-600 p-1 border rounded shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600 p-1 border rounded shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection