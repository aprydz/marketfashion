<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'total_amount',
        'shipping_cost',
        'shipping_service',
        'recipient_name',
        'recipient_phone',
        'shipping_address',
        'city',
        'province',
        'postal_code',
        'tracking_number',
        'status',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function getGrandTotalAttribute(): float
    {
        return (float) ($this->total_amount + $this->shipping_cost);
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'pending' => ['label' => 'Menunggu Pembayaran', 'class' => 'bg-amber-100 text-amber-800 border-amber-300'],
            'paid' => ['label' => 'Sudah Dibayar', 'class' => 'bg-emerald-100 text-emerald-800 border-emerald-300'],
            'processing' => ['label' => 'Sedang Diproses Seller', 'class' => 'bg-blue-100 text-blue-800 border-blue-300'],
            'shipped' => ['label' => 'Dalam Pengiriman', 'class' => 'bg-purple-100 text-purple-800 border-purple-300'],
            'delivered' => ['label' => 'Pesanan Selesai', 'class' => 'bg-emerald-100 text-emerald-800 border-emerald-300'],
            'cancelled' => ['label' => 'Dibatalkan', 'class' => 'bg-rose-100 text-rose-800 border-rose-300'],
            default => ['label' => ucfirst($this->status), 'class' => 'bg-zinc-100 text-zinc-800 border-zinc-300'],
        };
    }
}
