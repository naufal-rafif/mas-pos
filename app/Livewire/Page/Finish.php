<?php

namespace App\Livewire\Page;

use App\Models\Invoice;
use Livewire\Component;

class Finish extends Component
{
    public $cart = [];
    public $total = 0;

    public function mount($orderId = null)
    {
        if(!$orderId){
            return $this->redirect(route('home'));
        }
        if ($orderId) {
            $this->invoice = Invoice::where('order_id', $orderId)
                ->with('products')
                ->first();
            if ($this->invoice) {
                $this->products = $this->invoice->products;
                $this->total = $this->invoice->total_amount;
            }
        }

    }

    public function calculateTotal()
    {
        $this->total = collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function render()
    {
        return view('livewire.page.finish')->layout('layouts.app');
    }
}
