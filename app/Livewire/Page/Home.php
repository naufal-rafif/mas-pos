<?php

namespace App\Livewire\Page;

use Livewire\Component;

class Home extends Component
{
    public $selectedCategory = null;
    public $selectedIndex = 0;  
    public $cart = [];
    public $totalBill = 0;

    protected $listeners = ['categorySelected', 'addToCart', 'removeFromCart'];

    public function mount()
    {
        // Initialize cart from session if exists
        $this->cart = session()->get('cart', []);
        $this->calculateTotal();
    }

    public function categorySelected($categoryId, $index)
    {
        $this->selectedCategory = $categoryId;
        $this->selectedIndex = $index;
        $this->dispatch('category-changed');
    }

    public function addToCart($productId)
    {
        $product = \App\Models\Product::find($productId);
        if (!$product) return;

        $existingItemKey = collect($this->cart)->search(function($item) use ($productId) {
            return $item['id'] == $productId;
        });

        if ($existingItemKey !== false) {
            // Product exists, increment quantity if less than 10
            if ($this->cart[$existingItemKey]['quantity'] < 10) {
                $this->cart[$existingItemKey]['quantity']++;
                
                // Optional: Add a notification if max quantity reached
                if ($this->cart[$existingItemKey]['quantity'] == 10) {
                    $this->dispatch('showAlert', [
                        'type' => 'info',
                        'message' => 'Maximum quantity reached for this item'
                    ]);
                }
            } else {
                // Optional: Notify user that max quantity is reached
                $this->dispatch('showAlert', [
                    'type' => 'info',
                    'message' => 'Maximum quantity reached for this item'
                ]);
                return;
            }
        } else {
            // Product doesn't exist, add new item
            $this->cart[] = [
                'id' => $productId,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1
            ];
        }

        session()->put('cart', $this->cart);
        $this->calculateTotal();
        $this->dispatch('cart-updated');
    }

    public function removeFromCart($index)
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart);
        session()->put('cart', $this->cart);
        $this->calculateTotal();
        $this->dispatch('cart-updated');
    }

    private function calculateTotal()
    {
        $this->totalBill = collect($this->cart)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function render()
    {
        $product_categories = \App\Models\Category::select('id', 'name','uuid');
        return view('livewire.page.home', [
            'categories' => $product_categories->get(),
            'products' => $this->selectedCategory 
                ? \App\Models\Product::where('category_id', $this->selectedCategory)->get()
                : \App\Models\Product::where('category_id', $product_categories->first()?->id)->get()
        ])->layout('layouts.app');
    }
}
