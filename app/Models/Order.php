<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // TAMBAHKAN INI jika tabel 'orders' Anda tidak punya kolom created_at & updated_at
    public $timestamps = false; 

    protected $fillable = [
        'user_id',
        'total_amount',
        'paid_amount',
        'change_amount'
    ];

    /**
     * Relasi: Satu Order memiliki banyak detail item (OrderItem)
     */
    public function items()
    {
        // Pastikan Anda juga memiliki model OrderItem
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relasi: Satu Order dibuat oleh satu User (Kasir)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}