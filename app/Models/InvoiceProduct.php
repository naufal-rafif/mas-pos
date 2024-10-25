<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    protected $table = 'invoice_products';

    protected $fillable = [
        'invoice_id',
        'product_id',
        'quantity',
        'price'
    ];
}
