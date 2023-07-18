<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    use HasFactory;
    protected $fillable = ['nama','provinsi','tanggal','harga','kebutuhan','ketahanan','stok_bulog','stok_provinsi','stok_total','status'];
}
