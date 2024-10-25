<?php

namespace App\Livewire\Page;

use App\Models\Invoice;
use DB;
use Livewire\Component;
use Livewire\Attributes\On;
use Ramsey\Uuid\Uuid;

class Cart extends Component
{
    public $cart = [];
    public $total = 0;
    public $order_id;
    public $isProcessing = false;

    public function mount()
    {
        $this->cart = session()->get('cart', []);
        $this->order_id = (string) Uuid::uuid4();
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total = collect($this->cart)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function increaseQuantity($productId)
    {
        $index = collect($this->cart)->search(function($item) use ($productId) {
            return $item['id'] == $productId;
        });

        if ($index !== false && $this->cart[$index]['quantity'] < 10) {
            $this->cart[$index]['quantity']++;
            $this->updateCart();
        }
    }

    public function decreaseQuantity($productId)
    {
        $index = collect($this->cart)->search(function($item) use ($productId) {
            return $item['id'] == $productId;
        });

        if ($index !== false) {
            if ($this->cart[$index]['quantity'] > 1) {
                $this->cart[$index]['quantity']--;
                $this->updateCart();
            } else {
                $this->removeItem($productId);
            }
        }
    }

    public function removeItem($productId)
    {
        $this->cart = collect($this->cart)->filter(function($item) use ($productId) {
            return $item['id'] != $productId;
        })->values()->all();

        $this->updateCart();
    }

    private function updateCart()
    {
        session()->put('cart', $this->cart);
        $this->calculateTotal();
    }

    public function proceedToCheckout()
    {
        if (empty($this->cart)) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Your cart is empty!'
            ]);
            return;
        }
        $this->isProcessing = true;

        try {
            DB::beginTransaction();

            // Create invoice
            $invoice = Invoice::create([
                'order_id' => $this->order_id,
                'transaction_date' => now(),
                'total_amount' => $this->total
            ]);

            // Attach products to invoice
            foreach ($this->cart as $item) {
                $invoice->products()->attach($item['id'], [
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }

            // Clear cart session
            session()->forget('cart');

            DB::commit();

            return $this->redirect(route('finish', $invoice->order_id));

        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->isProcessing = false;
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Failed to process checkout. Please try again.'
            ]);
        }

        return $this->redirect(route('checkout'));
    }

    public function render()
    {
        return view('livewire.page.cart', [
            'cart' => $this->cart,
            'total' => $this->total
        ])->layout('layouts.app');
    }
}