<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * Matikan timestamps karena tabel order_items biasanya 
     * tidak membutuhkan kolom created_at dan updated_at secara default.
     */
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price'
    ];

    /**
     * Relasi: Detail item ini merujuk ke satu Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi: Detail item ini merujuk ke satu Produk
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}