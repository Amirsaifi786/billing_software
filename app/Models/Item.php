<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable=[ 
    // 'invoice_id',
    'item_name',
    'item_type',
    'barcode', // Ensure barcode is fillable
    'quantity',
    'price',
    'total',];
}
