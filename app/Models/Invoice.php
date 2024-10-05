<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Customer;

class Invoice extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=[
    'customer_id',
    'product_id',
    'quantity',
    'invoice_date',
    'price',
    'invoice_no',
    'discount_type',
    'total_amount',
    ];


    public function customer()
{
    return $this->belongsTo(Customer::class);
}

}
