<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Menentukan nama tabel (opsional jika nama tabelnya 'products')
    protected $table = 'products';

    /**
     * Kolom yang boleh diisi (mass assignable).
     * Ini harus sesuai dengan kolom yang ada di database phpMyAdmin tadi.
     */
    protected $fillable = [
        'kode_barang', 
        'barcode', 
        'nama', 
        'kategori', 
        'sub_kategori', 
        'supplier', 
        'tanggal_beli', 
        'isi', 
        'satuan', 
        'hpp', 
        'harga_jual', 
        'stock'
    ];

    /**
     * Relasi ke OrderItem.
     * Satu produk bisa muncul di banyak transaksi.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}