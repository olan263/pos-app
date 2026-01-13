<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Menampilkan halaman kasir
     */
    public function index()
    {
        $products = Product::all();
        return view('cashier.index', compact('products'));
    }

    /**
     * Menambahkan item ke keranjang (Session)
     */
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->nama,
                "quantity" => 1,
                "price" => $product->harga_jual,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    /**
     * Menghapus seluruh isi keranjang
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Keranjang dibersihkan!');
    }

    /**
     * Proses transaksi final (Checkout)
     */
    public function checkout(Request $request)
    {
        $cart = session()->get('cart');
        
        if(!$cart) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        $total = 0;
        foreach($cart as $item) {
            $total += $item['quantity'] * $item['price'];
        }

        $request->validate([
            'paid_amount' => 'required|numeric|min:' . $total,
        ], [
            'paid_amount.min' => 'Uang bayar tidak cukup! Minimal: Rp ' . number_format($total)
        ]);

        try {
            DB::transaction(function () use ($cart, $request, $total) {
                
                $order = Order::create([
                    'user_id'       => auth()->id(),
                    'total_amount'  => $total,
                    'paid_amount'   => $request->paid_amount,
                    'change_amount' => $request->paid_amount - $total,
                ]);

                foreach ($cart as $id => $details) {
                    $order->items()->create([
                        'product_id' => $id,
                        'quantity'   => $details['quantity'],
                        'price'      => $details['price'],
                    ]);

                    $product = Product::findOrFail($id);
                    $product->decrement('stock', $details['quantity']);
                }
            });

            session()->forget('cart');
            
            return redirect()->route('cashier.index')->with('success', 'Transaksi Berhasil! Kembalian: Rp ' . number_format($request->paid_amount - $total));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}