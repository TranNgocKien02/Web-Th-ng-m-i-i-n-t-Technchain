<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietDonHang extends Model
{
    use HasFactory;

    protected $fillable = [
        'don_hang_id',
        'san_pham_id',
        'don_gia',
        'so_luong',
        'thanh_tien',
    ];

    public function donHang(){
        return $this->belongsTo(DonHang::class) ;
    }
    public function sanPham()
    {
        return $this->belongsTo(SanPham::class);
    }
}
