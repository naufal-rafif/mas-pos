<?php

use App\Livewire\Page\Cart;
use App\Livewire\Page\Finish;
use Illuminate\Support\Facades\Route;
use App\Livewire\Page\Home;
Route::middleware('redirect.if.not.loggedin')->group(function () {
    Route::get('/' , Home::class)->name('home');
    Route::get('/cart', Cart::class)->name('cart');
    Route::get('/finish/{orderId}', Finish::class)->name('finish');
});