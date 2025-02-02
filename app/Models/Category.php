<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([CategoryObserver::class])]
class Category extends Model
{
    protected $fillable = [
        'name',
        'uuid',
        'description',
    ];
}
