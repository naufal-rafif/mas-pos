<?php

namespace App\Models;

use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([ProductObserver::class])]
class Product extends Model
{
    protected $fillable = [
        'category_id',
        'image',
        'uuid',
        'name',
        'qty',
        'price',
        'description',
    ];
}
